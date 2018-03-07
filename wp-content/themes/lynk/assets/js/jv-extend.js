// Dashboard 1

jQuery( function( $ ) {

	var javoMyDashboard = function() {
		this.param = bp_mypage_type_c_args;
		this.MORRIS = false;
		this.init();
	}

	javoMyDashboard.prototype = {
		constructor : javoMyDashboard,
		init : function() {
			var obj = this;

			if( obj.MORRIS ) {
				obj.setMorris();
			}

			obj.footerFunction();

			obj.setChart();
			obj.setPie();

			obj.setEvent();
			obj.setEventUploader();
			obj.setLeftMenu();
			obj.setRightMenu();
			obj.setBuddyPressPage();
			obj.setPreload();

			obj.setBuddyPressSingle();
			obj.setBuddyPressMemberSidebar();
			obj.bindSearchFormAction();

			obj.pallaxHeader();
			obj.setTooltips();

			obj.bp_notification();
			obj.carousel();
		},

		setMorris : function() {
			var
				currentTime = new Date(),
				dateLoop = new Date(),
				CHART_HEIGHT = 340,
				months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				chart_el = $( '#morris-area-chart' ),
				chart_args = {
					parse : {},
					dates : new Array(),
					keys : new Array(),
					color : new Array(),
					label : new Array(),
					data : new Array()
				};

			if( chart_el.length > 0 ) {

				dateLoop.setMonth( dateLoop.getMonth() - 6 );

				while( dateLoop < currentTime ) {
					dateLoop.setMonth( dateLoop.getMonth() + 1 );
					chart_args.dates.push( dateLoop.getFullYear().toString() + ( "0" + ( dateLoop.getMonth() + 1 ) ).slice( -2 ) + ( "0" + ( dateLoop.getDay() + 1 ) ).slice( -2 ) );
				}

				$.each( chart_el.data( 'values' ), function( intPostID, arrChartMeta ) {
					chart_args.keys.push( intPostID );
					chart_args.color.push( arrChartMeta.color );
					chart_args.label.push( arrChartMeta.title );
					$.each( arrChartMeta.values, function( intvalueKey, arrValueMeta ) {
						var output = {};
						if( typeof chart_args.parse[ arrValueMeta.period ] == 'undefined' ) {
							chart_args.parse[ arrValueMeta.period ] = {};
						}
						chart_args.parse[ arrValueMeta.period ][ intPostID ] = parseInt( arrValueMeta.count );
						//chart_args.parse[ arrValueMeta.period ].push( output );
					});
				} );

				$.each( chart_args.dates, function( intDateIndex, strDate ) {
					var output = {};
					output.period = strDate.slice( 0, 4 ) + '-' + strDate.slice( 4, 6 ) + '-' + strDate.slice( 6 );
					$.each( chart_args.keys, function( intKeyIndex, strKey ) {
						var parse = chart_args.parse[ strDate ] || {};
						output[ strKey ] = parse[ strKey ] || 0;
					} );
					chart_args.data.push( output );
				} );

			}
		},

		getMonthString : function( month ) {
			var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			return typeof months[ month ] != 'undefined' ? months[ month ] : null;
		},


		parseChartData : function( data, limit, type ) {

			var
				obj = this,
				current_time = new Date(),
				start_time = new Date(),
				chart_data = {
					months : new Array(),
					color : new Array(),
					data : new Array()
				},
				_limit = parseInt( limit ) || 0,
				_type = parseInt( type ) || 0;

			switch( _type ) {
				case 0:
					start_time.setDate( current_time.getDate() - _limit );
					break;

				case 2:
					start_time.setMonth( current_time.getMonth() - _limit );
					break;
			}


			while( start_time < current_time ) {

				// chart_data.months.push( obj.getMonthString( start_time.getMonth() ) );
				switch( _type ) {

					case 0:
						start_time.setDate( start_time.getDate() + 1 );
						chart_data.months.push(
							start_time.getFullYear().toString() +
							( '0' + (start_time.getMonth() + 1 ).toString() ).split(-2) +
							( '0' + (start_time.getDate() + 1 ).toString() ).split(-2)
						);
						break;

					case 2:
						start_time.setMonth( start_time.getMonth() + 1 );
						chart_data.months.push( start_time.getFullYear().toString() + ( '0' + (start_time.getMonth() + 1 ).toString() ).split(-2) );
						break;

				}
			}

			$.each( data, function( intPostID, arrChartMeta ) {
				var
					count_data = new Array(),
					start_time = new Date();

				switch( _type ) {
					case 0:
						start_time.setDate( current_time.getDate() - _limit );
						break;
					case 2:
						start_time.setMonth( current_time.getMonth() - _limit );
						break;
				}
				while( start_time < current_time ) {
					var _thisItemCount = 0;

					switch( _type ) {
						case 0:
							start_time.setDate( start_time.getDate() + 1 );
							break;
						case 2:
							start_time.setMonth( start_time.getMonth() + 1 );
							break;
					}

					$.each( arrChartMeta.values, function( intvalueKey, arrValueMeta ) {
						var _thisItemTime;
						switch( _type ) {
							case 0:
								_thisItemTime = new Date( arrValueMeta.period.substring( 0, 4 ) + '-' +  arrValueMeta.period.substring( 4,6 ) + '-' + arrValueMeta.period.substring( 6 ) );
								break;
							case 2:
								_thisItemTime = new Date( arrValueMeta.period.substring( 0, 4 ) + '-' +  arrValueMeta.period.substring( 4 ) + '-01' );
								break;
						}

						if( _type == 0 && ( start_time.getFullYear() == _thisItemTime.getFullYear() && start_time.getMonth() == _thisItemTime.getMonth() && start_time.getDate() == _thisItemTime.getDate() ) ) {
							_thisItemCount = arrValueMeta.count;
							return false;
						}

						if( _type == 2 && ( start_time.getFullYear() == _thisItemTime.getFullYear() && start_time.getMonth() == _thisItemTime.getMonth() ) ) {
							_thisItemCount = arrValueMeta.count;
							return false;
						}
					} );
					count_data.push( _thisItemCount );
				}

				chart_data.data.push({
					label : arrChartMeta.title,
					backgroundColor: arrChartMeta.color,
					borderColor: arrChartMeta.color,
					data: count_data,
					fill : '+2',
				});
				chart_data.color.push( arrChartMeta.color );
			} );

			return {
				labels : chart_data.months,
				datasets : chart_data.data

			};
		},

		parseChartData_old : function( data ) {

			var
				obj = this,
				current_time = new Date(),
				start_time = new Date(),
				chart_data = {
					months : new Array(),
					data : new Array()
				};

			start_time.setMonth( current_time.getMonth() - 6 );
			while( start_time < current_time ) {
				start_time.setMonth( start_time.getMonth() + 1 );
				// chart_data.months.push( obj.getMonthString( start_time.getMonth() ) );
				chart_data.months.push( start_time.getFullYear().toString() + ( '0' + (start_time.getMonth() + 1 ).toString() ).split(-2) );
			}

			$.each( data, function( intPostID, arrChartMeta ) {
				var
					count_data = new Array(),
					start_time = new Date();

				start_time.setMonth( current_time.getMonth() - 6 );
				while( start_time < current_time ) {
					var _thisItemCount = 0;
					start_time.setMonth( start_time.getMonth() + 1 );

					$.each( arrChartMeta.values, function( intvalueKey, arrValueMeta ) {
						var _thisItemTime = new Date( arrValueMeta.period.substring( 0, 4 ) + '-' +  arrValueMeta.period.substring( 4 ) + '-01' );
						if( start_time.getFullYear() == _thisItemTime.getFullYear() && ( start_time.getMonth() + 1 ) == _thisItemTime.getMonth() ) {
							_thisItemCount = arrValueMeta.count;
							return false;
						}
					} );
					count_data.push( _thisItemCount );
				}
				chart_data.data.push({
					label : arrChartMeta.title,
					backgroundColor: arrChartMeta.color,
					borderColor: arrChartMeta.color,
					data: count_data,
					fill : false,
				});
			} );

			return {
				labels : chart_data.months,
				datasets : chart_data.data

			};
		},

		footerFunction : function() {
			var
				footer_buttons = $( '.jvbpd-quick-buttons' ),
				BackToTop = $( '#back-to-top', footer_buttons );

			BackToTop.on( 'click', function() {
				$( 'html, body' ).animate( {
					scrollTop : 0,
				}, 800 );
			} );
			$( window ).on( 'scroll', function() {

				if( $( this ).scrollTop() > 50 ) {
					BackToTop.removeClass( 'hidden' ).fadeIn();
				}else{
					BackToTop.fadeOut();
				}
			} );

			$('body').on('mouseup',	function(e){
				var	$this =	$(this);

				if(	$(e.target).closest('.javo-quick-contact-us-content').length ==	0 ){
					$('.javo-quick-contact-us-content').removeClass('active');
				};

				$this.on('click', '.javo-quick-contact-us',	function(){
					console.log( $( this ) );
					$('.javo-quick-contact-us-content').addClass('active');
					$('.javo-quick-contact-us-content').css({
						top: $(this).closest( 'div' ).position().top - $('.javo-quick-contact-us-content').outerHeight(true)
					});
				});
			});


		},

		setChart : function() {

			var
				obj = this,
				elements = $( 'canvas.bp-mydahsobard-report-chart' );
			if( ! elements.length  ) {
				return false;
			}

			elements.map( function() {
				var element = $( this );
				new Chart( element.get(0).getContext( '2d' ) , {
					type: element.data( 'graph' ) || 'line',
					data: obj.parseChartData( element.data( 'values' ), element.data( 'limit' ), element.data( 'type' ) ),
					options: {
						responsive: true,
						title: { display:false, text:'Chart.js Line Chart' },
						tooltips: { mode: 'index', intersect: false },
						hover: { mode: 'nearest', intersect: true },
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: element.data( 'x' )
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: element.data( 'y' )
								}
							}]
						}
					}
				} );
			} );
		},

		setPie : function() {

			if( ! $( '#chart-area' ).length ) {
				return false;
			}


			var config = {
				type: 'doughnut',
				data: {
					datasets: [{
						data: [7,5,3],
						backgroundColor: [
							window.chartColors.blue,
							window.chartColors.green,
							window.chartColors.red,
						],
						label: 'Dataset 1'
					}],
					labels: [
						" Publish My Listings",
						" Pending My Listings",
						" Expired My Listings"
					]
				},
				options: {
					responsive: true,
						legend: {
							display: true,
										position: 'left',

						}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById("chart-area").getContext("2d");
				window.myPie = new Chart(ctx, config);
			};

		},

		setEvent : function() {
			var
				obj = this,
				LIST_WRAP = $( '.mypage-my-events-wrap' ),
				FORM_DELETE = LIST_WRAP.parent().find( 'form.delete-event-form' ),
				STR_DELETE = LIST_WRAP.data( 'delete-comment' ),
				BTN_DELETE = $( 'a.remove.action', LIST_WRAP ),
				DATE_PICKER_FIELD = $( 'input[data-date-picker]' );

			BTN_DELETE.on( 'click', function() {
				if( confirm( STR_DELETE ) ) {
					LIST_WRAP.closest( '.card' ).addClass( 'processing' );
					FORM_DELETE.find( '[name="event_id"]' ).val( $( this ).closest( 'li' ).data( 'id' ) );
					FORM_DELETE.submit();
				}
			} );

			DATE_PICKER_FIELD.datepicker( {
				dateFormat: 'yy-mm-dd',
				numberOfMonths: 3,
				changeMonth: true,
				changeYear: true
			} );
		},

		setEventUploader : function() {

			var obj = this;

			 /* Apply jquery ui sortable on gallery items */
			$( "#lava-multi-uploader" ).sortable({
				revert: 100,
				placeholder: "sortable-placeholder",
				cursor: "move"
			});

			/* initialize uploader */
			var uploaderArguments = {
				browse_button: 'select-images',          // this can be an id of a DOM element or the DOM element itself
				file_data_name: 'lava_multi_uploader',
				drop_element: 'lava-multi-uploader-drag-drop',
				url: obj.param.ajaxurl + '?action=' + obj.param.event_hook + 'upload_detail_images',
				filters: {
					mime_types : [
						{ title : 'image', extensions : "jpg,jpeg,gif,png" }
					],
					max_file_size: '10000kb',
					prevent_duplicates: true
				}
			};


			var uploader = new plupload.Uploader( uploaderArguments );
			uploader.init();

			$('#select-images').click(function(event){
				event.preventDefault();
				event.stopPropagation();
				uploader.start();
			});

			/* Run after adding file */
			uploader.bind('FilesAdded', function(up, files) {
				var html = '';
				var galleryThumb = "";
				plupload.each(files, function(file) {
					galleryThumb += '<div id="holder-' + file.id + '" class="gallery-thumb">' + '' + '</div>';
				});
				document.getElementById('lava-multi-uploader').innerHTML += galleryThumb;
				up.refresh();
				uploader.start();
			});


			/* Run during upload */
			uploader.bind('UploadProgress', function(up, file) {
				document.getElementById( "holder-" + file.id ).innerHTML = '<span>' + file.percent + "%</span>";
			});


			/* In case of error */
			uploader.bind('Error', function( up, err ) {
				document.getElementById('errors-log').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
			});


			/* If files are uploaded successfully */
			uploader.bind('FileUploaded', function ( up, file, ajax_response ) {
				var response = $.parseJSON( ajax_response.response );

				if ( response.success ) {

					var galleryThumbHtml = '<img src="' + response.url + '" alt="" />' +
					'<a class="remove-image" data-event-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#remove-image" ><i class="fa fa-trash-o"></i></a>' +
					'<a class="mark-featured" data-event-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#mark-featured" ><i class="fa fa-star-o"></i></a>' +
					'<input type="hidden" class="gallery-image-id" name="gallery_image_ids[]" value="' + response.attachment_id + '"/>' +
					'<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';

					document.getElementById( "holder-" + file.id ).innerHTML = galleryThumbHtml;

					bindThumbnailEvents();  // bind click event with newly added gallery thumb
				} else {
					// log response object
					console.log ( response );
				}
			});

			/* Bind thumbnails events with newly added gallery thumbs */
			var bindThumbnailEvents = function () {

				// unbind previous events
				$('a.remove-image').unbind('click');
				$('a.mark-featured').unbind('click');

				// Mark as featured
				$('a.mark-featured').click(function(event){

					event.preventDefault();

					var $this = $( this );
					var starIcon = $this.find( 'i');

					if ( starIcon.hasClass( 'fa-star-o' ) ) {   // if not already featured

						$('.gallery-thumb .featured-img-id').remove();      // remove featured image id field from all the gallery thumbs
						$('.gallery-thumb .mark-featured i').removeClass( 'fa-star').addClass( 'fa-star-o' );   // replace any full star with empty star

						var $this = $( this );
						var input = $this.siblings( '.gallery-image-id' );      //  get the gallery image id field in current gallery thumb
						var featured_input = input.clone().removeClass( 'gallery-image-id' ).addClass( 'featured-img-id' ).attr( 'name', 'featured_image_id' );     // duplicate, remove class, add class and rename to full fill featured image id needs

						$this.closest( '.gallery-thumb' ).append( featured_input );     // append the cloned ( featured image id ) input to current gallery thumb
						starIcon.removeClass( 'fa-star-o' ).addClass( 'fa-star' );      // replace empty star with full star

					}

				}); // end of mark as featured click event


				// Remove gallery images
				$('a.remove-image').click(function(event){

					event.preventDefault();
					var $this = $(this);
					var gallery_thumb = $this.closest('.gallery-thumb');
					var loader = $this.siblings('.loader');

					loader.show();

					var removal_request = $.ajax({
						url: obj.param.ajaxurl,
						type: "POST",
						data: {
							property_id : $this.data('event-id'),
							attachment_id : $this.data('attachment-id'),
							action : obj.param.event_hook + 'remove_detail_images',
						},
						dataType: "html"
					});

					removal_request.done(function( response ) {
						var result = $.parseJSON( response );
						if( result.attachment_removed ){
							gallery_thumb.remove();
						} else {
							document.getElementById('errors-log').innerHTML += "<br/>" + "Error : Failed to remove attachment";
						}
					});

					removal_request.fail(function( jqXHR, textStatus ) {
						alert( "Request failed: " + textStatus );
					});

				});  // end of remove gallery thumb click event

			};  // end of bind thumbnail events

			bindThumbnailEvents(); // run it first time - required for property edit page
		},

		setLeftMenu : function() {
			var
				obj = this,
				INT_COLLAPSE_WIDTH = 60,
				BTN_SIDEBAR_SWITCHER = $( '.dashboard-sidebar-switcher' ),
				HEADER_ELEMENT = $( '.navbar-default.navbar' ),
				BRAND_ELEMENT = $( '.navbar-header div.navbar-brand' ),
				SIDEBAR_ELEMENT = $( '.navbar-default.sidebar' ),
				CONTENT_ELEMENT = $( '#content-page-wrapper' ),
				LOGO_ELEMENT = $( '.navbar-brand', HEADER_ELEMENT ),
				INT_SIDEBAR_WIDTH = 220, //BRAND_ELEMENT.width(), //SIDEBAR_ELEMENT.width(),
				COOKIE_KEY = 'javobp_mypage_sidebar_switcher_onoff',
				IS_SWITCHER_COLLAPSE = this.getCookie( COOKIE_KEY ) == 'yes';

			// SIDEBAR_ELEMENT.find( '#nav-wrap' ).width( INT_SIDEBAR_WIDTH );
			BTN_SIDEBAR_SWITCHER.on( 'click', function( e, _param ) {
				var param = _param || {};
				if( true || $( window ).width() > 768 ) {
					if( ! $( this ).hasClass( 'active' ) ) {
						$( 'body' ).removeClass( 'sidebar-active' );
						BTN_SIDEBAR_SWITCHER.addClass( 'active' );
					}else{
						$( 'body' ).addClass( 'sidebar-active' );
						BTN_SIDEBAR_SWITCHER.removeClass( 'active' );
					}
				}

				/**
				BTN_SIDEBAR_SWITCHER.toggleClass( 'active' );
				*/
				if( true === param.activeClass ) {
					$( 'body' ).removeClass( 'sidebar-active-init' );
				}

				$( window ).trigger( 'resize' );
			} );

			$( '#nav-wrap', SIDEBAR_ELEMENT ).css( 'width', 'auto' );
		},

		setRightMenu : function() {
			var
				opener = $( '.overlay-sidebar-opener' ),
				panel = $( '.quick-view' ),
				panel_width = panel.width(),
				body_color = $( 'body' ).css( 'background-color' );

			panel.find( 'ul' ).width( panel_width );
			opener.on( 'click', function() {
				if( opener.hasClass( 'active' ) ) {
					panel.css( 'margin-right', -(panel_width) + 'px' );
					$( '.jv-my-page' ).removeClass( 'overlay' );
				}else{
					panel.css( 'margin-right', 0 );
					$( '.jv-my-page' ).addClass( 'overlay' );
				}
				opener.toggleClass( 'active' );
			} );
		},

		setCookie : function( key, value ) {
			var
				EXPIRE = new Date( new Date().getMonth() + 1 ),
				_COOKIE = key + '=' + escape( value ) + ';expires=0; path=/';
			document.cookie = _COOKIE;
		},

		getCookie : function( key, _default ) {
			var
				REGEXP = new RegExp( key + "=(.*?)(?:;|$)", "g" ),
				QUERY = REGEXP.exec( document.cookie ),
				_RETURN = _default;
			if( QUERY !== null ) {
				_RETURN = QUERY[1];
			}
			return _RETURN;
		},

		triggerBpListsGrid : function( callback ) {
			var self = this;
			return function() {
				var
					data_param = this.data || '',
					data = data_param.toString();
				$.each( ['action=members_filter', 'action=groups_filter'], function( index, query ) {
					if( data.indexOf( query ) >= 0 ) {
						callback();
					}
				} );
			}
		},

		setBuddyPressPage : function() {

			var
				self = this,
				switcher = $( '#groups-order-by, #members-order-by, #members-friends' ),
				callback = function() {
					$.each( [ $( '#members-loop-animation' ), $( '#group-loop-animation' ) ], function() {
						var
							nTimeID = null,
							element = $( this );
						if( element.length ) {
							nTimeID = setInterval( function() {
								new AnimOnScroll( element.get( 0 ), {
									minDuration : 0.4,
									maxDuration : 0.7,
									viewportFactor : 0.2
								});
								clearInterval( nTimeID );
							}, 500 );
						}
					} );
				};

			switcher.on( 'change', function() {
				$( '#buddypress-inner #grid' ).addClass( 'ajax-processing' );
			} );

			$.ajaxSetup( { complete : self.triggerBpListsGrid( callback ) } );
			jQuery( document ).ready( function( $ ) {
				callback();
			} );
		},

		setPreload : function() {
			var
				element = $( '.preloader' ),
				elementCloseFunc = function() {
					element.addClass( 'hidden' );
				};
			$( document ).ready( elementCloseFunc );
			$( '.skip', element ).on( 'click', elementCloseFunc );
		},

		// pallaxHeader : function() {},
		pallaxHeader : function() {

			$( '.jv-parallax' ).each( function() {

				var
					image = $( $( this ).data( 'image' ), this ) || false,
					overlay = $( $( this ).data( 'overlay' ), this ) || false;

				if( false == image || false == overlay ) {
					return false;
				}

				$( this ).css( 'overflow', 'hidden' );

				$( window ).on( 'scroll', function() {
					var currentY = $( this ).scrollTop();

					if( overlay.length ){
						var
							endY = overlay.offset().top + overlay.height(),
							scrollY = parseFloat( currentY / endY );

						if( scrollY <= 1 ){
							image.css({
								'transform':
									'scale(' + parseFloat( 1 + ( scrollY * 0.12 ) ) + ')' +
									'translate3d( 0, ' + parseInt( scrollY * 10 ) + '%, 0 )'
							});

							// Default Opacity : 0.4
							scrollY = 0.4 + scrollY;

							overlay.css({
								'backgroundColor':'rgba(0,0,0, ' +  scrollY + ')',
							});
						}
					}
				} );

			} );
		},

		setBuddyPressSingle : function() {
			jQuery(document).ready(function( $ ){
				if( typeof $.fn.tabdrop != 'undefined' ) {
					jQuery('.responsive-tabdrop').tabdrop();
				}
			});
		},

		setBuddyPressMemberSidebar : function() {
			$( '.jvbpd-member-sidebar .opener' ).on( 'click', function() {
				if( $( this ).hasClass( 'open' ) ) {
					$( this ).removeClass( 'open' );
					$( '.jvbpd-member-sidebar-overlay' ).removeClass( 'open' );
					$( this ).closest( '.jvbpd-member-sidebar' ).removeClass( 'open' );
				}else{
					$( this ).addClass( 'open' );
					$( '.jvbpd-member-sidebar-overlay' ).addClass( 'open' );
					$( this ).closest( '.jvbpd-member-sidebar' ).addClass( 'open' );
				}
			});

			$( '.jvbpd-member-sidebar-overlay' ).on( 'click', function() {
				$( '.jvbpd-member-sidebar .opener' ).trigger( 'click' );
			});
		},

		bindSearchFormAction : function() {
			var
				is_focus = 'is-focus-search-field',
				field = $( '.dashboard-search-wrap input[type="text"]' );

			field.on( 'focus', function(){ $( 'body' ).addClass( is_focus ); });
			field.on( 'blur', function(){ $( 'body' ).removeClass( is_focus ); });

		},

		setTooltips : function() {

			if( typeof $.fn.tooltip == 'undefined' ) {
				return;
			}

			$( '[data-jvbpd-tooltip]' ).each( function() {
				var content_template = $( $( this ).data( 'jvbpd-tooltip' ) );
				$( this ).tooltip( {
					html : true,
					title : content_template.html(),
					trigger : 'hover',
					placement : 'bottom'
				} );
			} );
		},

		bp_notification : function() {

			var
				self = this,
				last_notified = jvbpd_notify.last_notified,
				new_notifications_count = 0;

			jQuery(document).ready(function(){

				var jq = jQuery;

				wp.heartbeat.interval( 'fast' );

				jq(document).on( 'heartbeat-tick.jvbpd-data', function( event, data ) {

					if ( data.hasOwnProperty( 'jvbpd-data' ) ) {
						var jvbpd_data = data[ 'jvbpd-data' ] ;

						last_notified = jvbpd_data.last_notified;

						var messages = jvbpd_data.messages;

						if( messages == undefined || messages.length == 0 )
							return ;

						for( var i =0; i< messages.length; i++ ) {
						   jvbpd_notify.notify(messages[i]);
						}

						jq( document ).trigger( "bpln:new_notifications", [{count: messages.length, 'messages': messages}] );
					}
				});

				jq(document).on( 'heartbeat-send', function( e, data ) {
					data['jvbpd-data'] = { 'last_notified' : last_notified };
				});

				jvbpd_notify.notify = function( message ){
					if( jq.achtung != undefined ) {
						jq.achtung({message: message, timeout: jvbpd_notify.timeout});
					}
				};

				jvbpd_notify.get_count = function(){
					return new_notifications_count;
				};

				jq( document ).on('bpln:new_notifications', function(evt, data ){
					if( data.count && data.count>0 ){
						update_count_text( jq( '[data-bp-notifications="count"]'), data.count );
						jq( '[data-bp-notifications="list"]' ).append("<li>"+data.messages.join("</li><li>") + "</li>"  );
						jq( '.not-found-notification' ).remove();
					}
				});

				function update_count_text( elements, count) {

					if( ! elements.get(0) || ! count  )
						return;

					elements.each( function() {
						var element = jq(this);
						var current_count = parseInt( element.text() );
						current_count = current_count + parseInt(count) - 0;
						element.text( '' + current_count );
					});
				}
			});
		},

		carousel : function() {
			$('.jvbpd-carousel-items').each(function () {
                // Load Carousel options into variables
                var $currentCrslPrnt = $(this);
                var $currentCrsl = $currentCrslPrnt.children('.jvbpd-carousel');
                var $prev = $currentCrslPrnt.closest('.jvbpd-carousel-container').find(".carousel-arrow .carousel-prev");
                var $next = $currentCrslPrnt.closest('.jvbpd-carousel-container').find(".carousel-arrow .carousel-next");
                var $pagination = $currentCrslPrnt.closest('.jvbpd-carousel-container').find(".jvbpd-carousel-pager");

                var $visible,
                    $items_height = 'auto',
                    $items_width = null,
                    $auto_play = false,
                    $auto_pauseOnHover = 'resume',
                    $scroll_fx = 'scroll',
                    $duration = 2000;

                if ($currentCrslPrnt.data("pager")) {
                    $pagination = $currentCrslPrnt.closest('.jvbpd-carousel-container').find($currentCrslPrnt.data("pager"));
                }
                if ($currentCrslPrnt.data("autoplay")) {
                    $auto_play = true;
                }
                if ($currentCrslPrnt.data("speed")) {
                    $duration = parseInt($currentCrslPrnt.data("speed"));
                }
                if ($currentCrslPrnt.data("items-height")) {
                    $items_height = $currentCrslPrnt.data("items-height");
                }
                if ($currentCrslPrnt.data("items-width")) {
                    $items_width = $currentCrslPrnt.data("items-width");
                }
                if ($currentCrslPrnt.data("scroll-fx")) {
                    $scroll_fx = $currentCrslPrnt.data("scroll-fx");
                }

                if ($currentCrslPrnt.data("min-items") && $currentCrslPrnt.data("max-items")) {
                    $visible = {
                        min: $currentCrslPrnt.data("min-items"),
                        max: $currentCrslPrnt.data("max-items")
                    };
                }
                // Apply common carousel options
                $//currentCrsl.imagesLoaded(function () {
                    $currentCrsl.carouFredSel({
                        responsive: true,
                        width: '100%',
                        pagination: $pagination,
                        prev: $prev,
                        next: $next,
                        auto: {
                            play: $auto_play,
                            pauseOnHover: $auto_pauseOnHover
                        },
                        scroll: {
                            items: 1,
                            duration: 600,
                            fx: $scroll_fx,
                            easing: "swing",
                            timeoutDuration: $duration,
                            wipe: true
                        },
                        items: {
                            width: $items_width,
                            height: $items_height,
                            visible: $visible
                        }
                    });// .visible();
                    $currentCrsl.swipe({
                        excludedElements: "",
                        threshold: 40,
                        swipeLeft: function () {
                            $currentCrsl.trigger('next', 1);
                            setTimeout(function () {
                                $currentCrsl.trigger('updateSizes');
                            }, 600);
                        },
                        swipeRight: function () {
                            $currentCrsl.trigger('prev', 1);
                            setTimeout(function () {
                                $currentCrsl.trigger('updateSizes');
                            }, 600);

                        },
                    });
                //});
            });

            if ($(".jvbpd-thumbs-carousel").length) {
                $(".jvbpd-thumbs-carousel").each(function () {
                    var $thumbsCarousel = $(this),
                        $thumbsVisible = 6,
                        $circular = false;

                    if ($thumbsCarousel.data("min-items") && $thumbsCarousel.data("max-items")) {
                        $thumbsVisible = {
                            min: $thumbsCarousel.data("min-items"),
                            max: $thumbsCarousel.data("max-items")
                        };
                    }
                    if ($thumbsCarousel.data("circular")) {
                        $circular = true;
                    }

                    $thumbsCarousel.imagesLoaded(function () {
                        $thumbsCarousel.carouFredSel({
                            responsive: true,
                            circular: $circular,
                            infinite: true,
                            auto: false,
                            prev: {
                                button: function () {
                                    return $(this).parents('.jvbpd-gallery').find('.jvbpd-thumbs-prev');
                                }
                            },
                            next: {
                                button: function () {
                                    return $(this).parents('.jvbpd-gallery').find('.jvbpd-thumbs-next');
                                }
                            },
                            scroll: {
                                items: 1
                            },
                            items: {
                                height: 'auto',
                                visible: $thumbsVisible
                            }
                        });
                        $thumbsCarousel.swipe({
                            excludedElements: "",
                            threshold: 40,
                            swipeLeft: function () {
                                $thumbsCarousel.trigger('next', 1);
                                setTimeout(function () {
                                    $thumbsCarousel.trigger('updateSizes');
                                }, 600);
                            },
                            swipeRight: function () {
                                $thumbsCarousel.trigger('prev', 1);
                                setTimeout(function () {
                                    $thumbsCarousel.trigger('updateSizes');
                                }, 600);
                            }
                        });
                    });
                });
            }

            $('.jvbpd-thumbs-carousel a').click(function (e) {
                $(this).closest('.jvbpd-gallery-container').find('.jvbpd-gallery-image').trigger('slideTo', '#' + this.href.split('#').pop());
                $('.jvbpd-thumbs-carousel a').removeClass('selected');
                $(this).addClass('selected');
	            e.preventDefault();
                return false;
            });

            var jvbpdGalleryImage = $(".jvbpd-gallery-image");

            if (jvbpdGalleryImage.length) {
	            jvbpdGalleryImage.imagesLoaded(function () {
		            jvbpdGalleryImage.carouFredSel({
                        responsive: true,
                        circular: false,
                        auto: false,
                        items: {
                            height: 'variable',
                            visible: 1
                        },
                        scroll: {
                            items: 1,
                            fx: 'crossfade'
                        }
                    });
		            jvbpdGalleryImage.swipe({
                        excludedElements: "",
                        threshold: 40,
                        swipeLeft: function () {
                            $('.jvbpd-gallery-image').trigger('next', 1);
                            setTimeout(function () {
                                $('.jvbpd-gallery-image').trigger('updateSizes');
                            }, 600);
                        },
                        swipeRight: function () {
                            $('.jvbpd-gallery-image').trigger('prev', 1);
                            setTimeout(function () {
                                $('.jvbpd-gallery-image').trigger('updateSizes');
                            }, 600);
                        }
                    });
                });
            }

		}
	}

	window.javoDB = new javoMyDashboard;

	$( '.javo-mypage-toast' ).each( function() {
		$.toast({
			heading: $( this ).data( 'heading' ),
			text: $( this ).data( 'content' ),
			position: 'top-right',
			loaderBg: '#ff6849',
			icon: 'info',
			hideAfter: 10000,
			stack: 6
		});
	} );

	jQuery( document ).ready(function ($) {

		"use strict";

		var body = $("body");

		$(function () {
			/* $('.left-sidebar #nav-wrap').metisMenu(); */
			$('#jv-slidebar-left, #jv-slidebar-right').metisMenu();
			/* $('.vertical.sidebar #nav-wrap').metisMenu(); */
			// if( $( window ).width() < 992 ) {
				$('#jv-nav-menu-left').metisMenu();
			//  }
		});

		$(function () {
			var set = function () {
					var topOffset = 60,
						width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
						height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
					if (width < 768) {
						$('div.navbar-collapse').addClass('collapse');
						topOffset = 100;
					} else {
						$('div.navbar-collapse').removeClass('collapse');
					}

					if (width < 1170) {
						body.addClass('sidebar-closed');
						$(".open-close i").removeClass('icon-arrow-left-circle');
						$(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
						$(".logo span").hide();
					} else {
						body.removeClass('sidebar-closed');
						$(".open-close i").addClass('icon-arrow-left-circle');
						$(".logo span").show();
					}

					height = height - topOffset;
					if (height < 1) {
						height = 1;
					}
				},
				url = window.location,
				element = $('ul.nav a').filter(function () {
					return this.href === url || url.href.indexOf(this.href) === 0;
				})/*.addClass('active')*/.parent().parent().addClass('in').parent();
			if (element.is('li')) {
				// element.addClass('active');
			}
			$(window).ready(set);
			$(window).on("resize", set);
		});

		$(".open-close").on('click', function () {
			if ($("body").hasClass("sidebar-closed")) {
				$("body").trigger("resize");
				$(".sidebar-nav, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible");
				$("body").removeClass("sidebar-closed");
				$(".open-close i").addClass("icon-arrow-left-circle");
				$(".logo span").show();
			} else {
				$("body").trigger("resize");
				$(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
				$("body").addClass("sidebar-closed");
				$(".open-close i").removeClass("icon-arrow-left-circle");
				$(".logo span").hide();
			}
		});

		(function ($, window, document) {
			var panelSelector = '[data-perform="panel-collapse"]',
				panelRemover = '[data-perform="panel-dismiss"]';
			$(panelSelector).each(function () {
				var collapseOpts = {
						toggle: false
					},
					parent = $(this).closest('.panel'),
					wrapper = parent.find('.panel-wrapper'),
					child = $(this).children('i');
				if (!wrapper.length) {
					wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
					collapseOpts = {};
				}
				wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
					child.removeClass('ti-minus').addClass('ti-plus');
				}).on('show.bs.collapse', function () {
					child.removeClass('ti-plus').addClass('ti-minus');
				});
			});

			$(document).on('click', panelSelector, function (e) {
				e.preventDefault();
				var parent = $(this).closest('.panel'),
					wrapper = parent.find('.panel-wrapper');
				wrapper.collapse('toggle');
			});

			$(document).on('click', panelRemover, function (e) {
				e.preventDefault();
				var removeParent = $(this).closest('.panel');

				function removeElement() {
					var col = removeParent.parent();
					removeParent.remove();
					col.filter(function () {
						return ($(this).is('[class*="col-"]') && $(this).children('*').length === 0);
					}).remove();
				}
				removeElement();
			});
		}(jQuery, window, document));

		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});

		$(function () {
			$('[data-toggle="popover"]').popover();
		});

		$(".list-task li label").on("click", function () {
			$(this).toggleClass("task-done");
		});
		$(".settings_box a").on("click", function () {
			$("ul.theme_color").toggleClass("theme_block");
		});

		$(".collapseble").on("click", function () {
			$(".collapseblebox").fadeToggle(350);
		});

		body.trigger("resize");

		$('.visited li a').on("click", function (e) {
			$('.visited li').removeClass('active');
			var $parent = $(this).parent();
			if (!$parent.hasClass('active')) {
				$parent.addClass('active');
			}
			e.preventDefault();
		});

		$('#to-recover').on("click", function () {
			$("#loginform").slideUp();
			$("#recoverform").fadeIn();
		});

		$(".navbar-toggle").on("click", function () {
			$(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
		});
	});
} );
(  function($, window, undef ) {
	"use strict";

	var ajax_cache_obj = function() {
		this.data = new Array();
	}
	ajax_cache_obj.prototype.constructor = ajax_cache_obj;
	ajax_cache_obj.prototype.get = function( key ) {
		var key_name = this.sanitize_key( key );
		return this.data[key_name] || false;
	};

	ajax_cache_obj.prototype.set = function( key, value ) {
		var key_name = this.sanitize_key( key );
		this.data[key_name] = value;
	};

	ajax_cache_obj.prototype.sanitize_key = function( key ) {
		var
			objKey = key.attr || {},
			_return = '';

		if( typeof objKey == 'object' ) {
			$.each( objKey, function( i, k ) {
				if( k == '' || k == false || k == 'false' || k == null ) {
					delete objKey[ i ];
				}
			} );
			_return = JSON.stringify( objKey );
		}
		return _return;
	}

	window.JvbpdAjaxShortcodeCache = new ajax_cache_obj();

	/**
	 *
	 * Basic Shortcode
	 */

	var jvbpd_ajaxShortcode = function( el, attr ) {
		var
			exists,
			target = $( '#js-' + el ).closest( '.shortcode-container' ).attr( 'id' );

		this.ID = el;
		this.orginID	= target;
		this.el = $( '#' +	 this.orginID );
		this.attr = attr;
		exists = this.el.length;

		if( exists ) {
			this.init();
		}
	}

	jvbpd_ajaxShortcode.prototype = {

		constructor : jvbpd_ajaxShortcode,
		init : function() {

			var obj = this;
			obj.loadmore = false;
			obj.param = {};
			obj.param.attr = obj.attr;
			obj.param.action = 'jvbpd_ajaxShortcode_loader';

			obj.bindEvents();
			obj.lazyload();

		},

		bindEvents : function() {
			var
				obj = this,
				el = obj.el;

			$( document )
				.on( 'click.' + obj.ID	, el.find( "ul[data-tax] li:not(.flexMenu-viewMore)" ).selector, obj.category_filter() )
				.on( 'click.' + obj.ID	, el.find( "a.page-numbers" ).selector, obj.pagination() )
				.on( 'jv:sc' + obj.ID	, obj.slideShow() ).trigger( 'jv:sc' + obj.ID );

			$( window )
				.on( 'scroll.' + obj.ID, obj.lazyload() )
				.trigger( 'scroll' );



			if( ! el.hasClass( 'no-flex-menu' ) ) {
				obj.stackable();
				$( window ).on( 'resize.' + obj.ID,  obj.stackable() );
			}
		},

		category_filter : function() {
			var
				obj = this,
				element = obj.el;
			return function( e ) {

				e.preventDefault();

				var
					term_id = $(  this ).data( 'term' ),
					taxonomy = $(  this ).closest( 'ul.shortcode-filter' ).data( 'tax' );

				$( "ul[data-tax].shortcode-filter li", element ).removeClass( 'current' );
				$( this ).addClass( 'current' );

				if( taxonomy && obj.param.attr !== undef ){
					obj.param.attr.term_id = term_id;
					obj.param.attr.taxonomy	= taxonomy;
					obj.param.attr.paged = 1;
				}
				obj.filter( true );
				return;
			}
		},

		pagination : function() {

			var obj		= this;
			return function( e ) {
				var
					current			= 0,
					direction		= '',
					strPagination	= $( this ).data( 'href' ),
					is_disabled		= $( this ).hasClass( 'disabeld' ),
					is_loadmore		= $( this ).hasClass( 'loadmore' ),
					is_prevNext		= $( this ).hasClass( 'prevNext' );

				e.preventDefault();

				if( is_disabled )
					return;

				if( strPagination ){
					strPagination = strPagination.split( '|' );
					if( strPagination[1]  !== 'undefined' ) {
						current = strPagination[1];
					}
				}

				if( is_loadmore ) {
					obj.loadmore = true;
					obj.param.attr.pagination = 'loadmore';
				}

				obj.param.attr.paged = current;
				obj.filter();
				return;
			}
		},

		filter : function( is_setTerm ) {
			var
				obj = this,
				param = obj.param,
				element = obj.el,
				parent = element.parent(),
				is_loadmore = obj.loadmore,
				loading = $( ".output-cover, .output-loading" , parent ),
				_cached = JvbpdAjaxShortcodeCache.get( param ),
				callbackComplete = function( xhr ) {
					var output = $( '> .shortcode-output', element );

					if( false === _cached ) {
						JvbpdAjaxShortcodeCache.set( param, xhr );
					}

					if( element.hasClass( 'exists-wrap' ) )
						output = $( '> .shortcode-content > .shortcode-output', element );

					$( document ).off( 'click.' + obj.ID + ' ' + 'jv:sc' + obj.ID );
					$( window ).off( 'resize.' + obj.ID + ' ' + 'scroll.' + obj.ID );
					delete window.__javoAjaxShortcode_instance;

					if( is_setTerm ) {
						output.html( xhr );
					}else{
						if( is_loadmore ) {
							$( ".loadmore", element ).closest( '.jv-pagination' ).remove();
							output.append( xhr );
						}else{
							output.html( xhr );
						}
					}

					loading.removeClass( 'active' );
					$( window ).trigger( 'scroll' );

				};

			loading.addClass( 'active' );

			if( false !== _cached ) {
				callbackComplete( _cached );
			}else{
				$.post( document.ajaxurl, param, callbackComplete, 'html' ).fail( function( xhr ) { console.log( xhr.responseText ); } );
			}
			return false;
		},

		stackable : function() {
			var
				obj = this,
				element	= obj.el,
				nav = $( "ul.shortcode-filter", element ),
				divPopup = $( "ul.flexMenu-popup", nav ),
				btnMore = $( "> li.flexMenu-viewMore > a", nav );

			return function(){
				var
					containerWidth	= $( ".shortcode-header", element ).innerWidth()
					, titleWidth	= $( ".shortcode-title", element ).outerWidth()
					, offsetX		= containerWidth - ( titleWidth + 1 );

				// nav.width( offsetX );
				nav.flexMenu({ undo : true }).flexMenu({
					showOnHover : true
					//, linkText	: nav.data( 'more' )
					, linkText : '<i class="fa fa-bars"></i>'
					//, linkTextAll	: nav.data( 'mobile' )
					, linkTextAll : '<i class="fa fa-bars"></i>'
				});
			}
		},

		lazyload : function(){

			var
				obj				= this,
				lazyStarted		= false,
				intWinScrollTop	= 0,
				intWinHeight	= 0,
				intSumOffset	= 0,
				intCurrentIDX	= 0,
				intInterval		= 100,
				objWindow		= $( window );

			return function(){
				intWinScrollTop	= objWindow.scrollTop();
				intWinHeight	= objWindow.height() * 0.9;
				intSumOffset	= intWinScrollTop + intWinHeight;

				if( ( intSumOffset > obj.el.offset().top ) && !lazyStarted ) {

					$( 'img.jv-lazyload, div.jv-lazyload', obj.el ).each( function( i, el ){
						var nTimeID = setInterval( function(){
							$( el ).addClass( 'loaded' );
							clearInterval( nTimeID );
						}, i * intInterval );
					});
				}
			}
		},

		slideShow : function(){
			var
				obj				= this
				, el				= obj.el
				, output		= $( "> .shortcode-output", el )
			return function(){
				if( !el.hasClass( 'is-slider' ) || !$.fn.flexslider )
					return;

				$( "> .slider-wrap", output ).flexslider({
					animation		: 'slide'
					// Note : Flexslider.css Dot nav Padding Problem...
					, controlNav	: el.hasClass( 'circle-nav' )
					, slideshow		: el.hasClass( 'slide-show' )
					, direction		: el.hasClass( 'slider-vertical' ) ? 'vertical' : 'horizontal'
					, smoothHeight: true
				});
			}
		}
	}

	$.jvbpd_ajaxShortcode = function( element, args ){
		window.__javoAjaxShortcode_instance = new jvbpd_ajaxShortcode( element, args );
	};

	/**
	 *
	 * Buddypress Shortcode
	 */

	var jvbpd_bp_shortcode = function( el ){
		this.el = $( el );
		this.bindEvent();
	}

	jvbpd_bp_shortcode.prototype.constructor = jvbpd_bp_shortcode;
	jvbpd_bp_shortcode.prototype.bindEvent = function() {
		var self = this;
		$( '.item-options a', this.el ).on( 'click', function( e ) {
			e.preventDefault();
			var param = $( this ).closest( '.shortcode-nav' ).data( 'param' ) || {};
			param.filter = $( this ).data( 'filter' );
			$.post( document.ajaxurl, param, self.loopResponsive() );
		} );
	}

	jvbpd_bp_shortcode.prototype.loopResponsive = function() {
		var self = this;
		return function( xhr ) {
			$( '.item-list', self.el ).html( xhr );
		}
	}

	$( '[class*="shortcode-jvbpd_bp_"]' ).each( function() {
		new jvbpd_bp_shortcode( this );
	} );

} )( jQuery, window );
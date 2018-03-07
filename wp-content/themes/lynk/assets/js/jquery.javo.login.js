( function( $ ){
	"use strict";

	var jvbpd_ajax_login = function ( el ) {

		this.debugMode = false;

		this.form = $( el );
		this.param = jvbpd_login_param;
		this.ajaxurl = jvbpd_login_param.ajaxurl;
		this.init();
	}

	jvbpd_ajax_login.prototype.constructor = jvbpd_ajax_login;

	jvbpd_ajax_login.prototype.log = function( msg ) {
		if( ! this.debugMode ) {
			return false;
		}
		console.error( msg );
	}

	jvbpd_ajax_login.prototype.init = function() {
		this.bindEvent();
	};

	jvbpd_ajax_login.prototype.bindEvent = function() {

		this.form.on( 'submit', this.submit() );

		$( document )
			.on( 'submit', '[data-javo-modal-register-form]', this.join_submit() )
			.on( 'click', 'a[data-target="#register_panel"], a[data-target="#login_panel"]', this.swap_panel() )
			.on( 'javo:loginProcessing', this.processing() );
	}

	jvbpd_ajax_login.prototype.submit = function() {
		var self = this;
		return function( e ) {
			e.preventDefault();
			self.log( 'Login Start' );

			$.ajaxSetup({
				beforeSend : function () {
					$( document ).trigger( 'javo:loginProcessing' );
				},
				complete : function () {
					$( document ).trigger( 'javo:loginProcessing', new Array( true ) );
				}
			});

			$.post(
				self.ajaxurl,
				self.form.serialize(),
				function ( xhr ){
					self.log( xhr );
					if( xhr && xhr.error ) {
						$.jvbpd_msg({ content: xhr.error || "Failed" });
					}else{
						if( xhr && xhr.state == 'OK' ){
							if( xhr.redirect == '#' ){
								location.reload();
							}else{
								location.href = xhr.redirect;
							}
						}
					}
				}, 'json'
			)
			.fail( function(xhr) {
				console.log( xhr.responseText );
			} );
		}
	}

	jvbpd_ajax_login.prototype.processing = function() {
		var self		= this;
		return function ( event, able ) {
			var
				elements	= self.form.find( '*' ),
				submit		= self.form.find( "[type='submit']" );

			if( able ) {
				elements.prop( 'disabled', false )	.removeClass( 'disabled' );
				submit.button( 'reset' );
			}else{
				elements.prop( 'disabled', true )	.addClass( 'disabled' );
				submit.button( 'loading' );
			}
		}
	}

	jvbpd_ajax_login.prototype.join_submit = function() {
		var self = this;

		return function( e ) {
			e.preventDefault();

			var $this = $(this);

			$( this ).find('input').each( function(){
				if( $(this).val() == '' ){
					if( ! $( this ).hasClass( 'no-require' ) )
						$(this).addClass('isNull');
				}else{
					$(this).removeClass('isNull');
				}
			});

			if( $(this).find('[name="user_pass"]').val() != $(this).find('[name="user_con_pass"]').val() ){
				$(this).find('[name="user_pass"], [name="user_con_pass"]').addClass('isNull');
				return false;
			}else{
				$(this).find('[name="user_pass"], [name="user_con_pass"]').removeClass('isNull');
			}

			if( $(this).find('[name="user_login"]').get(0).value.match(/\s/g) ){
				var str = self.param.errUserName;
				$.jvbpd_msg({ content:str }, function(){ $(this).find('[name="user_login"]').focus(); });
				$(this).find('[name="user_login"]').addClass('isNull');
			}

			if( $(this).find('.isNull').length > 0 )
				return false;

			if( $( ".javo-register-agree" ).length > 0 )
				if( ! $( ".javo-register-agree" ).is( ":checked" ) ) {
					$.jvbpd_msg({ content: self.param.errNotAgree });
					return false;
				}

			$( this ).find('[type="submit"]').button('loading');

			$.ajax({
				url: self.ajaxurl,
				type:'post',
				data: $( this ).serialize(),
				dataType:'json',
				error: function(e){  },
				success: function(d){
					if( d.state == 'success'){
						$.jvbpd_msg({content:self.param.strJoinComplete, delay:3000}, function(){
							document.location.href= d.link;
						});
					}else{
						if(d.comment){
							$.jvbpd_msg({ content:d.comment, delay:100000 });
						}else{
							$.jvbpd_msg({ content:self.param.errDuplicateUser, delay:100000 });
						}
					}
					$this.find('[type="submit"]').button('reset');
				}
			});
		}
	}

	jvbpd_ajax_login.prototype.swap_panel = function() {
		return function( e ) {
			$( this ).closest( '.modal' ).modal( 'hide' );
		}
	}

	jvbpd_ajax_login.prototype.throw = function( strMessage, args ) {
		var has_msgbox = typeof $.fn.jvbpd_msg == 'function';
		alert( strMessage );


	}

	$( '.jv-modal-login' ).each( function( $ ) {
		new jvbpd_ajax_login( this );
	} );

} )( jQuery, window );
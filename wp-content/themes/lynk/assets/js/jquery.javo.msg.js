/**
 *
 * Javo Themes Message Dialogs
 * Version : 1.2
 */
;( function( $ ){
	"use strict";

	var jvbpd_messageFunc = function( a, c ) { this.init( a, c ); return this; }

	jvbpd_messageFunc.prototype.constructor = jvbpd_messageFunc;
	jvbpd_messageFunc.prototype.init = function( attr, callback ) {
		this.DEFAULT		= {
			content			: 'No Message'
			, delay			: 500000
			, close			: true
			, button		: "OK"
			, classes		: ''
			, blur_close	: false
		}
		this.attr		= $.extend( true, {}, this.DEFAULT, attr );
		this.callback	= callback;
		this.button		= '<div class="text-center">';
			this.button	+= '<input type="button" id="javo-alert-box-close" class="btn btn-dark btn-sm" value="' + this.attr.button + '">'
		this.button		+= '</div>';
		this.el			= '#javo-alert-box'
		this.el_bg		= '#javo-alert-box-bg';
		this.el_button	= '#javo-alert-box-close';
		if( typeof window.jvbpd_mbf_TimeID != "undefined" ) {
			$( this.el_bg + ", " + this.el ).remove();
			clearInterval( window.jvbpd_mbf_TimeID );
			window.jvbpd_mbf_TimeID	= null;
		}
		this.open( this.attr );
		$( document ).on( 'click', this.el_button, this.close() );
		if( typeof this.attr.close_trigger != "undefined" ) {
			$( document ).on( 'click', this.attr.close_trigger, this.close() );
		}
		if( this.attr.blur_close ) {
			$( document ).on( 'click', this.el_bg, this.close() );
		}
	}
	jvbpd_messageFunc.prototype.open = function() {
		var
			self = this,
			attr = self.attr;
		$( document )
			.find('body')
			.prepend( '<div id="javo-alert-box" class="' + attr.classes + '" tabindex="-1"></div><div id="javo-alert-box-bg"></div>' );
		$( this.el )
			.html( '<h5>' + attr.content + '</h5>' )
			.css({ marginLeft : -( $( this.el ).outerWidth(true) ) / 2 })
			.animate({ marginTop : -( $( this.el ).outerHeight(true) ) / 2 }, 300, function(){
				window.jvbpd_mbf_TimeID = setInterval( self.close, attr.delay );
			});
		if( attr.close ){
			$( this.el ).append( this.button );
		}

	}
	jvbpd_messageFunc.prototype.close = function() {
		var self = this;
		return function() {
			if( typeof e != 'undefined' ) {
				e.preventDefault();
			}
			if( typeof window.jvbpd_mbf_TimeID != 'undefined') {
				clearInterval( window.jvbpd_mbf_TimeID );
				self.nTimeID == null;
			}
			$( self.el_bg ).fadeOut('fast', function(){ $(this).remove(); });
			$( self.el ).fadeOut('fast', function(){ $(this).remove(); });
			if( typeof self.callback == 'function' ){
				self.callback();
			}
		}
	}
	$.jvbpd_msg = function( a, c ) { new jvbpd_messageFunc( a, c ); }
})(jQuery);
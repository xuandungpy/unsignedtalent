;(function($){
	"use strict";
	// WordPress media upload button command.
	// Required: library/enqueue.php:  wp_media_enqueue();
	$("body").on("click", ".javo-fileupload", function(e){
		e.preventDefault();
		var $this = $(this);
		var file_frame;
		if(file_frame){ file_frame.open(); return; }
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $this.data('title'),
			multiple: $this.data('multiple')
		});
		file_frame.on( 'select', function(){
			var attachment;
			if( $this.data('multiple') ){
				var selection = file_frame.state().get('selection');
				selection.map(function(attachment){
					var output = "";
					attachment = attachment.toJSON();

					if( $this.hasClass( 'other' ) ){
						output += "<li class=\"list-group-item jvbpd_dim_div\">";
						output += attachment.filename
						output += "<input type='hidden' name='jvbpd_attach_other[]' value='" + attachment.id + "'>";
						output += "<input type='button' value='Delete' class='btn btn-danger btn-sm jvbpd_detail_image_del'>";
						output += "</li>";
						$( $this.data('preview') ).append( output );

					}else{
						output += "<div class='col-md-3 jvbpd_dim_div'>";
						output += "		<div class='col-md-12' style='overflow:hidden;'><img src='" + attachment.url + "' style='height:120px;'></div>";
						output += "		<div class='row'><div class='col-md-12' align='center'>";
						output += "			<input type='hidden' name='jvbpd_dim_detail[]' value='" + attachment.id + "'>";
						output += "			<input type='button' value='Delete' class='btn btn-danger btn-xs jvbpd_detail_image_del'>";
						output += "		</div>";
						output += "</div>";
						$( $this.data('preview') ).append( output );
					}
				});

				$( window ).trigger( 'update_detail_image' );

			}else{
				attachment = file_frame.state().get('selection').first().toJSON();
				$( $this.data('input')).val(attachment.id);
				$( $this.data('preview') ).prop("src", attachment.url );

				$( window ).trigger( 'update_featured_image' );
			};
		});
		file_frame.open();
		// Upload field reset button
	}).on('click', '.javo-fileupload-cancel', function(){
		$($(this).data('preview')).prop('src', '');
		$($(this).data('input')).prop('value', '');
	}).on("click", ".jvbpd_detail_image_del", function(){
		var tar = $(this).data("id");
		$(this).parents(".jvbpd_dim_div").remove();
		$("input[name^='jvbpd_dim_detail'][value='" + tar + "']").remove();
		$( window ).trigger( 'update_detail_image' );
	});
	jQuery('.javo-color-picker').each(function(i, v){
		$(this).spectrum({
			clickoutFiresChange:true
			, showInitial: true
			, preferredFormat:'hex'
			, showInput: true
			, chooseText: 'Select'
		});
	});

	var jvbpd_share_func = function( selector ) {
		this.selector = selector;
		this.init();
	};

	jvbpd_share_func.prototype = {

		constructor : jvbpd_share_func

		, init : function () {

			var obj = this;

			$( document ).on( 'jvbpd_sns:init', function(){
				$( obj.selector ).off( 'click', obj.share() );
				$( obj.selector ).on( 'click', obj.share() );
			} ).trigger( 'jvbpd_sns:init' );

		}

		, share : function () {

			var obj			= this;

			return function ( e ) {

				e.preventDefault();

				var output_link		= new Array();

				if( $( this ).hasClass( 'sns-twitter' ) ) {
					output_link.push( "http://twitter.com/share" );
					output_link.push( "?url=" + $( this ).data( 'url' ) );
					output_link.push( "&text=" + $( this ).data( 'title' ) );
				}

				if( $( this ).hasClass( 'sns-facebook' ) ) {
					output_link.push( "http://www.facebook.com/sharer.php" );
					output_link.push( "?u=" + $( this ).data( 'url' ) );
					output_link.push( "&t=" + $( this ).data( 'title' ) );
				}

				if( $( this ).hasClass( 'sns-google' ) ) {
					output_link.push( "https://plus.google.com/share" );
					output_link.push( "?url=" + $( this ).data( 'url' ) );
				}
				window.open( output_link.join( '' ), '' );
			}
		}
	}
	new jvbpd_share_func( 'i.sns-facebook, i.sns-twitter, i.sns-google, .javo-share' );

	if( typeof $.fn.tooltip != 'undefined' ) {
		$('.javo-tooltip').each(function(i, e){
			var options = {};
			if( typeof( $(this).data('direction') ) != 'undefined' ){
				options.placement = $(this).data('direction');
			};
			$(this).tooltip(options);
		});
	}

	$(window).load(function(){
		$(this).trigger('resize');
	});
})(jQuery);
<?php
class jvbpd_post_meta_func {
	private $path;
	private $template_part;
	public static $instance;

	public function __construct() {
		self::$instance				= &$this;
		$this->path					= JVBPD_ADM_DIR;
		$this->template_part	=$this->path . '/templates/';
		add_action('add_meta_boxes'		, Array( __CLASS__, 'post_meta_box_init'), 30);
		add_action('save_post'			, Array( __CLASS__, 'post_meta_box_save'));

		$this->register_hooks();
	}

	public function register_hooks() {
		add_action( 'jvbpd_registered_script', array( $this, 'admin_js_params' ) );
	}

	public static function post_meta_box_init() {
		$jvbpd_meta_boxes = Array(
			// Post Meta ID.							MetaBox Callback				Post Type		Position	Level		Description
			// ===============================================================
			'jvbpd_postFormat_link'			=> Array( 'postFormat_link_func'			, 'post'		, 'normal'	, 'high' , esc_html__("Link Format Options", 'jvfrmtd' ) )
			, 'jvbpd_postFormat_quote'		=> Array( 'postFormat_quote_func'		, 'post'		, 'normal'	, 'high' , esc_html__("Quote Format Options", 'jvfrmtd' ) )
			, 'jvbpd_postFormat_video'		=> Array( 'postFormat_video_func'		, 'post'		, 'normal'	, 'high' , esc_html__("Video Format Options", 'jvfrmtd' ) )
			, 'jvbpd_postFormat_audio'		=> Array( 'postFormat_audio_func'		, 'post'		, 'normal'	, 'high' , esc_html__("Audio Format Options", 'jvfrmtd' ) )
		);

		$jvbpd_meta_boxes_post_and_page = Array(
			// Post Meta ID.							MetaBox Callback						Position	Level		Description
			// ================================================================
			'jvbpd_page_settings'	=> Array( 'jvbpd_page_settings_box'	, null , 'normal'		, 'high', esc_html__( "Page Settings", 'jvfrmtd' ) )
		);

		foreach( $jvbpd_meta_boxes as $boxID => $attribute ) {
			add_meta_box( $boxID, $attribute[4], Array( __CLASS__, $attribute[0] ), $attribute[1], $attribute[2], $attribute[3]);
		}

		foreach( Array( 'post', 'page', 'portfolio' ) as $post_type ) {
			foreach( $jvbpd_meta_boxes_post_and_page as $boxID => $attribute ) {
				add_meta_box( $boxID, $attribute[4], Array( __CLASS__, $attribute[0] ), $post_type, $attribute[2], $attribute[3]);
			}
		}
	}

	public static function postFormat_link_func( $post ) {
		self::postFormat_field(
			Array(
				'link_title'	=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Link", 'jvfrmtd' )
					)
			)
		);
	}

	public static function postFormat_quote_func( $post ) {
		self::postFormat_field(
			Array(
				'quote_format'	=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Quote", 'jvfrmtd' )
					)
			)
		);
	}

	public static function postFormat_video_func( $post ) {
		self::postFormat_field(
			Array(
				'video_format_choose' =>
					Array(
						'element'	=> 'select'
						, 'label'	=> esc_html__( "Choose Video Type", 'jvfrmtd' )
						, 'option'	=> Array(
							esc_html__( "Select Portal", 'jvfrmtd' )	=> ''
							, esc_html__( "Youtube", 'jvfrmtd' )		=> 'youtube'
							, esc_html__( "Vimeo", 'jvfrmtd' )			=> 'vimeo'
						)
					)
				, 'video_format_link'	=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Video ID", 'jvfrmtd' )
					)
			)
		);
	}

	public static function postFormat_audio_func( $post ) {
		self::postFormat_field(
			Array(
				'audio_link'		=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Audio Link", 'jvfrmtd' )
					)
			)
		);
	}

	public static function postFormat_field( $fields ) {

		global $post;

		if( ! empty( $fields ) ) : foreach( $fields as $name => $attr ) {

			echo "<div>";
					printf( "<label>%s</label>", $attr[ 'label' ] );

				$this_value		= get_post_meta( $post->ID, $name, true );

				switch( $attr[ 'element' ] ) {

					case 'input' :
						printf( "<input type=\"%s\" name=\"jvbpd_fp[%s]\" value=\"%s\">", $attr[ 'type' ], $name, $this_value );
					break;

					case 'select' :
						printf( "<select name=\"jvbpd_fp[%s]\">", $name );
							if( !empty( $attr[ 'option' ] ) ) : foreach( $attr[ 'option' ] as $optLabel => $optValue ) {
								printf( "<option value=\"%s\" %s>%s</option>", $optValue, selected( $this_value == $optValue ), $optLabel );
							} endif;
						echo "</select>";
					break;
				}
			echo "</div>";

		} endif;

	}

	public static function post_meta_box_save( $post_id ) {

		if(
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! is_admin()
		) return;

		/*
		 *		Variables Initialize
		 *
		 *======================================================================================*
		 */
			$jvbpd_query = new jvbpd_array($_POST);
			$lv_listinglist_query = new jvbpd_array( $jvbpd_query->get('jvbpd_il', Array()) );


		/*
		 *		Page Template Layout Setup
		 *
		 *======================================================================================*
		 */
			// Result Save
			{
				if( $value = $jvbpd_query->get( 'jvbpd_opt_header', false ) )
					update_post_meta( $post_id, 'jvbpd_header_type', $value );

				if( $value = $jvbpd_query->get( 'jvbpd_opt_fancy', false ) )
					update_post_meta( $post_id, 'jvbpd_header_fancy_type', $value );

				if( $value = $jvbpd_query->get( 'jvbpd_opt_sidebar', false ) )
					update_post_meta( $post_id, 'jvbpd_sidebar_type', $value );

				if( $value = $jvbpd_query->get( 'jvbpd_opt_slider', false ) )
					update_post_meta( $post_id, 'jvbpd_slider_type', $value );
			}

			if( false !== ( $tmp = $lv_listinglist_query->get('type', false) ) ){
				update_post_meta($post_id, "jvbpd_item_listing_type", $tmp);
			}

			if( false !== ( $tmp = $lv_listinglist_query->get('list_position', false) ) ){
				update_post_meta($post_id, "jvbpd_item_listing_position", $tmp);
			}

			if( false !== ( $tmp = $lv_listinglist_query->get('content_position', false) ) ){
				update_post_meta($post_id, "jvbpd_item_listing_content_position", $tmp);
			}

			if( false !== ( $tmp = $jvbpd_query->get('jvbpd_hd', false) ) ){
				update_post_meta($post_id, "jvbpd_hd_post", $tmp );
			}

			// Slide AutoPlay
			if( false !== ( $tmp = $jvbpd_query->get('jvbpd_detail_slide_autoplay', false) ) ){
				update_post_meta($post_id, "jvbpd_detail_slide_autoplay", $tmp );
			}

			// Fancy options
			if( $jvbpd_query->get('jvbpd_fancy', null) != null){
				update_post_meta( $post_id, "jvbpd_fancy_options", $jvbpd_query->get( 'jvbpd_fancy', null ) );
			}

			if( $jvbpd_query->get('jvbpd_slide', null) != null){
				update_post_meta( $post_id, "jvbpd_slider_options", $jvbpd_query->get('jvbpd_slide', null ) );
			}

			$jvbpd_controller_setup = !empty($_POST['jvbpd_post_control']) ? $_POST['jvbpd_post_control'] : '';
			update_post_meta( $post_id, "jvbpd_control_options", $jvbpd_controller_setup );

			// Post format
			$postFormat_options	= $jvbpd_query->get( 'jvbpd_fp', Array() );
			if( !empty( $postFormat_options ) ) : foreach( $postFormat_options as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			} endif;
	}

	public static function jvbpd_page_settings_box( $post ) {
		$strFileName		= self::$instance->template_part . '/page-options.php';
		if( file_exists( $strFileName ) )
			require_once $strFileName;
	}

	public function admin_js_params( $name='' ) {
		global $post;

		if( ! $post instanceof WP_Post ) {
			return;
		}

		if( $name == 'admin' ) {
			wp_localize_script(
				$name, 'jvbpd_metabox_variable',
				Array(
					'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'strAddressFindFailed' => esc_html__( "Sorry, find address failed", 'jvfrmtd' ),
					'strHeaderFancy' => get_post_meta( $post->ID, "jvbpd_header_fancy_type", true ),
					'strHeaderSlider' => get_post_meta( $post->ID, "jvbpd_slider_type", true ),
				)
			);
			wp_add_inline_script( $name, 'jQuery(function($){ $(document).trigger( "javo:metabox_after" ); });' );
		}
	}
}

new jvbpd_post_meta_func();
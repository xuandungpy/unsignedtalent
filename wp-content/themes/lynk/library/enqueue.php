<?php
class jvbpd_enqueue_func
{
	public static $instance;

	private $protocal = 'http://';
	private $theme = false;
	private $theme_ver = false;

	public $html_fonts = '';

	public $theme_dir = false;
	public $asset_dir = false;
	public $css_dir = false;
	public $js_dir = false;

	public $cssWoo_prefix = 'html body.woocommerce.woocommerce-page';
	public $cssWooCART_prefix = 'html body.woocommerce-cart.woocommerce-page';
	public $cssWooCHECK_prefix	= 'html body.woocommerce-checkout.woocommerce-page';
	public $cssWooACCOUNT_prefix = 'html body.woocommerce-account.woocommerce-page';

	public function __construct() {
		$this->setVariables();
		$this->loadFiles();

		$this->frontend_enqueue();
		$this->backend_enqueue();
		$this->modify_bodyclass();
		$this->setDefer_script();
	}

	public function setVariables() {
		$this->protocal = is_ssl() ? 'https://' : 'http://';
		$this->theme = wp_get_theme();
		$this->theme_ver	= $this->theme->get( 'Version' );

		// Folder Settings
		$this->theme_dir = defined( 'JVBPD_THEME_DIR' ) && JVBPD_THEME_DIR != '' ? JVBPD_THEME_DIR : get_template_directory_uri();
		$this->asset_dir = $this->theme_dir . '/assets';
		$this->css_dir = $this->asset_dir . '/css';
		$this->js_dir = $this->asset_dir . '/js';
	}

	public function is_wpless_active() {
		return true; /// jvbpd_tso()->get( 'wp_less' ) === 'enable';
	}

	public function loadFiles() {
		// WP-LESS Enable
		if( $this->is_wpless_active() ) {
			get_template_part( 'library/wp', 'less' );
		}
	}

	public function frontend_enqueue() {
		if( is_admin() )
			return;

		add_action( 'wp_print_scripts', Array( __class__, 'jvbpd_dequeue_scripts_callback' ), 100 );
		add_action( 'wp_enqueue_scripts', Array( __class__, 'enqueue_scripts'), 9 );
		add_action( 'wp_enqueue_scripts', Array( __class__, 'post_enqueue_scripts_callback'), 99 );
		add_action( 'wp_enqueue_scripts', Array( __class__, 'jvbpd_custom_style_apply_func') );
		add_action( 'wp_enqueue_scripts', Array( $this, 'get_custom_fonts' ) );
		add_action( 'wp_enqueue_scripts', Array( $this, 'last_enqueues' ), 99 );
		add_action( 'wp_enqueue_scripts', Array( $this, 'output_fontCSS' ) );
	}

	/**
	 * Defer Javascripts
	 * Defer jQuery Parsing using the HTML5 defer property
	 */
	public function setDefer_script() {
		if( is_admin() )
			return;

		add_filter( 'clean_url', Array( $this, 'defer_scripts' ), 11, 1 );
	}

	public function backend_enqueue() {
		if( ! is_admin() )
			return;
		add_action('admin_enqueue_scripts', Array( __class__, 'admin_enqueue_less_callback' ), 1 );
		add_action('admin_enqueue_scripts', Array( __class__, 'admin_enqueue_scripts_callback'), 9 );
	}

	public function modify_bodyclass() {
		add_filter( 'body_class', Array( __class__, 'jvbpd_add_transparent_class_callback' ), 10 );
	}

	public function loadBootstrap() {
		wp_enqueue_style( 'bootstrap', $this->css_dir . '/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap-custom', $this->css_dir . '/bootstrap-custom.css' );

		/** front-scripts.js moved */
	}

	public function loadIcons() {
		wp_enqueue_style( 'font-awsome', $this->css_dir . '/font-awesome.min.css' );
		wp_enqueue_style( 'icomoon', $this->css_dir . '/icon-icomoon.css' );
		wp_enqueue_style( 'viewer-icon', $this->css_dir . '/viewer-icon.css' );
		wp_enqueue_style( 'jvbpd-icon', $this->css_dir . '/jvbpd-icon.css' );
		wp_enqueue_style( 'jvbpd-icon1', $this->css_dir . '/jvbpd-icon1.css' );
		wp_enqueue_style( 'jvbpd-icon2', $this->css_dir . '/jvbpd-icon2.css' );
		wp_enqueue_style( 'jvbpd-icon3', $this->css_dir . '/jvbpd-icon3.css' );
		wp_enqueue_style( 'jvbpd-icon4', $this->css_dir . '/jvbpd-icon4.css' );
		wp_enqueue_style( 'fonts', $this->css_dir . '/fonts.css' );
	}

	// WP_ENQUEUE_SCRIPTS
	public static function enqueue_scripts() {
		$jvbpd_register_scripts = Array(
			'common.js' => 'jvbpd-common',
			'pace.min.js' => 'pace',
			'jquery.nouislider.min.js' => 'jquery-nouislider',
			'jquery.typehead.js' => 'jquery-typehead',
			'owl.carousel.min.js' => 'owl-carousel',
			'jquery.lazyload.min.js' => 'jquery-lazyload',
			'selectize.min.js' => 'selectize',
			'jquery.sticky.js' => 'jquery-sticky',
			'jquery.javo.login.js' => 'jquery-javo-login',
			'ZeroClipboard.min.js' => 'zeroclipboard',
			'jv-woocommerce.js' => 'jv-woocommerce',
			'lightgallery-all.min.js' => 'lightgallery-all',
			'ladda.min.js' => 'ladda',
			'spin.min.js' => 'spin',
			'bootstrap-tabdrop.js' => 'bootstrap-tabdrop',
			'jquery.javo.msg.js' => 'jquery-javo-msg',

			/* Masonry */
			'masonry/modernizr.custom.js' => 'modernizr-custom',
			'masonry/classie.js' => 'classie',
			'masonry/AnimOnScroll.js' => 'animonscroll',

			/** LazyLoad **/
			'jquery.lazy.min.js' => 'jquery-lazy',
			'jquery.lazy.plugins.min.js' => 'jquery-lazy-plugins',

			/* Shortcode */
			'flexmenu.min.js' => 'flexmenu',
			'jquery.javo_ajaxShortcode.js' => 'jquery-javo-ajaxshortcode',
			'jquery-caroufredsel.js' => 'jquery-caroufredsel',
		);

		$jvbpd_google_api = '';

		foreach( $jvbpd_register_scripts as $src => $handle ) {
			wp_register_script( $handle, self::$instance->js_dir . '/' . $src, Array( 'jquery') , '0.1', true );
		}

		if( $jvbpd_google_api	= jvbpd_tso()->get( 'google_api_key', false ) )
			$jvbpd_google_api	= "&key={$jvbpd_google_api}";

		if( $jvbpd_google_lang	= jvbpd_tso()->get( 'google_lang_code', false ) )
			$jvbpd_google_api	= "&language={$jvbpd_google_lang}";

		wp_enqueue_script( 'html5', self::$instance->js_dir . '/html5.js' );
		wp_script_add_data( 'html5', 'conditional', 'lte IE 9' );

		wp_enqueue_script(
			'javo-bp-front-scripts',
			self::$instance->js_dir . '/front-scripts.js',
			Array( 'jquery', 'jquery-ui-button' ),
			'0.1',
			false
		);

		wp_enqueue_script(
			'popper',
			self::$instance->js_dir . '/popper.min.js',
			Array( 'jquery' ),
			'0.0.0',
			false
		);

		wp_enqueue_script(
			'tether',
			self::$instance->js_dir . '/tether.min.js',
			Array( 'jquery' ),
			'0.0.0',
			false
		);

		if( get_query_var('pn') != 'member' ) {
			wp_enqueue_script(
				'bootstrap-min',
				self::$instance->js_dir . '/bootstrap.min.js',
				Array( 'jquery' ),
				'0.1',
				false
			);
		}else{
			wp_enqueue_script(
				'4-bootstrap-min',
				self::$instance->js_dir . '/4-bootstrap.min.js',
				Array( 'jquery'),
				'0.1',
				false
			);
		}


		wp_enqueue_script( 'jquery-javo-msg' );

		wp_enqueue_script( 'jquery-lazy' );
		wp_enqueue_script( 'jquery-lazy-plugins' );

		/*
		*
		**	Load Style And Scripts
		*/

		// Styles css
		self::$instance->loadBootstrap();
		self::$instance->loadIcons();

		//Boostrap select style
		wp_enqueue_script( 'bootstrap-select-min' );
		wp_enqueue_script( 'spin' );
		wp_enqueue_script( 'ladda' );
		wp_enqueue_script( 'bootstrap-tabdrop' );

		//masonry
		wp_enqueue_script( 'modernizr-custom' );

		wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'imagesloaded' );

		wp_enqueue_script( 'classie' );
		wp_enqueue_script( 'animonscroll' );

		// Preloading
		wp_enqueue_script( 'pace' );

		// Javo VC Row and Affix and Etc..
		wp_localize_script(
			'jvbpd-common',
			'jvbpd_common_args',
			Array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			)
		);

		wp_add_inline_script( 'jvbpd-common', jvbpd_tso()->get( 'analytics' ) );
		wp_add_inline_script( 'jvbpd-common', jvbpd_tso()->get( 'custom_js' ) );

		// Common Script
		wp_enqueue_script( 'jvbpd-common' );

		// Login
		wp_localize_script(
			'jquery-javo-login',
			'jvbpd_login_param',
			Array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'errUserName' => esc_html__( 'usernames with spaces should not be allowed.', 'jvfrmtd' ),
				'errDuplicateUser' => esc_html__( 'User Register failed. Please check duplicate email or Username.', 'jvfrmtd' ),
				'errNotAgree' => esc_html__( 'You need to read and agree the terms and conditions to register.', 'jvfrmtd' ),
				'strJoinComplete' => esc_html__( 'Register Complete', 'jvfrmtd' ),
			)
		);

		wp_enqueue_script( 'jquery-javo-login' );
		wp_enqueue_script( 'heartbeat' );
		wp_enqueue_style( 'bp-parent-css', get_template_directory_uri() . '/buddypress/css/bp-parent.css',false,'1.1','all');

		$jvbpd_general_styles = Array(
			'jvbpd-bind' => Array( 'file' => 'bind.css' ),
			'jvbpd-common' => Array( 'file' => 'common.css' ),
			'jquery-nouislider' => Array( 'file' => 'jquery.nouislider.min.css' ),
			'jasny-bootstrap' => Array( 'file' => 'jasny-bootstrap.min.css' ),
			'lightgallery-all'	=> Array( 'file' => 'lightgallery.min.css' ),
			'bootstrap-select' => Array( 'file' => 'bootstrap-select.min.css' ),
			'ladda-themeless' => Array( 'file' => 'ladda-themeless.min.css' ),
		);

		jvbpd_enqueues()->general_less_style( $jvbpd_general_styles );
		/** Load Styles **/
		foreach( $jvbpd_general_styles as $strHandle => $arrMeta ) {
			$strDefaultPath = self::$instance->css_dir . '/';
			$strFilePath = isset( $arrMeta[ 'dir' ] ) ? $arrMeta[ 'dir' ] : $strDefaultPath;

			$strFileName = sprintf( '%1$s/%2$s', untrailingslashit( $strFilePath ), $arrMeta[ 'file' ] );
			wp_enqueue_style( $strHandle, $strFileName );
		}

		// Custom css - Javo themes option
		wp_add_inline_style( 'jvbpd-bind', get_option( 'jvbpd_themes_settings_css' ) );

	}

	public function general_less_style( &$arrStyles=Array() ) {

		$arrAppendStyle = Array();

		if( $this->is_wpless_active() ){
			$arrAppendStyle = apply_filters( 'jvbpd_enqueue_less_array', Array(
				'common-style-less' => Array( 'file' => 'common-style.less' ),
			) );
		}else{
			$arrAppendStyle = apply_filters( 'jvbpd_enqueue_css_array', Array(
				'common-style-less' => Array( 'file' => 'common-Style.css' ),
			) );
		}
		$arrStyles = wp_parse_args( $arrAppendStyle, $arrStyles );
	}

	public static function admin_enqueue_less_callback() {
		echo "<link rel=\"stylesheet/less\" type=\"text/css\" href=\"".JVBPD_THEME_DIR . "/assets/css/theme-settings.less\" />\n";
	}

	// ADMIN_ENQUEUE_SCRIPTS
	static function admin_enqueue_scripts_callback() {

		$jvbpd_admin_css = Array(
			'admin.css' => 'admin',
			'javo_admin_theme_settings-extend.css' => 'javo-admin-theme-settings-extend',
			'javo_admin_post_meta.css' => 'javo-admin-post-meta'
		);

		$jvbpd_admin_jss = Array(
			'admin.js' => 'admin'
		);

		foreach( $jvbpd_admin_css as $src => $id){ jvbpd_get_asset_style($src, $id); }
		foreach( $jvbpd_admin_jss as $src => $id){ jvbpd_get_asset_script($src, $id); }

		wp_enqueue_script(
			'less'
			, get_template_directory_uri()."/assets/js/less.min.js"
			, false
			, '0.1'
			, false
		);

		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_style( "chosen", JVBPD_THEME_DIR."/assets/css/chosen.min.css", null, "0.1" );

		wp_enqueue_script( 'thickbox');
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'admin-color-picker', JVBPD_THEME_DIR.'/assets/js/admin-color-picker.js', array( 'wp-color-picker' ), false, true );
	}

	public function get_custom_fonts() {

		$arrFontTags = Array(
			'basic_font',
			'h1_font',
			'h2_font',
			'h3_font',
			'h4_font',
			'h5_font',
			'h6_font'
		);

		$arrLoadFonts	= $arrFontsApply = $arrOutput = Array();

		if( !empty( $arrFontTags ) ) foreach( $arrFontTags as $tag ) {
			if( $strFontFamily = jvbpd_tso()->get( $tag, false ) ) {
				$sanitize_tag = @explode( '_', $tag );
				$sanitize_tag = isset( $sanitize_tag[0] ) ? $sanitize_tag[0] : null;

				/* Translators: If there are characters in your language that are not
				* supported by Open Sans, translate this to 'off'. Do not translate
				* into your own language. */
				if(
					$strFontFamily == 'Open Sans' &&
					'off' ===_x( 'on', 'Open Sans font: on or off', 'jvfrmtd' )
				) continue;

				/* Translators: If there are characters in your language that are not
				* supported by Raleway, translate this to 'off'. Do not translate
				* into your own language. */
				if(
					$strFontFamily == 'Raleway' &&
					'off' ===_x( 'on', 'Raleway font: on or off', 'jvfrmtd' )
				) continue;

				/* Translators: If there are characters in your language that are not
				* supported by Roboto Condensed, translate this to 'off'. Do not translate
				* into your own language. */
				if(
					$strFontFamily == 'Roboto Condensed' &&
					'off' ===_x( 'on', 'Roboto Condensed font: on or off', 'jvfrmtd' )
				) continue;

				/* Translators: If there are characters in your language that are not
				* supported by Montserrat, translate this to 'off'. Do not translate
				* into your own language. */
				if(
					$strFontFamily == 'Montserrat' &&
					'off' ===_x( 'on', 'Montserrat font: on or off', 'jvfrmtd' )
				) continue;

				$arrLoadFonts[] = $strFontFamily . ':300,400,500,600,700';
				$arrFontsApply[ $sanitize_tag ]	= $strFontFamily;
			}
		}

		if( empty( $arrLoadFonts ) )
			return;

		$arrLoadFonts	= join( '|', Array_unique( $arrLoadFonts ) );
		if($strFontFamily != 'Arial'){
			$strLoadFonts	= add_query_arg(
				Array(
					'family' => urlencode( $arrLoadFonts )
					, 'subset' => urlencode( 'latin,latin-ext' )
				)
				, 'https://fonts.googleapis.com/css'
			);
		}
		$strLoadFonts	= esc_url_raw( $strLoadFonts );

		$arrOutput[]		= null;
		if( !empty( $arrFontsApply ) ) foreach( $arrFontsApply as $tag => $family ) {
			if( $tag == 'basic' ) {
				$arrOutput[] = "html, body, div, form, label, a, b, p, pre, small, em,  blockquote, strong, u, em, ul, li, input, button, textarea, select{font-family:\"{$family}\", sans-serif; }";
			}else{
				$arrOutput[] = "html body {$tag}, html body {$tag} a{font-family:\"{$family}\", sans-serif; }";
			}
		}
		wp_enqueue_style( 'jv-google-fonts', $strLoadFonts, Array(), null );
		$this->html_fonts = join( false, $arrOutput ) . "\n";
	}

	public function last_enqueues() {
		wp_enqueue_style( 'style-jv-woocommerce', JVBPD_THEME_DIR . "/assets/css/woocommerce.css" );
		wp_enqueue_style( 'javoThemes-bp', get_stylesheet_uri(), array(), self::$instance->theme_ver );
	}

	public function output_fontCSS() {
		if( !empty( $this->html_fonts ) ) {
			wp_add_inline_style( 'jvbpd-bind', $this->html_fonts );
		}
	}

	public static function jvbpd_custom_style_apply_func() {
		$defaultStyle = 'html body{ font-size:13px; }html body{ line-height:20px; }';
		wp_add_inline_style( 'jvbpd-bind', jvbpd_tso()->get('custom_css', $defaultStyle ) );
	}

	public function admin_custom_style_apply_func( &$rows=Array() ) {

		$rows[] = sprintf( '#wp%s{ position:fixed; }', 'adminbar' );

		if(
			jvbpd_tso()->get( 'footer_background_image_use' ) == 'use' &&
			jvbpd_tso()->get( 'footer_background_image_url' ) != ''
		) :

			$rows[] = "footer.footer-wrap,";
			$rows[] = ".footer-bottom{background-color:transparent !important; border:none;}";
			$rows[] = "footer.footer-wrap .widgettitle_wrap .widgettitle span{background-color:transparent;}";

			$strBuf = '';
			foreach(
				Array(
					'footer_background_size' => 'background-size',
					'footer_background_repeat' => 'background-repeat',
					'footer_background_image_url' => 'background-image',
				)
			as $strOption => $strAttr
			) :
				$strValue = jvbpd_tso()->get( $strOption, false );

				if( !$strValue )
					continue;

				$strValue = $strAttr == 'background-image' ? 'url("' . $strValue . '")' : $strValue;
				$strBuf .= sprintf( '%1$s:%2$s;' , $strAttr, $strValue );
			endforeach;

			$rows[] = sprintf( '%1$s{ %2$s }', '.footer-background-wrap', $strBuf );

		endif;

		/* theme setting - single page*/
		if( $strCSS = jvbpd_tso()->get('single_page_box_background_color', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:%3$s; }',
				'html body.single div.single-item-tab #javo-single-content.item-single .javo-detail-item-content>.col-md-12',
				'background-color',
				$strCSS.' !important'
			);
		}

		/* Title Color */
		if( $strCSS = jvbpd_tso()->get('single_page_title_color', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:%3$s; }',
				'.single-item-tab #javo-single-content .javo-detail-item-content .col-md-12 > h3,
				.single-item-tab #javo-single-content .javo-detail-item-content .col-md-12 > #javo-item-detail-image-section > h3,
				.single-item-tab #javo-single-sidebar > .col-md-12 > h3',
				'color',
				$strCSS
			);
		}

		/* Title Color */
		if( $strCSS = jvbpd_tso()->get('single_page_location_title_color', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:%3$s; }',
				'.single-item-tab #javo-single-content #javo-item-location-section .col-md-12>h3',
				'color',
				$strCSS
			);
		}

		/*description color*/
		if( $strCSS = jvbpd_tso()->get('single_page_description_color', false ) ) :
			$rows[] = "#javo-single-content .javo-detail-item-content .item-description .jv-custom-post-content-inner p,";
			$rows[] = "#javo-single-content .javo-detail-item-content .item-description .jv-custom-post-content-inner li,";
			$rows[] = "#javo-single-content .javo-detail-item-content .item-description .jv-custom-post-content-inner strong";
			$rows[] = sprintf( '{ color:%1$s !important; }', $strCSS );
		endif;

		/* theme setting - maps - bg */
		if( $strCSS = jvbpd_tso()->get( 'map_page_listing_part_bg', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:%3$s; }',
				'#javo-maps-listings-wrap #javo-listings-wrap', 'background-color', $strCSS
			);
		}

		/* theme setting - maps - bg */
		if( $strCSS = jvbpd_tso()->get( 'map_page_listing_part_bg_image', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:url("%3$s"); background-attachment:fixed; background-size:100%; }',
				'#javo-maps-listings-wrap #javo-listings-wrap', 'background-image', $strCSS
			);
		}

		if( $strCSS = jvbpd_tso()->get( 'single_page_background_color', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:%3$s; }',
				'.single-item-tab', 'background-color', $strCSS
			);
		}

		if( $strCSS = jvbpd_tso()->get( 'single_page_background_color', false ) ) {
			$rows[] = sprintf(
				'%1$s{ %2$s:%3$s; }',
				'.single-item-tab', 'background-color', $strCSS
			);
		}

		if( $strCSS = jvbpd_tso()->get( 'footer_title_color', false ) ) {
			$rows[] = ".footer-top-full-wrap h5,";
			$rows[] = ".footer-bottom-full-wrap h5,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .widgettitle_wrap .widgettitle span,";
			$rows[] = ".footer-background-wrap .footer-wrap >.container .widgets-wraps .lava-recent-widget .lava-recent-widget-title h3,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .footer-sidebar-wrap .jv-footer-column.col-md-4 .lava-recent-widget .lava-recent-widget-title h3,";
			$rows[] = ".footer-background-wrap .widgets-wraps .lava-featured-widget .lava-featured-widget-title h3,";
			$rows[] = ".footer-background-wrap .widgets-wraps .widgettitle span a.rsswidget,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-logo-wrap .jv-footer-logo-text-title,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-text-wrap .jv-footer-info-text-title,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-image-wrap .jv-footer-info-image-title";
			$rows[] = sprintf( '{ color:%s !important; }', $strCSS );
		}

		if( $strCSS = jvbpd_tso()->get( 'footer_content_color', false ) ) {
			$rows[] = ".footer-top-full-wrap .latest-posts .col-md-12 h3 a,";
			$rows[] = ".footer-top-full-wrap .latest-posts .col-md-12 a span,";
			$rows[] = ".footer-bottom-full-wrap .latest-posts .col-md-12 h3 a,";
			$rows[] = ".footer-bottom-full-wrap .latest-posts .col-md-12 a span,";
			$rows[] = "footer.footer-wrap .jv-footer-column a,";
			$rows[] = "footer.footer-wrap .jv-footer-column a div,";
			$rows[] = "footer.footer-wrap .jv-footer-column li,";
			$rows[] = "footer.footer-wrap .javo-shortcode.shortcode-jvbpd_slider2 .shortcode-container .shortcode-output .slider-wrap.flexslider .flex-viewport ul.slides .module.javo-module3 .section-excerpt > a .meta-excerpt,";
			$rows[] = "#menu-footer-menu>li>a,";
			$rows[] = "footer.footer-wrap .col-md-3 .lava-featured-widget-content>span,";
			$rows[] = "footer.footer-wrap .col-md-3 .lava-featured-widget-content>.price,";
			$rows[] = "footer.footer-wrap .widgets-wraps label,";
			$rows[] = "footer.footer-wrap .widgets-wraps #wp-calendar caption,";
			$rows[] = "footer.footer-wrap .widgets-wraps #wp-calendar th,";
			$rows[] = "footer.footer-wrap .widgets-wraps #wp-calendar td,";
			$rows[] = "footer.footer-wrap .widgets-wraps .textwidget p,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-text-wrap .jv-footer-info-text,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-logo-wrap .jv-footer-info-email a,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-logo-wrap .jv-footer-info-email,";
			$rows[] = ".footer-background-wrap footer.footer-wrap .jv-footer-info .jv-footer-info-logo-wrap .jv-footer-info-working-hour,";
			$rows[] = ".footer-background-wrap .footer-wrap a";
			$rows[] = sprintf( '{ color:%s !important; }', $strCSS );
		}

		/* Footer WIdget Line */{
			$rows[] = "footer.footer-wrap .widgettitle_wrap .widgettitle,";
			$rows[] = "footer.footer-wrap .widgettitle_wrap .widgettitle:after,";
			$rows[] = "footer.footer-wrap .lava-featured-widget-title";
			$rows[] = sprintf(
				'{ %s !important; }',
				jvbpd_tso()->get('show_footer_title_underline', '' ) == '' ?
				'border-color:' . jvbpd_tso()->get('footer_title_underline_color', '#ffffff' ) : 'border:none'
			);
		}

		/* Footer Widget */{
			$rows[] = ".footer-background-wrap .widgets-wraps .widget_posts_wrap .latest-posts .col-md-12:hover a,";
			$rows[] = ".footer-background-wrap .widgets-wraps .widget_posts_wrap .latest-posts .col-md-12:hover a span,";
			$rows[] = ".lava-featured-widget .lava-featured-widget-content a:hover,";
			$rows[] = "footer .widgets-wraps li a:hover";
			$rows[] = sprintf( '{ color:%s !important; }', jvbpd_tso()->get('footer_content_link_hover_color', '#ffffff' ) );

			$rows[] = sprintf( '.footer-background-wrap .footer-sidebar-wrap .footer-copyright{ color:%s !important; }', jvbpd_tso()->get('copyright_color', '#ffffff' ) );
		}
		/* Header Padding */{
			foreach(
				Array(
					'height' => 'jvbpd_header_height',
					'padding-left' => 'jvbpd_header_padding_left',
					'padding-right' => 'jvbpd_header_padding_right',
					'padding-top' => 'jvbpd_header_padding_top',
					'padding-bottom' => 'jvbpd_header_padding_bottom',
				) as $strCSSKey => $strStyleKey
			) {
				if( '' !== jvbpd_tso()->header->get( $strStyleKey, '' ) ) {
					$rows[] = sprintf( 'header >.javo-main-navbar{ %1$s:%2$s; }', $strCSSKey, $strStyleKey );
				}
			}
		}


	}

	public static function jvbpd_dequeue_scripts_callback() {
		// Block to google Map of Visual Composer
		wp_dequeue_script( "googleapis" );
	}

	public static function post_enqueue_scripts_callback() {
		global $jvbpd_tso;

		$post = $GLOBALS[ 'wp_query' ]->get_queried_object();

		if( ! $post instanceof WP_Post ) {
			$post = new stdClass();
			$post->ID = 0;
		}

		$is_post = is_singular( 'post' );
		$core_custom_postType = apply_filters( 'jvbpd_core_post_type', 'custom_type' );
		$jvbpd_hd_options = get_post_meta( $post->ID, 'jvbpd_hd_post', true );

		$jvbpd_hd_options = is_array( $jvbpd_hd_options ) ? $jvbpd_hd_options : array();

		if( $is_post ) {
			$jvbpd_hd_options[ 'header_skin' ] = 'light';
		}

		$jvbpd_query = new jvbpd_array( $jvbpd_hd_options );
		$jvbpd_css_one_row = Array();

		// Backgeound Color
		if( false !== ( $css = $jvbpd_query->get( 'page_bg', jvbpd_tso()->get( 'page_bg', false ) ) ) ){
			$jvbpd_css_one_row[] = "html body{ background-color:{$css}; }";
		}

		// Navigation Background Color
		$strHeaderBgColorOption = $jvbpd_query->get( 'header_bg', jvbpd_tso()->header->get( 'header_bg', '#506ac5' ) );
		$strHeaderBgColorCode = apply_filters( 'jvbpd_header_bg_option', $strHeaderBgColorOption );

		if( !empty( $strHeaderBgColorCode ) ) {
			$floatOpacity = false;
			if( $jvbpd_query->get( 'header_opacity_as', '' ) != '' ) {
				$floatOpacity = $jvbpd_query->get( 'header_opacity', false );
			}else{
				$floatOpacity = jvbpd_tso()->header->get( 'header_opacity', false );
			}

			$floatOpacity = apply_filters( 'jvbpd_header_bg_opacity_option', $floatOpacity );
			$floatOpacity = false !== $floatOpacity ? floatVal( $floatOpacity ) : false;
			$strRGB = apply_filters( 'jvbpd_rgb', substr( $strHeaderBgColorCode, 1) );

			if( false !== $floatOpacity ) {
				$cssFormat = 'rgba( %1$s, %2$s, %3$s, %4$s )';
			}else{
				$cssFormat = 'rgb( %1$s, %2$s, %3$s )';
			}

			$strCSS = sprintf( $cssFormat, $strRGB[ 'r' ], $strRGB[ 'g' ], $strRGB[ 'b' ], $floatOpacity );

			$jvbpd_css_one_row[] = sprintf(
				'html nav.nav-top.navbar-static-top{ background:none !important; background-color:%s !important; }', $strCSS
			);
			$jvbpd_css_one_row[] = sprintf(
				'div.jvbpd-member-sidebar .opener,.vertical-sidebar.left-sidebar .sidebar-swicher-wrap, .quick-view .quick-header{ background-color:rgba(%1$s,%2$s,%3$s,%4$s) !important; }',
				$strRGB[ 'r' ], $strRGB[ 'g' ], $strRGB[ 'b' ], '0.9'
			);
		}

		if( false !== ( $css = jvbpd_tso()->header->get( 'db_menu_link_color', false ) ) ) {
			$jvbpd_css_one_row[] = 'body.top-nav-type-dashboard-style .nav-top .horizon.sidebar #jv-nav-menu-left >li.menu-item-depth-1 span.menu-titles,';
			$jvbpd_css_one_row[] = 'html body.top-nav-type-dashboard-style .nav-top .navbar-header .top-nav-menu-right-wrap .menu-item.jvbpd-menu i[class^="jvbpd-"],';
			$jvbpd_css_one_row[] = 'html body.top-nav-type-dashboard-style .nav-top .navbar-header .top-nav-menu-right-wrap .menu-item.jvbpd-menu i[class^="jvbpd-icon"],';
			$jvbpd_css_one_row[] = 'html body.top-nav-type-dashboard-style .nav-top .navbar-header .top-nav-menu-right-wrap .menu-item.jvbpd-menu.jvbpd-add_new_button-nav button[type="button"][data-toggle] > *,';
			$jvbpd_css_one_row[] = 'html body.top-nav-type-dashboard-style .nav-top.navbar-static-top .navbar-header a.dashboard-topbar-switcher span';
			$jvbpd_css_one_row[] =  sprintf( '{color:%s;}', $css );
		}

		$jvbpd_css_one_row[] = 'html body.bbpress.bbp-user-page header#header-one-line{ margin-top:0; }';
		$jvbpd_css_one_row[] = 'html body.bbpress.bbp-user-page header#header-one-line nav.navbar,';
		$jvbpd_css_one_row[] = 'html body.buddypress.groups header#header-one-line nav.navbar{ background-color: transparent;box-shadow:none; }';
		$jvbpd_css_one_row[] = 'html body.bbpress.bbp-user-page header#header-one-line.main{ position:absolute; left:0; right:0; }';

		// Sticky Navigation Background Color
		if( false !== ( $hex = $jvbpd_query->get( 'sticky_header_bg', jvbpd_tso()->header->get( 'sticky_header_bg', false ) ) ) )
		{
			if( $jvbpd_query->get( 'sticky_header_opacity_as', '' ) != '' )
			{
				// 'enable' => Page Setting
				if( false === ( $opacity = (float)$jvbpd_query->get( 'sticky_header_opacity', false ) ) ){
					$opacity = (float)1;
				}
			}else{
				// '' => Theme settings
				if( false === ( $opacity = (float)jvbpd_tso()->header->get( 'sticky_header_opacity', false ) ) ){
					$opacity = (float)1;
				}
			}

			$jvbpd_rgb = apply_filters( 'jvbpd_rgb', substr( $hex, 1) );
			$jvbpd_css_one_row[] = "html header.main nav.navbar.affix{ background-color:rgba( {$jvbpd_rgb['r']}, {$jvbpd_rgb['g']}, {$jvbpd_rgb['b']}, {$opacity}) !important; }";
		}

		// Single page Navigation Background Color
		if($jvbpd_tso->get( 'single_page_menu_bg_color' ) != '' && false !== ( $hex = $jvbpd_tso->get( 'single_page_menu_bg_color', false ) ) ) {
			if( false === ( $opacity = (float)jvbpd_tso()->header->get( 'single_header_opacity', false ) ) ){
				$opacity = (float)1;
			}

			if($jvbpd_query->get( 'single_header_relation' ) != 'absolute'){
				$jvbpd_css_one_row[] = "html .single-{$core_custom_postType} #header-one-line>nav{ background-color:transparent !important; }";
			}

			$jvbpd_rgb = apply_filters( 'jvbpd_rgb', substr( $hex, 1) );
			$jvbpd_css_one_row[] = "html .single header.main{ background-color:rgba( {$jvbpd_rgb['r']}, {$jvbpd_rgb['g']}, {$jvbpd_rgb['b']}, {$opacity}) !important;     background-image: none !important;}";
		}

		// Dropdown Menu Color
		if(jvbpd_tso()->header->get("header_dropdown_bg")!=''){
			$css=jvbpd_tso()->header->get("header_dropdown_bg");
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul .menu-item .dropdown-menu li a,";
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul .menu-item .dropdown-menu li.dropdown-header{background:{$css};}";
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul .menu-item .dropdown-menu li.divider{border-color:{$css}; margin-bottom:0px}";
			$jvbpd_css_one_row[] = "header#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul > li.menu-item.menu-item-has-children > ul.dropdown-menu:after{border-bottom-color:{$css};}";
		}

		if(jvbpd_tso()->header->get("header_dropdown_hover_bg")!=''){
			$css=jvbpd_tso()->header->get("header_dropdown_hover_bg");
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul .menu-item .dropdown-menu li.menu-item a:hover,";
			$jvbpd_css_one_row[] = "header#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.navbar-left > li.menu-item.menu-item-has-children > ul.dropdown-menu li.menu-item-has-children ul.dropdown-menu li.menu-item > a:hover,";
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul .menu-item .dropdown-menu li.menu-item.active a{background:{$css};}";
		}
		if(jvbpd_tso()->header->get("header_dropdown_text")!=''){
			$css=jvbpd_tso()->header->get("header_dropdown_text");
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul.jv-nav-ul .menu-item .dropdown-menu li.menu-item a{color:{$css} !important;}";
		}

		// Header Size
		{
			$intHeaderHeight			= 0;
			if( $jvbpd_query->get( 'header_size_as', '' ) != '' )
			{
				// 'enable' => Page Setting
				$intHeaderHeight = intVal( $jvbpd_query->get( 'header_size', 40 ) );
			}else{
				// '' => Theme settings
				$intHeaderHeight = intVal( jvbpd_tso()->header->get( 'header_size', 40 ) );
			}

			$intHeaderHeight		.= 'px';
		}

		// Navigation Shadow
		$strHeaderShadowOption = $jvbpd_query->get( 'header_shadow', jvbpd_tso()->header->get( 'header_shadow', false ) );
		if( "enable" != apply_filters( 'jvbpd_header_shadow_option', $strHeaderShadowOption ) ){
			$jvbpd_css_one_row[] = "html body #wrapper .nav-top.navbar-static-top{ box-shadow:none; }";
			$jvbpd_css_one_row[] = "html header#header-one-line:after{ content:none; }";
		}

		// Header Skin
		{
			switch( apply_filters( 'jvbpd_header_skin_option', 'light' ) ) {
				case "dark":
					$jvbpd_css_one_row[] = '@media(min-width:768px){ html body .nav-top.navbar-static-top li.menu-item-depth-0.menu-item > a > span.menu-titles{ color:#454545; }}';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-search_in_nav-nav.menu-item-object-custom.menu-item > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_notifications-nav.menu-item-object-custom.menu-item > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_menu-nav > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_menu-nav > a:focus,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_notifications-nav > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-right_sidebar_opener-nav > div > a > i';
					$jvbpd_css_one_row[] = '{ color:#454545; }';
				break;

				default:
				case "light":
					$jvbpd_css_one_row[] = '@media(min-width:768px){ html body .nav-top.navbar-static-top li.menu-item-depth-0.menu-item > a > span.menu-titles{ color:#fff; }}';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-search_in_nav-nav.menu-item-object-custom.menu-item > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_notifications-nav.menu-item-object-custom.menu-item > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_menu-nav > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_menu-nav > a:focus,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-my_notifications-nav > a > i,';
					$jvbpd_css_one_row[] = 'html body li.jvbpd-menu.jvbpd-right_sidebar_opener-nav > div > a > i';
					$jvbpd_css_one_row[] = '{ color:#ffffff; }';
				break;
			}
		}

		// Navigation Full-Width
		if( "full" == $jvbpd_query->get("header_fullwidth", jvbpd_tso()->header->get( 'header_fullwidth', false ) ) ){
			$jvbpd_css_one_row[]	= "html header#header-one-line:not(.jv-nav-row-2) .container{ width:100%; }";
			$jvbpd_css_one_row[] = "html header#header-one-line div#javo-navibar{ text-align:right; }";
			$jvbpd_css_one_row[] = "html header#header-one-line div#javo-navibar ul{ text-align:left; }";
			$jvbpd_css_one_row[] = "html header#header-one-line.header-general .javo-main-navbar .navbar-header .navbar-brand-wrap .navbar-brand img{ left:15px; }";
			$jvbpd_css_one_row[] = "html header#header-one-line:not(.jv-nav-row-2) div#javo-navibar ul.jv-nav-ul:not(.mobile){ float:none !important; display:inline-block; vertical-align:top; margin-top:6px; }";
			$jvbpd_css_one_row[] = "html header#header-one-line div#javo-navibar ul.navbar-right:not(.mobile){ float:none !important; display:inline-block; vertical-align:top; }";
		}else if( "fixed-right" == $jvbpd_query->get("header_fullwidth", jvbpd_tso()->header->get( 'header_fullwidth', false ) ) ){
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar ul#javo-header-featured-menu .right-menus .widget_top_menu_wrap{padding-left:5px;}";
		}else{
		}

		$jvbpd_css_one_row[] = "html header#header-one-line div#javo-navibar ul.jv-nav-ul:not(.mobile){ margin-top:6px; }";

		// Navigation Menu Transparent
		$strHeaderRelationOption = !is_archive() && !is_search() && !is_attachment() && !get_query_var( 'pn' ) ? $jvbpd_query->get( 'header_relation', jvbpd_tso()->header->get( 'header_relation', false ) ) : '';
		if( false !== ( $css = apply_filters( 'jvbpd_header_relation_option', $strHeaderRelationOption ) ) ) {
			$jvbpd_css_one_row[] = ".nav-top.navbar-static-top{ position:{$css} !important; }";
			if( $css == 'absolute' ) {
				$jvbpd_css_one_row[] = ".nav-top.navbar-static-top{ left:0; right:0; }";
				$jvbpd_css_one_row[] = "@media(min-width:768px){ body.admin-bar .nav-top.navbar-static-top{ top:32px !important; } }";
			}
		}

		// Sticky Menu
		{
			if( "disabled" == $jvbpd_query->get("header_sticky", jvbpd_tso()->header->get( 'header_sticky', false )  ) ){
				add_filter( 'body_class', Array( __CLASS__, 'append_parametter' ) );
			}
		}

		// Sticky Header Skin
		{
			switch( $jvbpd_query->get("sticky_header_skin", jvbpd_tso()->header->get( 'sticky_header_skin', false ) ) )
			{
				case "light":
					$jvbpd_css_one_row[] = "html body header#header-one-line .affix #javo-navibar ul.nav > li.menu-item > a{ color:#fff; }";
					$jvbpd_css_one_row[] = "html body header#header-one-line .affix ul.widget_top_menu_wrap > li.widget_top_menu > a{ color:#fff; }";
					$jvbpd_css_one_row[] = "html body header#header-one-line .affix ul.widget_top_menu_wrap > li.widget_top_menu button.btn{ color:#fff; }";
					$jvbpd_css_one_row[] = "#header-one-line.jv-vertical-nav .javo-main-navbar.affix .container #javo-navibar #menu-primary >.menu-item >.dropdown-menu:after{border-left-color: #fff;}";
				break;

				default:
				case "dark":
					$jvbpd_css_one_row[] = "html body header#header-one-line .affix #javo-navibar ul.nav > li.menu-item > a{ color:#000; }";
					$jvbpd_css_one_row[] = "html body header#header-one-line .affix ul.widget_top_menu_wrap > li.widget_top_menu > a{ color:#000; }";
					$jvbpd_css_one_row[] = "html body header#header-one-line .affix ul.widget_top_menu_wrap > li.widget_top_menu button.btn{ color:#000; }";
					$jvbpd_css_one_row[] = "#header-one-line.jv-vertical-nav .javo-main-navbar.affix .container #javo-navibar #menu-primary >.menu-item >.dropdown-menu:after{border-left-color: #454545;}";
				break;
			}
		}

		// Sticky Header Shadow
		if( $jvbpd_query->get('sticky_menu_shadow')=='enable' ){
			$jvbpd_css_one_row[] = "html header#header-one-line nav.javo-main-navbar.affix{
				-webkit-box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
				-moz-box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
				-ms-box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
				-o-box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
				box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
			}";
		}

		if( "enable" != $jvbpd_query->get("sticky_menu_shadow", jvbpd_tso()->header->get( 'sticky_menu_shadow', false ) ) ){
			$jvbpd_css_one_row[] = "html header#header-one-line nav.javo-main-navbar.affix{ box-shadow:none; color:transparent;}";
			$jvbpd_css_one_row[] = "html header#header-one-line:after{ content:none; }";
		}

		// Mobile Navigation
		if( false !== ( $hex = $jvbpd_query->get("mobile_header_bg", jvbpd_tso()->header->get( 'mobile_header_bg', false ) ) ) )
		{
			if( false === ( $opacity = (float)jvbpd_tso()->header->get( 'mobile_header_opacity', false ) ) ){
				$opacity = (float)1;
			}

			$jvbpd_rgb = apply_filters( 'jvbpd_rgb', substr( $hex, 1) );
			$jvbpd_css_one_row[] = "html body.mobile nav.nav-top.navbar-static-top{ background-color:rgba( {$jvbpd_rgb['r']}, {$jvbpd_rgb['g']}, {$jvbpd_rgb['b']}, {$opacity}) !important; }";
			$jvbpd_css_one_row[] = "#header-one-line .javo-main-navbar .container .container-fluid #javo-navibar >.navbar-mobile{ background-color:transparent !important; }";
			$jvbpd_css_one_row[] = "body.mobile.page-template-lava_lv_listing_map #header-one-line #javo-navibar{ background-color:rgba( {$jvbpd_rgb['r']}, {$jvbpd_rgb['g']}, {$jvbpd_rgb['b']}, {$opacity}) !important; }";
		}

		// Mobile Header Skin
		{
			switch( $jvbpd_query->get("mobile_header_skin", jvbpd_tso()->header->get( 'mobile_header_skin', false ) ) )
			{
				case "light":
					$jvbpd_css_one_row[] = "html body.mobile .nav-top.navbar-static-top li.menu-item-depth-0.menu-item > a > span.menu-titles{color:#fff !important;}";
					$jvbpd_css_one_row[] = "html body.mobile #jv-nav{background:#646464 !important;}";
				break;

				default:
				case "dark":
					$jvbpd_css_one_row[] = "html body.mobile .nav-top.navbar-static-top li.menu-item-depth-0.menu-item > a > span.menu-titles{ color:#646464 !important; }";
				break;
			}
		}


		// Topbar
		if( jvbpd_header()->getTopbarAllow() ) {
			$objTopBarMeta = Array(
				'color' => apply_filters( 'jvbpd_topbar_text_color', '#000000' ),
				'height' => apply_filters( 'jvbpd_topbar_height', false ),
				'background-image' => apply_filters( 'jvbpd_topbar_logo', false ),
				'background-color' => apply_filters( 'jvbpd_topbar_bgcolor', '#000000' ),
				'background-position' => 'bottom center',
				'background-repeat' => 'no-repeat',
			);
			$arrTopbarCss = Array();
			foreach( $objTopBarMeta as $strProperty => $strValue ) {
				if( false === $strValue ) {
					continue;
				}
				if( 'background-image' === $strProperty ) {
					$arrTopbarCss[] = $strProperty . ':url(' . $strValue . ')';
					continue;
				}
				$arrTopbarCss[] = $strProperty . ':' . $strValue;
			}
			$strTopbarCSS = implode( ';', $arrTopbarCss );
			$jvbpd_css_one_row[] = 'body .nav-top .sidebar.top-bar{' . $strTopbarCSS . '}';
			$jvbpd_css_one_row[] = 'body .nav-top .sidebar.top-bar .jvbpd-menu div.social-icons > a > i,';
			$jvbpd_css_one_row[] = 'body .nav-top .sidebar.top-bar ul.navbar-nav li.menu-item.menu-item-depth-0 > a > span.menu-titles';
			$jvbpd_css_one_row[] = '{ color:' . $objTopBarMeta[ 'color' ] . '; }';
		}

		// Page Background Image
		if('' != ( $css = $jvbpd_query->get('page_background_image', $jvbpd_tso->get('page_background_image', false)))){
			$jvbpd_css_one_row[] = "html body, html body.custom-background{background-image:url('{$css}'); background-size:cover; background-repeat:no-repeat; background-attachment:fixed;}";
		}


		$color = null;
		// Primary Color
		if( $color = $jvbpd_tso->get( 'total_button_color', false ) )

			/**
			 *	Common Part
			 */
			$jvbpd_css_one_row[] = "html body .admin-color-setting,";
			$jvbpd_css_one_row[] = "html body a.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body button.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body a.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body button.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body .admin-color-setting-hover:hover,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting-hover:hover,";
			$jvbpd_css_one_row[] = "html body button.btn.admin-color-setting-hover:hover,";
			$jvbpd_css_one_row[] = ".lv-directory-review-wrap .jv-rating-form-wrap #javo-review-form-container .lv-review-submit:hover,";
			$jvbpd_css_one_row[] = "body.single-lv_listing #javo-item-wc-booking-section .cart button.wc-bookings-booking-form-button:hover,";
			$jvbpd_css_one_row[] = ".lv-directory-review-wrap .lv-review-loadmore button#javo-detail-item-review-loadmore:hover,";

			$jvbpd_css_one_row[] = "html body div.javo-shortcode.shortcode-jvbpd_search2 div.row.jv-search2-actions-row button[type='submit'].admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body a.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body .btn.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body button.btn.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body button.btn.jv-button-transition:hover,";
			$jvbpd_css_one_row[] = "html body a#back-to-top,";
			$jvbpd_css_one_row[] = "html body a#back-to-top:hover,";
			$jvbpd_css_one_row[] = "body #register_panel .modal-footer .text-right button,";
			$jvbpd_css_one_row[] = "body #register_panel .modal-footer .text-right button:hover,";
			$jvbpd_css_one_row[] = "html body #login_panel .modal-dialog .modal-content .modal-body .bottom_row .required,";
			$jvbpd_css_one_row[] = "html body #login_panel .modal-dialog .modal-content .modal-body .bottom_row .required:hover,";
			$jvbpd_css_one_row[] = "html body #login_panel .modal-dialog .modal-content .modal-body .lava_login_wrap .lava_login button,";
			$jvbpd_css_one_row[] = "html body #login_panel .modal-dialog .modal-content .modal-body .lava_login_wrap .lava_login button:hover,";
			$jvbpd_css_one_row[] = ".jvbpd_pagination > .page-numbers.current,";

			/**
			 *	Single Part
			 */
			$jvbpd_css_one_row[] = "html body.single button.lava_contact_modal_button,";
			$jvbpd_css_one_row[] = "html body.single button.lava_contact_modal_button:hover,";
			$jvbpd_css_one_row[] = "html body.single div.single-item-tab div.container form.lava-wg-author-contact-form";
			$jvbpd_css_one_row[] = "div.panel div.panel-body.author-contact-button-wrap button.btn.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body.single div.single-item-tab div.container div.panel div.panel-body.author-contact-button-wrap";
			$jvbpd_css_one_row[] = "button.btn.admin-color-setting-hover:hover,";
			$jvbpd_css_one_row[] = ".single-lv_listing #jvlv-single-get-direction .modal-footer button,";
			$jvbpd_css_one_row[] = ".single-lv_listing .single-item-tab #dot-nav ul li:hover,";
			$jvbpd_css_one_row[] = ".single-lv_listing .single-item-tab #dot-nav ul li.active,";
			$jvbpd_css_one_row[] = ".lv-directory-review-wrap .review-avg-wrap .review-avg-score-wrap .review-avg-des .review-avg-bar-wrap .col-md-9 .progress .progress-bar,";
			$jvbpd_css_one_row[] = ".lava_contact_modal .modal-dialog .modal-content .modal-body .contact-form-widget-wrap .ninja-forms-cont .field-wrap input[type='submit'],";
			$jvbpd_css_one_row[] = ".lava_report_modal .modal-dialog .modal-content .modal-body .contact-form-widget-wrap .ninja-forms-cont .field-wrap input[type='submit'],";
			$jvbpd_css_one_row[] = ".single-lv_listing #javo-single-sidebar #javo-item-contact-section .ninja-forms-cont .field-wrap input[type='submit'],";
			$jvbpd_css_one_row[] = "body.single.single-lv_listing .lava-Di-share-dialog#lava-alert-box h5 .row .col-md-12 .modal-header,";
			$jvbpd_css_one_row[] = "body.single.single-lv_listing .lava-Di-share-dialog#lava-alert-box h5 .row .col-md-12 .row .col-md-3 button,";

			/**
			 *	Booking Part
			 */
			 $jvbpd_css_one_row[] = ".widget_lava_directory_booking_widget button.wc-bookings-booking-form-button,";


			 /**
			 *	Header Search Part
			 */
			 $jvbpd_css_one_row[] = "#lv-header-search-container.nav > form#lv-header-search-addon-form > .lv-header-search-addon-wrap #lv-header-search-addon .row .lv-header-search-addon-search-now button,";

			/**
			 *	Map Part
			 */
			$jvbpd_css_one_row[] = "html body div.javo-slider-tooltip,";
			$jvbpd_css_one_row[] = "html body div.javo-my-position-geoloc .noUi-handle,";
			$jvbpd_css_one_row[] = "html body div.jvbpd_map_list_sidebar_wrap .noUi-handle,";
			$jvbpd_css_one_row[] = "html body #javo-maps-listings-switcher > .switcher-right > .btn-group label:hover,";
			$jvbpd_css_one_row[] = "html body #javo-maps-listings-switcher > .switcher-right > .btn-group label.active,";
			$jvbpd_css_one_row[] = "html body .javo-maps-panel-wrap .javo-map-box-advance-filter-wrap-fixed #javo-map-box-advance-filter,";
			$jvbpd_css_one_row[] = "html body .javo-maps-search-wrap #javo-map-box-advance-filter:hover,";
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module3 .media-left .meta-category,";
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module12 .jv-module-featured-label,";
			$jvbpd_css_one_row[] = "html body #javo-listings-wrap .javo-module12 .jv-module-featured-label,";
			$jvbpd_css_one_row[] = "end#primary-color{ background-color:{$color} !important; }";

			/**
			 *	Primary Font Colors
			 */
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module3 .media-body .meta-price ,";
			$jvbpd_css_one_row[] = "end#primary-font-color{ color:{$color} }";

			/**
			 *	Primary Border Colors
			 */
			$jvbpd_css_one_row[] = "html body h3.page-header,";
			$jvbpd_css_one_row[] = ".lava_contact_modal .contact-form-widget-wrap .page-header,";
			$jvbpd_css_one_row[] = ".lava_contact_modal .modal-dialog .modal-content .modal-body .contact-form-widget-wrap .ninja-forms-cont .field-wrap input[type='submit'],";
			$jvbpd_css_one_row[] = ".lava_report_modal .contact-form-widget-wrap .page-header,";
			$jvbpd_css_one_row[] = ".lava_report_modal .modal-dialog .modal-content .modal-body .contact-form-widget-wrap .ninja-forms-cont .field-wrap input[type='submit'],";
			$jvbpd_css_one_row[] = ".single-lv_listing #javo-single-sidebar #javo-item-contact-section .ninja-forms-cont .page-header,";
			$jvbpd_css_one_row[] = ".single-lv_listing #javo-single-sidebar #javo-item-contact-section .ninja-forms-cont .field-wrap input[type='submit'],";
			$jvbpd_css_one_row[] = "body.single.single-lv_listing .lava-Di-share-dialog#lava-alert-box h5 .row .col-md-12 .row .col-md-3 button,";
			$jvbpd_css_one_row[] = "html body #login_panel .modal-dialog .modal-content .modal-body .lava_login_wrap .lava_login button,";
			$jvbpd_css_one_row[] = "#lv-header-search-container.nav > form#lv-header-search-addon-form > .lv-header-search-addon-wrap #lv-header-search-addon .row .lv-header-search-addon-search-now button,";
			$jvbpd_css_one_row[] = "end#primary-border-colo,";
			$jvbpd_css_one_row[] = "body #register_panel .modal-footer .text-right button,";
			$jvbpd_css_one_row[] = "body #register_panel .modal-footer .text-right button:hover,";
			$jvbpd_css_one_row[] = "#javo-infow-brief-window .heading-wrap h2,";
			$jvbpd_css_one_row[] = ".single-lv_listing #jvlv-single-get-direction .modal-footer button,";
			$jvbpd_css_one_row[] = "#header-one-line.jv-nav-row-2 .javo-main-navbar #javo-navibar #menu-primary >.menu-item.active, #header-one-line.jv-nav-row-2 .javo-main-navbar #javo-navibar #menu-primary >.menu-item.current_page_parent, #header-one-line.jv-nav-row-2 .javo-main-navbar #javo-navibar #menu-primary >.menu-item:hover{ border-color:{$color} !important; }";

			/**
			 *	Map module 12 Featured label color
			 */
			$jvbpd_css_one_row[] = "html body #javo-listings-wrap .javo-module12 .jv-module-featured-label:before,";
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module12 .jv-module-featured-label:before{border-top-color:{$color} !important;}";
			$jvbpd_css_one_row[] = "html body #javo-listings-wrap .javo-module12 .jv-module-featured-label:after,";
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module12 .jv-module-featured-label:after{border-top-color:{$color} !important;border-bottom-color:{$color} !important;}";

			/**
			 *	Toolbar Left/Right
			 */
			$jvbpd_css_one_row[] = "html body .jv-trans-menu-contact-left-wrap i.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .jv-trans-menu-contact-right-wrap i.admin-color-setting";
			$jvbpd_css_one_row[] = "{ background-color:transparent !important; color:{$color}; }";

			/**
			 *	Primary Color for Font Color
			 */
			$jvbpd_css_one_row[] = "html body #dot-nav > ul > li.active,";
			$jvbpd_css_one_row[] = ".pull-left li.active > a > span.menu-titles,";
			$jvbpd_css_one_row[] = "html body div.jv-custom-post-content > div.jv-custom-post-content-trigger,";
			$jvbpd_css_one_row[] = "html body #javo-item-description-read-more{ color:{$color}; }";
			$jvbpd_css_one_row[] = "html body .shortcode-jvbpd_timeline1 .timeline-item .jv-data i{ color:{$color}; }";


		$color = null;
		// Primary Font Color
		if( $color = $jvbpd_tso->get( 'primary_font_color', false ) )

			/**
			 *	Common Part
			 */
			$jvbpd_css_one_row[] = "html body .admin-color-setting,";
			$jvbpd_css_one_row[] = "html body a.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body button.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body a.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body button.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body a.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body .btn.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body button.btn.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body button.btn.jv-button-transition:hover,";
			$jvbpd_css_one_row[] = "html body a#back-to-top,";
			$jvbpd_css_one_row[] = "html body a#back-to-top:hover,";
			$jvbpd_css_one_row[] = ".jvbpd_pagination > .page-numbers.current,";

			/**
			 *	Single Part
			 */
			$jvbpd_css_one_row[] = "html body.single button.lava_contact_modal_button,";
			$jvbpd_css_one_row[] = "html body.single button.lava_contact_modal_button:hover,";
			$jvbpd_css_one_row[] = "html body.single .lava-single-sidebar .panel-heading.admin-color-setting .col-md-12 h3,";


			/**
			 *	Map Part
			 */
			$jvbpd_css_one_row[] = "html body div.javo-slider-tooltip,";
			$jvbpd_css_one_row[] = "html body div.javo-my-position-geoloc .noUi-handle,";
			$jvbpd_css_one_row[] = "html body div.jvbpd_map_list_sidebar_wrap .noUi-handle,";
			$jvbpd_css_one_row[] = "html body #javo-maps-listings-switcher > .switcher-right > .btn-group label:hover,";
			$jvbpd_css_one_row[] = "html body #javo-maps-listings-switcher > .switcher-right > .btn-group label.active,";
			$jvbpd_css_one_row[] = "html body .javo-maps-panel-wrap .javo-map-box-advance-filter-wrap-fixed #javo-map-box-advance-filter,";
			$jvbpd_css_one_row[] = "html body .javo-maps-search-wrap #javo-map-box-advance-filter:hover,";
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module3 .media-left .meta-category,";

			/**
			 *	Booking Part
			 */
			$jvbpd_css_one_row[] = ".widget_lava_directory_booking_widget button.wc-bookings-booking-form-button,";

			/**
			 *  shortcode navi
			 */
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li.active > span:hover,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output .page-numbers.loadmore:hover,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li > a:hover ,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li.active > a ,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li.active > a:hover ,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li.active > a:focus ,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li.active > span ,";
			$jvbpd_css_one_row[] = ".javo-shortcode .shortcode-output ul.pagination > li.active > a:focus,";

			/**
			 *	Primary Font Colors
			 */
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module3 .media-body .meta-price ,";
			$jvbpd_css_one_row[] = "end#primary-font-color{ color:{$color} !important; }";

		$color = null;
		// Primary Border Color
		if( $color = $jvbpd_tso->get( 'total_button_border_color', false ) ) :
			/**
			 *	Common Part
			 */
			$jvbpd_css_one_row[] = "html body .admin-color-setting,";
			$jvbpd_css_one_row[] = "html body a.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body button.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting,";
			$jvbpd_css_one_row[] = "html body .admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body a.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body button.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body .btn.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body a.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body .btn.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body button.btn.jv-button-transition,";
			$jvbpd_css_one_row[] = "html body button.btn.jv-button-transition:hover,";
			$jvbpd_css_one_row[] = "html body a#back-to-top,";
			$jvbpd_css_one_row[] = "html body a#back-to-top:hover,";

			/**
			 *	Single Part
			 */
			$jvbpd_css_one_row[] = "html body.single button.lava_contact_modal_button,";
			$jvbpd_css_one_row[] = "html body.single button.lava_contact_modal_button:hover,";
			$jvbpd_css_one_row[] = "html body.single div.single-item-tab div.container form.lava-wg-author-contact-form";
			$jvbpd_css_one_row[] = "div.panel div.panel-body.author-contact-button-wrap button.btn.admin-color-setting:hover,";
			$jvbpd_css_one_row[] = "html body.single div.single-item-tab div.container div.panel";
			$jvbpd_css_one_row[] = "div.panel-body.author-contact-button-wrap button.btn.admin-color-setting-hover:hover,";

			/**
			 *	Booking Part
			 */
			$jvbpd_css_one_row[] = ".widget_lava_directory_booking_widget button.wc-bookings-booking-form-button,";

			/**
			 * mypage listing list
			 */
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li.active > span:hover,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output .page-numbers.loadmore:hover,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li > a:hover ,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li.active > a ,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li.active > a:hover ,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li.active > a:focus ,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li.active > span ,";
			$jvbpd_css_one_row[] = "#page-style .jv-my-page .javo-shortcode .shortcode-container .shortcode-output ul.pagination > li.active > a:focus,";

			/**
			 *	Map Part
			 */
			$jvbpd_css_one_row[] = "html body div.javo-slider-tooltip,";
			$jvbpd_css_one_row[] = "html body div.javo-my-position-geoloc .noUi-handle,";
			$jvbpd_css_one_row[] = "html body div.jvbpd_map_list_sidebar_wrap .noUi-handle,";
			$jvbpd_css_one_row[] = "html body #javo-maps-listings-switcher > .switcher-right > .btn-group label:hover,";
			$jvbpd_css_one_row[] = "html body #javo-maps-listings-switcher > .switcher-right > .btn-group label.active,";
			$jvbpd_css_one_row[] = "html body .javo-maps-panel-wrap .javo-map-box-advance-filter-wrap-fixed #javo-map-box-advance-filter,";
			$jvbpd_css_one_row[] = "html body .javo-maps-search-wrap #javo-map-box-advance-filter:hover,";
			$jvbpd_css_one_row[] = "html body #javo-maps-wrap .javo-module3 .media-left .meta-category,";
			$jvbpd_css_one_row[] = "end#primary-border-color{ border-color:{$color} !important; }";

		endif;

		// Footer Middle Color
		if( $color = $jvbpd_tso->get( 'footer_middle_background_color' , false ) )
			$jvbpd_css_one_row[] = "html body > div.footer-background-wrap{ background-color:{$color}; }";

		jvbpd_enqueues()->admin_custom_style_apply_func( $jvbpd_css_one_row );

		// Output Stylesheet
		$jvbpd_css_one_row = apply_filters( 'jvbpd_custom_css_rows', $jvbpd_css_one_row );
		wp_add_inline_style( 'jvbpd-bind', join( false, $jvbpd_css_one_row ) );

	}

	public static function jvbpd_add_transparent_class_callback( $classes )
	{
		global $post;

		$post_id = 0;

		if( !empty( $post ) )
			$post_id = $post->ID;

		$jvbpd_hd_options = get_post_meta( $post_id, 'jvbpd_hd_post', true );
		$jvbpd_query = new jvbpd_array( $jvbpd_hd_options );
		$arrAllowPostTypes = apply_filters( 'jvbpd_single_post_types_array', Array( 'custom_type' ) );

		if(
			( !empty( $post->post_type ) && in_Array( $post->post_type, $arrAllowPostTypes ) && jvbpd_tso()->header->get( 'single_header_relation' ) === 'absolute' ) ||
			( $jvbpd_query->get("header_relation", jvbpd_tso()->header->get( 'header_relation', false ) ) === 'absolute' )
		) $classes[]	= "jv-header-transparent";

		if( 'full' == $jvbpd_query->get("header_fullwidth", jvbpd_tso()->header->get( 'header_fullwidth', false ) ) )
			$classes[]	= "jv-header-fullwidth";

		return $classes;
	}

	public static function append_parametter( $classes ) {
		$classes[]			= "no-sticky";
		return $classes;
	}

	public function defer_scripts( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        if ( strpos( $url, '.json' ) ) return $url;
		if ( strpos( $url, 'buddypress' ) ) return $url;
        return "$url' defer onload='";
    }

	public static function getInstance() {
		if( ! self::$instance )
			self::$instance = new self;
		return self::$instance;
	}
}

if( !function_exists( 'jvbpd_enqueues' ) ) :
	function jvbpd_enqueues(){
		return jvbpd_enqueue_func::getInstance();
	}
	jvbpd_enqueues();
endif;
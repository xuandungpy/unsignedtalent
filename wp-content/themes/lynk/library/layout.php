<?php

class jvbpd_layout_function {

	public static $instance;

	public $path;

	public $themeType = 'jvd-lk';
	public $footer_path;

	public $widgets	= Array(
		'single-slider' => 'Jvbpd_Single_Post_Slider'
	);

	public function __construct() {

		$this->setVariables();

		add_action( 'wp_head', Array( $this, 'theme_slug_render_title' ) );

		add_action( 'jvbpd_body_after', Array( $this, 'footer' ) );
		add_action( 'wp_footer', Array( $this, 'common_load' ) );
		add_action( 'wp_footer', Array( $this, 'common_script' ) );
		add_action( 'widgets_init', Array( $this, 'widgets_init' ) );

		add_action( 'after_setup_theme', Array( $this, 'init' ) );

		add_filter( 'body_class', array( $this, 'body_class' ) );

		add_action( 'jvbpd_output_header', array( $this, 'single_page_header' ), 10, 1 );

		add_filter( 'jvbpd_sidebar_position', array( $this, 'sidebar_position' ), 10, 2 );

		add_filter( 'lava_post_single_enqueues', array( $this, 'singlePostEnqueue' ), 10, 3 );
		add_filter( 'lava_bpp_single_change_template', array( $this, 'singleChangeTemplate' ), 10, 3 );


		if( ! is_admin() ) {
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_navi_item' ), 10, 2 );
			add_filter( 'walker_nav_menu_start_el', array( $this, 'javo_custom_navi' ), 10, 4 );
		}

		/* General Post */ {
			add_action( 'jvbpd_post_content_after', Array( $this, 'relative_posts' ) );
		}

		/* Header */ {
			add_filter( 'jvbpd_theme_option_header_type_default', array( $this, 'header_type_option' ), 10, 2 );
			add_filter( 'jvbpd_theme_option_sidebar_left_default', array( $this, 'sidebar_default_option' ), 10, 2 );
			add_filter( 'jvbpd_theme_option_sidebar_member_default', array( $this, 'sidebar_default_option' ), 10, 2 );
		}

		/* Topbar */{
			add_filter( 'jvbpd_topbar_height', array( $this, 'topbar_height' ) );
			add_filter( 'jvbpd_topbar_logo', array( $this, 'topbar_logo' ) );
			add_filter( 'jvbpd_topbar_bgcolor', array( $this, 'tobar_bgcolor' ) );
			add_filter( 'jvbpd_topbar_text_color', array( $this, 'tobar_text_color' ) );
		}

		/* Sidebar */{
			add_filter( 'jvbpd_left_sidebar_display', array( $this, 'sidebarLeftDisplay' ) );
			add_filter( 'jvbpd_member_sidebar_display', array( $this, 'sidebarMemberDisplay' ) );
		}
		add_filter( 'jvbpd_middle_header_display', array( $this, 'middleMenuDisplay' ) );

		// Menu in javo bp core
		add_action( 'init', array( $this, 'add_menu_in_shortcode' ) );

		add_filter( 'jvbpd_header_relation_option', array( $this, 'dashboard_header_relation_option' ), 11 );
		add_filter( 'jvbpd_header_relation_option', array( $this, 'header_relation_option' ) );
		add_filter( 'jvbpd_header_skin_option', array( $this, 'header_skin_option' ) );
		add_filter( 'jvbpd_header_bg_option', array( $this, 'header_bg_option' ) );
		add_filter( 'jvbpd_header_bg_opacity_option', array( $this, 'header_bg_opacity_option' ) );
		add_filter( 'jvbpd_header_shadow_option', array( $this, 'header_shadow_option' ) );
	}

	public function setVariables() {
		$this->path = get_template_directory() . '/library/';
		$this->footer_path	= $this->path . 'footer/';
		$this->widget_path	= $this->path . 'widgets/';
	}

	public function getThemeType() {
		return apply_filters( 'jvbpd_theme_type', $this->themeType, $this );
	}

	public function init(){
		add_filter( 'wc_get_template', Array( $this, 'vender_template' ), 10, 2 );
	}

	public function body_class( $classes=Array() ) {
		$sidebar_position = apply_filters( 'jvbpd_sidebar_position', 'default', get_the_ID() );
		$strNavPosition = jvbpd_header()->header_fullwidth;

		if( empty( $strNavPosition ) ) {
			$strNavPosition = jvbpd_tso()->header->get( 'header_fullwidth', 'fixed' );
		}

		$classes[] = 'nav-pos-' . $strNavPosition;
		$classes[] = 'layout-' . $sidebar_position;
		$classes[] = 'skin-' . apply_filters( 'jvbpd_header_skin_option', false );

		//if( is_singular( 'post' ) ) {
			$classes[] = 'jvbpd-single-post-type-' . $this->getThemeType();
		//}
		return $classes;
	}

	public function single_page_header( $post_id ) {
		$post = get_queried_object();

		if( ( !$post instanceof WP_Post ) && ! is_search() ) {
			return;
		}

		/*
		if( 'page' !== $post->post_type && is_search() ) {
			//return;
		} */

		if( ! is_search() ) {

			$option = 'showtitle';
			if( false !== get_post_meta( $post->ID, 'jvbpd_header_type', true ) ) {
				$option = get_post_meta( $post->ID, 'jvbpd_header_type', true );
			}

			if( 'notitle' === apply_filters( 'jvbpd_single_post_header', $option, $post->ID ) ) {
				return;
			}
		}

		if( $this->getThemeType() == 'jvd-lp' ) {
			get_template_part( 'templates/template', 'post-header' );
		}
	}

	public function sidebar_position( $position='', $post_id=0 ) {

		if( 'post' == get_post( $post_id )->post_type ) {
			$position = 'right';
		}

		$setting = get_post_meta( $post_id, 'jvbpd_sidebar_type', true );
		if( !empty( $setting ) ) {
			$position = $setting;
		}

		if( is_archive() || is_search() ) {
			$position = 'right';
		}

		return strtolower( $position );
	}

	public function singlePostEnqueue() {
		if( ! function_exists( 'lava_bpp' ) ) {
			return;
		}
		wp_enqueue_script( lava_bpp()->enqueue->getHandleName( 'jquery.flexslider-min.js' ) );
		wp_enqueue_script( lava_bpp()->enqueue->getHandleName( 'lava-single.js' ) );
		wp_add_inline_script(
			lava_bpp()->enqueue->getHandleName( 'lava-single.js' ),
			'jQuery( function($){ jQuery.lava_single({slider:$( ".lava-detail-images")});});'
		);
	}

	public function singleChangeTemplate( $boolean=true, $slug, $post ) {
		if( $slug == 'post' ) {
			$boolean = false;
		}
		return $boolean;
	}

	public function getNavClass( $classes='' ) {
		$separator = ' ';
		$classes = explode( $separator, $classes );

		$classes[] = 'navbar';
		$classes[] = 'navbar-default';
		$classes[] = 'nav-top';
		$classes[] = 'navbar-static-top';

		$classes = apply_filters( 'jvbpd_nav_classes', $classes );
		printf( 'class="%s"', join( $separator, $classes ) );
	}

	public function getLogo( $args=Array() ) {
		$options = shortcode_atts(
			Array(
				'type' => false,
				'no_image' => true,
				'class' => '',
				'width' => 0,
				'height' => 0,
				'allow_types' => Array()
			), $args
		);

		$defaults = Array(
			'no_image' => JVBPD_IMG_DIR .'/no-image.png',
			// 'logo_url' => JVBPD_IMG_DIR .'/jv-logo4-m.png',
			'logo_url' => JVBPD_IMG_DIR .'/jv-logo2.png',
			'logo_light_url' => JVBPD_IMG_DIR .'/jv-logo1.png',
			'logo_small_url' => JVBPD_IMG_DIR .'/jv-logo4.png',
		);

		$classes = Array();
		$classes = @explode( ' ', $options[ 'class' ] );

		jvbpd_header()->getOptions();
		$strHeaderType = jvbpd_header()->options->header_type;
		$strHeaderSkin = jvbpd_header()->options->header_skin;

		if( !empty( $options[ 'allow_types' ] ) && is_array( $options[ 'allow_types' ] ) ) {
			if( !in_array( $strHeaderType, $options[ 'allow_types' ] ) ) {
				return sprintf( '<img alt="%s">', esc_html__( "Logo", 'jvfrmtd' ) );
			}
		}

		if( false === $options[ 'no_image' ] ) {
			$strNoImageURL = '';
		}elseif( true === $options[ 'no_image' ] ) {
			$strNoImageURL = jvbpd_tso()->get( 'no_image', $defaults[ 'no_image' ] );
		}else{
			$strNoImageURL = $options[ 'no_image' ];
		}

		if( false === $options[ 'type' ] ) {
			if( 'dashboard-style' == $strHeaderType ) {
				$options[ 'type' ] = 'logo_small_url';
			}else{
				$options[ 'type' ] = 'logo_url';
				if( 'light' == apply_filters( 'jvbpd_header_skin_option', $strHeaderSkin ) ) {
					$options[ 'type' ] = 'logo_light_url';
				}
			}
		}

		$strImageURL = jvbpd_tso()->get( $options[ 'type' ], false );

		if( in_array( $options[ 'type' ], Array( 'logo_url', 'logo_light_url' ) ) ) {
			$strPageLogoImageURL = jvbpd_header()->header_logo;
			if( !empty( $strPageLogoImageURL ) ) {
				$strImageURL = $strPageLogoImageURL;
			}
		}

		if( empty( $strImageURL ) ) {
			$strDefaultURL = array_key_exists( $options[ 'type' ], $defaults ) ? $defaults[ $options[ 'type' ] ] : false;
			if( !empty( $strDefaultURL ) ) {
				$strImageURL = $strDefaultURL;
			}else{
				$strImageURL = $strNoImageURL;
			}
		}

		$jvbpd_mobile_logo =  jvbpd_tso()->get( 'mobile_logo_url', '' );
		if( $jvbpd_mobile_logo != '' )		{
			//$jvbpd_mobile_logo = " data-javo-mobile-src=\"{$jvbpd_mobile_logo}\"";
		}

		if( $options['type'] == 'logo_url' && $jvbpd_mobile_logo != '' ){
			$strImageURL = $jvbpd_mobile_logo;
		}

		return sprintf(
			'<img src="%1$s" class="%2$s" alt="%3$s" %4$s>',
			$strImageURL,
			join( ' ', $classes ),
			esc_html__( "Logo", 'jvfrmtd' ),
			$jvbpd_mobile_logo
		);
	}

	public function getSiteShortLabel() {
		jvbpd_header()->getOptions();
		$strHeaderType = jvbpd_header()->options->header_type;
		if( $strHeaderType !== 'dashboard-style' ) {
			return;
		}

		$strSiteTitle = get_bloginfo( 'name' );
		$strShortTitle = jvbpd_tso()->header->get( 'header_short_label', false );
		if( false !== $strShortTitle ) {
			$strSiteTitle = $strShortTitle;
		}
		return $strSiteTitle;
	}

	public function getBannerImage() {
		$classes = Array();
		$strNoImageURL = jvbpd_tso()->getNoImage();
		$StrBannerImageUrl = jvbpd_header()->header_banner;
		if( empty( $StrBannerImageUrl ) ) {
			$StrBannerImageUrl = jvbpd_tso()->header->get( 'header_banner', false );
		}

		if( empty( $StrBannerImageUrl ) ) {
			$StrBannerImageUrl = $strNoImageURL;
		}

		$classes[] = 'top-ad-banner';
		$classes[] = 'img-responsive';

		return sprintf( '<img src="%1$s" class="%2$s" alt="%3$s">', $StrBannerImageUrl, join( ' ', $classes ), esc_html__( "Banner", 'jvfrmtd' ) );
	}

	public function theme_slug_render_title(){
		if( function_exists( '_wp_render_title_tag' ) )
			return false;
		?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
	}

	public function getBreadcrumb() {
		$breadcrumb_args = Array(
			'home' => sprintf(
				'<li class=""><a href="%1$s" title="%2$s" target="_self">%2$s</a></li>',
				home_url( '/' ),
				esc_html__( "Home", 'jvfrmtd' )
			),
		);

		if( is_page() ) {
			$breadcrumb_args[ get_the_ID() ] = sprintf(
				'<li class=""><a href="%1$s" title="%2$s" target="_self">%2$s</a></li>',
				get_permalink(), get_the_title()
			);
		}

		$breadcrumb = apply_filters( 'jvbpd_breadcrumb_array', $breadcrumb_args );
		$breadcrumb = join( '', $breadcrumb );
		return sprintf( '<ul class="list-unstyled breadcrumb">%s</ul>', $breadcrumb );
	}

	public function footer() {
		$this->getContent( 'banner', 'footer' );
		$this->getContent( 'widget', 'footer-body' );
		$this->getContent( 'html', 'contact-us' );
		$this->getContent( 'html', 'quick-buttons' );

		get_template_part( 'templates/parts/modal', 'contact-us' );	// modal contact us
		get_template_part( 'templates/parts/modal', 'map-brief' );	// Map Brief
		get_template_part( 'templates/parts/modal', 'emailme' );	// Link address send to me
		get_template_part( 'templates/parts/modal', 'claim' );		// claim
	}

	public function getContent( $strType ='', $strName='', $args=Array() ) {
		global $jvbpd_tso;

		if( !empty( $args ) )
			extract( $args, EXTR_SKIP );

		$strFilename = $this->footer_path .  $strType . '-' . $strName . '.php';
		if( file_exists( $strFilename ) ) {
			require_once( $strFilename );
		}
	}

	public function common_load() {
		$this->getLoginPart();
	}

	public function common_script() {
		$mail_alert_msg = Array(
			'to_null_msg'			=> esc_html__('Please, type email address.', 'jvfrmtd' )
			, 'from_null_msg'		=> esc_html__('Please, type your email adress.', 'jvfrmtd' )
			, 'subject_null_msg'	=> esc_html__('Please, type your name.', 'jvfrmtd' )
			, 'content_null_msg'	=> esc_html__('Please, type your message', 'jvfrmtd' )
			, 'failMsg'				=> esc_html__('Sorry, failed to send your message', 'jvfrmtd' )
			, 'successMsg'			=> esc_html__('Successfully sent!', 'jvfrmtd' )
			, 'confirmMsg'			=> esc_html__('Do you want to send this email ?', 'jvfrmtd' )
		);
		$jvbpd_favorite_alerts = Array(
			"nologin"				=> esc_html__('If you want to add it to your favorite, please login.', 'jvfrmtd' )
			, "save"				=> esc_html__('Saved', 'jvfrmtd' )
			, "unsave"				=> esc_html__('Unsaved', 'jvfrmtd' )
			, "error"				=> esc_html__('Sorry, server error.', 'jvfrmtd' )
			, "fail"				=> esc_html__('favorite register fail.', 'jvfrmtd' )
		); ?>
		<?php
	}

	public function load_template( $strTemplateName=false, $args=Array() ) {
		$strFileName = apply_filters( 'jvbpd_layout_load_template', JVBPD_TP_DIR . '/' . $strTemplateName, $strTemplateName, JVBPD_TP_DIR . '/' );
		return $this->load_file( $strFileName . '.php', $args );
	}

	public function load_file( $strFileName=false, $args=Array(), $options=Array() ){
		$options = shortcode_atts(
			Array(
				'once' => false,
			), $options
		);
		if( is_Array( $args ) )
			extract( $args, EXTR_SKIP );

		if( file_exists( $strFileName ) ){
			if( $options[ 'once' ] ) {
				require_once( $strFileName );
			}else{
				require( $strFileName );
			}
			return true;
		}
		return false;
	}

	public function load_widget( $template_name=false, $args=Array() ) {
		$strFileName = $this->widget_path .'wg-javo-' . $template_name . '.php';
		return $this->load_file( $strFileName, $args );
	}

	public function widgets_init(){
		if( ! empty( $this->widgets ) ) : foreach( $this->widgets as $strFileName => $strClassName ) {
			if( $this->load_widget($strFileName) )
				register_widget( $strClassName );
		} endif;
	}

	public function vender_template( $located, $template_name ) {
		global $wc_product_vendors;

		if( is_object( $wc_product_vendors ) ){
			if( is_tax( $wc_product_vendors->token ) && 'archive-product.php' == $template_name ) {
				return get_stylesheet_directory() . '/woocommerce/taxonomy-shop_vendor.php';
			}
		}
		return $located;
	}

	public function getLoginPart() {
		global $jvbpd_tso;

		switch( $jvbpd_tso->get('login_modal_type', 2) ) {
			case 2: get_template_part('templates/parts/modal', 'login'); break;
			case 1: default: get_template_part('templates/parts/modal', 'login-type1');
		}
		if( get_option( 'users_can_register' ) )
			get_template_part('templates/parts/modal', 'register');		// modal Register
	}

	public function single_author_information() {
		$this->section_title(
			esc_html__( "About the author", 'jvfrmtd' ),
			'author'
		);
		$this->getContent( 'html'	, 'single-footer-author' );
	}

	public function relative_posts() {
		global $wp_query;
		$post = $wp_query->get_queried_object();
		$strBlock = 'jvbpd_block11';

		if( 'post' != $post->post_type || !class_exists( $strBlock ) )
			return;

		$this->section_title(
			esc_html__( "Related Posts", 'jvfrmtd' ),
			'relative-posts'
		);

		$objBlock = new $strBlock();
		$objOption = Array(
			'filter_style' => 'paragraph',
			'count' => 3,
			'hide_filter' => true,
			'order_by' => 'date',
			'order_' => 'DESC',
			'columns' => 3,
			'display_category_tag' => 'hide',
			'thumbnail_size' => 'jvbpd-box',
			'module_contents_length' => 10,
			'exclude' => $post->ID,
		);
		$thisTerms = wp_get_post_terms( $post->ID, 'category', Array( 'fields' => 'ids' ) );
		if( $thisTerms[0] ) {
			$objOption[ 'filter_by' ] = 'category';
			$objOption[ 'custom_filter' ] = $thisTerms[0];
			$objOption[ 'custom_filter_by_post' ] = true;
		}
		echo join( "\n", Array(
			'<div class="jv-single-footer-relative-posts">',
			$objBlock->output( $objOption ),
			'</div>',
		) );
	}

	public function header_type_option( $option='', $tso=Array() ) {
		if( $this->getThemeType() == 'jvd-lp' ) {
			$option = 'inline';
		}
		return $option;
	}

	public function sidebar_default_option( $option='' ) {
		if( $this->getThemeType() == 'jvd-lp' ) {
			$option = 'disabled';
		}
		return $option;
	}

	public function topbar_height( $value=false ) {
		$intHeight = jvbpd_tso()->header->get( 'topbar_height', false );
		if( jvbpd_tso()->header->get( 'topbar' ) == 'enable' && false !== $intHeight ) {
			if( 0 < absint( $intHeight ) ) {
				$value = absint( $intHeight ) . 'px';
			}
		}
		if( jvbpd_header()->topbar == 'enable' && false !== jvbpd_header()->topbar_height ) {
			if( 0 < absint( jvbpd_header()->topbar_height ) ) {
				$value = absint( jvbpd_header()->topbar_height ) . 'px';
			}
		}
		return $value;

	}
	public function topbar_logo( $value=false ) {
		$strLogoURi = jvbpd_tso()->header->get( 'topbar_logo', false );
		if( jvbpd_tso()->get( 'topbar_use' ) == 'enable' && false !== $strLogoURi ) {
			$value = $strLogoURi;
		}
		if( jvbpd_header()->topbar == 'enable' && false !== jvbpd_header()->topbar_logo ) {
			$value = jvbpd_header()->topbar_logo;
		}
		return $value;
	}
	public function tobar_bgcolor( $value=false ) {
		$strColorCode = jvbpd_tso()->header->get( 'topbar_bg_color', false );
		if( jvbpd_tso()->get( 'topbar_use' ) == 'enable' && false !== $strColorCode ) {
			$value = $strColorCode;
		}
		if( jvbpd_header()->topbar == 'enable' && false !== jvbpd_header()->topbar_bg_color ) {
			$value = jvbpd_header()->topbar_bg_color;
		}
		return $value;
	}
	public function tobar_text_color( $value=false ) {
		$strColorCode = jvbpd_tso()->header->get( 'topbar_text_color', false );
		if( jvbpd_tso()->get( 'topbar_use' ) == 'enable' && false !== $strColorCode ) {
			$value = $strColorCode;
		}
		if( jvbpd_header()->topbar == 'enable' && false !== jvbpd_header()->topbar_text_color ) {
			$value = jvbpd_header()->topbar_text_color;
		}
		return $value;
	}
	public function sidebarLeftDisplay( $boolOnOff=true ) {
		$objMenu = wp_nav_menu( Array( 'theme_location' => 'sidebar_left', 'fallback_cb' => '__return_false', 'echo' => false ) );
		if( empty( $objMenu ) ) {
			return false;
		}
		if( jvbpd_header()->sidebar_left == '' ) {
			if( jvbpd_tso()->get( 'sidebar_left', apply_filters( 'jvbpd_theme_option_sidebar_left_default', '' ) ) == 'disabled' ) {
				$boolOnOff = false;
			}
		}else{
			$boolOnOff = jvbpd_header()->sidebar_left != 'disabled';
		}
		return $boolOnOff;
	}

	public function sidebarMemberDisplay( $boolOnOff=true ) {

		if( ! function_exists( 'jvlynkCore' ) ) {
			return false;
		}

		if( jvbpd_header()->sidebar_member == '' ) {
			if( jvbpd_tso()->get( 'sidebar_member', apply_filters( 'jvbpd_theme_option_sidebar_member_default', '' ) ) == 'disabled' ) {
				$boolOnOff = false;
			}
		}else{
			$boolOnOff = jvbpd_header()->sidebar_member != 'disabled';
		}
		return $boolOnOff;
	}

	public function middleMenuDisplay( $boolOnOff=false ) {
		if( jvbpd_header()->header_type == 'jv-nav-row-2-search' ) {
			$boolOnOff = true;
		}
		return $boolOnOff;

	}

	public function section_title( $strLabel='No Label', $icon_id='' ){
		echo join( "\n",
			Array(
				'<div id="jv-single-'. $icon_id . '-title" class="jv-single-section-title ' . $icon_id . '">',
					'<h2 class="section-title">',
						$strLabel,
					'</h2>',
				'</div>'
			)
		);
	}

	public function is_woocommerce_page() {
		$is_woocommerce_page = false;
		foreach(
			Array(
				'shop',
				'cart',
				'checkout',
				'woocommerce',
				'account_page',
				'view_order_page',
				'checkout_pay_page',
				'lost_password_page',
				'order_received_page',
				'add_payment_method_page',
			) as $page_name
		) {
			if( function_exists( 'is_' . $page_name ) && call_user_func( 'is_' . $page_name ) ) {
				$is_woocommerce_page = true;
				break;
			}
		}
		return $is_woocommerce_page;
	}

	public static function getInstance() {
		if( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	public function filterMenuSlug( $menu_item=Array() ) {
		return isset( $menu_item[ 'slug' ] ) ? $menu_item[ 'slug' ] : '';
	}

	public function setup_navi_item( $menu_item ) {
		$strFindString = '';
		if( is_array( $menu_item->classes ) ) {
			$strFindString = implode(' ', $menu_item->classes );
		}
		preg_match('/\sjvbpd-(.*)-nav/', $strFindString, $matches);

		if( empty( $matches[1] ) ) {
			return $menu_item;
		}

		$arrAppendMenus = jvbpd_customNav()->getAppendMenus();
		$arrAppendMenuSlugs = array_map( array( $this, 'filterMenuSlug' ), $arrAppendMenus );
		if( in_array( $matches[1], $arrAppendMenuSlugs ) ) {
			$menu_item->jv_menu = str_replace( '_', '-', $matches[1] );
		}
		return $menu_item;
	}

	public function javo_custom_navi( $output, $item=Array(), $depth=0, $args=Array() ) {
		/**
		 *
		 *
		 * $args : wp_menu_nav
		 *
		 */

		if( isset( $item->jv_menu ) ) {
			ob_start();
			$this->load_template( 'parts/part-menu-'. $item->jv_menu );
			$output = ob_get_clean();
		}
		return $output;
	}

	public function add_menu_in_shortcode() {
		add_filter( 'jvbpd_shortcodes_atts', array( $this, 'add_menu_shortcode_atts' ) );
		add_filter( 'jvbpd_shortcodes_loop', array( $this, 'menu_shortcode_loop' ), 10, 3 );
	}

	public function add_menu_shortcode_atts( $atts=Array() ) {
		$atts[ 'in_menu' ] = false; // Initialize Option
		return $atts;
	}

	public function menu_shortcode_loop( $output='', $posts=Array(), $obj=Array() ) {
		if( isset( $obj->in_menu ) && ( true == $obj->in_menu || 'true' == $obj->in_menu ) ) {
			ob_start();
			$this->load_template(
				'parts/part-menu-wide-category-loop',
				Array(
					'objWideCateShortcode' => $obj,
				)
			);
			$output = ob_get_clean();
		}
		return $output;
	}

	public function dashboard_header_relation_option( $option='' ) {
		jvbpd_header()->getOptions();
		$strHeaderType = jvbpd_header()->options->header_type;
		if( $strHeaderType == 'dashboard-style' ) {
			$option = false;
		}
		return $option;
	}

	public function header_relation_option( $option='' ) {
		if( is_singular( 'post' ) ) {
			$option = jvbpd_tso()->header->get( 'post_header_relation', 'relative' );
		}
		return $option;
	}

	public function header_skin_option( $option='' ) {
		if( false === ( $option = jvbpd_header()->header_skin ) ) {
			$option = jvbpd_tso()->header->get( 'header_skin', 'light' );
		}
		if( is_singular( 'post' ) ) {
			$option = jvbpd_tso()->header->get( 'post_header_skin', 'light' );
		}
		return $option;
	}

	public function header_bg_option( $option='' ) {
		if( is_singular( 'post' ) ) {
			$option = jvbpd_tso()->header->get( 'post_header_bg', '#ffffff' );
		}
		return $option;
	}

	public function header_bg_opacity_option( $option='' ) {
		if( is_singular( 'post' ) ) {
			$option = jvbpd_tso()->header->get( 'post_header_opacity', '1' );
		}
		return $option;
	}

	public function header_shadow_option( $option='' ) {
		if( is_singular( 'post' ) ) {
			$option = jvbpd_tso()->header->get( 'post_header_shadow' );
		}
		return $option;
	}

	public function getPageLayoutTypes() {
		return Array(
			'wide-0' => esc_html__( "Wide( Width : 1140px )", 'jvfrmtd' ),
			'wide-1' => esc_html__( "Wide( Width : 1280px )", 'jvfrmtd' ),
			'wide-2' => esc_html__( "Wide( Width : 1400px )", 'jvfrmtd' ),
		);
	}
}

if( !function_exists( 'jvbpd_layout' ) ) :
	function jvbpd_layout() {
		return jvbpd_layout_function::getInstance();
	}
	jvbpd_layout();
endif;
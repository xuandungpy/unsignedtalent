<?php

if( ! class_exists( 'jvbpd_Header_Func' ) ) :
class jvbpd_Header_Func {

	public static $instance;

	private $slug;
	private $optionInstance = null;

	public $options = Array();
	public $arrNav_classes = Array();

	public function __get( $key ) {
		global $post;

		if( isset( $this->$key ) ) {
			return $this->$key;
		}

		if( ( $post instanceof WP_Post ) && class_exists( 'jvbpd_array' ) ) {
			$options = get_post_meta( $post->ID, 'jvbpd_hd_post', true );
			if( is_null( $this->optionInstance ) ) {
				$this->optionInstance = new jvbpd_array( $options );
			}
			return $this->optionInstance->get( $key, false );
		}
	}

	public function __construct() {

		add_action( 'wp_head', Array( $this, 'getOptions' ) );
		add_action( 'wp_head', Array( $this, 'toolbar_widget' ), 11 );
		add_action( 'jvbpd_header_wrap_after', Array( $this, 'custom_title' ) );
		add_action( 'jvbpd_contact_header_nav', Array( $this, 'basic_walker' ) );
		add_action( 'jvbpd_header_logos', Array( $this, 'custom_logo' ) );
		add_filter( 'jvbpd_header_class', Array( $this, 'header_classes' ), 10, 3 );
		add_filter( 'jvbpd_options_header_types', Array( $this, 'header_type_options' ) );

		add_filter( 'jvbpd_display_header', Array( $this, 'header_onoff' ) );

		add_filter( 'body_class', array( $this, 'add_class_nav_type' ) );
	}

	public function getOptions(){
		global $post;

		if( ! $post instanceof WP_Post ) {
			$post = new stdClass();
			$post->ID = 0;
		}

		$arrOptions		= get_post_meta( $post->ID, 'jvbpd_hd_post', true );
		$arrOptions		= is_array( $arrOptions ) ? $arrOptions : Array();
		$this->options	= (object) shortcode_atts(
			Array(
				'topbar'			=> '',
				'header_size_as'	=> '',
				'header_size'		=> esc_html(intVal( jvbpd_tso()->header->get( 'header_size', 50 ) ) ),
				'header_type'		=> '',
				'header_skin'		=> jvbpd_tso()->header->get( 'header_skin', '' ),
			)
			, $arrOptions
		);

		if( empty( $this->options->header_type ) ) {
			$this->options->header_type	=  jvbpd_tso()->header->get( 'header_type', apply_filters( 'jvbpd_theme_option_header_type_default', 'dashboard-style', jvbpd_tso() ) );
		}

		if( in_array( $this->options->header_type, Array( 'inline-clean' ) ) ) {
			add_filter( 'jvbpd_display_navi_in_header', array( $this, 'display_navi_in_header' ), 10, 1 );
		}
	}

	public function display_navi_in_header( $old_value ) { return false; }

	public function header_type_options( $options ) {
		return wp_parse_args(
			Array(
				esc_html__( "Dashboard Style", 'jvfrmtd' ) => 'dashboard-style',
				esc_html__( "1 Row (inline) type", 'jvfrmtd' ) => 'inline',
				esc_html__( "1 Row (inline clean) type", 'jvfrmtd' ) => 'inline-clean',
				esc_html__( "2 Rows type (Right Banner)", 'jvfrmtd' ) => 'jv-nav-row-2',
				esc_html__( "2 Rows logo center (M)", 'jvfrmtd' ) => 'jv-nav-row-2-second',
				/* esc_html__( "Wide Type", 'jvfrmtd' ) => 'jv-wide-type', */
				esc_html__( "2 Rows search center", 'jvfrmtd' ) => 'jv-nav-row-2-search',
				esc_html__( "Vertical type", 'jvfrmtd' ) => 'jv-vertical-nav',
			), $options
		);
	}

	public function header_onoff( $onoff=true ) {

		if( is_search() || is_archive() ) {
			return $onoff;
		}

		jvbpd_header()->getOptions();
		$strHeaderType = jvbpd_header()->options->header_type;
		return 'disable-header' != $strHeaderType;
	}

	public function basic_walker( $alignType ) {
		$strNavAlign				= 'navbar-' . $alignType;

		echo "<div id=\"javo-navibar\">";
			wp_nav_menu(
				Array(
					'menu_class'		=> 'nav navbar-nav' . ' ' . $strNavAlign
					, 'theme_location'	=> 'primary'
					, 'depth'			=> 3
					, 'container'		=> false
					, 'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback'
					, 'walker'			=> new wp_bootstrap_navwalker()
				)
			);
		echo "</div>";
	}

	public function add_class_nav_type( $classes=Array() ) {
		if( !empty( $this->options->header_type ) ) {
			$classes[] = sprintf( 'top-nav-type-%s', $this->options->header_type );
		}
		return $classes;
	}

	public function custom_logo() {
		global $jvbpd_tso;

		$strBasicLogo				= JVBPD_IMG_DIR.'/Javo_Directory_logo.png';

		$arrLogoImages				= Array(
			'dark'					=> $jvbpd_tso->get( 'logo_url' , $strBasicLogo )
			, 'light'				=> $jvbpd_tso->get( 'logo_light_url' , $strBasicLogo )
		);

		if( ! empty( $arrLogoImages ) ) foreach( $arrLogoImages as $classes => $url )
			echo "<img src=\"{$url}\" height=\"100%\" class=\"logo {$classes}\">";

	}

	public function header_classes( $classes, $post_id=0, $query=null ) {
		if( is_object( $query ) ) :
			$classes[]		= $query->get( 'header_skin', jvbpd_tso()->header->get( 'header_skin', 'dark' ) );
		endif;

		if( get_post_type( $post_id ) == 'post' && get_query_var('pn')!='member' && !is_archive())
			$classes[]		= jvbpd_tso()->header->get( 'single_post_page_header_type' );
		else
			$classes[]		= $query->get( 'header_type', jvbpd_tso()->header->get( 'header_type', '' ) );

		return $classes;
	}

	public function nav_classes( $classe='' ) {

		global $post;

		$strHeaderTypeOption = '';

		if( !empty( $classe ) )
			$this->arrNav_classes[] = $classe;

		if( get_post_type( $post->ID ) != 'post' ){
			$strHeaderTypeOption = $this->options->header_type;
		}else{
			$strHeaderTypeOption = jvbpd_tso()->header->get( 'single_post_page_header_type' );
		}

		if( false !== strpos( $strHeaderTypeOption, 'jv-nav-row-2-lvl' ) )
			$this->arrNav_classes[] = 'nav-justified';
	}

	public function get_classes( $classes='' ) {
		$this->nav_classes( $classes );
		return join( ' ', $this->arrNav_classes );
	}

	public function custom_title( $post_id ) {
		global $wp_query;

		if( !$wp_query->is_single && !$wp_query->is_page )
			return;


		get_template_part("library/header/post", "header");
	}

	public function output( $post_id ) {
		$jvbpd_headerParams		= Array();
		$jvbpd_headerClasses		= '';

		$headerSlug				= 'general';
		$jvbpd_hd_options			= get_post_meta( $post_id, 'jvbpd_hd_post', true );
		$jvbpd_post_skin			= new jvbpd_array( $jvbpd_hd_options );
		$intHeaderHeight		= 0;

		if( $jvbpd_post_skin->get( 'header_size_as', '' ) != '' )
			$intHeaderHeight	= intVal( $jvbpd_post_skin->get( 'header_size', 50 ) );
		else
			$intHeaderHeight	= intVal( jvbpd_tso()->header->get( 'header_size', 50 ) );

		$jvbpd_headerParams[ 'height' ]	= $intHeaderHeight . 'px' ;

		$jvbpd_headerParams[ 'slug' ]		= $headerSlug;
		$jvbpd_headerClasses				= apply_filters(
			'jvbpd_header_class'
			, Array(
				'main'
				, 'header-' . $headerSlug
				, 'javo-main-prmary-header'
			)
			, $post_id
			, $jvbpd_post_skin
		);
		$jvbpd_headerParams[ 'classes']		= ' class="'. implode( ' ', $jvbpd_headerClasses ) . '" ';

		$GLOBALS[ 'jvbpd_headerParams' ]	= $jvbpd_headerParams;
		$strHeaderFile = JVBPD_HDR_DIR . '/header-' . $headerSlug . '.php';

		do_action( 'jvbpd_header_wrap_before', $post_id );
		if( file_exists( $strHeaderFile ) )
			load_template( $strHeaderFile );
		do_action( 'jvbpd_header_wrap_after', $post_id );
	}

	public function toolbar_widget() {
		if( 'inline' != $this->options->header_type ) {
			add_action( 'jvbpd_header_inner_logo_after', Array( $this, 'getToolbarWidgets' ) );
		}else{
			add_action( 'jvbpd_header_toolbars_body', Array( $this, 'getToolbarWidgets' ) );
		}
	}

	public function getToolbarWidgets() {
		$strStyle	= '';

		if( false !== ( strpos( $this->options->header_type, 'jv-nav-row-2-lvl' ) ) )
			$strStyle = sprintf(
				'style="min-height:%spx; line-height:%spx;"',
				$this->options->header_size,
				$this->options->header_size
			);
		?>
		<div class="javo-toolbar-left" <?php echo esc_attr( $strStyle ); ?>>
			<div><?php if( is_active_sidebar( 'toolbar-left-widget' ) ) dynamic_sidebar( 'toolbar-left-widget' ); ?></div>
		</div><!-- /.javo-toolbar-left -->

		<div class="javo-toolbar-right" <?php echo esc_attr( $strStyle ); ?>>
			<div><?php if( is_active_sidebar( 'toolbar-right-widget' ) ) dynamic_sidebar( 'toolbar-right-widget' ); ?></div>
		</div><!-- /.javo-toolbar-right -->
		<?php
	}

	public function getTopbarAllow(){
		if( !$strTopbaar = $this->options->topbar )
			$strTopbaar = jvbpd_tso()->get( 'topbar_use', 'disabled' );
		return $strTopbaar == 'enable';
	}

	public static function getInstance(){
		if( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

} endif;

if( !function_exists( 'jvbpd_header' ) ) : function jvbpd_header() {
	return jvbpd_Header_Func::getInstance();
} jvbpd_header(); endif;
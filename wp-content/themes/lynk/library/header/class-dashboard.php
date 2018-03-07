<?php
class jvbpd_dashboard {

	Const MYPAGE_ENQUEUE_FORMAT = 'jvbpd_db_enq_%s';

	public $page_style;
	public $is_db_page = false;

	private static $pages = Array();
	public static $instance = false;

	public function __construct() {
		$this->setVariables();
		$this->loadFiles();
		$this->registerHooks();

		$this->eventAjaxHooks();
	}

	public function setVariables() {
		$this->page_style = jvbpd_tso()->get( 'mypage_style', 'type-c' );
	}

	public function registerHooks() {
		add_action( 'init', Array( __class__, 'define_slug' ) );
		add_filter( 'template_include', Array( __class__, 'dashboard_template'), 1, 1 );
	}

	public function loadFiles() {
		get_template_part( 'library/header/functions', 'dashboard' );
	}

	public function getEnqueueHandle( $suffix='' ) {
		return sprintf( self::MYPAGE_ENQUEUE_FORMAT, sanitize_title( $suffix ) );
	}

	public static function define_slug() {
		self::$pages = apply_filters(
			'jvbpd_dashboard_slugs',
			Array(
				'JVBPD_MEMBER_SLUG' => 'member',
				'JVBPD_PROFILE_SLUG' => 'edit-my-profile',
				'JVBPD_CHNGPW_SLUG' => 'change-password',
				'JVBPD_MANAGE_SLUG' => 'manage',
			)
		);
		foreach( self::$pages as $key => $value ) {
			define( $key, $value);
		}
	}

	public function is_dashboard_page() { return get_query_var( 'pn' ) == 'member'; }

	static function dashboard_template( $template ) {
		global
			$wp_query
			, $jvbpd_current_user;

		$GLOBALS[ 'jvbpd_dashboard_type' ] = $page_style = jvbpd_dashboard()->page_style;

		add_action( 'wp_enqueue_scripts', Array( __class__, 'wp_media_enqueue_callback' ) );

		if( get_query_var('pn') == 'member' ) {
			$jvbpd_current_user = get_user_by('login', str_replace("%20", " ", get_query_var('user')));

			if( !empty( $jvbpd_current_user ) ) {
				self::$instance->is_db_page = true;
				add_filter( 'body_class', Array(__class__, 'jvbpd_dashboard_bodyclass_callback'));
				if( jvbpd_dashboard()->page_style =='type-b' ){
					add_action( 'wp_enqueue_scripts', Array( __class__, 'mypage_header_apply_type_b' ) );
				}else{
					add_action('wp_enqueue_scripts'	, Array( __class__, 'mypage_header_apply' ) );
				}

				$GLOBALS[ 'jvbpd_curUser' ] = $jvbpd_current_user;
				$GLOBALS[ 'manage_mypage' ] = $jvbpd_current_user->ID === get_current_user_id();

				add_filter( 'wp_title', Array( jvbpd_dashboard(), 'dashboardTitle' ), 99, 2 );

				if( in_Array( get_query_var('sub_page'), self::$pages ) ) {

					if( ! apply_filters( 'jvbpd_dashboard_allow_private_page', ( $GLOBALS[ 'manage_mypage' ] || current_user_can( 'manage_options' ) ), get_query_var( 'sub_page' ), $jvbpd_current_user ) ) {
						if( ! in_array( get_query_var( 'sub_page' ), Array( 'favorite', 'contact' ) ) ) {
							return JVBPD_DSB_DIR.'/mypage-private-page.php';
						}
					}
					return apply_filters(
						'jvbpd_dashboard_custom_template_url'
						, JVBPD_DSB_DIR . '/' . $page_style . '/mypage-' . get_query_var( 'sub_page' ) . '.php'
						, get_query_var( 'sub_page' )
					);
				} else {
					return JVBPD_DSB_DIR.'/' . $page_style . '/mypage-member.php';
				}
			} else {
				return JVBPD_DSB_DIR.'/mypage-no-user.php';
			}
		}
		return $template;
	}

	public function getDashboardTItle() {
		$objOnwerUser = jvbpd_getDashboardUser();
		$strTitleFormat = esc_html__( '%1$s Profile', 'jvfrmtd' );
		if( $this->checkPermission( 'memberOnly' ) ) {
			$strTitleFormat = esc_html__( '%1$s Dashboard', 'jvfrmtd' );
		}
		return sprintf( $strTitleFormat, '<b>' . $objOnwerUser->display_name . '</b>' );
	}

	public function getBreadCrumbs() {

		$strSlugName = get_query_var( 'sub_page' );

		$arrBreadCrumbs = Array();
		$arrBreadCrumbs[] = esc_html__( "Dashboard", 'jvfrmtd' );
		if( ! empty( $strSlugName ) ) {
			$arrBreadCrumbs[] = $this->getDashboardTItle();
		}
		$arrBreadCrumbs = apply_filters( 'jvbpd_dashboard_breadcrumbs', $arrBreadCrumbs, $strSlugName );

		$output = null;

		if( !empty( $arrBreadCrumbs ) ) {
			$output .= sprintf( '<ol class="breadcrumb">' );
			foreach( $arrBreadCrumbs as $arrItem ) {
				$output .= sprintf( '<li><a href="javascript:">%s</a></li>', $arrItem );
			}
			$output .= sprintf( '</ol>' );
		}
		return $output;
	}

	public function dashboardTitle( $title, $sep=' | ' ) {
		$arrOutput = Array( $this->getDashboardTItle(), esc_html__( "My Dashboard", 'jvfrmtd' ), get_bloginfo( 'name' ) );
		return join( $sep, $arrOutput );
	}

	public static function loadMypageLess( $args=Array() ) {
		$arrDirectory = Array( JVBPD_THEME_DIR, 'assets/css/extend', 'jv-member/css/colors' );
		wp_enqueue_style( 'jvbpd_mypage_less', join( '/', $arrDirectory ) . '/jv-my-page.less' );
	}

	static function jvbpd_dashboard_bodyclass_callback( $classes ) {

		$classes[] = 'javo-dashboard';
		$classes[] = self::$instance->page_style;
		$classes[] = 'page-dashboard-' . get_query_var( 'sub_page' );

		if( is_admin_bar_showing() ) {
			$classes[] = 'admin-bar';
		}

		if( self::$instance->checkPermission( 'memberOnly' ) ) {
			$classes[] = 'author-own-page';
		}

		return $classes;
	}

	public static function wp_media_enqueue_callback() {
		wp_enqueue_script( 'plupload' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_media();

		$arrDBScripts = Array(
			'metisMenu.min.js' => Array( 'ver' => '0.0.0', 'pos' => '../metisMenu/dist' ),
			'jquery.slimscroll.js' => Array( 'ver' => '0.0.0', 'pos' => '../slimscroll' ),
			'jquery.waypoints.js' => Array( 'ver' => '0.0.0', 'pos' => '../counterup' ),
			'jquery.counterup.min.js' => Array( 'ver' => '0.0.0', 'pos' => '../counterup' ),
			'jv-extend.js' => Array( 'ver' => '0.0.0', 'pos' => '../', 'footer' => false ),
		);

		$arrDBStyles = Array();

		if( !empty( $arrDBScripts ) ) {
			foreach( $arrDBScripts as $strFileName => $arrFileMeta ) {

				if($strFileName != 'bootstrap.min.js')
					$arrDirectory = Array( JVBPD_THEME_DIR, 'assets/js/extend' );
				else
					$arrDirectory = Array( JVBPD_THEME_DIR );

				if( isset( $arrFileMeta[ 'pos' ] ) ) {
					$arrDirectory[] = $arrFileMeta[ 'pos' ];
				}
				$arrDirectory[] = $strFileName;

				$is_footer = true;
				if( isset( $arrFileMeta[ 'footer' ] ) && false == $arrFileMeta[ 'footer' ] ) {
					$is_footer = false;
				}

				wp_register_script(
					jvbpd_dashboard()->getEnqueueHandle( $strFileName ),
					join( '/', $arrDirectory ),
					array( 'jquery' ), $arrFileMeta[ 'ver' ],
					$is_footer
				);
				jvbpd_dashboard()->localize_script( $strFileName );
				do_action( 'jvbpd_dashboard_enqueues', $strFileName );
				wp_enqueue_script( jvbpd_dashboard()->getEnqueueHandle( $strFileName ) );
			}
		}

		if( !empty( $arrDBStyles ) ) {
			foreach( $arrDBStyles as $strFileName => $arrFileMeta ) {

				$arrDirectory = Array( JVBPD_THEME_DIR, 'assets/css/extend' );
				if( isset( $arrFileMeta[ 'pos' ] ) ) {
					$arrDirectory[] = $arrFileMeta[ 'pos' ];
				}
				$arrDirectory[] = $strFileName;

				wp_register_style(
					jvbpd_dashboard()->getEnqueueHandle( $strFileName ), join( '/', $arrDirectory ), array(), $arrFileMeta[ 'ver' ]
				);
				wp_enqueue_style( jvbpd_dashboard()->getEnqueueHandle( $strFileName ) );
			}
		}
	}

	public function localize_script( $js_name='' ) {

		switch( $js_name ) {

			case 'jv-extend.js' :
				wp_localize_script(
					jvbpd_dashboard()->getEnqueueHandle( $js_name ),
					'bp_mypage_type_c_args',
					Array(
						'ajaxurl' => admin_url( 'admin-ajax.php' ),
						'event_hook' => function_exists( 'Lava_EventConnector' ) ? Lava_EventConnector()->upload->getAjaxHook() : null,
						'leftSidebar' => jvbpd_tso()->header->get( 'left_sidebar', '' ),
						'rightSidebar' => jvbpd_tso()->header->get( 'right_sidebar', '' ),
					)
				);
				break;
		}

	}

	public static function mypage_header_apply_type_b() {
		global $jvbpd_current_user;

		$staticImage = true;
		$strBackground = JVBPD_IMG_DIR . '/bg/mypage-bg.png';

		if( !empty( $jvbpd_current_user->mypage_header ) ) {
			$mypage_header_meta = wp_get_attachment_image_src( $jvbpd_current_user->mypage_header, 'full' );
			if( !empty( $mypage_header_meta[0] ) ) {
				$strBackground = $mypage_header_meta[0];
				$staticImage	= false;
			}
		}
	}

	public static function mypage_header_apply() {
		global $jvbpd_current_user;

		$strBackground	= JVBPD_IMG_DIR . '/bg/mypage-bg.png';
		if( !empty( $jvbpd_current_user->mypage_header ) ) {
			$mypage_header_meta = wp_get_attachment_image_src( $jvbpd_current_user->mypage_header, 'full' );
			if( !empty( $mypage_header_meta[0] ) )
				$strBackground = $mypage_header_meta[0];
		}
	}

	/**
	Action : admin_init
	rewrite
	**/
	static function rewrite() {
		add_rewrite_tag('%pn%'										, '([^&]+)');
		add_rewrite_tag('%user%'									, '([^&]+)');
		add_rewrite_tag('%sub_page%'								, '([^&]+)');
		add_rewrite_tag('%edit%'									, '([^&]+)');
		add_rewrite_tag('%update%'									, '([^&]+)');
		add_rewrite_rule( 'lava-my-add-form/?$'						, 'index.php?pn=addform', 'top');
		add_rewrite_rule( 'member/([^/]*)/?$'						, 'index.php?pn=member&user=$matches[1]', 'top');
		add_rewrite_rule( 'member/([^/]*)/page/([^/]*)/?$'			, 'index.php?pn=member&user=$matches[1]&paged=$matches[2]', 'top');
		add_rewrite_rule( 'member/([^/]*)/([^/]*)/?$'				, 'index.php?pn=member&user=$matches[1]&sub_page=$matches[2]', 'top');
		add_rewrite_rule( 'member/([^/]*)/([^/]*)/page/([^/]*)/?$'	, 'index.php?pn=member&user=$matches[1]&sub_page=$matches[2]&paged=$matches[3]', 'top');
		add_rewrite_rule( 'member/([^/]*)/([^/]*)/edit/([^/]*)/?$'	, 'index.php?pn=member&user=$matches[1]&sub_page=$matches[2]&edit=$matches[3]', 'top');
	}

	public static function getInstance(){
		if( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	public function checkPermission( $allowed='' ) {
		$is_allowed = false;
		switch( $allowed ) {
			case 'logged_user' :
				$is_allowed = is_user_logged_in();
				break;

			case 'member' :
				$is_allowed = is_user_logged_in() && ( current_user_can( 'manage_options' ) || jvbpd_getDashboardUser()->ID == get_current_user_id() );
				break;

			case 'admin' :
				$is_allowed = is_user_logged_in() && current_user_can( 'manage_options' );
				break;

			case 'memberOnly' :
				$is_allowed = is_user_logged_in() && jvbpd_getDashboardUser()->ID == get_current_user_id();
				break;

			case 'all' :
			default:
				$is_allowed = true;
		}
		return $is_allowed;
	}

	public function getOwnerAvatar( $user_id=9, $size='thumbnail', $args=Array() ) {

		$width = is_array( $size ) && isset( $size[0] ) && is_numeric( $size[0] ) ?  $size[0] : 0;
		$height = is_array( $size ) && isset( $size[1] ) && is_numeric( $size[1] ) ?  $size[1] : 0;
		$classes = isset( $args[ 'class' ] ) ? $args[ 'class' ] : null;

		$output = sprintf( '<img src="%s" width="%s" height="%s" class="%s">', jvbpd_tso()->get( 'no_image', '' ), $width, $height, $classes );
		$intAvatarID = intVal( get_user_meta( $user_id, 'avatar', true ) );
		if( 0 < $intAvatarID ) {
			$strAvatar = wp_get_attachment_image( $intAvatarID, $size, false, $args );
			if( ! empty( $strAvatar ) ) {
				$output = $strAvatar;
			}
		}
		return $output;
	}

	public function eventAjaxHooks() {


	}

}
if( !function_exists( 'jvbpd_dashboard' ) ) :
	function jvbpd_dashboard() {
		return jvbpd_dashboard::getInstance();
	}
	jvbpd_dashboard();
endif;

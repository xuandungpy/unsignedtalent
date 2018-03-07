<?php
/**
 *
 *
 * @Author Javo Themes
 * @since 2017. 03. 14.
 *
 */

/**
 *
 * @param int UserID
 * @param string Member page slug name
 * @param string member page slug separator
 *
 * @return string Member page URL
 */
function jvbpd_getUserPage( $user_id, $slug='', $closechar='/' ) {

	$user_id = intVal( $user_id );

	if( ! 0 < $user_id )
		return false;

	$user = new WP_User( $user_id );

	$arrDashboard = Array();

	$arrDashboard[]	= defined( 'JVBPD_DEF_LANG' ) ? JVBPD_DEF_LANG . JVBPD_MEMBER_SLUG : JVBPD_MEMBER_SLUG;
	$arrDashboard[]	= $user->user_login;

	if( !empty( $slug ) ) {
		$arrDashboard[] = strtolower( $slug );
	}

	$strDashboard = @implode( '/', $arrDashboard );
	return esc_url( home_url( $strDashboard . $closechar ) );
}

/**
 *
 * @return object Member page user object
 */
function jvbpd_getDashboardUser() {
	$objDisplayedUser = get_user_by( 'login', str_replace( "%20", " ", get_query_var( 'user' ) ) );
	if( ! $objDisplayedUser instanceof WP_User ) {
		$objDisplayedUser = wp_get_current_user();
	}
	return $objDisplayedUser;
}

function jvbpd_getCurrentUserPage( $slug='', $closechar='/' ){
	return jvbpd_getUserPage( get_current_user_id(), $slug, $closechar );
}

function jvbpd_getMypageSideberRender( $menuMeta=Array(), $currentPage='' ) {

	$boolVisible = false;
	$strNavItemClass = jvbpd_dashboard()->page_style != 'type-c' ? 'admin-color-setting' : NULL;

	if( isset( $menuMeta[ 'visible' ] ) ) {
		if( $menuMeta[ 'visible' ] == 'all' ) {
			$boolVisible = true;
		}else{
			if( $menuMeta[ 'visible' ] == 'member' ) {
				if( jvbpd_getDashboardUser()->ID == get_current_user_id() || current_user_can( 'manage_options' ) ) {
					$boolVisible = true;
				}
				if(isset($menuMeta['addon']) && $menuMeta['addon'] == 'disable'){
					$boolVisible = false;
				}
			}
		}
	}

	if( ! $boolVisible ) {
		return;
	}

	$arrListClass = !empty( $menuMeta[ 'li_class' ] ) ? explode( ' ', $menuMeta[ 'li_class' ] ) : Array();
	$arrListClass[] = 'nav-item';
	$is_current = false;
	if( get_query_var( 'sub_page' ) == $currentPage ) {
		$is_current = true;
	}

	return sprintf(
		'<li class="%1$s"><a href="%2$s" class="%3$s %6$s"><i class="%4$s"></i> %5$s</a></li>',
		join( ' ', $arrListClass ), $menuMeta[ 'url' ], $strNavItemClass, $menuMeta[ 'icon' ],  $menuMeta[ 'label' ],
		( $is_current ? 'current' : null )
	);

}

function jvbpd_getMypageSidebar() {
	$arrMyMenus = apply_filters(
		'jvbpd_mypage_sidebar_args',
		Array(
			'' => Array(
				'li_class' => 'side-menu home',
				'url' => jvbpd_getUserPage( jvbpd_getDashboardUser()->ID, '' ),
				'icon' => 'jvbpd-icon1-house',
				'label' => esc_html__("Dashboard", 'jvfrmtd' ),
				'visible' => 'all',
			),

			JVBPD_PROFILE_SLUG => Array(
				'li_class' => 'side-menu edit-propfile',
				'url' => jvbpd_getUserPage( jvbpd_getDashboardUser()->ID, JVBPD_PROFILE_SLUG ),
				'icon' => 'jvbpd-icon1-people',
				'label' => esc_html__("Edit Profile", 'jvfrmtd' ),
				'visible' => 'member',
			),
		)
	);



	echo "<ul class=\"nav nav-sidebar\">";
	if( !empty( $arrMyMenus ) ) foreach( $arrMyMenus as $strPageID => $menuMeta ) {

		$strBuffer = null;
		if( isset( $menuMeta[ 'inner' ] ) ) {
			$strBuffer .= sprintf(
				'<li class="nav-item"><a><i class="%1$s"></i> %2$s</a><ul class="nav-child">',
				$menuMeta[ 'icon' ],
				$menuMeta[ 'label' ]
			);
			foreach( $menuMeta[ 'inner' ] as $innerMenuMeta ) {
				$strBuffer .= jvbpd_getMypageSideberRender( $innerMenuMeta, $strPageID );
			}
			$strBuffer .= '</ul></li>';
		}else{
			$strBuffer .= jvbpd_getMypageSideberRender( $menuMeta, $strPageID );
		}
		echo $strBuffer;
	}
	echo "</ul>";
}

if( !function_exists( 'jvbpd_dashboard_msg' ) ) : function jvbpd_dashboard_msg(){
	return $GLOBALS[ 'jvbpd_change_message' ];
} endif;


function jvbpd_dashboard_change_pw() {

	if( ! isset( $_POST[ 'jvbpd_dashboard_changepw_nonce' ] ) ) {
		return false;
	}

	try{

		if( ! wp_verify_nonce( $_POST[ 'jvbpd_dashboard_changepw_nonce' ], 'security' ) ) {
			throw new Exception( esc_html__( "Password does not match the confirm password.", 'jvfrmtd' ) );
		}

		$query = new jvbpd_array( $_POST );
		$current_password = $query->get( 'current_pass' );
		$new_password = $query->get( 'new_pass' );
		$new_password_confirm = $query->get( 'new_pass_confirm' );
		$current_user = wp_signon(
			Array(
				'user_login' => wp_get_current_user()->user_login,
				'user_password'	=> $current_password
			)
		);

		if( is_wp_error( $current_user ) )
			throw new Exception( $current_user->get_error_message() );

		if( $new_password == '' || $new_password_confirm == '' )
			throw new Exception( esc_html__( "Please check your password or password confirm.", 'jvfrmtd' ) );


		if( $new_password != $new_password_confirm )
			throw new Exception( esc_html__( "Password does not match the confirm password.", 'jvfrmtd' ) );

		if( $result = wp_update_user( Array( 'ID' => $current_user->ID, 'user_pass' => $new_password ) ) )
			if( is_wp_error( $result ) )
				throw new Exception( $result->get_error_message() );

	} catch( Exception $e ) {
		return new WP_Error( 'jvbpd_mypage_cpw_err', $e->getMessage() );
	}
	return esc_html__( "It has been successfully changed,", 'jvfrmtd' );
}
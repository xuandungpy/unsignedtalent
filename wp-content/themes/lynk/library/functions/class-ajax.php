<?php

class jvbpd_ajax_propcess{

	public $hooks = Array();

	private static $instance =null;

	public function __construct() {
		$this->setVariables();
		$this->register_hooks();
		add_action( 'init', array( $this, 'register_ajax_action' ) );
	}

	public function setVariables() {
		$this->hooks[ 'send_mail' ] = Array( $this, 'send_mail' );
		$this->hooks[ 'register_login_add_user' ] = Array( $this, 'add_user_callback' );
		$this->hooks[ 'jvbpd_ajax_user_login' ] = Array( $this, 'user_login' );
	}

	public function register_hooks() {
		add_filter( 'jvbpd_front_user_registered_redirect', array( $this, 'registered_redirect' ) );
	}

	public function register_ajax_action() {
		foreach( $this->hooks as $strAction => $fnCallback ) {
			add_action( 'wp_ajax_' . $strAction, $fnCallback );
			add_action( 'wp_ajax_nopriv_' . $strAction, $fnCallback );
		}
	}

	public function add_user_callback() {
		$jvbpd_query = new jvbpd_array( $_POST );
		$jvbpd_this_result = Array();
		$jvbpd_new_user_args = Array('user_pass'=>null);

		if( isset( $_POST['user_login'] ) ){
			$jvbpd_new_user_args['user_login'] = $jvbpd_query->get('user_login');
		}
		if( isset( $_POST['user_name'] ) ){
			$jvbpd_user_fullname	 = (Array) @explode(' ', $_POST['user_name']);

			$jvbpd_new_user_args['first_name'] = $jvbpd_user_fullname[0];

			if(
				!empty( $jvbpd_user_fullname[1] ) &&
				$jvbpd_user_fullname[1] != ''
			){
				$jvbpd_new_user_args['last_name'] = $jvbpd_user_fullname[1];
			}
		}

		if( isset( $_POST['first_name'] ) ){
			$jvbpd_new_user_args['first_name'] = $jvbpd_query->get('first_name');
		}
		if( isset( $_POST['last_name'] ) ){
			$jvbpd_new_user_args['last_name'] = $jvbpd_query->get('last_name');
		}
		if( isset( $_POST['user_pass'] ) ){
			$jvbpd_new_user_args['user_pass'] = $jvbpd_query->get('user_pass');

		}else{
			// Password is Empty ???
			$jvbpd_new_user_args['user_pass'] = wp_generate_password( 12, false );
		}
		if( isset( $_POST['user_login'] ) ){
			$jvbpd_new_user_args['user_email'] = $jvbpd_query->get('user_email');
			if( !is_email( $jvbpd_new_user_args['user_email'] ) )
				$jvbpd_this_result[ 'err' ]		= __( "Your email address is invalid. Please enter a valid address.", 'jvfrmtd' );
		}
		if(!isset($jvbpd_this_result[ 'err' ])){
			$user_id = wp_insert_user($jvbpd_new_user_args, true);
			if( !is_wp_error($user_id) ){
				update_user_option( $user_id, 'default_password_nag', true, true );

				if( apply_filters( 'jvbpd_add_new_user_notification', true ) ) {
					wp_new_user_notification( $user_id, $jvbpd_new_user_args['user_pass'] );
				}

				// Assign Post
				if( isset( $_POST['post_id'] ) && (int)$_POST['post_id'] > 0 ){
					$origin_post_id		= (int) $_POST['post_id'];
					$parent_post_id		= (int)get_post_meta( $origin_post_id, 'parent_post_id', true);

					$post_id = wp_update_post(Array(
						'ID'			=> $parent_post_id
						, 'post_author'	=> $user_id
					));

					update_post_meta($origin_post_id	, 'approve', 'approved');
					update_post_meta($post_id			, 'claimed', 'yes');
				}else{
					wp_set_current_user( $user_id );
					wp_set_auth_cookie( $user_id );
					do_action( 'wp_login', $user_id, get_user_by( 'id', $login_state ) );
				}

				if( function_exists( 'bp_core_get_user_domain' ) ) {
					$strRedirectURL = bp_core_get_user_domain( $user_id );
				}

				do_action( 'jvbpd_new_user_append_meta', $user_id );
				$jvbpd_this_result['state'] = 'success';
				$jvbpd_this_result['link'] = apply_filters( 'jvbpd_front_user_registered_redirect', $strRedirectURL );

			}else{
				$jvbpd_this_result['state']		= 'failed';
				$jvbpd_this_result['comment']	= $user_id->get_error_message();
			}
		}else{
			$jvbpd_this_result['state']		= 'failed';
			$jvbpd_this_result['comment']	= $jvbpd_this_result[ 'err' ];
		}
		echo json_encode($jvbpd_this_result);
		exit;
	}

	public function send_mail(){
		do_action( 'jvbpd_contact_send_mail' );
	}

	public function getLoginRedirectURL( $user_id=0 ){
		global $bp;

		$strRedirect = home_url( '/' );
		if( function_exists( 'bp_core_get_user_domain' ) ) {
			$strRedirect = bp_core_get_user_domain( $user_id );
		}
		return $strRedirect;
	}

	public function user_login() {

		header( 'content-type:application/json; charset=utf-8' );

		check_ajax_referer( 'user_login', 'security' );

		$response = Array();
		$query = new jvbpd_array( $_POST );

		$login_state = wp_signon(
			Array(
				'user_login' => $query->get( 'log' ),
				'user_password'	=> $query->get( 'pwd' ),
				'remember' => $query->get( 'rememberme' )
			),
			false
		);

		if( is_wp_error( $login_state ) ) {
			$response[ 'error' ] = $login_state->get_error_message();
		}else{
			wp_set_current_user( $login_state->ID );
			wp_set_auth_cookie( $login_state->ID );
			do_action( 'wp_login', $login_state->user_login, $login_state );
			$response[ 'redirect' ] = $this->getLoginRedirectURL( $login_state->ID );
			$response[ 'state' ] = 'OK';
		}
		die( json_encode( $response ) ) ;
	}

	public function registered_redirect( $permalink='' ) {
		$redirect_type = jvbpd_tso()->get( 'login_redirect', '' );

		switch( $redirect_type ) {
			case 'home' : $permalink = home_url( '/' ); break;
			case 'current' : $permalink = home_url( '/' ); break;
			case 'admin' : $permalink = admin_url( '/' ); break;
		}
		return $permalink;
	}

	public static function getInstance() {
		if( is_null( self::$instance ) )
			self::$instance = new self;
		return self::$instance;
	}

}

if( !function_exists( 'jvbpd_process' ) ) : function jvbpd_process() {
	return jvbpd_ajax_propcess::getInstance();
} jvbpd_process(); endif;
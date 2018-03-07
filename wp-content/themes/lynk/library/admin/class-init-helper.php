<?php

class jvbpd_init_helper {

	public static $instance = null;

	public $tgmpa_menu_slug = 'tgmpa-install-plugins';
	public $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

	public function __construct() {
		$this->registerHooks();
	}

	public function registerHooks() {
		add_action( 'admin_menu', array( $this, 'regieter_menu' ) );
		add_action( 'admin_init', array( $this, 'helper_content' ) );

		add_action( 'init', array( $this, 'initialize' ),11  );

		add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ) );

	}

	public function initialize() {
		add_action( 'wp_ajax_jvbpd_wizard_plugin', array( $this, 'ajax_plugins' ) );
	}

	public function tgmpa_load( $state ) {
		return is_admin();
	}

	public function regieter_menu() {
		add_theme_page( 'Install Wizard', 'Install Wizard', 'manage_options', 'jvbpd-core', '__return_false' );
	}

	public function step_sort( $param1=Array(), $param2=Array() ) {
		return $param1[ 'priority' ] < $param2[ 'priority' ] ? -1 : 1;
	}

	public function helper_content() {

		if ( empty( $_GET['page'] ) || 'jvbpd-core' !== $_GET['page'] ) {
			return;
		}
		$default_steps = array(
			'introduction' => array(
				'name'    => __( 'Introduction', 'jvfrmtd' ),
				'view'    => array( $this, 'wc_setup_introduction' ),
				'handler' => '',
				'priority' => 1,
			),
			'plugins' => array(
				'name'    => __( 'Plugins', 'jvfrmtd' ),
				'view'    => array( $this, 'plugins_page' ),
				'handler' => '',
				'priority' => 10,
			),
			'status' => array(
				'name'    => __( 'Server Status', 'jvfrmtd' ),
				'view'    => array( $this, 'status_page' ),
				'handler' => array( $this, 'wc_setup_location_save' ),
				'priority' => 20,
			),
			'demo_import' => array(
				'name'    => __( 'Demo import', 'jvfrmtd' ),
				'view'    => array( $this, 'import_page' ),
				'handler' => '',
				'priority' => 30,
			),
			'next_steps' => array(
				'name'    => __( 'Ready!', 'jvfrmtd' ),
				'view'    => array( $this, 'finish_page' ),
				'handler' => '',
				'priority' => 40,
			),
		);

		uasort( $default_steps, array( $this, 'step_sort' ) );

		if ( ! current_user_can( 'install_themes' ) || ! current_user_can( 'switch_themes' ) || is_multisite() || current_theme_supports( 'jvfrmtd' ) ) {
			unset( $default_steps['theme'] );
		}

		$this->steps = apply_filters( 'woocommerce_setup_wizard_steps', $default_steps );
		$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );
		$suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'jvbpd-admin', JVBPD_THEME_DIR . '/assets/css/admin.css', array( 'dashicons', 'install', 'themes' ) );
		wp_enqueue_style( 'jvbpd-admin-meta', JVBPD_THEME_DIR . '/assets/css/javo_admin_post_meta.css', array( 'jvbpd-admin' ) );

		wp_register_script( 'jvbpd-wizard', JVBPD_THEME_DIR . '/assets/js/admin.js', array( 'jquery' ) );
		wp_localize_script(
			'jvbpd-wizard',
			'jvbpd_wizard_param',
			Array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'verify_text' => ' ' . esc_html__( "Verifying...", 'jvfrmtd' ),
			)
		);

		if ( ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
			call_user_func( $this->steps[ $this->step ]['handler'], $this );
		}

		ob_start();
		$this->setup_wizard_header();
		$this->setup_wizard_steps();
		$this->setup_wizard_content();
		$this->setup_wizard_footer();
		exit;

	}

	/** private function _get_plugins() { */
	public function _get_plugins() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins  = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
		);

		foreach ( $instance->plugins as $plugin ) {
			if ( $instance->is_plugin_active( $plugin[ 'slug' ] ) && false === $instance->does_plugin_have_update( $plugin[ 'slug' ] ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				$plugins['all'][ $plugin[ 'slug' ] ] = $plugin;
				if ( ! $instance->is_plugin_installed( $plugin[ 'slug' ] ) ) {
					$plugins['install'][ $plugin[ 'slug' ] ] = $plugin;
				} else {
					if ( false !== $instance->does_plugin_have_update( $plugin[ 'slug' ] ) ) {
						$plugins['update'][ $plugin[ 'slug' ] ] = $plugin;
					}

					if ( $instance->can_plugin_activate( $plugin[ 'slug' ] ) ) {
						$plugins['activate'][ $plugin[ 'slug' ] ] = $plugin;
					}
				}
			}
		}

		return $plugins;
	}


	public function ajax_plugins() {
		if ( empty( $_POST['slug'] ) ) {
			wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No Slug Found', 'jvfrmtd' ) ) );
		}

		$json = array();
		$plugins = $this->_get_plugins();

		// what are we doing with this plugin?
		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'tgmpa-activate' => 'activate-plugin',
					'message'       => esc_html__( 'Activating Plugin', 'jvfrmtd' ),
				);
				break;
			}
		}
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'tgmpa-update' => 'update-plugin',
					'message'       => esc_html__( 'Updating Plugin', 'jvfrmtd' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'tgmpa-install' => 'install-plugin',
					'message'       => esc_html__( 'Installing Plugin', 'jvfrmtd' ),
				);
				break;
			}
		}

		if ( $json ) {
			$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json( $json );
		} else {
			wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'jvfrmtd' ) ) );
		}
		exit;

	}

	public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<?php printf( '<%1$s>%2$s</%1$s>', 'title', esc_html__( 'Listopia &rsaquo; Setup Wizard', 'jvfrmtd' ) ); ?>
			<?php
			wp_print_scripts( 'jvbpd-wizard' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_head' ); ?>
		</head>
		<body class="jvbpd-wizard wp-core-ui">
			<h1 id="jvbpd-logo"><img src="<?php echo esc_url_raw( JVBPD_IMG_DIR . '/jv-logo2.png' ); ?>" alt="logo2" /></h1>
		<?php
	}

	public function setup_wizard_steps() {
		$ouput_steps = $this->steps;
		array_shift( $ouput_steps );
		?>
		<ol class="jvbpd-wizard-steps">
			<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
				<li class="<?php
					if ( $step_key === $this->step ) {
						echo 'active';
					} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
						echo 'done';
					}
				?>"><?php echo esc_html( $step['name'] ); ?></li>
			<?php endforeach; ?>
		</ol>
		<?php
	}

	public function setup_wizard_content() {
		echo '<div class="jvbpd-wizard-content">';
		call_user_func( $this->steps[ $this->step ]['view'], $this );
		echo '</div>';
	}

	public function setup_wizard_footer() {
		?>
			<?php if ( 'next_steps' === $this->step ) : ?>
				<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'jvfrmtd' ); ?></a>
			<?php endif; ?>
			</body>
		</html>
		<?php
	}

	public function get_next_step_link( $step = '' ) {
		if ( ! $step ) {
			$step = $this->step;
		}

		$keys = array_keys( $this->steps );
		if ( end( $keys ) === $step ) {
			return admin_url();
		}

		$step_index = array_search( $step, $keys );
		if ( false === $step_index ) {
			return '';
		}

		return add_query_arg( 'step', $keys[ $step_index + 1 ] );
	}

	public function wc_setup_introduction() {
		jvbpd_admin()->load_template( Array( 'name' => 'intro', 'sub' => 'helper' ), Array( 'helper' => &$this ) );
	}

	public function plugins_page() {
		jvbpd_admin()->load_template( Array( 'name' => 'plugins', 'sub' => 'helper' ), Array( 'helper' => &$this ) );
	}

	public function status_page() {
		jvbpd_admin()->load_template( Array( 'name' => 'status', 'sub' => 'helper' ), Array( 'helper' => &$this ) );
	}

	public function import_page() {
		jvbpd_admin()->load_template( Array( 'name' => 'import', 'sub' => 'helper' ), Array( 'helper' => &$this ) );
	}

	public function finish_page() {
		jvbpd_admin()->load_template( Array( 'name' => 'finish', 'sub' => 'helper' ), Array( 'helper' => &$this ) );
	}

	public function wc_setup_ready_actions() {

		if ( isset( $_GET['wc_tracker_optin'] ) && isset( $_GET['wc_tracker_nonce'] ) && wp_verify_nonce( $_GET['wc_tracker_nonce'], 'wc_tracker_optin' ) ) {
			update_option( 'woocommerce_allow_tracking', 'yes' );

		} elseif ( isset( $_GET['wc_tracker_optout'] ) && isset( $_GET['wc_tracker_nonce'] ) && wp_verify_nonce( $_GET['wc_tracker_nonce'], 'wc_tracker_optout' ) ) {
			update_option( 'woocommerce_allow_tracking', 'no' );
		}
	}

	public function wc_setup_pages_save() {
		check_admin_referer( 'jvbpd-wizard' );

		WC_Install::create_pages();
		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	public static function getInstance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}


}

if( ! function_exists( 'jvbpd_init' ) ) {
	function jvbpd_init() {
		return jvbpd_init_helper::getInstance();
	}
	jvbpd_init();
}
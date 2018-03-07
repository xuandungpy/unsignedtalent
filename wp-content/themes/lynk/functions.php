<?php
/**
 *	Javo Themes functions and definitions
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

 // Path Initialize
define( 'JVBPD_APP_PATH'		, get_template_directory() );				// Get Theme Folder URL : hosting absolute path
define( 'JVBPD_THEME_DIR'		, get_template_directory_uri() );			// Get http URL : ex) http://www.abc.com/
define( 'JVBPD_SYS_DIR'		, JVBPD_APP_PATH."/library");			// Get Library path
define( 'JVBPD_TP_DIR'			, JVBPD_APP_PATH."/templates");		// Get Tempate folder
define( 'JVBPD_ADM_DIR'		, JVBPD_SYS_DIR."/admin");				// Administrator Page
define( 'JVBPD_IMG_DIR'		, JVBPD_THEME_DIR."/assets/images");	// Images folder
define( 'JVBPD_WG_DIR'			, JVBPD_SYS_DIR."/widgets");			// Widgets Folder
define( 'JVBPD_HDR_DIR'		, JVBPD_SYS_DIR."/header");			// Get Headers
define( 'JVBPD_CLS_DIR'		, JVBPD_SYS_DIR."/classes");			// Classes
define( 'JVBPD_FUC_DIR'		, JVBPD_SYS_DIR."/functions");			// Functions
define( 'JVBPD_PLG_DIR'		, JVBPD_SYS_DIR."/plugins");			// Plugin folder
define( 'JVBPD_ADO_DIR'		, JVBPD_SYS_DIR . "/addons");			// Addons folder

define( 'JVBPD_CUSTOM_HEADER', false );

// Includes : Basic or default functions and included files
get_template_part( 'library/define' ) ;								// defines
get_template_part( 'library/load' );									// loading functions, classes, shotcode, widgets
get_template_part( 'library/enqueue' );								// enqueue js, css
get_template_part( 'library/wp_init' );								// post-types, taxonomies
get_template_part( 'library/admin/class', 'admin-theme-settings' );			// theme options
get_template_part( 'library/header/class', 'dashboard' );						// theme screen options tab.

if( ! function_exists( 'jvbpd_theme_type' ) ) {
	add_filter( 'jvbpd_theme_type', 'jvbpd_theme_type' );
	function jvbpd_theme_type( $default='' ) {
		if( ! function_exists( 'jvbpd_admin_helper_init' ) ) {
			return;
		}
		if( jvbpd_admin_helper_init()->slug == 'listopia' ) {
			$default = 'jvd-lp';
		}
		return $default;
	}
}

update_option( 'wp_less_cached_files', array() );

if( ! function_exists( 'jvbpd_wcs_dequeue_quantity' ) ) {
	add_action( 'wp_enqueue_scripts', 'jvbpd_wcs_dequeue_quantity' );
	function jvbpd_wcs_dequeue_quantity() {
		wp_dequeue_style( 'wcqi-css' );
	}
}

if( ! function_exists( 'jvbpd_add_member_loop_class' ) ) {
	function jvbpd_add_member_loop_class( $css=Array(), $module='' ) {
		$bp_css = bp_get_member_class( Array( 'bg-cycle-img bp-members' ) );
		$module_style = jvbpd_tso()->get( 'bp_members_loop_module', false );

		$strip_css = str_replace( Array( '"', 'class=' ), '', $bp_css );
		$css[] = $strip_css;

		if( false !== $module_style ) {
			$css[] = $module_style;
		}
		return $css;
	}
}

if( ! function_exists( 'jvbpd_add_member_loop_action' ) ) {
	function jvbpd_add_member_loop_action( $module='', $obj=Array() ) {
		if ( bp_get_member_latest_update() ) : ?>
			<span class="update"> <?php bp_member_latest_update(); ?></span>
		<?php
		endif;
		 do_action( 'bp_directory_members_actions' );
	}
}

if( ! function_exists( 'jvbpd_bp_member_thumbnail' ) ) {
	function jvbpd_bp_member_thumbnail( $src='', $obj=Array() ) {
		$member_cover_image_url = bp_attachments_get_attachment('url', array(
		  'object_dir' => 'members',
		  'item_id' => bp_get_member_user_id(),
		));

		if( !empty( $member_cover_image_url ) ) {
			$src = $member_cover_image_url;
		}

		return $src;
	}
}

if( ! function_exists( 'jvbpd_bp_module_no_image' ) ) {
	function jvbpd_bp_module_no_image( $noImage='' ) {
		$strThemeSettingImageURi = jvbpd_tso()->get( 'bp_no_image', false );
		return false != $strThemeSettingImageURi ? $strThemeSettingImageURi : JVBPD_IMG_DIR .'/jv-bp-default-cover-bg.jpg';
	}
}

if( ! function_exists( 'jvbpd_add_group_loop_class' ) ) {
	function jvbpd_add_group_loop_class( $css=Array(), $module='' ) {
		$bp_css = bp_get_member_class( Array( 'bg-cycle-img bp-members' ) );
		$module_style = jvbpd_tso()->get( 'bp_group_loop_module', false );

		$strip_css = str_replace( Array( '"', 'class=' ), '', $bp_css );
		$css[] = $strip_css;

		if( false !== $module_style ) {
			$css[] = $module_style;
		}

		return $css;
	}
}

if( ! function_exists( 'jvbpd_add_group_loop_action' ) ) {
	function jvbpd_add_group_loop_action( $module='', $obj=Array() ) {
		if ( bp_get_member_latest_update() ) : ?>
			<span class="update"> <?php bp_member_latest_update(); ?></span>
		<?php
		endif;
		 do_action( 'bp_directory_groups_actions' );
	}
}

if( ! function_exists( 'jvbpd_bp_group_thumbnail' ) ) {
	function jvbpd_bp_group_thumbnail( $src='', $obj=Array() ) {
		$member_cover_image_url = bp_attachments_get_attachment('url', array(
		  'object_dir' => 'groups',
		  'item_id' => bp_get_group_id(),
		));

		if( !empty( $member_cover_image_url ) ) {
			$src = $member_cover_image_url;
		}

		return $src;
	}
}


if ( class_exists( 'WooCommerce' ) ) {
	add_action( 'jv_add_woocommerce_price', 'woocommerce_template_loop_price', 10 );
	add_action( 'jv_add_woocommerce_rating', 'woocommerce_template_loop_rating', 5 );
}

if( ! function_exists( 'jvbpd_filter_message_button_link' ) ) {
	/* Private message in Members directory loop */
	function jvbpd_filter_message_button_link( $link = '' ) {
		$bp_user_id = (bp_get_member_user_id() ? bp_get_member_user_id() : bp_displayed_user_id() );
		$link = wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $bp_user_id ) );
		return $link;
	}
}

if( ! function_exists( 'jvbpd_bp_dir_send_private_message_button' ) ) {
	function jvbpd_bp_dir_send_private_message_button() {
		if( bp_get_member_user_id() != bp_loggedin_user_id() ) {
			add_filter('bp_get_send_private_message_link', 'jvbpd_filter_message_button_link', 1, 1 );
			add_filter('bp_get_send_message_button_args', 'jvbpd_bp_private_msg_args');
			bp_send_message_button();
		}
	}
}

if( ! function_exists( 'jvbpd_register_actions' ) ) {
	// Messages button.
	add_action( 'after_setup_theme', 'jvbpd_register_actions' );
	function jvbpd_register_actions() {
		if ( function_exists( 'bp_is_active' ) && bp_is_active( 'messages' ) ) {
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button', 20 );
			add_action( 'bp_directory_members_actions',    'jvbpd_bp_dir_send_private_message_button',11 );
		}
	}
}


if( ! function_exists( 'jvbpd_bp_private_msg_args' ) ) {
	/**
	 * Override default BP private message button to work on Friends tab
	 * @since 2.2
	 * @param array $btn
	 * @return array
	 */
	function jvbpd_bp_private_msg_args( $btn ) {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		$btn['link_href'] = jvbpd_filter_message_button_link();

		return $btn;
	}
}

if( ! function_exists( 'jvbpd_bpfr_truncate_latest_update' ) ) {
	function jvbpd_bpfr_truncate_latest_update( $update_content ) {

		if( 150 < strlen( $update_content ) ) {
			$update_content = str_replace( '[&hellip;]', '', $update_content );
			return trim( substr( $update_content, 0, 30 ) ). ' [&hellip;]';
		}
		else
			return $update_content;
	}
}

add_filter( 'bps_templates', 'jvbpd_bp_search_forms' );

function jvbpd_bp_search_forms( $templates ) {
    $templates = array ( 'members/bps-form-legacy', 'members/bps-form-inline', 'members/bps-form-vertical' );

    return $templates;
}

if( !function_exists( 'get_breadcrumb') ) {
	function get_breadcrumb() {
		echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
		if (is_category() || is_single()) {
			echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
			the_category(' &bull; ');
				if (is_single()) {
					echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
					the_title();
				}
		} elseif (is_page()) {
			echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
			echo the_title();
		} elseif (is_search()) {
			echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
			echo '"<em>';
			echo the_search_query();
			echo '</em>"';
		}
	}
}
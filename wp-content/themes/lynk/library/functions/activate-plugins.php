<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Javo
 * @version    2.6.1 for parent theme Javobp for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */



add_action( 'tgmpa_register', 'jvbpd_register_required_plugins' );
function jvbpd_register_required_plugins() {

	$config = array(
		'id'           => 'jvfrmtd',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	$coreName = sprintf( '%s Core', jvbpd_tso()->themeName );
	tgmpa(
		apply_filters( 'jvbpd_tgmpa_plugins', Array(
			Array(
				'name' => $coreName,
				'slug' => sanitize_title( $coreName ),
				'version' => '1.0.3',
				'required' => true,
				'force_activation' => false,
				'force_deactivation' => false,
				'external_url' => '',
				'source' => get_template_directory() . '/library/plugins/' . sanitize_title( $coreName ) . '.zip',
				'image_url' => JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-lynk-core.png',
			),

			// BuddyPress
			array(
				'name'						=> 'BuddyPress', // The plugin name
				'slug'						=> 'buddypress', // The plugin slug (typically the folder name)
				'required'					=> true, // If false, the plugin is only 'recommended' instead of required
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'image_url'					=> esc_url_raw( JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-buddypress.png' ),
			),

			// BBpress
			array(
				'name'						=> 'BBpress', // The plugin name
				'slug'						=> 'bbpress', // The plugin slug (typically the folder name)
				'required'					=> true, // If false, the plugin is only 'recommended' instead of required
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'image_url'					=> esc_url_raw( JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-bbpress.png' ),
			),


			// Lava Bp Post
			array(
				'name'						=> 'Lava Bp Post', // The plugin name
				'slug'						=> 'lava-bp-post', // The plugin slug (typically the folder name)
				'required'					=> false, // If false, the plugin is only 'recommended' instead of required
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'image_url'					=> JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-bp-post.png',
			),

			// Lava ajax search
			array(
				'name'						=> 'Lava Ajax Search', // The plugin name
				'slug'						=> 'lava-ajax-search', // The plugin slug (typically the folder name)
				'required'					=> false, // If false, the plugin is only 'recommended' instead of required
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'image_url'					=> JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-ajax-search.png',
			),

			// Visual Composer
			array(
				'name'						=> 'WPBakery Visual Composer', // The plugin name
				'slug'						=> 'js_composer', // The plugin slug (typically the folder name)
				'source'					=> get_template_directory() . '/library/plugins/js_composer.zip', // The plugin source
				'required'					=> true, // If false, the plugin is only 'recommended' instead of required
				'version'					=> '5.4.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'				=> '', // If set, overrides default API URL and points to an external URL
				'image_url'					=> JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-js_composer.png',
			),

			// Ultimate Addons
			array(
				'name'						=> 'Ultimate Addons for Visual Composer', // The plugin name
				'slug'						=> 'Ultimate_VC_Addons', // The plugin slug (typically the folder name)
				'source'					=> get_template_directory() . '/library/plugins/Ultimate_VC_Addons.zip', // The plugin source
				'required'					=> true, // If false, the plugin is only 'recommended' instead of required
				'version'					=> '3.16.21', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'				=> '', // If set, overrides default API URL and points to an external URL
				'image_url'					=> JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-Ultimate_VC_Addons.png',
			),
			// The Grid
			array(
				'name'						=> 'The Grid', // The plugin name
				'slug'						=> 'the-grid', // The plugin slug (typically the folder name)
				'source'					=> get_template_directory() . '/library/plugins/the-grid.zip', // The plugin source
				'required'					=> true, // If false, the plugin is only 'recommended' instead of required
				'version'					=> '2.6.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'				=> '', // If set, overrides default API URL and points to an external URL
				'image_url'					=> JVBPD_IMG_DIR . '/icon/jv-default-setting-plugin-javo-the-grid-core-logo.png',
			)
		) ),
		apply_filters( 'jvbpd_tgmpa_config', $config )
	);
}
<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/javmah/
 * @since             1.0.0
 * @package           Automail
 *
 * @wordpress-plugin
 * Plugin Name:       AutoMail - Event-driven email automation. Easy email Auto-reply and Notification.
 * Plugin URI:        https://wordpress.org/plugins/automai
 * Description:       AutoMail is an Email Automation plugin, It works with WordPress, WooCommerce, Contact form seven, and other Plugins.
 * Version:           1.0.0
 * Author:            javmah
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       automail
 * Domain Path:       /languages
*/

// If this file is called directly, abort.
if(!defined('WPINC')){
	die;
}
# freemius Starts
if ( function_exists( 'automail_fs' ) ) {
    automail_fs()->set_basename( true, __FILE__ );
} else {
    if ( ! function_exists( 'automail_fs' ) ) {
		// Create a helper function for easy SDK access.
		function automail_fs() {
			global $automail_fs;

			if(!isset($automail_fs)){
				// Include Freemius SDK.
				require_once dirname(__FILE__) . '/includes/freemius/start.php';
				$automail_fs = fs_dynamic_init( array(
					'id'                  => '9286',
					'slug'                => 'automail',
					'premium_slug'        => 'automail-professional',
					'type'                => 'plugin',
					'public_key'          => 'pk_207f56b5950aac72c5813628a81bc',
					'is_premium'          => true,
					'premium_suffix'      => 'Professional',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'trial'               => array(
						'days'               => 7,
						'is_require_payment' => true,
					),
					'menu'                => array(
						'slug'           => 'automail',
						'first-path'     => 'admin.php?page=automail',
						'support'        => false,
					),
					// Set the SDK to work in a sandbox mode (for development & testing).
					// IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
					'secret_key'          => 'sk_I37.yuN2ojM+)YM7KoS~19!oLDMNC',
            	));
			}

			return $automail_fs;
		}
		// Init Freemius.
		automail_fs();
		// Signal that SDK was initiated.
		do_action( 'automail_fs_loaded' );
	}

    // ... Your plugin's main file logic ... freemius ends Here ! 
	/**
	 * Currently plugin version.Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	*/
	define('AUTOMAIL_VERSION', '1.0.0');

	/**
	 * The code that runs during plugin activation. This action is documented in includes/class-automail-activator.php
	*/
	function activate_automail() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-automail-activator.php';
		Automail_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation. This action is documented in includes/class-automail-deactivator.php
	*/
	function deactivate_automail() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-automail-deactivator.php';
		Automail_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_automail');
	register_deactivation_hook( __FILE__, 'deactivate_automail');

	/**
	 * The core plugin class that is used to define internationalization, admin-specific hooks, and public-facing site hooks.
	*/
	require plugin_dir_path( __FILE__ ) . 'includes/class-automail.php';

	/**
	 * Begins execution of the plugin. Since everything within the plugin is registered via hooks, 
	 * then kicking off the plugin from this point in the file does not affect the page life cycle.
	 * @since    1.0.0
	*/
	function run_automail(){
		$plugin = new Automail();
		$plugin->run();
	}
	run_automail();
}

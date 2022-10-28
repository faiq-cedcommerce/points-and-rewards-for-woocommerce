<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpswings.com/
 * @since             1.0.0
 * @package           Ced_Pointsrewards_Tutorlms
 *
 * @wordpress-plugin
 * Plugin Name:       Points and Rewards For Tutor LMS
 * Plugin URI:        https://wpswings.com/
 * Description:       Points and Rewards for Tutor LMS
 * Version:           1.0.0
 * Author:            WP Swings
 * Author URI:        https://wpswings.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ced-pointsrewards-tutorlms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CED_POINTSREWARDS_TUTORLMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ced-pointsrewards-tutorlms-activator.php
 */
function activate_ced_pointsrewards_tutorlms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ced-pointsrewards-tutorlms-activator.php';
	Ced_Pointsrewards_Tutorlms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ced-pointsrewards-tutorlms-deactivator.php
 */
function deactivate_ced_pointsrewards_tutorlms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ced-pointsrewards-tutorlms-deactivator.php';
	Ced_Pointsrewards_Tutorlms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ced_pointsrewards_tutorlms' );
register_deactivation_hook( __FILE__, 'deactivate_ced_pointsrewards_tutorlms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ced-pointsrewards-tutorlms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

/**
 * Check WooCommerce is Installed and Active.
 *
 * since Tutor LMS is extension for WooCommerce it's necessary,
 * to check that WooCommerce is installed and activated or not,
 * if yes allow extension to execute functionalities and if not
 * let deactivate the extension and show the notice to admin.
 * 
 * @author CedCommerce
 */
if(ced_tutor_lms_points_rewards_woocommerce_active()){
	run_ced_pointsrewards_tutorlms();
}else{
	add_action( 'admin_init', 'deactivate_tutor_lms_points_rewards_woo_missing' );
}

/**
 * Check WooCommmerce active or not.
 *
 * @since 1.0.0
 * @return bool true|false
 */
function ced_tutor_lms_points_rewards_woocommerce_active(){

	if ( function_exists('is_multisite') && is_multisite() ){

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ){

			return true;
		}
		return false;
	}else{
			
		if ( in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ){

			return true;
		}
		return false;
	}
}
/**
 * This code runs when WooCommerce is not activated,
 * deativates the extension and displays the notice to admin.
 *
 * @since 1.0.0
 */
function deactivate_tutor_lms_points_rewards_woo_missing() {

	deactivate_plugins( plugin_basename( __FILE__ ) );
	add_action('admin_notices', 'tutor_lms_points_rewards_woo_missing_notice' );
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}
/**
 * callback function for sending notice if woocommerce is not activated.
 *
 * @since 1.0.0
 * @return string
 */
function tutor_lms_points_rewards_woo_missing_notice(){

	echo '<div class="error"><p>' . sprintf(__('Tutor LMS Points and Rewards plugin requires WooCommerce to be installed and active. You can download %s here.', 'cedcommerce-vidaxl-dropshipping'), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a>') . '</p></div>';
}

function run_ced_pointsrewards_tutorlms() {

	$plugin = new Ced_Pointsrewards_Tutorlms();
	$plugin->run();

}


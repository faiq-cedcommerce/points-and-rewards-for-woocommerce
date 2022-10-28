<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ced_Pointsrewards_Tutorlms
 * @subpackage Ced_Pointsrewards_Tutorlms/includes
 * @author     Cedcommerce <support@cedcommerce.com>
 */
class Ced_Pointsrewards_Tutorlms_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ced-pointsrewards-tutorlms',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

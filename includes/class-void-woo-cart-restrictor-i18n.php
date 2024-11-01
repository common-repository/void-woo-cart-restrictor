<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://voidcoders.com
 * @since      1.0.0
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/includes
 * @author     VoidCoders <support@voidcoders.com>
 */
class Void_Woo_Cart_Restrictor_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'void-woo-cart-restrictor',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

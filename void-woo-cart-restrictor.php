<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://voidcoders.com
 * @since             1.0.0
 * @package           Void_Woo_Cart_Restrictor
 *
 * @wordpress-plugin
 * Plugin Name:       Void Woo Cart Restrictor
 * Plugin URI:        https://voidcoders.com/product/void-woo-cart-restrictor-free/
 * Description:       Void Woo Cart Restrictor lets you restrict a certain type of category products to only defined user role. It will make the selected cateogory product completely non purchasble other than the chosen user role. 
 * Version:           1.0.0
 * Author:            VoidCoders
 * Author URI:        https://voidcoders.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       void-woo-cart-restrictor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 * 
 */
define( 'VOID_WOO_CART_RESTRICTOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-void-woo-cart-restrictor-activator.php
 */
function activate_void_woo_cart_restrictor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-void-woo-cart-restrictor-activator.php';
	Void_Woo_Cart_Restrictor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-void-woo-cart-restrictor-deactivator.php
 */
function deactivate_void_woo_cart_restrictor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-void-woo-cart-restrictor-deactivator.php';
	Void_Woo_Cart_Restrictor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_void_woo_cart_restrictor' );
register_deactivation_hook( __FILE__, 'deactivate_void_woo_cart_restrictor' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-void-woo-cart-restrictor.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_void_woo_cart_restrictor() {

	$plugin = new Void_Woo_Cart_Restrictor();
	$plugin->run();

}
run_void_woo_cart_restrictor();

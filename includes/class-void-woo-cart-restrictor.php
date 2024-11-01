<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://voidcoders.com
 * @since      1.0.0
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/includes
 * @author     VoidCoders <support@voidcoders.com>
 */
class Void_Woo_Cart_Restrictor {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Void_Woo_Cart_Restrictor_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'VOID_WOO_CART_RESTRICTOR_VERSION' ) ) {
			$this->version = VOID_WOO_CART_RESTRICTOR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'void-woo-cart-restrictor';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Void_Woo_Cart_Restrictor_Loader. Orchestrates the hooks of the plugin.
	 * - Void_Woo_Cart_Restrictor_i18n. Defines internationalization functionality.
	 * - Void_Woo_Cart_Restrictor_Admin. Defines all hooks for the admin area.
	 * - Void_Woo_Cart_Restrictor_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-void-woo-cart-restrictor-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-void-woo-cart-restrictor-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-void-woo-cart-restrictor-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-void-woo-cart-restrictor-public.php';

		$this->loader = new Void_Woo_Cart_Restrictor_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Void_Woo_Cart_Restrictor_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Void_Woo_Cart_Restrictor_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Void_Woo_Cart_Restrictor_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'product_cat_add_form_fields', $plugin_admin, 'voidcoders_add_product_cat_field', 10, 1 );
		$this->loader->add_action( 'product_cat_edit_form_fields', $plugin_admin, 'voidcoders_edit_product_cat_field', 10, 1 );
		$this->loader->add_action( 'created_product_cat', $plugin_admin, 'voidcoders_save_product_cat_field', 10, 2 );
		$this->loader->add_action( 'edited_product_cat', $plugin_admin, 'voidcoders_save_product_cat_field', 10, 2 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'voidcoders_register_sub_menu');
		$this->loader->add_action( 'admin_post_voidcoders_restricted_to_role', $plugin_admin, 'voidcoders_restrictor_form_handler');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Void_Woo_Cart_Restrictor_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_before_single_product_summary', $plugin_public, 'voidcoders_restricted_notice');
		$this->loader->add_filter( 'woocommerce_is_purchasable', $plugin_public, 'voidcoders_disable_purchased_products', 10, 2 );
		$this->loader->add_filter( 'woocommerce_login_redirect', $plugin_public, 'voidcoders_redirect_after_login' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Void_Woo_Cart_Restrictor_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

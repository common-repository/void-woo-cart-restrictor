<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://voidcoders.com
 * @since      1.0.0
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/public
 * @author     VoidCoders <support@voidcoders.com>
 */
class Void_Woo_Cart_Restrictor_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Void_Woo_Cart_Restrictor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Void_Woo_Cart_Restrictor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/void-woo-cart-restrictor-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Void_Woo_Cart_Restrictor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Void_Woo_Cart_Restrictor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/void-woo-cart-restrictor-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Check if a product has restricted category
	 *
	 * @since    1.0.0
	 */
	protected function voidcoders_check_restrictor_value( $product_id ){
		// flag is true if the product has a category which is restricted, by default set to false
		$flag = false;

		if( get_option( 'voidcoders_restrictor_response' ) ){
			$restricted_roles = array_map( 'strtolower', get_option( 'voidcoders_restrictor_response' ) );
			if( is_user_logged_in() ){
				$user_roles = wp_get_current_user()->roles;
				$is_role_chosen = array_intersect( $restricted_roles, $user_roles );
				if( $is_role_chosen ){
					$flag = false;
				}else{
					//get all the terms/categories
					$terms = get_the_terms ( $product_id, 'product_cat' );
					//check if it has restricted category
					foreach ( $terms as $term ) {
						$cat_id = $term->term_id;
						$voidcoders_response = get_term_meta( $cat_id, 'VoidCodersProductCatVisibility', true);
					    //compare with the retricted cateogry term id, if found break out of the loop
						if( $voidcoders_response ){
							$flag = true;
							break;
						}
					}
				}
			}else{
				//get all the terms/categories
				$terms = get_the_terms ( $product_id, 'product_cat' );
				//check if it has restricted category
				foreach ( $terms as $term ) {
					$cat_id = $term->term_id;
					$voidcoders_response = get_term_meta( $cat_id, 'VoidCodersProductCatVisibility', true);
				    //compare with the retricted cateogry term id, if found break out of the loop
					if( $voidcoders_response ){
						$flag = true;
						break;
					}
				}
			}
			
		}		
		
		return $flag;
	}
	/**
	 * if a product has restricted category, make it non purchasable(remove add to cart)
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_disable_purchased_products( $is_purchasable, $product ){
 
	
		$flag = $this->voidcoders_check_restrictor_value( $product->get_id() );

		if( $flag ){
			//not purchaseble
			return false;
		}
		else{
			return $is_purchasable;
		}

	}
	/**
	 * if a product has restricted category, show a notice on product to login
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_restricted_notice(){
    	$product = new WC_Product();
		$flag = $this->voidcoders_check_restrictor_value( $product->get_id() );
		//print the URL if prescribed medice category found
		if( $flag ){
			include_once( 'partials/void-woo-cart-restrictor-public-display.php' );
		}
	}
	/**
	 * Redirect the user to the product the user was browsing before logging in
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_redirect_after_login( $redirect_to ) {
	
		//check if there is URL
		 if( isset( $_COOKIE['voidcodersWooReferrer'] ) && !empty( $_COOKIE['voidcodersWooReferrer'] ) ){
			$url = $_COOKIE['voidcodersWooReferrer'];
			//destroy referrer cookie
			unset( $_COOKIE['voidcodersWooReferrer'] );
			setcookie( 'voidcodersWooReferrer', '', time() - 3600 );
			//escape URL for security
			$redirect_to = esc_url( $url );
	     	return $redirect_to;
		 }
		 // return default URL
	     return $redirect_to;
	}

}

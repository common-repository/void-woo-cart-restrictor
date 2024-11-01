<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://voidcoders.com
 * @since      1.0.0
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/admin
 * @author     VoidCoders <support@voidcoders.com>
 */
class Void_Woo_Cart_Restrictor_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/void-woo-cart-restrictor-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/void-woo-cart-restrictor-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Add checkbox field to products>catgories admin page
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_add_product_cat_field( $term ){ ?>

		<tr class="form-field">
			<th><label for="VoidCodersProductCatVisibility"><?php _e( 'Restrict this category? ', 'void-woo-cart-restrictor' ); ?></label></th>
			 
			<td>	 
				<input type="checkbox" name="VoidCodersProductCatVisibility" id="VoidCodersProductCatVisibility" value="<?php echo esc_attr( 'yes' ); ?>"><?php echo esc_html__('Yes', 'void-woo-cart-restrictor'); ?>
			</td>
		</tr>

	<?php }
	/**
	 * Add checkbox field to products>catgories>edit category admin page
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_edit_product_cat_field( $term ){ 

		$voidcoders_response = get_term_meta( $term->term_id, 'VoidCodersProductCatVisibility', true);
	?>
		<tr class="form-field">
			<th><label for="VoidCodersProductCatVisibility"><?php _e( 'Restrict this category', 'void-woo-cart-restrictor' ); ?></label></th>
			 
			<td>	 
				<input type="checkbox" name="VoidCodersProductCatVisibility" id="VoidCodersProductCatVisibility" value="<?php echo esc_attr( 'yes' );?>" <?php if( $voidcoders_response ){ echo esc_attr(' checked'); } ?> > <?php echo esc_html__('Yes', 'void-woo-cart-restrictor'); ?>
			</td>
		</tr>
	<?php }
	/**
	 * Save added checkbox response to Database
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_save_product_cat_field( $term_id, $tt_id ){
	
		if( !isset( $_POST['VoidCodersProductCatVisibility'] ) ){
			update_term_meta( $term_id, 'VoidCodersProductCatVisibility', sanitize_text_field( '' ) );
			return;
		}
		update_term_meta( $term_id, 'VoidCodersProductCatVisibility', sanitize_text_field( $_POST['VoidCodersProductCatVisibility'] ) );
	}
	
	/**
	 * Create Void Woo Cart Restrictor Submenu under Settings Menu
	 *
	 * @since    1.0.0
	 */
	public function voidcoders_register_sub_menu() {
        add_submenu_page( 
            'options-general.php', esc_html__( 'Void Woo Cart Restrictor', 'void-woo-cart-restrictor'), esc_html__( 'Void Woo Cart Restrictor', 'void-woo-cart-restrictor'), 'manage_options', 'void-woo-cart-restrictor', array( &$this, 'voidcoders_submenu_page_callback')
        );
    }
 	
 	/**
     * Render submenu
     * @return void
     */
    public function voidcoders_submenu_page_callback() {
    	include_once( 'partials/void-woo-cart-restrictor-admin-display.php' );	
    }
    /**
	 * Form response handler, pass the data to 'voidcoders_restrictor_response' option
	 *
	 * @since    1.0.0
	 */
    public function voidcoders_restrictor_form_handler(){
    	if( isset( $_POST[ 'voidcoders-restricted-nonce' ] ) && wp_verify_nonce( $_POST[ 'voidcoders-restricted-nonce' ], 'voidcoders-form-restriction' ) ){
    		/****
    		*	if the option already exists, we update the value otherwise we crate it and 
    		*   insert the value
    		*/
    		if( isset( $_POST[ 'voidcoders-roles' ] ) ){
    			if ( get_option( 'voidcoders_restrictor_response' ) !== false ) {

				    // The option already exists, so we just update it.
				    update_option( 'voidcoders_restrictor_response', array_map( 'strtolower', array_map( 'sanitize_text_field', $_POST['voidcoders-roles'] ) ) );
				    //redirect to option page
				    wp_safe_redirect( wp_get_referer() );

				}else{
					add_option( 'voidcoders_restrictor_response', array_map( 'strtolower', array_map( 'sanitize_text_field', $_POST['voidcoders-roles'] ) ) );
    				//redirect to option page
    		  		wp_safe_redirect( wp_get_referer() );
				}
    			
    		}else{
    			if ( get_option( 'voidcoders_restrictor_response' ) !== false ) {
    				update_option( 'voidcoders_restrictor_response', sanitize_text_field( '' ) );
    				//redirect to option page
				    wp_safe_redirect( wp_get_referer() );
    			}else{
    				//redirect to option page
				    wp_safe_redirect( wp_get_referer() );
    			}
    		}
 
    	}
   
    }

    
}

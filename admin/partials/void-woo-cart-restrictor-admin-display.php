<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://voidcoders.com
 * @since      1.0.0
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

	$roles_obj = new WP_Roles();
	//get all registered role names
	$roles_name_array = array_map( 'strtolower', $roles_obj->get_names() );
	$restricted_roles = get_option( 'voidcoders_restrictor_response' );
	$user = wp_get_current_user();
	$user_roles = wp_get_current_user()->roles;
	
	if( get_option( 'voidcoders_restrictor_response' ) ){
		//check if user role matches with chosen restricted role
		$is_role_chosen = array_intersect( $restricted_roles, $user_roles );
		$saved_response =  get_option( 'voidcoders_restrictor_response' );
	}else{
		$saved_response = '';
	}

?>
	<h2> <?php echo esc_html__( 'Cart only visible to:', 'void-woo-cart-restrictor'); ?> </h2>
	<form action ="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="voidcoders-role" >
		<input type="hidden" name="action" value="voidcoders_restricted_to_role">
		<input type="hidden" name="voidcoders-restricted-nonce" value="<?php echo wp_create_nonce( 'voidcoders-form-restriction' ); ?>">
		<div class="voidcoders-roles-wrapper">
			<!--- retrieve what role is already selected !-->
			<?php foreach ( $roles_name_array as $role_name ) { 
				if( $saved_response && in_array( $role_name, $saved_response) ){
					$check = 'checked';
				}else{
					$check = '';
				}
			?>
				<label>
				<input type="checkbox" name="voidcoders-roles[]" value="<?php echo esc_attr( $role_name ); ?>" <?php echo esc_attr( ' '. $check ); ?> > <?php echo esc_html__( $role_name, 'void-woo-cart-restrictor' ); ?> </label>	
			<?php } ?>
		</div>
		<p><input type="submit" class="button buton-primary" name="submit" value="<?php echo esc_html__('Submit', 'void-woo-cart-restrictor'); ?>"></p>
	</form>
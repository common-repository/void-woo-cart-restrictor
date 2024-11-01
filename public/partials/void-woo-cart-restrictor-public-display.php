<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://voidcoders.com
 * @since      1.0.0
 *
 * @package    Void_Woo_Cart_Restrictor
 * @subpackage Void_Woo_Cart_Restrictor/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<p class="voidcoders-woo-account-link"><?php echo esc_html__( 'You must ', 'void-woo-cart-restrictor'); ?><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php echo esc_html__( ' Login ', 'void-woo-cart-restrictor'); ?></a><?php echo esc_html__( 'to buy this product', 'void-woo-cart-restrictor' ); ?></p>
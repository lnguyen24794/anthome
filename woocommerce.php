<?php
/**
 * The template for displaying all WooCommerce pages
 *
 * This template handles:
 * - Single product pages (is_product)
 * - Cart page (is_cart)
 * - Checkout page (is_checkout)
 * - Account pages (is_account_page)
 * - Other WooCommerce pages
 * 
 * Archive/shop pages use: woocommerce/archive-product.php
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Archive pages (shop, category) have their own template
if ( ! is_singular( 'product' ) && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
	// Let WooCommerce handle archive pages normally
	wc_get_template( 'archive-product.php' );
	return;
}

get_header();

/**
 * Hook: woocommerce_before_main_content
 *
 * @hooked anthome_woocommerce_wrapper_before - 10 (outputs opening divs for the content)
 */
do_action( 'woocommerce_before_main_content' );

?>

<?php
/**
 * Main WooCommerce content
 */
woocommerce_content();
?>

<?php

/**
 * Hook: woocommerce_after_main_content
 *
 * @hooked anthome_woocommerce_wrapper_after - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * No sidebar for single product pages, cart, and checkout
 */

get_footer();


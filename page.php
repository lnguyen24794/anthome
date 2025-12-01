<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Anthome
 */

get_header();

// Check if this is a WooCommerce page (cart, checkout, my account)
$is_woocommerce_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );

if ( $is_woocommerce_page ) {
	// For WooCommerce pages, render appropriate template
	do_action( 'woocommerce_before_main_content' );
	
	if ( is_cart() ) {
		// Cart doesn't need special args
		wc_get_template( 'cart/cart.php' );
	} elseif ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
		// Checkout form (but not thank you page)
		$checkout = WC()->checkout();
		wc_get_template( 'checkout/form-checkout.php', array( 'checkout' => $checkout ) );
	} elseif ( is_wc_endpoint_url( 'order-received' ) ) {
		// Thank you page (order received)
		global $wp;
		$order_id = absint( $wp->query_vars['order-received'] );
		$order = wc_get_order( $order_id );
		wc_get_template( 'checkout/thankyou.php', array( 'order' => $order ) );
	} elseif ( is_account_page() ) {
		wc_get_template( 'myaccount/my-account.php' );
	}
	
	do_action( 'woocommerce_after_main_content' );
} else {
	// Standard page template
	?>
	<main id="main" class="site-main">
		<div class="container py-5">
			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'anthome' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</div>
	</main><!-- #main -->
	<?php
}

get_footer();


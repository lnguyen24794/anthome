<?php
/**
 * Enqueue scripts and styles
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function anthome_scripts() {
	// Google Fonts
	wp_enqueue_style( 'anthome-google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@700&display=swap', array(), null );

	// Bootstrap 5 CSS
	wp_enqueue_style( 'anthome-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0' );

	// Bootstrap Icons
	wp_enqueue_style( 'anthome-bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css', array(), '1.11.0' );

	// Font Awesome (for Floating Contact)
	if ( anthome_get_option( 'floating_contact_enable' ) ) {
		wp_enqueue_style( 'anthome-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
	}

	// AOS CSS
	wp_enqueue_style( 'anthome-aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1' );

	// Main Theme Style (assets/css/main.css)
	wp_enqueue_style( 'anthome-main-css', get_template_directory_uri() . '/assets/css/main.css', array('anthome-bootstrap'), ANTHOME_VERSION );

    // WP Style (style.css)
    wp_enqueue_style( 'anthome-style', get_stylesheet_uri(), array(), ANTHOME_VERSION );

	// Scripts
	// Bootstrap 5 Bundle JS
	wp_enqueue_script( 'anthome-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true );

	// AOS JS
	wp_enqueue_script( 'anthome-aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true );

	// Theme Main JS
	wp_enqueue_script( 'anthome-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'anthome-bootstrap-js'), ANTHOME_VERSION, true );
	
	// Product Search AJAX (for WooCommerce)
	if ( anthome_is_woocommerce_activated() ) {
		wp_enqueue_script( 'anthome-product-search', get_template_directory_uri() . '/assets/js/product-search.js', array('jquery'), ANTHOME_VERSION, true );
		
		// Add to Cart AJAX Handler
		wp_enqueue_script( 'anthome-add-to-cart', get_template_directory_uri() . '/assets/js/add-to-cart.js', array('jquery'), ANTHOME_VERSION, true );
		
		// Pass WooCommerce AJAX URL to scripts
		wp_localize_script( 'anthome-add-to-cart', 'anthome_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'wc_ajax_url' => WC_AJAX::get_endpoint( '%%endpoint%%' ),
		));
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'anthome_scripts' );

/**
 * Initialize AOS and other scripts inline
 */
function anthome_footer_scripts() {
	?>
	<script>
		// AOS Init
		AOS.init({
			duration: 1000,
			once: true
		});
	</script>
	<?php
}
add_action( 'wp_footer', 'anthome_footer_scripts', 100 );

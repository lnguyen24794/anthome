<?php
/**
 * Theme Setup
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'anthome_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function anthome_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'anthome', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'anthome' ),
				'footer'  => esc_html__( 'Footer Menu', 'anthome' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// WooCommerce Support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

        // Auto Assign Menus (One-time check)
        $locations = get_theme_mod('nav_menu_locations');
        $menus = wp_get_nav_menus();
        
        if ($menus) {
            foreach ($menus as $menu) {
                if ($menu->slug == 'menu-ngang' && !isset($locations['primary'])) {
                    $locations['primary'] = $menu->term_id;
                }
                if ($menu->slug == 'menu-duoi-cung' && !isset($locations['footer'])) {
                    $locations['footer'] = $menu->term_id;
                }
            }
            set_theme_mod('nav_menu_locations', $locations);
        }
	}
endif;
add_action( 'after_setup_theme', 'anthome_setup' );

/**
 * Register widget areas
 */
function anthome_widgets_init() {
	// Blog Sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'anthome' ),
			'id'            => 'sidebar-blog',
			'description'   => esc_html__( 'Add widgets for blog pages here.', 'anthome' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title mb-3 pb-3 border-bottom">',
			'after_title'   => '</h5>',
		)
	);
}
add_action( 'widgets_init', 'anthome_widgets_init' );


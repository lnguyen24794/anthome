<?php
/**
 * Anthome functions and definitions
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Theme Constants
define( 'ANTHOME_VERSION', '1.0.2' );
define( 'ANTHOME_THEME_DIR', get_template_directory() );
define( 'ANTHOME_THEME_URI', get_template_directory_uri() );

/**
 * Require core files
 */
require ANTHOME_THEME_DIR . '/inc/setup.php';
require ANTHOME_THEME_DIR . '/inc/enqueue.php';
require ANTHOME_THEME_DIR . '/inc/helpers.php';
require ANTHOME_THEME_DIR . '/inc/template-tags.php';
require ANTHOME_THEME_DIR . '/inc/theme-options.php';
require ANTHOME_THEME_DIR . '/inc/classes/class-bootstrap-navwalker.php';

/**
 * WooCommerce setup
 */
if ( class_exists( 'WooCommerce' ) ) {
	require ANTHOME_THEME_DIR . '/inc/woocommerce/functions.php';
	require ANTHOME_THEME_DIR . '/inc/woocommerce/hooks.php';
	require ANTHOME_THEME_DIR . '/inc/woocommerce/filters.php';
}


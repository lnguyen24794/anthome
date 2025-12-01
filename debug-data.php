<?php
require_once( '/var/www/html/wp-load.php' );

if ( ! class_exists( 'WooCommerce' ) ) {
    echo "WooCommerce not active.\n";
    exit;
}

echo "--- CATEGORIES ---\n";
$terms = get_terms( array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
) );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        echo "ID: {$term->term_id} | Name: {$term->name} | Slug: {$term->slug} | Count: {$term->count}\n";
    }
} else {
    echo "No categories found.\n";
}

echo "\n--- MENUS ---\n";
$menus = wp_get_nav_menus();
foreach ( $menus as $menu ) {
    echo "ID: {$menu->term_id} | Name: {$menu->name} | Slug: {$menu->slug}\n";
}

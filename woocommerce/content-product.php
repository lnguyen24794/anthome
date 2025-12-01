<?php
/**
 * The template for displaying product content within loops
 *
 * @package Anthome
 * 
 * Available variables:
 * @var string $thumbnail_size - Image size (default: 'woocommerce_thumbnail')
 *                               Can be: 'thumbnail', 'medium', 'large', 'full', 
 *                               'woocommerce_thumbnail', 'woocommerce_single'
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Get thumbnail size from variable or use default
$thumbnail_size = isset( $thumbnail_size ) ? $thumbnail_size : 'woocommerce_thumbnail';
?>
<div <?php wc_product_class( 'col-lg-3 col-md-6', $product ); ?>>
    <a href="<?php the_permalink(); ?>" class="text-decoration-none d-block">
        <div class="card product-card h-100 border-0 shadow-sm">
            <div class="card-img-wrapper position-relative overflow-hidden">
                <?php 
                /**
                 * Hook: woocommerce_before_shop_loop_item_title.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 * 
                 * Note: Thumbnail size is controlled by $thumbnail_size variable
                 * You can also use custom function: anthome_product_thumbnail( $product, $thumbnail_size )
                 */
                do_action( 'woocommerce_before_shop_loop_item_title' ); 
                
                // Alternative: Use custom function with specific size
                // echo anthome_product_thumbnail( $product, $thumbnail_size );
                ?>
            </div>
        
            <div class="card-body text-center">
                <?php
                /**
                 * Hook: woocommerce_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_product_title - 10
                 */
                do_action( 'woocommerce_shop_loop_item_title' );

                /**
                 * Hook: woocommerce_after_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );
                ?>
            </div>
        </div>
    </a>
</div>


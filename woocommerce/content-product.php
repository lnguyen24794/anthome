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
    <div class="card product-card h-100 border-0 shadow-sm">
        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
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
                
                // Display rating badge if product has reviews
                $rating_count = $product->get_rating_count();
                $average_rating = $product->get_average_rating();
                if ( $rating_count > 0 && $average_rating > 0 ) {
                    ?>
                    <div class="product-rating-badge position-absolute top-0 start-0 m-2">
                        <div class="badge bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; font-size: 14px; font-weight: bold;"
                             title="<?php printf( esc_attr__( 'Đánh giá %s trên 5', 'anthome' ), $average_rating ); ?>">
                            <?php echo number_format( $average_rating, 1 ); ?>★
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </a>
        
        <div class="card-body text-center d-flex flex-column">
            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
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
            </a>
            
            <!-- Add to Cart Button (Inside card-body, below price) -->
            <div class="product-card-actions mt-auto pt-2">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item' );
                ?>
            </div>
        </div>
    </div>
</div>


<?php
/**
 * Template part for displaying product section
 * 
 * @package Anthome
 * 
 * Usage:
 * get_template_part( 'template-parts/product/product-section', null, array(
 *     'title' => 'Sản phẩm mới',
 *     'icon' => 'bi-star-fill',
 *     'link_url' => get_permalink( wc_get_page_id( 'shop' ) ),
 *     'bg_class' => 'bg-light',
 *     'text_class' => 'text-primary',
 *     'query_args' => array(
 *         'post_type' => 'product',
 *         'posts_per_page' => 4,
 *     ),
 *     'thumbnail_size' => 'full',
 *     'columns' => 4
 * ) );
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get passed arguments
$title = isset( $args['title'] ) ? $args['title'] : 'Sản phẩm';
$icon = isset( $args['icon'] ) ? $args['icon'] : '';
$link_url = isset( $args['link_url'] ) ? $args['link_url'] : '#';
$link_text = isset( $args['link_text'] ) ? $args['link_text'] : 'Xem tất cả';
$bg_class = isset( $args['bg_class'] ) ? $args['bg_class'] : 'bg-light';
$text_class = isset( $args['text_class'] ) ? $args['text_class'] : 'text-primary';
$query_args = isset( $args['query_args'] ) ? $args['query_args'] : array();
$thumbnail_size = isset( $args['thumbnail_size'] ) ? $args['thumbnail_size'] : 'full';
$columns = isset( $args['columns'] ) ? $args['columns'] : 4;
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : 'container mb-5';

// Fallback query if empty
if ( empty( $query_args ) ) {
    $query_args = array(
        'post_type' => 'product',
        'posts_per_page' => $columns,
    );
}

if ( ! anthome_is_woocommerce_activated() ) {
    return;
}
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
    <div class="d-flex justify-content-between align-items-center <?php echo esc_attr( $bg_class ); ?> p-3 border mb-3 rounded-top">
        <h4 class="fw-bold text-uppercase m-0 <?php echo esc_attr( $text_class ); ?>">
            <?php if ( $icon ) : ?>
                <i class="bi <?php echo esc_attr( $icon ); ?> me-2"></i>
            <?php endif; ?>
            <?php echo esc_html( $title ); ?>
        </h4>
        <a href="<?php echo esc_url( $link_url ); ?>" class="text-decoration-none small fw-bold <?php echo esc_attr( $text_class ); ?>">
            <?php echo esc_html( $link_text ); ?> <i class="bi bi-chevron-right"></i>
        </a>
    </div>
    
    <div class="row g-3">
        <?php
        $products = new WP_Query( $query_args );
        if ( $products->have_posts() ) {
            while ( $products->have_posts() ) : $products->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            wp_reset_postdata();
        } else {
            // No products found message
            ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Không có sản phẩm nào được tìm thấy.</p>
            </div>
            <?php
        }
        ?>
    </div>
</section>


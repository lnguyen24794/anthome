<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

?>

<!-- Breadcrumb Section -->
<div class="container pt-4">
    <?php 
    /**
     * Display breadcrumb
     * Using customized WooCommerce breadcrumb
     */
    if ( function_exists( 'woocommerce_breadcrumb' ) ) {
        woocommerce_breadcrumb();
    }
    ?>
</div>

<div class="container pb-5">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <!-- Mobile Filter Toggle Button -->
            <button class="btn btn-primary w-100 mb-3 d-lg-none filter-toggle" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#filterSidebar" 
                    aria-expanded="false" 
                    aria-controls="filterSidebar">
                <i class="bi bi-funnel me-2"></i>Bộ lọc tìm kiếm
                <i class="bi bi-chevron-down float-end"></i>
            </button>
            
            <!-- Collapsible Sidebar -->
            <div class="collapse d-lg-block" id="filterSidebar">
                <div class="card border-0 shadow-sm rounded-3">
                    <h5 class="fw-bold mb-3 font-playfair bg-primary text-white p-2 d-none d-lg-block">Bộ lọc tìm kiếm</h5>

                <div class="p-2">
                    <div class="mb-4">
                        <h6 class="fw-bold small text-uppercase mb-3">
                            <i class="bi bi-funnel me-2"></i>Khoảng giá
                        </h6>
                        
                        <div class="price-filter-container">
                            <!-- Price Input Fields -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small text-muted mb-1">Từ</label>
                                    <input type="number" class="form-control form-control-sm" id="min-price-input" 
                                           min="0" max="5000000" step="10000" value="0" 
                                           placeholder="0₫">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-muted mb-1">Đến</label>
                                    <input type="number" class="form-control form-control-sm" id="max-price-input" 
                                           min="0" max="5000000" step="10000" value="5000000" 
                                           placeholder="5.000.000₫">
                                </div>
                            </div>
                            
                            <!-- Double Range Slider -->
                            <div class="price-slider-wrapper position-relative mb-3">
                                <div class="price-progress"></div>
                                <input type="range" class="form-range price-input-min" 
                                       min="0" max="5000000" step="10000" 
                                       value="0" id="price-min">
                                <input type="range" class="form-range price-input-max" 
                                       min="0" max="5000000" step="10000" 
                                       value="5000000" id="price-max">
                            </div>
                            
                            <!-- Filter Actions -->
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary btn-sm flex-fill" id="apply-price-filter">
                                    <i class="bi bi-funnel me-1"></i>Lọc
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="reset-price-filter">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                    <?php else : ?>
                        <!-- Fallback Static Filter HTML from Template if no widget -->
                        <div class="mb-4">
                            <h6 class="fw-bold small text-uppercase mb-3">Danh mục</h6>
                            <?php 
                            $terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false ) );
                            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                echo '<ul class="list-unstyled filter-list">';
                                foreach ( $terms as $term ) {
                                    echo '<li><a href="' . get_term_link( $term ) . '" class="text-decoration-none text-muted d-flex justify-content-between align-items-center mb-2 text-capitalize">' . $term->name . ' <span class="badge bg-light text-dark rounded-pill">' . $term->count . '</span></a></li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            </div><!-- End Collapse -->
        </div>

        <!-- Product List -->
        <div class="col-lg-9">
            <!-- Shop Header -->
            <div class="shop-header mb-4">
                <!-- Title & Description -->
                <div class="mb-3">
                    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <h1 class="h3 mb-2 fw-bold font-playfair page-title text-uppercase"><?php woocommerce_page_title(); ?></h1>
                    <?php endif; ?>
                    
                    <?php
                    /**
                     * Hook: woocommerce_archive_description.
                     *
                     * @hooked woocommerce_taxonomy_archive_description - 10
                     * @hooked woocommerce_product_archive_description - 10
                     */
                    do_action( 'woocommerce_archive_description' );
                    ?>
                </div>

                <!-- Controls Bar -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-3 bg-light rounded shadow-sm">
                    <div class="d-flex align-items-center flex-wrap gap-2 w-100">
                        <?php
                        /**
                         * Hook: woocommerce_before_shop_loop.
                         *
                         * @hooked woocommerce_output_all_notices - 10
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         * @hooked anthome_products_per_page_selector - 25
                         * @hooked anthome_view_mode_toggle - 26
                         */
                        do_action( 'woocommerce_before_shop_loop' );
                        ?>
                    </div>
                </div>
            </div>

            <?php
            if ( woocommerce_product_loop() ) {
                ?>
                <div class="row g-4">
                    <?php
                    while ( have_posts() ) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content', 'product' );
                    }
                    ?>
                </div>

                <!-- Pagination & Bottom Actions -->
                <div class="shop-footer mt-5">
                    <div class="pagination-wrapper p-2 bg-light rounded shadow-sm">
                        <?php
                        /**
                         * Hook: woocommerce_after_shop_loop.
                         *
                         * @hooked woocommerce_pagination - 10
                         * @hooked anthome_back_to_top_button - 20
                         */
                        do_action( 'woocommerce_after_shop_loop' );
                        ?>
                    </div>
                </div>
                <?php
            } else {
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' );
            }
            ?>
        </div>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer();


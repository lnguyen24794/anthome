<?php
/**
 * The template for displaying product details
 *
 * @package Anthome
 * Template Name: Single Product
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <div class="row g-5 mb-5">
        <!-- Product Gallery -->
        <div class="col-md-6" data-aos="fade-right">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary
             * ================================================
             * This hook displays the product gallery and related elements
             *
             * DEFAULT HOOKS:
             * @hooked woocommerce_show_product_sale_flash - 10 (Sale badge)
             * @hooked woocommerce_show_product_images - 20 (Product gallery)
             * 
             * CUSTOM HOOKS (see inc/woocommerce/functions.php):
             * @hooked anthome_product_trust_badges - 25 (Trust badges below gallery)
             * 
             * CUSTOMIZATION EXAMPLES:
             * - Add custom badge: anthome_product_custom_badge() - priority 5
             * - Add video button: anthome_product_video_button() - priority 30
             * - Add 360° view: anthome_product_360_view() - priority 35
             * 
             * To customize, edit inc/woocommerce/functions.php
             */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>

        <!-- Product Summary -->
        <div class="col-md-6" data-aos="fade-left">
            <div class="product-summary ps-lg-4">
                <?php
                /**
                 * Hook: woocommerce_single_product_summary
                 * =========================================
                 * This hook displays the main product information
                 *
                 * DEFAULT HOOKS:
                 * @hooked woocommerce_template_single_title - 5 (Product title H1)
                 * @hooked woocommerce_template_single_rating - 11 (Star rating - reordered)
                 * @hooked woocommerce_template_single_price - 10 (Product price)
                 * @hooked woocommerce_template_single_excerpt - 20 (Short description)
                 * @hooked woocommerce_template_single_add_to_cart - 30 (Add to cart form)
                 * @hooked woocommerce_template_single_meta - 40 (SKU, categories, tags)
                 * @hooked woocommerce_template_single_sharing - 50 (Social sharing)
                 * @hooked WC_Structured_Data::generate_product_data() - 60 (Schema.org)
                 * 
                 * CUSTOM HOOKS (see inc/woocommerce/functions.php):
                 * @hooked anthome_custom_stock_status - 12 (Custom stock badge with icons)
                 * @hooked anthome_product_highlights - 25 (Product highlights list)
                 * @hooked anthome_payment_methods - 45 (Payment method icons)
                 * 
                 * CUSTOMIZATION EXAMPLES:
                 * - Add countdown timer: anthome_product_countdown() - priority 15
                 * - Add size guide: anthome_size_guide_button() - priority 28
                 * - Add warranty info: anthome_warranty_badge() - priority 35
                 * - Add comparison button: anthome_compare_button() - priority 32
                 * 
                 * To customize, edit inc/woocommerce/functions.php
                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>
                
                <!-- Custom Service Features (Static Template Content) -->
                <div class="product-features mt-4 pt-4 border-top">
                    <div class="d-flex justify-content-start gap-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-truck fs-4 text-muted me-2"></i>
                            <span class="small">Miễn phí vận chuyển</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-check fs-4 text-muted me-2"></i>
                            <span class="small">Bảo hành 2 năm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs & Related Products Section -->
    <div class="product-tabs-section py-5" data-aos="fade-up">
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary
         * ===============================================
         * This hook displays tabs (description, reviews) and related products
         *
         * DEFAULT HOOKS:
         * @hooked woocommerce_output_product_data_tabs - 10 (Product tabs)
         * @hooked woocommerce_upsell_display - 15 (Upsell products)
         * @hooked woocommerce_output_related_products - 20 (Related products)
         * 
         * CUSTOM HOOKS (see inc/woocommerce/functions.php):
         * @hooked anthome_product_guarantee_section - 18 (Guarantee/trust section)
         * 
         * CUSTOM FILTERS:
         * - anthome_custom_product_tabs_single() - Rename tabs, add custom tabs
         * - anthome_shipping_info_tab_content() - Add "Vận chuyển & Đổi trả" tab
         * - anthome_related_products_args() - Control related products count/columns
         * - anthome_upsell_products_args() - Control upsell products count/columns
         * 
         * CUSTOMIZATION EXAMPLES:
         * - Add FAQ section: anthome_product_faq() - priority 17
         * - Add video reviews: anthome_video_reviews() - priority 19
         * - Add size chart: anthome_size_chart_tab() via filter
         * - Add installation guide: anthome_installation_tab() via filter
         * 
         * To customize, edit inc/woocommerce/functions.php
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>

</div>

<?php 
/**
 * Hook: woocommerce_after_single_product
 * =======================================
 * This hook fires after all product content
 * Perfect for adding additional sections or features
 * 
 * CUSTOM HOOKS (see inc/woocommerce/functions.php):
 * @hooked anthome_recently_viewed_products - 10 (Show recently viewed products)
 * 
 * CUSTOMIZATION EXAMPLES:
 * - Add customer reviews slider: anthome_reviews_slider() - priority 15
 * - Add Instagram feed: anthome_product_instagram() - priority 20
 * - Add related blog posts: anthome_related_blog_posts() - priority 25
 * - Add newsletter signup: anthome_product_newsletter() - priority 30
 * - Add "Customers also bought": anthome_frequently_bought() - priority 12
 * 
 * To customize, edit inc/woocommerce/functions.php
 */
do_action( 'woocommerce_after_single_product' ); 
?>


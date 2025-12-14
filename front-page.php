<?php
/**
 * The template for displaying front page
 *
 * @package Anthome
 */

get_header();

// Hero Section Image
$hero_bg = 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1600&q=80';
?>

<main class="site-main mt-lg-0 mt-3">
    
    <!-- Top Layout: Sidebar & Slider -->
    <section class="home-top-section mb-5">
        <div class="container">
            <div class="row g-0">
                <!-- Left Sidebar Spacer (Menu is Absolute from Header) -->
                <div class="col-lg-3 d-none d-lg-block position-relative">
                    <!-- Placeholder to push content if menu wasn't absolute, 
                         but since it is absolute, this col keeps the grid structure 
                         and we can put banners or just leave empty if menu covers it. 
                         The menu in header has min-height 400px, same as slider.
                    -->
                </div>

                <!-- Right Content: Product Slider -->
                <div class="col-lg-9">
                    <?php
                    if ( anthome_is_woocommerce_activated() ) {
                        // Get category from theme options
                        $slider_category_id = anthome_get_option( 'homepage_slider_category', '' );
                        
                        // Build query args
                        $product_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => -1, // Get all products to group into slides
                            'orderby' => 'rand', // Random order
                        );
                        
                        // Add category filter if set
                        if ( ! empty( $slider_category_id ) ) {
                            $product_args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => absint( $slider_category_id ),
                                ),
                            );
                        }
                        
                        $products_query = new WP_Query( $product_args );
                        
                        if ( $products_query->have_posts() ) {
                            // Group products into slides (3 per slide)
                            $all_products = array();
                            while ( $products_query->have_posts() ) {
                                $products_query->the_post();
                                $all_products[] = get_post();
                            }
                            wp_reset_postdata();
                            
                            // Split into slides of 3
                            $slides = array_chunk( $all_products, 3 );
                            
                            if ( ! empty( $slides ) ) {
                                ?>
                                <div id="homepageProductSlider" class="carousel slide" data-bs-ride="carousel" style="height: 369px;">
                                    <div class="carousel-inner h-100">
                                        <?php
                                        foreach ( $slides as $slide_index => $slide_products ) {
                                            $is_active = $slide_index === 0 ? 'active' : '';
                                            ?>
                                            <div class="carousel-item <?php echo esc_attr( $is_active ); ?> h-100">
                                                <div class="row g-3 h-100 p-3">
                                                    <?php
                                                    foreach ( $slide_products as $product_post ) {
                                                        global $post, $product;
                                                        $post = $product_post;
                                                        setup_postdata( $post );
                                                        $product = wc_get_product( $post->ID );
                                                        $thumbnail_size = 'woocommerce_thumbnail';
                                                        ?>
                                                        <div class="col-4">
                                                            <?php
                                                            // Custom product card for slider
                                                            if ( empty( $product ) || ! $product->is_visible() ) {
                                                                continue;
                                                            }
                                                            ?>
                                                            <div class="card product-card h-100 border-0 shadow-sm">
                                                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                                                    <div class="card-img-wrapper position-relative overflow-hidden">
                                                                        <?php 
                                                                        do_action( 'woocommerce_before_shop_loop_item_title' ); 
                                                                        
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
                                                                        do_action( 'woocommerce_shop_loop_item_title' );
                                                                        do_action( 'woocommerce_after_shop_loop_item_title' );
                                                                        ?>
                                                                    </a>
                                                                    
                                                                    <div class="product-card-actions mt-auto pt-2">
                                                                        <?php
                                                                        do_action( 'woocommerce_after_shop_loop_item' );
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    wp_reset_postdata();
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    
                                    <?php if ( count( $slides ) > 1 ) : ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#homepageProductSlider" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#homepageProductSlider" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                        
                                        <div class="carousel-indicators">
                                            <?php
                                            for ( $i = 0; $i < count( $slides ); $i++ ) {
                                                $is_active = $i === 0 ? 'active' : '';
                                                ?>
                                                <button type="button" data-bs-target="#homepageProductSlider" data-bs-slide-to="<?php echo esc_attr( $i ); ?>" class="<?php echo esc_attr( $is_active ); ?>" aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo esc_attr( $i + 1 ); ?>"></button>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="hero-slider position-relative" style="height: 369px; overflow: hidden;">
                                    <div class="hero-slide h-100 w-100" style="background: url('<?php echo esc_url($hero_bg); ?>') no-repeat center center/cover;">
                                        <div class="hero-overlay" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)); position: absolute; inset: 0;"></div>
                                        <div class="hero-content position-absolute top-50 start-0 translate-middle-y p-5 text-white" data-aos="fade-right">
                                            <span class="d-block mb-2 text-uppercase fw-bold text-warning ls-1">Khuyến mãi mùa hè</span>
                                            <h1 class="display-4 fw-bold font-playfair mb-4 text-shadow">RÈM CỬA CAO CẤP<br>GIÁ TỐT NHẤT</h1>
                                            <p class="lead mb-4 d-none d-md-block">Mang đến vẻ đẹp sang trọng và hiện đại cho ngôi nhà của bạn.</p>
                                            <?php if ( anthome_is_woocommerce_activated() ) : ?>
                                                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-lg rounded-0 px-4 fw-bold shadow-sm">Mua ngay</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                             <div class="hero-slider position-relative" style="height: 369px; overflow: hidden;">
                                <div class="hero-slide h-100 w-100" style="background: url('<?php echo esc_url($hero_bg); ?>') no-repeat center center/cover;">
                                    <div class="hero-overlay" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)); position: absolute; inset: 0;"></div>
                                    <div class="hero-content position-absolute top-50 start-0 translate-middle-y p-5 text-white" data-aos="fade-right">
                                        <span class="d-block mb-2 text-uppercase fw-bold text-warning ls-1">Khuyến mãi mùa hè</span>
                                        <h1 class="display-4 fw-bold font-playfair mb-4 text-shadow">RÈM CỬA CAO CẤP<br>GIÁ TỐT NHẤT</h1>
                                        <p class="lead mb-4 d-none d-md-block">Mang đến vẻ đẹp sang trọng và hiện đại cho ngôi nhà của bạn.</p>
                                        <?php if ( anthome_is_woocommerce_activated() ) : ?>
                                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-lg rounded-0 px-4 fw-bold shadow-sm">Mua ngay</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                         <div class="hero-slider position-relative" style="height: 369px; overflow: hidden;">
                            <div class="hero-slide h-100 w-100" style="background: url('<?php echo esc_url($hero_bg); ?>') no-repeat center center/cover;">
                                <div class="hero-overlay" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)); position: absolute; inset: 0;"></div>
                                <div class="hero-content position-absolute top-50 start-0 translate-middle-y p-5 text-white" data-aos="fade-right">
                                    <span class="d-block mb-2 text-uppercase fw-bold text-warning ls-1">Khuyến mãi mùa hè</span>
                                    <h1 class="display-4 fw-bold font-playfair mb-4 text-shadow">RÈM CỬA CAO CẤP<br>GIÁ TỐT NHẤT</h1>
                                    <p class="lead mb-4 d-none d-md-block">Mang đến vẻ đẹp sang trọng và hiện đại cho ngôi nhà của bạn.</p>
                                    <?php if ( anthome_is_woocommerce_activated() ) : ?>
                                        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-lg rounded-0 px-4 fw-bold shadow-sm">Mua ngay</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories (Grid) -->
    <section class="container mb-5">
        <h3 class="fw-bold text-uppercase border-bottom pb-2 mb-4"><span class="text-primary border-bottom border-primary border-3 pb-2">Danh mục</span> nổi bật</h3>
        <div class="row g-3">
            <?php
            $cats = get_terms( array( 'taxonomy' => 'product_cat', 'number' => 8, 'parent' => 0, 'hide_empty' => false ) );
            if ( ! is_wp_error( $cats ) && ! empty( $cats ) ) {
                foreach ( $cats as $cat ) {
                    // Placeholder image if no thumbnail
                    $thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                    $img_url = $thumb_id ? wp_get_attachment_url( $thumb_id ) : 'https://placehold.co/300x200?text=' . $cat->name;
                    ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="text-decoration-none">
                            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                                <div class="ratio ratio-4x3">
                                    <img src="<?php echo esc_url( $img_url ); ?>" class="card-img-top object-fit-cover" alt="<?php echo  $cat->name ; ?>">
                                </div>
                                <div class="card-body text-center p-2">
                                    <h6 class="card-title text-dark small fw-bold mb-0 text-capitalize"><?php echo esc_html( $cat->name ); ?></h6>
                                    <small class="text-muted"><?php echo $cat->count; ?> sản phẩm</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>

    <!-- Product Block 1: Rèm Cửa (Example) -->
    <section class="container mb-5">
        <div class="d-flex justify-content-between align-items-center bg-light p-3 border mb-3 rounded-top">
            <h4 class="fw-bold text-uppercase m-0 text-primary">Sản phẩm mới</h4>
            <a href="<?php echo anthome_is_woocommerce_activated() ? esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) : '#'; ?>" class="text-decoration-none small fw-bold">Xem tất cả <i class="bi bi-chevron-right"></i></a>
        </div>
        <div class="row g-3">
            <?php
            if ( anthome_is_woocommerce_activated() ) {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $products = new WP_Query( $args );
                if ( $products->have_posts() ) {
                    while ( $products->have_posts() ) : $products->the_post();
                        // Pass thumbnail size to product template
                        // Options: 'thumbnail', 'medium', 'large', 'full', 
                        //          'woocommerce_thumbnail', 'woocommerce_single'
                        $thumbnail_size = 'full'; // You can change this
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                    wp_reset_postdata();
                }
            }
            ?>
        </div>
    </section>

    <!-- Product Block 2: Sản phẩm bán chạy -->
    <section class="container mb-5">
        <div class="d-flex justify-content-between align-items-center bg-light p-3 border mb-3 rounded-top">
            <h4 class="fw-bold text-uppercase m-0 text-primary">Sản phẩm bán chạy</h4>
            <a href="<?php echo anthome_is_woocommerce_activated() ? esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) : '#'; ?>" class="text-decoration-none small fw-bold">Xem tất cả <i class="bi bi-chevron-right"></i></a>
        </div>
        <div class="row g-3">
            <?php
            if ( anthome_is_woocommerce_activated() ) {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC'
                );
                $products = new WP_Query( $args );
                if ( $products->have_posts() ) {
                    while ( $products->have_posts() ) : $products->the_post();
                        $thumbnail_size = 'full';
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                    wp_reset_postdata();
                }
            }
            ?>
        </div>
    </section>

    <!-- Product Block 3: Sản phẩm theo danh mục 1 -->
    <?php
    if ( anthome_is_woocommerce_activated() ) {
        // Lấy danh mục đầu tiên
        $featured_cats = get_terms( array( 
            'taxonomy' => 'product_cat', 
            'number' => 1, 
            'parent' => 0,
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC'
        ) );
        
        if ( ! is_wp_error( $featured_cats ) && ! empty( $featured_cats ) ) {
            $cat_1 = $featured_cats[0];
            ?>
            <section class="container mb-5">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 border mb-3 rounded-top">
                    <h4 class="fw-bold text-uppercase m-0 text-primary">
                        <i class="bi bi-tag-fill me-2"></i><?php echo esc_html( $cat_1->name ); ?>
                    </h4>
                    <a href="<?php echo esc_url( get_term_link( $cat_1 ) ); ?>" class="text-decoration-none small fw-bold">Xem tất cả <i class="bi bi-chevron-right"></i></a>
                </div>
                <div class="row g-3">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $cat_1->term_id,
                            ),
                        ),
                    );
                    $products = new WP_Query( $args );
                    if ( $products->have_posts() ) {
                        while ( $products->have_posts() ) : $products->the_post();
                            $thumbnail_size = 'full';
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </section>
            <?php
        }
    }
    ?>

    <!-- Product Block 3: Sản phẩm theo danh mục 1 -->
    <?php
    if ( anthome_is_woocommerce_activated() ) {
        // Lấy danh mục đầu tiên
        $featured_cats = get_terms( array( 
            'taxonomy' => 'product_cat', 
            'number' => 2, 
            'parent' => 0,
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC'
        ) );
        
        if ( ! is_wp_error( $featured_cats ) && ! empty( $featured_cats ) ) {
            $cat_2 = $featured_cats[1];
            ?>
            <section class="container mb-5">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 border mb-3 rounded-top">
                    <h4 class="fw-bold text-uppercase m-0 text-primary">
                        <i class="bi bi-tag-fill me-2"></i><?php echo esc_html( $cat_2->name ); ?>
                    </h4>
                    <a href="<?php echo esc_url( get_term_link( $cat_2 ) ); ?>" class="text-decoration-none small fw-bold">Xem tất cả <i class="bi bi-chevron-right"></i></a>
                </div>
                <div class="row g-3">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $cat_2->term_id,
                            ),
                        ),
                    );
                    $products = new WP_Query( $args );
                    if ( $products->have_posts() ) {
                        while ( $products->have_posts() ) : $products->the_post();
                            $thumbnail_size = 'full';
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </section>
            <?php
        }
    }
    ?>

    <!-- Banner Middle -->
    <section class="container mb-5">
        <div class="row">
            <div class="col-12">
                <img src="https://images.unsplash.com/photo-1615529182904-14819c35db37?auto=format&fit=crop&w=1200&q=80" alt="Banner" class="img-fluid w-100 rounded shadow-sm" style="max-height: 200px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Latest News -->
    <section class="container py-5 mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
            <h3 class="fw-bold font-playfair text-uppercase m-0"><span class="text-primary">Tin tức</span> - Tư vấn</h3>
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="text-decoration-none text-dark fw-bold small">Xem tin tức <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row g-4">
            <?php
            $blog_query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
            if ( $blog_query->have_posts() ) :
                while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    ?>
                    <div class="col-md-4">
                        <div class="card border h-100 shadow-sm">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="ratio ratio-16x9 d-block">
                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top object-fit-cover" alt="<?php the_title(); ?>">
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title fw-bold line-clamp-2"><a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a></h6>
                                <p class="card-text text-muted small line-clamp-3"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>

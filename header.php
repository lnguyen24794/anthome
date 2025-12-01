<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <!-- Top Bar -->
    <div class="top-bar bg-light py-1 border-bottom d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
             <div class="top-contact small text-muted">
                 <?php if ( anthome_get_option( 'address' ) ) : ?>
                     <span class="me-3"><i class="bi bi-geo-alt me-1"></i> <?php echo esc_html( anthome_get_option( 'address' ) ); ?></span>
                 <?php endif; ?>
                 <?php if ( anthome_get_option( 'phone' ) ) : ?>
                     <span class="me-3"><i class="bi bi-telephone me-1"></i> <?php echo esc_html( anthome_get_option( 'phone' ) ); ?></span>
                 <?php endif; ?>
                 <?php if ( anthome_get_option( 'email' ) ) : ?>
                     <span><i class="bi bi-envelope me-1"></i> <?php echo esc_html( anthome_get_option( 'email' ) ); ?></span>
                 <?php endif; ?>
             </div>
             <div class="top-social">
                 <?php if ( anthome_get_option( 'facebook_url' ) ) : ?>
                     <a href="<?php echo esc_url( anthome_get_option( 'facebook_url' ) ); ?>" class="text-muted me-2" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                 <?php endif; ?>
                 <?php if ( anthome_get_option( 'instagram_url' ) ) : ?>
                     <a href="<?php echo esc_url( anthome_get_option( 'instagram_url' ) ); ?>" class="text-muted me-2" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                 <?php endif; ?>
                 <?php if ( anthome_get_option( 'youtube_url' ) ) : ?>
                     <a href="<?php echo esc_url( anthome_get_option( 'youtube_url' ) ); ?>" class="text-muted" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
                 <?php endif; ?>
             </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header py-3 bg-white ">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-3 col-6">
                     <a class="navbar-brand fw-bold fs-3 text-uppercase" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php 
                        if ( has_custom_logo() ) { 
                            the_custom_logo(); 
                        } else { 
                            echo 'ANTHOME<span style="color: var(--text-color);">VN</span>.'; 
                        } 
                        ?>
                    </a>
                </div>
                
                <!-- Search Bar (Desktop) -->
                <div class="col-lg-5 d-none d-lg-block">
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <form action="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" 
                          method="get" 
                          class="d-flex header-search-form position-relative">
                        <div class="input-group">
                             <select class="form-select bg-light border-end-0 text-muted" 
                                     id="product-search-category"
                                     name="product_cat"
                                     style="max-width: 160px; font-size: 0.9rem;">
                                <option value="">Chọn danh mục ...</option>
                                <?php 
                                $cats = get_terms(array(
                                    'taxonomy' => 'product_cat', 
                                    'parent' => 0, 
                                    'hide_empty' => false
                                ));
                                if (!is_wp_error($cats)) {
                                    foreach($cats as $c) {
                                        echo '<option value="' . esc_attr($c->slug) . '">' . esc_html($c->name) . '</option>';
                                    }
                                }
                                ?>
                             </select>
                            <input type="search" 
                                   id="product-search-input"
                                   name="s" 
                                   class="form-control border-start-0" 
                                   placeholder="Tìm kiếm sản phẩm..."
                                   autocomplete="off">
                            <input type="hidden" name="post_type" value="product">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <!-- AJAX Results (auto-generated by product-search.js) -->
                    </form>
                    <?php else : ?>
                    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="s" class="form-control border-start-0" placeholder="Tìm kiếm...">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="col-lg-4 col-6 d-flex justify-content-end align-items-center gap-3">
                     <!-- Mobile Toggle -->
                     <button class="navbar-toggler d-lg-none border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <i class="bi bi-list fs-1 text-primary"></i>
                     </button>

                     <!-- <div class="d-none d-lg-flex align-items-center gap-2">
                        <div class="icon-box text-center">
                             <i class="bi bi-telephone-fill fs-3 text-primary"></i>
                        </div>
                        <div class="text-start" style="line-height: 1.2;">
                            <small class="d-block text-muted">Gọi đặt hàng</small>
                            <span class="fw-bold text-danger fs-6">028.3553.0534</span>
                        </div>
                     </div> -->
                     
                    <div class="d-none d-lg-flex align-items-center gap-2">
                       <div class="icon-box text-center">
                            <i class="bi bi-headset fs-3 text-primary"></i>
                       </div>
                       <div class="text-start" style="line-height: 1.2;">
                           <small class="d-block text-muted">Gọi tư vấn</small>
                           <span class="fw-bold text-danger fs-6"><?php echo esc_html( anthome_get_option( 'phone', '0908.719.379' ) ); ?></span>
                       </div>
                    </div>

                     <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                     <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="position-relative btn btn-light border-0 ms-2 text-primary">
                        <i class="bi bi-bag-fill fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                     </a>
                     <?php endif; ?>
                </div>
            </div>
            
            <!-- Search Mobile -->
            <div class="d-lg-none mt-3">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <form action="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" 
                      method="get" 
                      class="d-flex header-search-form position-relative">
                    <input type="search" 
                           id="product-search-input-mobile"
                           name="s" 
                           class="form-control" 
                           placeholder="Tìm kiếm sản phẩm..."
                           autocomplete="off">
                    <input type="hidden" name="post_type" value="product">
                    <button class="btn btn-primary ms-1" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <!-- AJAX Results -->
                </form>
                <?php else : ?>
                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="d-flex">
                    <input type="text" name="s" class="form-control" placeholder="Tìm kiếm...">
                    <button class="btn btn-primary ms-1" type="submit"><i class="bi bi-search"></i></button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <div class="header-nav bg-white d-none d-lg-block sticky-top-nav">
        <div class="container">
            <div class="row g-0">
                <!-- Vertical Menu Title -->
                <div class="col-lg-3 position-relative">
                    <div class="vertical-menu-header bg-primary text-white p-3 fw-bold text-uppercase d-flex justify-content-between align-items-center" style="cursor: pointer;">
                        <span><i class="bi bi-list me-2"></i> Danh mục sản phẩm</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    
                    <!-- Vertical Menu List (Absolute Overlay) -->
                    <!-- Show by default on Front Page, Hide on others (hover to show) -->
                    <div class="vertical-menu-wrapper position-absolute w-100 bg-white" style="z-index: 999; top: 100%; left: 0; min-height: 400px; display: <?php echo is_front_page() ? 'block' : 'none'; ?>;">
                         <?php get_template_part('template-parts/header/vertical-menu'); ?>
                    </div>
                </div>

                <!-- Primary Menu -->
                <div class="col-lg-9 ps-4 border">
                    <nav class="navbar navbar-expand-lg p-0 h-100">
                        <div class="container-fluid px-0">
                            <div class="collapse navbar-collapse">
                                <?php
                                if ( has_nav_menu( 'primary' ) ) {
                                    wp_nav_menu( array(
                                        'theme_location' => 'primary',
                                        'menu_class'     => 'navbar-nav',
                                        'container'      => false,
                                        'walker'         => new Anthome_Bootstrap_Navwalker(),
                                    ) );
                                }
                                ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header bg-white border-bottom">
            <a class=" offcanvas-title fw-bold text-uppercase text-decoration-none" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php 
                if ( has_custom_logo() ) { 
                    the_custom_logo(); 
                } else { 
                    echo 'ANTHOME<span style="color: var(--text-color);">VN</span>.'; 
                } 
                ?>
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="mobile-nav-content">
                
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'list-unstyled border-bottom pb-2 mb-2 px-3 pt-3',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>
        </div>
    </div>
</header>

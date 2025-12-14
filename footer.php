<?php
/**
 * The template for displaying the footer
 *
 * @package Anthome
 */
?>

<footer class="bg-dark text-white pt-5 pb-3 mt-5" style="border-top: 5px solid var(--primary-color);">
    <div class="container">
        <div class="row g-4">
            <!-- Col 1: Introduction -->
            <div class="col-lg-3 col-md-6 mb-2">
                <h5 class="text-uppercase fw-bold mb-3 border-bottom pb-2 d-inline-block border-secondary">Giới thiệu</h5>
                <p class="small text-white-50"><strong>Anthomevn</strong> là đơn vị chuyên cung cấp các sản phẩm rèm cửa đẹp và các phụ kiện trang trí nhà cửa, văn phòng hàng đầu hiện nay.</p>
                <div class="social-icons mt-3">
                    <?php if ( anthome_get_option( 'facebook_url' ) ) : ?>
                        <a href="<?php echo esc_url( anthome_get_option( 'facebook_url' ) ); ?>" class="btn btn-outline-light btn-sm rounded-square me-1" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if ( anthome_get_option( 'youtube_url' ) ) : ?>
                        <a href="<?php echo esc_url( anthome_get_option( 'youtube_url' ) ); ?>" class="btn btn-outline-light btn-sm rounded-square me-1" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
                    <?php endif; ?>
                    <?php if ( anthome_get_option( 'instagram_url' ) ) : ?>
                        <a href="<?php echo esc_url( anthome_get_option( 'instagram_url' ) ); ?>" class="btn btn-outline-light btn-sm rounded-square" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Col 2: Danh mục sản phẩm -->
            <div class="col-lg-3 col-md-6 mb-2">
                <h5 class="text-uppercase fw-bold mb-3 border-bottom pb-2 d-inline-block border-secondary">Liên hệ</h5>
                <ul class="list-unstyled small text-white-50">
                    <?php if ( anthome_get_option( 'address' ) ) : ?>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> <?php echo esc_html( anthome_get_option( 'address' ) ); ?></li>
                    <?php endif; ?>
                    <?php if ( anthome_get_option( 'phone' ) ) : ?>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> <?php echo esc_html( anthome_get_option( 'phone' ) ); ?></li>
                    <?php endif; ?>
                    <?php if ( anthome_get_option( 'email' ) ) : ?>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> <?php echo esc_html( anthome_get_option( 'email' ) ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- Col 3: Danh mục sản phẩm -->
            <div class="col-lg-3 col-md-6 mb-2">
                <h5 class="text-uppercase fw-bold mb-3 border-bottom pb-2 d-inline-block border-secondary">Danh mục sản phẩm</h5>
                <ul class="list-unstyled small text-white-50">
                   <?php
                   $cats = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => false ) );
                   if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
                       foreach ( $cats as $cat ) {
                           echo '<li class="mb-2"><a href="' . get_term_link( $cat ) . '" class="text-decoration-none text-white-50 text-capitalize">' . $cat->name . '</a></li>';
                       }
                   }
                   ?>
                </ul>
            </div>
            <!-- Col 4: Chính sách -->
            <div class="col-lg-3 col-md-6 mb-2">
                <h5 class="text-uppercase fw-bold mb-3 border-bottom pb-2 d-inline-block border-secondary">Chính sách</h5>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><a href="#" class="text-decoration-none text-white-50">Chính sách đổi trả</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-white-50">Chính sách bảo hành</a></li>
                </ul>
            </div>
        </div>
        
        <hr class="border-secondary opacity-25">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start small text-white-50">
                &copy; <?php echo date('Y'); ?> <strong>Thế Giới Rèm Cửa</strong>. All rights reserved.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <!-- Payment Icons or Tag Cloud -->
                <span class="small text-white-50">Thiết kế bởi Anthome Team</span>
            </div>
        </div>
    </div>
</footer>

<?php 
// Render Floating Contact
anthome_render_floating_contact();
wp_footer(); 
?>
</body>
</html>

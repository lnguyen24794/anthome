<?php
/**
 * Vertical Menu Content with Mega Menu Style
 */
$args = array(
    'taxonomy'     => 'product_cat',
    'parent'       => 0,
    'hide_empty'   => false,
    'orderby'      => 'name',
    'order'        => 'ASC',
);
$categories = get_terms( $args );

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
    <div class="vertical-menu bg-white border shadow-sm h-100 position-relative">
        <ul class="list-unstyled m-0 p-0">
            <?php foreach ( $categories as $category ) : 
                // Check children
                $child_args = array(
                    'taxonomy' => 'product_cat',
                    'parent'   => $category->term_id,
                    'hide_empty' => false
                );
                $child_cats = get_terms( $child_args );
                $has_children = ! empty( $child_cats );
            ?>
                <li class="vertical-menu-item position-static border-bottom"> <!-- position-static để submenu bung full chiều cao menu cha -->
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="d-flex justify-content-between align-items-center px-3 py-2 text-decoration-none text-dark transition-hover text-capitalize">
                        <span class="fw-medium">
                            <?php 
                            // Icon giả lập (có thể thay bằng logic lấy icon thật)
                            echo '<i class="bi bi-caret-right text-muted small me-2" style="font-size: 0.8rem;"></i>'; 
                            echo esc_html( $category->name ); 
                            ?>
                        </span>
                        <?php if ( $has_children ) : ?>
                            <i class="bi bi-chevron-right small text-muted" style="font-size: 0.7rem;"></i>
                        <?php endif; ?>
                    </a>

                    <!-- Submenu Overlay (Mega Menu style) -->
                    <div class="vertical-submenu bg-white shadow-lg border-start border-bottom">
                        <div class="row h-100 g-0">
                            <!-- Cột Danh Mục Con (70%) -->
                            <div class="col-md-8 p-4 border-end">
                                <h6 class="fw-bold text-uppercase border-bottom pb-2 mb-3 text-primary">
                                    <?php echo esc_html( $category->name ); ?>
                                </h6>
                                
                                <?php if ( $has_children ) : ?>
                                    <div class="row g-3">
                                        <?php foreach ( $child_cats as $child ) : ?>
                                            <div class="col-6 col-lg-4">
                                                <a href="<?php echo esc_url( get_term_link( $child ) ); ?>" class="fw-bold text-dark text-decoration-none d-block mb-1 text-capitalize">
                                                    <?php echo esc_html( $child->name ); ?>
                                                </a>
                                                <!-- Nếu có cháu (level 3) thì hiển thị ở đây -->
                                                <?php 
                                                $grand_child_args = array(
                                                    'taxonomy' => 'product_cat',
                                                    'parent'   => $child->term_id,
                                                    'number'   => 3,
                                                    'hide_empty' => false
                                                );
                                                $grand_childs = get_terms($grand_child_args);
                                                if (!empty($grand_childs)) {
                                                    echo '<ul class="list-unstyled small ps-2 border-start border-2 ms-1 mb-2">';
                                                    foreach ($grand_childs as $grand) {
                                                        echo '<li><a href="'.esc_url(get_term_link($grand)).'" class="text-muted text-decoration-none text-capitalize">'.esc_html($grand->name).'</a></li>';
                                                    }
                                                    echo '</ul>';
                                                }
                                                ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <p class="text-muted small">Đang cập nhật danh mục con...</p>
                                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="btn btn-sm btn-outline-primary rounded-0 mt-2">Xem tất cả sản phẩm</a>
                                <?php endif; ?>
                            </div>

                            <!-- Cột Sản Phẩm Nổi Bật / Banner (30%) -->
                            <div class="col-md-4 p-4 bg-light d-flex flex-column">
                                <h6 class="fw-bold text-uppercase border-bottom pb-2 mb-3 text-dark">Nổi bật</h6>
                                <?php
                                // Query 2 sản phẩm mới nhất của danh mục này
                                $product_args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 2,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'term_id',
                                            'terms' => $category->term_id,
                                        )
                                    )
                                );
                                $products = new WP_Query( $product_args );
                                
                                if ( $products->have_posts() ) {
                                    while ( $products->have_posts() ) : $products->the_post();
                                        global $product;
                                        ?>
                                        <div class="d-flex align-items-start mb-3 bg-white p-2 rounded shadow-sm border">
                                            <a href="<?php the_permalink(); ?>" class="flex-shrink-0">
                                                <?php echo $product->get_image( 'thumbnail', array( 'style' => 'width: 60px; height: 60px; object-fit: cover; border-radius: 4px;' ) ); ?>
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="mb-1" style="font-size: 0.85rem; line-height: 1.3;">
                                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark fw-bold text-capitalize"><?php the_title(); ?></a>
                                                </h6>
                                                <div class="small text-danger fw-bold"><?php echo $product->get_price_html(); ?></div>
                                            </div>
                                        </div>
                                        <?php
                                    endwhile;
                                    wp_reset_postdata();
                                } else {
                                    // Fallback Banner nếu không có sản phẩm
                                    echo '<div class="text-center text-muted py-5"><i class="bi bi-star fs-1 opacity-25"></i><br><small>Sản phẩm đang cập nhật</small></div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

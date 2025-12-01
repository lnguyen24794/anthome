<?php
/**
 * WooCommerce functions
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checks if WooCommerce is active
 */
if ( ! function_exists( 'anthome_is_woocommerce_activated' ) ) {
	function anthome_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' );
	}
}

/**
 * Remove default WooCommerce Wrapper
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'anthome_woocommerce_wrapper_before' ) ) {
	function anthome_woocommerce_wrapper_before() {
		?>
		<div class="container py-5">
			<div class="row">
				<div class="col-12">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'anthome_woocommerce_wrapper_before', 10 );

if ( ! function_exists( 'anthome_woocommerce_wrapper_after' ) ) {
	function anthome_woocommerce_wrapper_after() {
		?>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'anthome_woocommerce_wrapper_after', 10 );

/**
 * Configure WooCommerce image sizes
 */
add_action( 'after_setup_theme', 'anthome_woocommerce_image_dimensions', 20 );
function anthome_woocommerce_image_dimensions() {
	// Product catalog/loop image size
	$catalog = array(
		'width'  => 400,   // px
		'height' => 400,   // px
		'crop'   => 1      // hard crop
	);
	
	// Single product image size
	$single = array(
		'width'  => 600,   // px
		'height' => 600,   // px
		'crop'   => 1      // hard crop
	);
	
	// Product thumbnail size (for gallery)
	$thumbnail = array(
		'width'  => 100,   // px
		'height' => 100,   // px
		'crop'   => 1      // hard crop (0 = soft crop)
	);

	// Apply sizes
	update_option( 'woocommerce_thumbnail_image_width', $catalog['width'] );
	update_option( 'woocommerce_thumbnail_image_height', $catalog['height'] );
	update_option( 'woocommerce_thumbnail_cropping', $catalog['crop'] ? 'yes' : 'no' );
	
	update_option( 'woocommerce_single_image_width', $single['width'] );
	update_option( 'woocommerce_single_image_height', $single['height'] );
	
	update_option( 'woocommerce_gallery_thumbnail_image_width', $thumbnail['width'] );
	update_option( 'woocommerce_gallery_thumbnail_image_height', $thumbnail['height'] );
}

/**
 * Customize product loop thumbnail size
 * Filter allows changing size dynamically
 */
add_filter( 'woocommerce_gallery_thumbnail_size', 'anthome_woocommerce_thumbnail_size' );
function anthome_woocommerce_thumbnail_size( $size ) {
	// You can return: 'woocommerce_thumbnail', 'medium', 'large', 'full'
	// or array( width, height )
	return apply_filters( 'anthome_product_thumbnail_size', 'woocommerce_thumbnail' );
}

/**
 * Custom function to get product image with specific size
 * Usage: anthome_product_thumbnail( $product, 'medium' )
 */
if ( ! function_exists( 'anthome_product_thumbnail' ) ) {
	function anthome_product_thumbnail( $product = null, $size = 'woocommerce_thumbnail', $attr = array() ) {
		if ( ! $product ) {
			global $product;
		}
		
		if ( ! $product instanceof WC_Product ) {
			return '';
		}
		
		$image_id = $product->get_image_id();
		
		if ( $image_id ) {
			$image = wp_get_attachment_image( $image_id, $size, false, $attr );
		} else {
			$image = wc_placeholder_img( $size, $attr );
		}
		
		return $image;
	}
}

/**
 * Get product thumbnail URL
 * Usage: anthome_product_thumbnail_url( $product, 'medium' )
 */
if ( ! function_exists( 'anthome_product_thumbnail_url' ) ) {
	function anthome_product_thumbnail_url( $product = null, $size = 'woocommerce_thumbnail' ) {
		if ( ! $product ) {
			global $product;
		}
		
		if ( ! $product instanceof WC_Product ) {
			return '';
		}
		
		$image_id = $product->get_image_id();
		
		if ( $image_id ) {
			$image_url = wp_get_attachment_image_url( $image_id, $size );
		} else {
			$image_url = wc_placeholder_img_src( $size );
		}
		
		return $image_url;
	}
}

/**
 * Customize WooCommerce Breadcrumb
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'anthome_woocommerce_breadcrumb_defaults' );
function anthome_woocommerce_breadcrumb_defaults( $defaults ) {
	return array(
		'delimiter'   => '<i class="bi bi-chevron-right mx-2 text-muted small"></i>',
		'wrap_before' => '<nav aria-label="breadcrumb" class="woocommerce-breadcrumb-wrapper mb-4"><ol class="breadcrumb bg-light p-3 rounded-3 mb-0">',
		'wrap_after'  => '</ol></nav>',
		'before'      => '<li class="breadcrumb-item">',
		'after'       => '</li>',
		'home'        => '<i class="bi bi-house-door me-1"></i>' . _x( 'Trang chủ', 'breadcrumb', 'anthome' ),
	);
}

/**
 * Custom Breadcrumb Function for WooCommerce
 * Can be used as alternative to default breadcrumb
 */
if ( ! function_exists( 'anthome_custom_breadcrumb' ) ) {
	function anthome_custom_breadcrumb() {
		if ( ! is_front_page() ) {
			$home_text = '<i class="bi bi-house-door me-1"></i>Trang chủ';
			$delimiter = '<i class="bi bi-chevron-right mx-2 text-muted small"></i>';
			
			echo '<nav aria-label="breadcrumb" class="anthome-breadcrumb mb-4">';
			echo '<ol class="breadcrumb bg-light p-3 rounded-3 mb-0 shadow-sm">';
			
			// Home link
			echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url('/') ) . '" class="text-decoration-none text-primary fw-medium">' . $home_text . '</a></li>';
			
			// WooCommerce Shop page
			if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() || is_product() ) ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				$shop_page_url = get_permalink( $shop_page_id );
				
				if ( ! is_shop() ) {
					echo '<li class="breadcrumb-item"><a href="' . esc_url( $shop_page_url ) . '" class="text-decoration-none text-primary">Cửa hàng</a></li>';
				}
			}
			
			// Product Category
			if ( is_product_category() ) {
				$current_term = $GLOBALS['wp_query']->get_queried_object();
				
				// Parent categories
				if ( $current_term->parent ) {
					$parent_terms = array();
					$parent_id = $current_term->parent;
					
					while ( $parent_id ) {
						$parent = get_term( $parent_id, 'product_cat' );
						$parent_terms[] = $parent;
						$parent_id = $parent->parent;
					}
					
					$parent_terms = array_reverse( $parent_terms );
					
					foreach ( $parent_terms as $parent_term ) {
						echo '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $parent_term ) ) . '" class="text-decoration-none text-primary text-capitalize">' . esc_html( $parent_term->name ) . '</a></li>';
					}
				}
				
				// Current category
				if ( is_shop() ) {
					echo '<li class="breadcrumb-item active text-capitalize" aria-current="page"><strong>Cửa hàng</strong></li>';
				} else {
					echo '<li class="breadcrumb-item active text-capitalize" aria-current="page"><strong>' . esc_html( $current_term->name ) . '</strong></li>';
				}
			}
			
			// Product Tag
			elseif ( is_product_tag() ) {
				$current_term = $GLOBALS['wp_query']->get_queried_object();
				echo '<li class="breadcrumb-item active" aria-current="page"><i class="bi bi-tag me-1"></i><strong>' . esc_html( $current_term->name ) . '</strong></li>';
			}
			
			// Single Product
			elseif ( is_product() ) {
				global $post;
				$terms = get_the_terms( $post->ID, 'product_cat' );
				
				if ( $terms && ! is_wp_error( $terms ) ) {
					// Get the first category (or primary if set)
					$term = array_shift( $terms );
					
					// Show parent categories
					if ( $term->parent ) {
						$parent_terms = array();
						$parent_id = $term->parent;
						
						while ( $parent_id ) {
							$parent = get_term( $parent_id, 'product_cat' );
							$parent_terms[] = $parent;
							$parent_id = $parent->parent;
						}
						
						$parent_terms = array_reverse( $parent_terms );
						
						foreach ( $parent_terms as $parent_term ) {
							echo '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $parent_term ) ) . '" class="text-decoration-none text-primary text-capitalize">' . esc_html( $parent_term->name ) . '</a></li>';
						}
					}
					
					// Category link
					echo '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $term ) ) . '" class="text-decoration-none text-primary text-capitalize">' . esc_html( $term->name ) . '</a></li>';
				}
				
				// Product title
				echo '<li class="breadcrumb-item active" aria-current="page"><strong>' . esc_html( get_the_title() ) . '</strong></li>';
			}
			
			// Shop page
			elseif ( is_shop() ) {
				echo '<li class="breadcrumb-item active" aria-current="page"><strong>Cửa hàng</strong></li>';
			}
			
			// Search results
			elseif ( is_search() ) {
				echo '<li class="breadcrumb-item active" aria-current="page"><i class="bi bi-search me-1"></i><strong>Kết quả tìm kiếm: ' . esc_html( get_search_query() ) . '</strong></li>';
			}
			
			// Default page
			elseif ( is_page() ) {
				echo '<li class="breadcrumb-item active" aria-current="page"><strong>' . esc_html( get_the_title() ) . '</strong></li>';
			}
			
			// Single post
			elseif ( is_single() ) {
				$categories = get_the_category();
				if ( $categories ) {
					$category = $categories[0];
					echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="text-decoration-none text-primary">' . esc_html( $category->name ) . '</a></li>';
				}
				echo '<li class="breadcrumb-item active" aria-current="page"><strong>' . esc_html( get_the_title() ) . '</strong></li>';
			}
			
			// Category archive
			elseif ( is_category() ) {
				echo '<li class="breadcrumb-item active" aria-current="page"><strong>' . single_cat_title( '', false ) . '</strong></li>';
			}
			
			// Tag archive
			elseif ( is_tag() ) {
				echo '<li class="breadcrumb-item active" aria-current="page"><i class="bi bi-tag me-1"></i><strong>' . single_tag_title( '', false ) . '</strong></li>';
			}
			
			// Archive
			elseif ( is_archive() ) {
				echo '<li class="breadcrumb-item active" aria-current="page"><strong>' . get_the_archive_title() . '</strong></li>';
			}
			
			echo '</ol>';
			echo '</nav>';
		}
	}
}

/**
 * Remove default WooCommerce breadcrumb (optional)
 * Uncomment below to completely remove default breadcrumb
 */
// remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * ========================================
 * Customize WooCommerce Shop Loop Controls
 * ========================================
 * 
 * Structure & Priority:
 * 
 * MAIN WRAPPER (Priority 19 & 32):
 * - 19: Main wrapper start (w-100 d-flex justify-content-between)
 * - 32: Main wrapper end
 * 
 * LEFT GROUP (Priority 20-27):
 * - 20: Left wrapper start
 * - 25: View Mode Toggle (Grid/List)
 * - 26: Products Per Page Selector (12, 24, 36, 48)
 * - 27: Left wrapper end
 * 
 * RIGHT GROUP (Priority 28-31):
 * - 28: Right wrapper start
 * - 29: Result Count (Hiển thị X-Y trong Z sản phẩm)
 * - 30: Catalog Ordering (Sắp xếp dropdown)
 * - 31: Right wrapper end
 * 
 * Layout: |-- [Left Group] --------- [Right Group] --|
 *         |<------------ Full Width ---------------->|
 */

/**
 * ========================================
 * WooCommerce Pagination Customization
 * ========================================
 */

/**
 * Custom Pagination Args
 */
add_filter( 'woocommerce_pagination_args', 'anthome_woocommerce_pagination_args' );
function anthome_woocommerce_pagination_args( $args ) {
	$args['prev_text'] = '<i class="bi bi-chevron-left me-1"></i>' . __( 'Trước', 'anthome' );
	$args['next_text'] = __( 'Sau', 'anthome' ) . '<i class="bi bi-chevron-right ms-1"></i>';
	$args['type']      = 'list';
	$args['end_size']  = 2;
	$args['mid_size']  = 2;
	return $args;
}

/**
 * Main Controls Wrapper - Start
 * Full width container with flex to push right group to the right
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_controls_wrapper_start', 19 );
function anthome_controls_wrapper_start() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	echo '<div class="shop-controls-wrapper w-100 d-flex justify-content-between align-items-center flex-wrap gap-3">';
}

/**
 * Left Controls Group Wrapper - Start
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_left_controls_start', 20 );
function anthome_left_controls_start() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	echo '<div class="shop-controls-left d-flex align-items-center gap-2">';
}

/**
 * Left Controls Group Wrapper - End
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_left_controls_end', 27 );
function anthome_left_controls_end() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	echo '</div>';
}

/**
 * Right Controls Group Wrapper - Start
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_right_controls_start', 28 );
function anthome_right_controls_start() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	echo '<div class="shop-controls-right d-flex align-items-center gap-2">';
}

/**
 * Right Controls Group Wrapper - End
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_right_controls_end', 31 );
function anthome_right_controls_end() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	echo '</div>';
}

/**
 * Main Controls Wrapper - End
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_controls_wrapper_end', 32 );
function anthome_controls_wrapper_end() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	echo '</div>';
}

/**
 * Custom Result Count Text
 * Remove default and re-add with custom priority to group with ordering
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'anthome_woocommerce_result_count', 29 );

function anthome_woocommerce_result_count() {
	global $wp_query;
	
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	
	$total    = $wp_query->found_posts;
	$per_page = $wp_query->get( 'posts_per_page' );
	$current  = max( 1, $wp_query->get( 'paged', 1 ) );
	$first    = ( $per_page * $current ) - $per_page + 1;
	$last     = min( $total, $per_page * $current );
	
	if ( $total <= $per_page ) {
		$result = sprintf(
			'<div class="woocommerce-result-count text-muted small">Hiển thị <strong>%d</strong> sản phẩm</div>',
			$total
		);
	} else {
		$result = sprintf(
			'<div class="woocommerce-result-count text-muted small">Hiển thị <strong>%d-%d</strong> trong tổng số <strong>%d</strong> sản phẩm</div>',
			$first,
			$last,
			$total
		);
	}
	
	echo $result;
}

/**
 * Customize Catalog Ordering (Sort by dropdown)
 */
add_filter( 'woocommerce_catalog_orderby', 'anthome_woocommerce_catalog_orderby' );
function anthome_woocommerce_catalog_orderby( $sortby ) {
	$sortby = array(
		'menu_order' => __( 'Mặc định', 'anthome' ),
		'popularity' => __( 'Phổ biến', 'anthome' ),
		'rating'     => __( 'Đánh giá cao', 'anthome' ),
		'date'       => __( 'Mới nhất', 'anthome' ),
		'price'      => __( 'Giá: Thấp đến cao', 'anthome' ),
		'price-desc' => __( 'Giá: Cao đến thấp', 'anthome' ),
	);
	return $sortby;
}



/**
 * Custom Products Per Page Options
 */
add_filter( 'loop_shop_per_page', 'anthome_products_per_page', 20 );
function anthome_products_per_page( $cols ) {
	// Allow user to set via URL parameter ?products_per_page=12
	if ( isset( $_GET['products_per_page'] ) ) {
		return intval( $_GET['products_per_page'] );
	}
	return 12; // Default products per page
}

/**
 * Add View Mode Toggle (Grid/List)
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_view_mode_toggle', 25 );
function anthome_view_mode_toggle() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	
	$view_mode = isset( $_COOKIE['anthome_view_mode'] ) ? $_COOKIE['anthome_view_mode'] : 'grid';
	?>
	<div class="woocommerce-view-mode">
		<div class="btn-group btn-group-sm" role="group" aria-label="View mode">
			<button type="button" class="btn btn-outline-secondary <?php echo ( $view_mode === 'grid' ) ? 'active' : ''; ?>" data-view="grid" title="Grid View">
				<i class="bi bi-grid-3x3-gap"></i>
			</button>
			<button type="button" class="btn btn-outline-secondary <?php echo ( $view_mode === 'list' ) ? 'active' : ''; ?>" data-view="list" title="List View">
				<i class="bi bi-list-ul"></i>
			</button>
		</div>
	</div>
	
	<script>
	jQuery(document).ready(function($) {
		$('.woocommerce-view-mode button').on('click', function() {
			var view = $(this).data('view');
			document.cookie = 'anthome_view_mode=' + view + '; path=/; max-age=31536000';
			location.reload();
		});
	});
	</script>
	<?php
}

/**
 * Add Products Per Page Selector
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_products_per_page_selector', 26 );
function anthome_products_per_page_selector() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	
	$per_page_options = array( 12, 24, 36, 48 );
	$current = isset( $_GET['products_per_page'] ) ? intval( $_GET['products_per_page'] ) : 12;
	
	// Get current URL without products_per_page param
	$current_url = remove_query_arg( 'products_per_page' );
	
	?>
	<div class="woocommerce-products-per-page">
		<label class="small text-muted me-2">Hiển thị:</label>
		<select class="form-select form-select-sm d-inline-block w-auto" onchange="window.location.href=this.value">
			<?php foreach ( $per_page_options as $option ) : ?>
				<option value="<?php echo esc_url( add_query_arg( 'products_per_page', $option, $current_url ) ); ?>" <?php selected( $current, $option ); ?>>
					<?php echo $option; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php
}

/**
 * Customize No Products Found Message
 */
add_action( 'woocommerce_no_products_found', 'anthome_no_products_found', 10 );
function anthome_no_products_found() {
	?>
	<div class="woocommerce-no-products-found text-center py-5">
		<div class="mb-4">
			<i class="bi bi-inbox display-1 text-muted"></i>
		</div>
		<h3 class="h4 fw-bold mb-3">Không tìm thấy sản phẩm</h3>
		<p class="text-muted mb-4">Xin lỗi, chúng tôi không tìm thấy sản phẩm nào phù hợp với tiêu chí của bạn.</p>
		<div class="d-flex gap-2 justify-content-center flex-wrap">
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary text-white">
				<i class="bi bi-shop me-2"></i>Xem tất cả sản phẩm
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline-secondary">
				<i class="bi bi-house-door me-2"></i>Về trang chủ
			</a>
		</div>
	</div>
	<?php
}

// Remove default no products message
remove_action( 'woocommerce_no_products_found', 'wc_no_products_found' );

/**
 * ========================================
 * AJAX Price Filter
 * ========================================
 */

/**
 * Enqueue Price Filter Scripts
 */
add_action( 'wp_enqueue_scripts', 'anthome_enqueue_price_filter_scripts' );
function anthome_enqueue_price_filter_scripts() {
	// Only load on shop pages
	if ( is_shop() || is_product_category() || is_product_taxonomy() ) {
		wp_enqueue_script(
			'anthome-price-filter',
			get_template_directory_uri() . '/assets/js/price-filter.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		
		// Pass AJAX URL to script
		wp_localize_script( 'anthome-price-filter', 'anthomeAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'anthome_price_filter' )
		));
	}
}

/**
 * Filter Products by Price
 */
add_action( 'pre_get_posts', 'anthome_filter_products_by_price' );
function anthome_filter_products_by_price( $query ) {
	// Only on main query, shop pages, not admin
	if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() || is_product_taxonomy() ) ) {
		
		$min_price = isset( $_GET['min_price'] ) ? floatval( $_GET['min_price'] ) : 0;
		$max_price = isset( $_GET['max_price'] ) ? floatval( $_GET['max_price'] ) : PHP_FLOAT_MAX;
		
		if ( $min_price > 0 || $max_price < PHP_FLOAT_MAX ) {
			$meta_query = $query->get( 'meta_query' ) ?: array();
			
			$meta_query[] = array(
				'key' => '_price',
				'value' => array( $min_price, $max_price ),
				'compare' => 'BETWEEN',
				'type' => 'NUMERIC'
			);
			
			$query->set( 'meta_query', $meta_query );
		}
	}
}

/**
 * ========================================
 * Single Product Page Customization
 * ========================================
 */

/**
 * Remove default upsell and related products if needed
 * Uncomment the lines below to remove sections
 */
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Customize related products args
 */
add_filter( 'woocommerce_output_related_products_args', 'anthome_related_products_args' );
function anthome_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // Show 4 products
	$args['columns'] = 4;
	return $args;
}

/**
 * Customize upsell products args
 */
add_filter( 'woocommerce_upsell_display_args', 'anthome_upsell_products_args' );
function anthome_upsell_products_args( $args ) {
	$args['posts_per_page'] = 4; // Show 4 products
	$args['columns'] = 4;
	return $args;
}

/**
 * Customize product tabs
 */
add_filter( 'woocommerce_product_tabs', 'anthome_custom_product_tabs', 98 );
function anthome_custom_product_tabs( $tabs ) {
	
	// Remove tabs if needed
	// unset( $tabs['description'] );       // Remove description tab
	// unset( $tabs['reviews'] );           // Remove reviews tab
	// unset( $tabs['additional_information'] ); // Remove additional info tab
	
	// Rename tabs
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = 'Mô tả sản phẩm';
		$tabs['description']['priority'] = 10;
	}
	
	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['title'] = 'Đánh giá';
		$tabs['reviews']['priority'] = 20;
	}
	
	if ( isset( $tabs['additional_information'] ) ) {
		$tabs['additional_information']['title'] = 'Thông tin thêm';
		$tabs['additional_information']['priority'] = 30;
	}
	
	return $tabs;
}

/**
 * Display Active Filters
 */
add_action( 'woocommerce_before_shop_loop', 'anthome_display_active_filters', 15 );
function anthome_display_active_filters() {
	if ( ! woocommerce_products_will_display() ) {
		return;
	}
	
	$active_filters = array();
	
	// Price filter
	if ( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ) {
		$min = isset( $_GET['min_price'] ) ? number_format( floatval( $_GET['min_price'] ), 0, ',', '.' ) : '0';
		$max = isset( $_GET['max_price'] ) ? number_format( floatval( $_GET['max_price'] ), 0, ',', '.' ) : '5.000.000';
		
		$remove_url = remove_query_arg( array( 'min_price', 'max_price' ) );
		
		$active_filters[] = array(
			'label' => sprintf( 'Giá: %s₫ - %s₫', $min, $max ),
			'url' => $remove_url
		);
	}
	
	if ( ! empty( $active_filters ) ) {
		?>
		<div class="active-filters mb-3 w-100">
			<div class="d-flex flex-wrap gap-2 align-items-center">
				<span class="text-muted small fw-bold">Đang lọc:</span>
				<?php foreach ( $active_filters as $filter ) : ?>
					<a href="<?php echo esc_url( $filter['url'] ); ?>" 
					   class="badge bg-primary text-white text-decoration-none d-inline-flex align-items-center gap-1">
						<?php echo esc_html( $filter['label'] ); ?>
						<i class="bi bi-x-circle"></i>
					</a>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( remove_query_arg( array( 'min_price', 'max_price', 'orderby' ) ) ); ?>" 
				   class="badge bg-secondary text-white text-decoration-none">
					<i class="bi bi-x-lg me-1"></i>Xóa tất cả
				</a>
			</div>
		</div>
		<?php
	}
}

/**
 * ============================================================================
 * SINGLE PRODUCT PAGE CUSTOMIZATIONS
 * ============================================================================
 */

/**
 * Customize single product gallery area (woocommerce_before_single_product_summary)
 * 
 * Default WooCommerce hooks on this action:
 * @hooked woocommerce_show_product_sale_flash - 10
 * @hooked woocommerce_show_product_images - 20
 */

// Example: Add custom badge above gallery
// add_action( 'woocommerce_before_single_product_summary', 'anthome_product_custom_badge', 5 );
// function anthome_product_custom_badge() {
//     global $product;
//     if ( $product->is_featured() ) {
//         echo '<div class="featured-badge mb-3"><span class="badge bg-warning">Nổi bật</span></div>';
//     }
// }

// Example: Add custom trust badges below gallery
add_action( 'woocommerce_before_single_product_summary', 'anthome_product_trust_badges', 25 );
function anthome_product_trust_badges() {
	?>
	<div class="trust-badges mt-3 d-flex flex-wrap gap-2">
		<div class="badge bg-light text-dark border">
			<i class="bi bi-shield-check text-success me-1"></i>
			Hàng chính hãng
		</div>
		<div class="badge bg-light text-dark border">
			<i class="bi bi-truck text-primary me-1"></i>
			Giao hàng nhanh
		</div>
		<div class="badge bg-light text-dark border">
			<i class="bi bi-arrow-return-left text-info me-1"></i>
			Đổi trả 7 ngày
		</div>
	</div>
	<?php
}

/**
 * Customize single product info area (woocommerce_single_product_summary)
 * 
 * Default WooCommerce hooks on this action:
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 * @hooked WC_Structured_Data::generate_product_data() - 60
 */

// Reorder: Move rating to after price
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );

// Add custom stock status with icon
add_action( 'woocommerce_single_product_summary', 'anthome_custom_stock_status', 12 );
function anthome_custom_stock_status() {
	global $product;
	
	$stock_status = $product->get_stock_status();
	$stock_quantity = $product->get_stock_quantity();
	
	?>
	<div class="custom-stock-status mb-3">
		<?php if ( $stock_status === 'instock' ) : ?>
			<span class="badge bg-success-subtle text-success border border-success">
				<i class="bi bi-check-circle me-1"></i>
				<?php if ( $stock_quantity ) : ?>
					Còn <?php echo esc_html( $stock_quantity ); ?> sản phẩm
				<?php else : ?>
					Còn hàng
				<?php endif; ?>
			</span>
		<?php elseif ( $stock_status === 'outofstock' ) : ?>
			<span class="badge bg-danger-subtle text-danger border border-danger">
				<i class="bi bi-x-circle me-1"></i>
				Hết hàng
			</span>
		<?php elseif ( $stock_status === 'onbackorder' ) : ?>
			<span class="badge bg-warning-subtle text-warning border border-warning">
				<i class="bi bi-clock me-1"></i>
				Đặt trước
			</span>
		<?php endif; ?>
	</div>
	<?php
}

// Add product highlights before add to cart
add_action( 'woocommerce_single_product_summary', 'anthome_product_highlights', 25 );
function anthome_product_highlights() {
	global $product;
	
	// You can add custom fields or logic here
	$highlights = array(
		'✓ Chất lượng cao cấp',
		'✓ Bảo hành chính hãng',
		'✓ Giao hàng toàn quốc',
	);
	
	if ( ! empty( $highlights ) ) {
		?>
		<div class="product-highlights mb-3">
			<ul class="list-unstyled small text-success mb-0">
				<?php foreach ( $highlights as $highlight ) : ?>
					<li class="mb-1"><?php echo esc_html( $highlight ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

// Add custom payment methods icons after meta
add_action( 'woocommerce_single_product_summary', 'anthome_payment_methods', 45 );
function anthome_payment_methods() {
	?>
	<div class="payment-methods mt-3 pt-3 border-top">
		<div class="small text-muted mb-2">Phương thức thanh toán:</div>
		<div class="d-flex gap-2 flex-wrap">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/payment/visa.svg" 
				 alt="Visa" class="payment-icon" style="height: 24px;" onerror="this.style.display='none'">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/payment/mastercard.svg" 
				 alt="Mastercard" class="payment-icon" style="height: 24px;" onerror="this.style.display='none'">
			<span class="badge bg-light text-dark border">
				<i class="bi bi-credit-card me-1"></i>COD
			</span>
			<span class="badge bg-light text-dark border">
				<i class="bi bi-bank me-1"></i>Chuyển khoản
			</span>
		</div>
	</div>
	<?php
}

/**
 * Customize tabs and related products area (woocommerce_after_single_product_summary)
 * 
 * Default WooCommerce hooks on this action:
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */

// Modify product tabs
add_filter( 'woocommerce_product_tabs', 'anthome_custom_product_tabs_single', 98 );
function anthome_custom_product_tabs_single( $tabs ) {
	// Rename tabs
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = 'Mô tả sản phẩm';
	}
	
	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['title'] = 'Đánh giá';
	}
	
	if ( isset( $tabs['additional_information'] ) ) {
		$tabs['additional_information']['title'] = 'Thông tin bổ sung';
	}
	
	// Add custom tab - Shipping Info
	$tabs['shipping_info'] = array(
		'title'    => 'Vận chuyển & Đổi trả',
		'priority' => 25,
		'callback' => 'anthome_shipping_info_tab_content',
	);
	
	return $tabs;
}

function anthome_shipping_info_tab_content() {
	?>
	<div class="shipping-info-content">
		<h3>Chính sách vận chuyển</h3>
		<ul>
			<li><strong>Miễn phí vận chuyển</strong> cho đơn hàng từ 500.000đ trong nội thành TP.HCM</li>
			<li><strong>Giao hàng nhanh</strong> trong 1-2 ngày với đơn hàng nội thành</li>
			<li><strong>Giao hàng toàn quốc</strong> 3-5 ngày làm việc</li>
		</ul>
		
		<h3 class="mt-4">Chính sách đổi trả</h3>
		<ul>
			<li><strong>Đổi trả trong 7 ngày</strong> nếu sản phẩm lỗi hoặc không đúng mô tả</li>
			<li><strong>Hoàn tiền 100%</strong> nếu sản phẩm bị lỗi từ nhà sản xuất</li>
			<li><strong>Hỗ trợ đổi size/màu</strong> miễn phí trong 3 ngày đầu</li>
		</ul>
	</div>
	<?php
}

// Add custom section before related products
add_action( 'woocommerce_after_single_product_summary', 'anthome_product_guarantee_section', 18 );
function anthome_product_guarantee_section() {
	?>
	<div class="product-guarantee-section py-5 mb-5 bg-light rounded">
		<div class="container">
			<h3 class="text-center mb-4">Cam kết của chúng tôi</h3>
			<div class="row g-4">
				<div class="col-md-3 col-6 text-center">
					<i class="bi bi-shield-check display-4 text-primary mb-3"></i>
					<h5 class="h6">Hàng chính hãng</h5>
					<p class="small text-muted mb-0">100% hàng nhập khẩu</p>
				</div>
				<div class="col-md-3 col-6 text-center">
					<i class="bi bi-truck display-4 text-success mb-3"></i>
					<h5 class="h6">Giao hàng nhanh</h5>
					<p class="small text-muted mb-0">1-2 ngày nội thành</p>
				</div>
				<div class="col-md-3 col-6 text-center">
					<i class="bi bi-arrow-return-left display-4 text-info mb-3"></i>
					<h5 class="h6">Đổi trả dễ dàng</h5>
					<p class="small text-muted mb-0">Trong vòng 7 ngày</p>
				</div>
				<div class="col-md-3 col-6 text-center">
					<i class="bi bi-headset display-4 text-warning mb-3"></i>
					<h5 class="h6">Hỗ trợ 24/7</h5>
					<p class="small text-muted mb-0">Tư vấn nhiệt tình</p>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * After everything (woocommerce_after_single_product)
 * 
 * Add custom content after the product
 */

// Add recently viewed products
add_action( 'woocommerce_after_single_product', 'anthome_recently_viewed_products', 10 );
function anthome_recently_viewed_products() {
	// Track recently viewed products
	$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) 
		? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) 
		: array();
	
	$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
	
	// Remove current product from the list
	$current_product_id = get_the_ID();
	$viewed_products = array_diff( $viewed_products, array( $current_product_id ) );
	
	if ( empty( $viewed_products ) ) {
		return;
	}
	
	// Show only 4 products
	$viewed_products = array_slice( $viewed_products, 0, 4 );
	
	?>
	<div class="recently-viewed-products py-5">
		<div class="container">
			<h3 class="h4 mb-4">Sản phẩm đã xem</h3>
			<div class="row g-4">
				<?php
				$args = array(
					'post_type'      => 'product',
					'posts_per_page' => 4,
					'post__in'       => $viewed_products,
					'orderby'        => 'post__in',
				);
				
				$query = new WP_Query( $args );
				
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						wc_get_template_part( 'content', 'product' );
					}
					wp_reset_postdata();
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * ============================================================================
 * PRODUCT SEARCH CUSTOMIZATIONS
 * ============================================================================
 */

/**
 * Enhanced product search with AJAX
 */
add_action( 'wp_enqueue_scripts', 'anthome_enqueue_search_scripts' );
function anthome_enqueue_search_scripts() {
	wp_enqueue_script(
		'anthome-product-search',
		get_template_directory_uri() . '/assets/js/product-search.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);
	
	wp_localize_script(
		'anthome-product-search',
		'anthomeSearch',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'anthome_search_nonce' ),
		)
	);
}

/**
 * AJAX product search handler
 */
add_action( 'wp_ajax_anthome_product_search', 'anthome_ajax_product_search' );
add_action( 'wp_ajax_nopriv_anthome_product_search', 'anthome_ajax_product_search' );
function anthome_ajax_product_search() {
	check_ajax_referer( 'anthome_search_nonce', 'nonce' );
	
	$search_term = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
	$category = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';
	
	if ( empty( $search_term ) ) {
		wp_send_json_error( array( 'message' => 'Vui lòng nhập từ khóa tìm kiếm' ) );
	}
	
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 10,
		's'              => $search_term,
		'post_status'    => 'publish',
	);
	
	// Add category filter if specified
	if ( ! empty( $category ) && $category !== 'all' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}
	
	$query = new WP_Query( $args );
	
	$results = array();
	
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$product = wc_get_product( get_the_ID() );
			
			$results[] = array(
				'id'          => get_the_ID(),
				'title'       => get_the_title(),
				'url'         => get_permalink(),
				'price'       => $product->get_price_html(),
				'image'       => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
				'stock_status' => $product->get_stock_status(),
			);
		}
		wp_reset_postdata();
		
		wp_send_json_success( array(
			'results' => $results,
			'count'   => $query->found_posts,
		) );
	} else {
		wp_send_json_error( array(
			'message' => 'Không tìm thấy sản phẩm nào',
			'results' => array(),
		) );
	}
}

/**
 * ============================================================================
 * CART PAGE CUSTOMIZATIONS
 * ============================================================================
 */

/**
 * Add continue shopping button to cart
 */
add_action( 'woocommerce_cart_actions', 'anthome_continue_shopping_button' );
function anthome_continue_shopping_button() {
	$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
	echo '<a href="' . esc_url( $shop_url ) . '" class="btn btn-outline-primary me-2">';
	echo '<i class="bi bi-arrow-left me-2"></i>Tiếp tục mua hàng';
	echo '</a>';
}

/**
 * Add estimated delivery info to cart
 */
add_action( 'woocommerce_cart_totals_after_order_total', 'anthome_cart_estimated_delivery' );
function anthome_cart_estimated_delivery() {
	?>
	<tr class="estimated-delivery">
		<th><?php esc_html_e( 'Dự kiến giao hàng:', 'anthome' ); ?></th>
		<td data-title="<?php esc_attr_e( 'Estimated Delivery', 'anthome' ); ?>">
			<span class="text-success">
				<i class="bi bi-truck me-1"></i>
				<?php 
				$delivery_date = date( 'd/m/Y', strtotime( '+3 days' ) );
				echo sprintf( esc_html__( '1-3 ngày làm việc', 'anthome' ) );
				?>
			</span>
		</td>
	</tr>
	<?php
}

/**
 * Add trust badges to cart
 */
add_action( 'woocommerce_after_cart', 'anthome_cart_trust_badges' );
function anthome_cart_trust_badges() {
	?>
	<div class="cart-trust-badges mt-5 p-4 bg-light rounded">
		<div class="row g-3 text-center">
			<div class="col-md-3 col-6">
				<i class="bi bi-shield-check fs-1 text-success mb-2 d-block"></i>
				<h6 class="small fw-bold">An toàn bảo mật</h6>
				<p class="small text-muted mb-0">Thanh toán an toàn</p>
			</div>
			<div class="col-md-3 col-6">
				<i class="bi bi-truck fs-1 text-primary mb-2 d-block"></i>
				<h6 class="small fw-bold">Giao hàng nhanh</h6>
				<p class="small text-muted mb-0">1-3 ngày làm việc</p>
			</div>
			<div class="col-md-3 col-6">
				<i class="bi bi-arrow-return-left fs-1 text-info mb-2 d-block"></i>
				<h6 class="small fw-bold">Đổi trả dễ dàng</h6>
				<p class="small text-muted mb-0">Trong 7 ngày</p>
			</div>
		<div class="col-md-3 col-6">
			<i class="bi bi-headset fs-1 text-warning mb-2 d-block"></i>
			<h6 class="small fw-bold">Hỗ trợ 24/7</h6>
			<p class="small text-muted mb-0"><?php echo esc_html( anthome_get_option( 'phone', '0908.719.379' ) ); ?></p>
		</div>
		</div>
	</div>
	<?php
}

/**
 * ============================================================================
 * CHECKOUT PAGE CUSTOMIZATIONS
 * ============================================================================
 */

/**
 * Add custom checkout fields
 */
add_filter( 'woocommerce_checkout_fields', 'anthome_custom_checkout_fields' );
function anthome_custom_checkout_fields( $fields ) {
	// Reorder fields
	$fields['billing']['billing_first_name']['priority'] = 10;
	$fields['billing']['billing_last_name']['priority'] = 20;
	$fields['billing']['billing_phone']['priority'] = 30;
	$fields['billing']['billing_email']['priority'] = 40;
	$fields['billing']['billing_address_1']['priority'] = 60;
	$fields['billing']['billing_city']['priority'] = 70;
	$fields['billing']['billing_state']['priority'] = 80;
	$fields['billing']['billing_postcode']['priority'] = 90;
	
	// Add delivery note field
	$fields['order']['order_comments']['placeholder'] = 'Ghi chú về đơn hàng, ví dụ: giao hàng giờ hành chính...';
	$fields['order']['order_comments']['label'] = 'Ghi chú đơn hàng (tùy chọn)';
	
	// Make phone required
	$fields['billing']['billing_phone']['required'] = true;
	
	// Translate labels
	$fields['billing']['billing_first_name']['label'] = 'Họ';
	$fields['billing']['billing_last_name']['label'] = 'Tên';
	$fields['billing']['billing_phone']['label'] = 'Số điện thoại';
	$fields['billing']['billing_email']['label'] = 'Email';
	$fields['billing']['billing_address_1']['label'] = 'Địa chỉ';
	$fields['billing']['billing_city']['label'] = 'Thành phố';
	$fields['billing']['billing_state']['label'] = 'Tỉnh/Thành';
	$fields['billing']['billing_postcode']['label'] = 'Mã bưu điện';
	
	return $fields;
}

/**
 * Add payment method icons
 */
add_action( 'woocommerce_review_order_before_payment', 'anthome_payment_icons' );
function anthome_payment_icons() {
	?>
	<div class="payment-icons mb-3 p-3 bg-white border rounded">
		<p class="small text-muted mb-2">Phương thức thanh toán được chấp nhận:</p>
		<div class="d-flex gap-2 flex-wrap">
			<span class="badge bg-light text-dark border px-3 py-2">
				<i class="bi bi-credit-card me-1"></i>COD
			</span>
			<span class="badge bg-light text-dark border px-3 py-2">
				<i class="bi bi-bank me-1"></i>Chuyển khoản
			</span>
			<span class="badge bg-light text-dark border px-3 py-2">
				<i class="bi bi-wallet me-1"></i>Ví điện tử
			</span>
		</div>
	</div>
	<?php
}

/**
 * Add order summary collapsible on mobile
 */
add_action( 'woocommerce_checkout_before_customer_details', 'anthome_mobile_order_summary' );
function anthome_mobile_order_summary() {
	?>
	<div class="mobile-order-summary d-lg-none mb-4">
		<button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#mobileOrderSummary">
			<i class="bi bi-receipt me-2"></i>
			Xem tóm tắt đơn hàng
			<span class="float-end"><?php echo WC()->cart->get_total(); ?></span>
		</button>
		<div class="collapse mt-3" id="mobileOrderSummary">
			<div class="card border">
				<div class="card-body">
					<?php woocommerce_order_review(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * ============================================
 * THANK YOU PAGE CUSTOMIZATION
 * ============================================
 */

/**
 * Customize Thank You Page - Add custom styling to order details table
 */
add_action( 'wp_enqueue_scripts', 'anthome_thankyou_page_styles' );
function anthome_thankyou_page_styles() {
	if ( is_wc_endpoint_url( 'order-received' ) ) {
		wp_add_inline_style( 'anthome-main-style', '
			/* Thank You Page Styling */
			.woocommerce-order {
				margin: 3rem 0;
			}
			
			.woocommerce-order .woocommerce-order-overview {
				background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
				border-radius: 0.75rem;
				padding: 0;
				margin-bottom: 3rem;
				box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08);
				overflow: hidden;
			}
			
			.woocommerce-order .woocommerce-order-overview li {
				padding: 1.5rem 2rem;
				border-right: 1px solid rgba(0,0,0,0.05);
				margin: 0;
			}
			
			.woocommerce-order .woocommerce-order-overview li:last-child {
				border-right: none;
			}
			
			.woocommerce-order .woocommerce-order-overview li strong {
				display: block;
				font-size: 1.25rem;
				color: var(--bs-primary);
				margin-top: 0.5rem;
			}
			
			/* Order Details Table */
			.woocommerce-order-details {
				background: #fff;
				border-radius: 0.75rem;
				box-shadow: 0 0.25rem 1rem rgba(0,0,0,0.05);
				overflow: hidden;
				margin-bottom: 2rem;
			}
			
			.woocommerce-order-details .woocommerce-table {
				margin: 0;
				border: none;
			}
			
			.woocommerce-order-details thead {
				background: var(--bs-primary);
				color: #fff;
			}
			
			.woocommerce-order-details thead th {
				border: none;
				padding: 1.25rem 1.5rem;
				font-weight: 600;
				text-transform: uppercase;
				font-size: 0.875rem;
				letter-spacing: 0.5px;
			}
			
			.woocommerce-order-details tbody td,
			.woocommerce-order-details tbody th {
				padding: 1.25rem 1.5rem;
				border-bottom: 1px solid #f1f1f1;
				vertical-align: middle;
			}
			
			.woocommerce-order-details tbody tr:last-child td {
				border-bottom: none;
			}
			
			.woocommerce-order-details tfoot {
				background: #f8f9fa;
			}
			
			.woocommerce-order-details tfoot th,
			.woocommerce-order-details tfoot td {
				padding: 1rem 1.5rem;
				border-top: 2px solid #dee2e6;
				font-weight: 600;
			}
			
			.woocommerce-order-details tfoot tr:last-child {
				background: #fff;
			}
			
			.woocommerce-order-details tfoot tr:last-child th,
			.woocommerce-order-details tfoot tr:last-child td {
				border-top: 3px solid var(--bs-primary);
				font-size: 1.125rem;
				color: var(--bs-primary);
			}
			
			/* Customer Details */
			.woocommerce-customer-details {
				margin-top: 2rem;
			}
			
			.woocommerce-column {
				background: #fff;
				border-radius: 0.5rem;
				padding: 2rem;
				box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.05);
			}
			
			.woocommerce-column h2 {
				font-size: 1.25rem;
				font-weight: 600;
				margin-bottom: 1rem;
				color: #333;
				border-bottom: 2px solid var(--bs-primary);
				padding-bottom: 0.5rem;
			}
			
			.woocommerce-column address {
				line-height: 1.8;
				color: #666;
			}
			
			/* Responsive */
			@media (max-width: 767.98px) {
				.woocommerce-order .woocommerce-order-overview {
					flex-direction: column !important;
				}
				
				.woocommerce-order .woocommerce-order-overview li {
					border-right: none;
					border-bottom: 1px solid rgba(0,0,0,0.05);
				}
				
				.woocommerce-order .woocommerce-order-overview li:last-child {
					border-bottom: none;
				}
			}
		' );
	}
}

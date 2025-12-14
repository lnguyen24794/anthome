<?php
/**
 * Theme Options Page
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Theme Options Page to Admin Menu
 */
function anthome_add_theme_options_page() {
	add_menu_page(
		'Cài đặt Theme',           // Page title
		'Cài đặt Theme',           // Menu title
		'manage_options',          // Capability
		'anthome-theme-options',   // Menu slug
		'anthome_theme_options_page', // Callback function
		'dashicons-admin-generic', // Icon
		61                         // Position
	);
}
add_action( 'admin_menu', 'anthome_add_theme_options_page' );

/**
 * Register Theme Options Settings
 */
function anthome_register_theme_options() {
	// Register settings
	register_setting( 'anthome_theme_options_group', 'anthome_options', 'anthome_sanitize_options' );

	// Company Info Section
	add_settings_section(
		'anthome_company_section',
		'Thông tin công ty',
		'anthome_company_section_callback',
		'anthome-theme-options'
	);

	// Company Name
	add_settings_field(
		'company_name',
		'Tên công ty',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_company_section',
		array( 'field' => 'company_name' )
	);

	// Address
	add_settings_field(
		'address',
		'Địa chỉ',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_company_section',
		array( 'field' => 'address' )
	);

	// Phone
	add_settings_field(
		'phone',
		'Số điện thoại',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_company_section',
		array( 'field' => 'phone' )
	);

	// Email
	add_settings_field(
		'email',
		'Email',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_company_section',
		array( 'field' => 'email' )
	);

	// Working Hours
	add_settings_field(
		'working_hours',
		'Giờ làm việc',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_company_section',
		array( 'field' => 'working_hours' )
	);

	// Social Media Section
	add_settings_section(
		'anthome_social_section',
		'Mạng xã hội',
		'anthome_social_section_callback',
		'anthome-theme-options'
	);

	// Facebook
	add_settings_field(
		'facebook_url',
		'Facebook URL',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_social_section',
		array( 'field' => 'facebook_url' )
	);

	// Instagram
	add_settings_field(
		'instagram_url',
		'Instagram URL',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_social_section',
		array( 'field' => 'instagram_url' )
	);

	// YouTube
	add_settings_field(
		'youtube_url',
		'YouTube URL',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_social_section',
		array( 'field' => 'youtube_url' )
	);

	// Contact Form Section
	add_settings_section(
		'anthome_contact_section',
		'Thông tin liên hệ',
		'anthome_contact_section_callback',
		'anthome-theme-options'
	);

	// Contact Email
	add_settings_field(
		'contact_email',
		'Email nhận liên hệ',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_contact_section',
		array( 'field' => 'contact_email' )
	);

	// Google Maps Embed
	add_settings_field(
		'google_maps_embed',
		'Google Maps Embed Code',
		'anthome_textarea_field_callback',
		'anthome-theme-options',
		'anthome_contact_section',
		array( 'field' => 'google_maps_embed' )
	);

	// Floating Contact Section
	add_settings_section(
		'anthome_floating_contact_section',
		'Floating Contact Buttons',
		'anthome_floating_contact_section_callback',
		'anthome-theme-options'
	);

	// Enable Floating Contact
	add_settings_field(
		'floating_contact_enable',
		'Bật Floating Contact',
		'anthome_checkbox_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_contact_enable' )
	);

	// Messenger URL
	add_settings_field(
		'floating_messenger_url',
		'Messenger URL',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_messenger_url', 'placeholder' => 'https://m.me/yourpage' )
	);

	// Enable Messenger
	add_settings_field(
		'floating_messenger_enable',
		'Hiển thị nút Messenger',
		'anthome_checkbox_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_messenger_enable' )
	);

	// Zalo URL/Phone
	add_settings_field(
		'floating_zalo_url',
		'Zalo URL/Số điện thoại',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_zalo_url', 'placeholder' => 'https://zalo.me/0900000000 hoặc 0900000000' )
	);

	// Enable Zalo
	add_settings_field(
		'floating_zalo_enable',
		'Hiển thị nút Zalo',
		'anthome_checkbox_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_zalo_enable' )
	);

	// Phone Number
	add_settings_field(
		'floating_phone',
		'Số điện thoại',
		'anthome_text_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_phone', 'placeholder' => '0909999999' )
	);

	// Enable Phone
	add_settings_field(
		'floating_phone_enable',
		'Hiển thị nút Gọi điện',
		'anthome_checkbox_field_callback',
		'anthome-theme-options',
		'anthome_floating_contact_section',
		array( 'field' => 'floating_phone_enable' )
	);

	// Mobile Menu Section
	add_settings_section(
		'anthome_mobile_menu_section',
		'Mobile Menu Settings',
		'anthome_mobile_menu_section_callback',
		'anthome-theme-options'
	);

	// Mobile Menu Slider Images
	add_settings_field(
		'mobile_menu_slider_images',
		'Ảnh Slide trong Mobile Menu',
		'anthome_image_gallery_field_callback',
		'anthome-theme-options',
		'anthome_mobile_menu_section',
		array( 'field' => 'mobile_menu_slider_images' )
	);

	// Homepage Product Slider Section
	add_settings_section(
		'anthome_homepage_slider_section',
		'Homepage Product Slider',
		'anthome_homepage_slider_section_callback',
		'anthome-theme-options'
	);

	// Product Category for Homepage Slider
	add_settings_field(
		'homepage_slider_category',
		'Danh mục sản phẩm hiển thị',
		'anthome_product_category_field_callback',
		'anthome-theme-options',
		'anthome_homepage_slider_section',
		array( 'field' => 'homepage_slider_category' )
	);
}
add_action( 'admin_init', 'anthome_register_theme_options' );

/**
 * Section Callbacks
 */
function anthome_company_section_callback() {
	echo '<p>Cài đặt thông tin công ty sẽ hiển thị trên website.</p>';
}

function anthome_social_section_callback() {
	echo '<p>Nhập URL đầy đủ của các trang mạng xã hội.</p>';
}

function anthome_contact_section_callback() {
	echo '<p>Cài đặt thông tin cho trang liên hệ.</p>';
}

function anthome_floating_contact_section_callback() {
	echo '<p>Cài đặt các nút liên hệ nổi (Floating Contact) hiển thị ở góc phải màn hình.</p>';
}

function anthome_mobile_menu_section_callback() {
	echo '<p>Cài đặt ảnh slide và thông tin liên hệ hiển thị trong mobile menu.</p>';
}

function anthome_homepage_slider_section_callback() {
	echo '<p>Cài đặt danh mục sản phẩm hiển thị trong slider trên trang chủ. Nếu không chọn danh mục, hệ thống sẽ hiển thị tất cả sản phẩm ngẫu nhiên.</p>';
}

/**
 * Field Callbacks
 */
function anthome_text_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	?>
	<input type="text" 
		   name="anthome_options[<?php echo esc_attr( $field ); ?>]" 
		   value="<?php echo esc_attr( $value ); ?>" 
		   class="regular-text"
		   placeholder="<?php echo esc_attr( $placeholder ); ?>">
	<?php
}

function anthome_textarea_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	?>
	<textarea name="anthome_options[<?php echo esc_attr( $field ); ?>]" 
			  rows="5" 
			  class="large-text"
			  placeholder="<?php echo esc_attr( $placeholder ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
	<?php
}

function anthome_checkbox_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<input type="checkbox" 
		   name="anthome_options[<?php echo esc_attr( $field ); ?>]" 
		   value="1" 
		   <?php checked( $value, 1 ); ?>>
	<label for="anthome_options[<?php echo esc_attr( $field ); ?>]">Bật</label>
	<?php
}

function anthome_image_gallery_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	$image_ids = ! empty( $value ) ? explode( ',', $value ) : array();
	?>
	<div class="anthome-image-gallery-field">
		<input type="hidden" 
			   name="anthome_options[<?php echo esc_attr( $field ); ?>]" 
			   id="<?php echo esc_attr( $field ); ?>" 
			   value="<?php echo esc_attr( $value ); ?>">
		
		<div class="image-gallery-preview mb-3" style="display: flex; flex-wrap: wrap; gap: 10px;">
			<?php if ( ! empty( $image_ids ) ) : 
				foreach ( $image_ids as $image_id ) :
					$image_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
					if ( $image_url ) :
			?>
			<div class="gallery-item" style="position: relative; width: 100px; height: 100px;">
				<img src="<?php echo esc_url( $image_url ); ?>" 
					 style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2px solid #ddd;">
				<button type="button" 
						class="remove-image" 
						data-image-id="<?php echo esc_attr( $image_id ); ?>"
						style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">
					×
				</button>
			</div>
			<?php 
					endif;
				endforeach;
			endif; 
			?>
		</div>
		
		<button type="button" 
				class="button button-secondary add-images-button">
			<?php echo empty( $image_ids ) ? 'Thêm ảnh' : 'Thêm ảnh khác'; ?>
		</button>
		<p class="description">Chọn một hoặc nhiều ảnh để hiển thị trong mobile menu. Ảnh sẽ được hiển thị dạng carousel/slider.</p>
	</div>
	
	<script>
	jQuery(document).ready(function($) {
		var fieldId = '<?php echo esc_js( $field ); ?>';
		var fieldWrapper = $('#' + fieldId).closest('.anthome-image-gallery-field');
		var hiddenInput = fieldWrapper.find('input[type="hidden"]');
		var preview = fieldWrapper.find('.image-gallery-preview');
		
		// Add images button
		fieldWrapper.find('.add-images-button').on('click', function(e) {
			e.preventDefault();
			
			var imageUploader = wp.media({
				title: 'Chọn ảnh cho Mobile Menu',
				button: {
					text: 'Chọn ảnh'
				},
				multiple: true
			});
			
			imageUploader.on('select', function() {
				var attachments = imageUploader.state().get('selection').toJSON();
				var currentIds = hiddenInput.val() ? hiddenInput.val().split(',') : [];
				
				attachments.forEach(function(attachment) {
					if (currentIds.indexOf(String(attachment.id)) === -1) {
						currentIds.push(String(attachment.id));
						
						var thumbnailUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
						var item = $('<div class="gallery-item" style="position: relative; width: 100px; height: 100px;">' +
							'<img src="' + thumbnailUrl + '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2px solid #ddd;">' +
							'<button type="button" class="remove-image" data-image-id="' + attachment.id + '" style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>' +
							'</div>');
						
						preview.append(item);
					}
				});
				
				hiddenInput.val(currentIds.join(','));
			});
			
			imageUploader.open();
		});
		
		// Remove image
		fieldWrapper.on('click', '.remove-image', function() {
			var imageId = $(this).data('image-id');
			var currentIds = hiddenInput.val() ? hiddenInput.val().split(',') : [];
			currentIds = currentIds.filter(function(id) {
				return id !== String(imageId);
			});
			
			hiddenInput.val(currentIds.join(','));
			$(this).closest('.gallery-item').remove();
		});
	});
	</script>
	<?php
}

function anthome_product_category_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	
	if ( ! anthome_is_woocommerce_activated() ) {
		echo '<p class="description">WooCommerce chưa được kích hoạt.</p>';
		return;
	}
	
	$categories = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'parent' => 0,
	) );
	?>
	<select name="anthome_options[<?php echo esc_attr( $field ); ?>]" class="regular-text">
		<option value="">-- Chọn danh mục (hoặc để trống để hiển thị tất cả) --</option>
		<?php
		if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$selected = selected( $value, $category->term_id, false );
				echo '<option value="' . esc_attr( $category->term_id ) . '" ' . $selected . '>' . esc_html( $category->name ) . ' (' . $category->count . ')</option>';
			}
		}
		?>
	</select>
	<p class="description">Chọn danh mục sản phẩm để hiển thị trong slider trang chủ. Nếu không chọn, hệ thống sẽ hiển thị tất cả sản phẩm ngẫu nhiên.</p>
	<?php
}

/**
 * Sanitize Options
 */
function anthome_sanitize_options( $input ) {
	$sanitized = array();

	// Text fields
	$text_fields = array( 
		'company_name', 'address', 'phone', 'email', 'working_hours',
		'facebook_url', 'instagram_url', 'youtube_url', 'contact_email',
		'floating_messenger_url', 'floating_zalo_url', 'floating_phone',
		'mobile_menu_slider_images', 'homepage_slider_category'
	);

	foreach ( $text_fields as $field ) {
		if ( isset( $input[ $field ] ) ) {
			if ( $field === 'mobile_menu_slider_images' ) {
				// Sanitize comma-separated image IDs
				$ids = array_map( 'absint', explode( ',', $input[ $field ] ) );
				$sanitized[ $field ] = implode( ',', array_filter( $ids ) );
			} elseif ( $field === 'homepage_slider_category' ) {
				// Sanitize category ID
				$sanitized[ $field ] = ! empty( $input[ $field ] ) ? absint( $input[ $field ] ) : '';
			} else {
				$sanitized[ $field ] = sanitize_text_field( $input[ $field ] );
			}
		}
	}

	// Checkbox fields
	$checkbox_fields = array(
		'floating_contact_enable', 'floating_messenger_enable', 
		'floating_zalo_enable', 'floating_phone_enable'
	);

	foreach ( $checkbox_fields as $field ) {
		$sanitized[ $field ] = isset( $input[ $field ] ) ? 1 : 0;
	}

	// Textarea fields
	if ( isset( $input['google_maps_embed'] ) ) {
		$sanitized['google_maps_embed'] = wp_kses_post( $input['google_maps_embed'] );
	}

	return $sanitized;
}

/**
 * Enqueue media uploader scripts for theme options page
 */
function anthome_enqueue_theme_options_scripts( $hook ) {
	if ( 'toplevel_page_anthome-theme-options' !== $hook ) {
		return;
	}
	
	wp_enqueue_media();
	wp_enqueue_script( 'jquery' );
}
add_action( 'admin_enqueue_scripts', 'anthome_enqueue_theme_options_scripts' );

/**
 * Theme Options Page HTML
 */
function anthome_theme_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Show success message
	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error(
			'anthome_messages',
			'anthome_message',
			'Cài đặt đã được lưu',
			'updated'
		);
	}

	settings_errors( 'anthome_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'anthome_theme_options_group' );
			do_settings_sections( 'anthome-theme-options' );
			submit_button( 'Lưu cài đặt' );
			?>
		</form>
	</div>
	<?php
}

/**
 * Helper function to get theme option
 */
function anthome_get_option( $key, $default = '' ) {
	$options = get_option( 'anthome_options' );
	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}


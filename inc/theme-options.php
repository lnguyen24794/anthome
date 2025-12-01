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

/**
 * Field Callbacks
 */
function anthome_text_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<input type="text" 
		   name="anthome_options[<?php echo esc_attr( $field ); ?>]" 
		   value="<?php echo esc_attr( $value ); ?>" 
		   class="regular-text">
	<?php
}

function anthome_textarea_field_callback( $args ) {
	$options = get_option( 'anthome_options' );
	$field = $args['field'];
	$value = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<textarea name="anthome_options[<?php echo esc_attr( $field ); ?>]" 
			  rows="5" 
			  class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
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
		'facebook_url', 'instagram_url', 'youtube_url', 'contact_email'
	);

	foreach ( $text_fields as $field ) {
		if ( isset( $input[ $field ] ) ) {
			$sanitized[ $field ] = sanitize_text_field( $input[ $field ] );
		}
	}

	// Textarea fields
	if ( isset( $input['google_maps_embed'] ) ) {
		$sanitized['google_maps_embed'] = wp_kses_post( $input['google_maps_embed'] );
	}

	return $sanitized;
}

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


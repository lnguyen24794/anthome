<?php
/**
 * Helper functions
 *
 * @package Anthome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'anthome_log' ) ) {
	function anthome_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

/**
 * Get Contact Link (Zalo or Phone)
 * Returns Zalo link if available, otherwise phone link
 */
if ( ! function_exists( 'anthome_get_contact_link' ) ) {
	function anthome_get_contact_link( $return_type = 'url' ) {
		$zalo_url = anthome_get_option( 'floating_zalo_url' );
		$phone = anthome_get_option( 'floating_phone' );
		
		// If no phone from floating contact, use main phone
		if ( ! $phone ) {
			$phone = anthome_get_option( 'phone' );
		}
		
		// Format Zalo URL
		$zalo_link = '';
		if ( $zalo_url ) {
			if ( strpos( $zalo_url, 'http' ) === 0 ) {
				$zalo_link = $zalo_url;
			} else {
				// If it's just a phone number, format as zalo.me link
				$zalo_link = 'https://zalo.me/' . preg_replace( '/[^0-9]/', '', $zalo_url );
			}
		}
		
		// Format phone for tel: link
		$phone_link = '';
		if ( $phone ) {
			$phone_link = 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
		}
		
		// Return based on type
		if ( $return_type === 'url' ) {
			// Return URL (prefer Zalo, fallback to phone)
			return $zalo_link ? $zalo_link : $phone_link;
		} elseif ( $return_type === 'zalo' ) {
			return $zalo_link;
		} elseif ( $return_type === 'phone' ) {
			return $phone_link;
		} elseif ( $return_type === 'phone_display' ) {
			// Return formatted phone for display
			return $phone ? $phone : '';
		} elseif ( $return_type === 'zalo_display' ) {
			// Return Zalo phone number for display
			if ( $zalo_url ) {
				if ( strpos( $zalo_url, 'http' ) === 0 ) {
					// Extract from URL like https://zalo.me/0900000000
					preg_match( '/zalo\.me\/([0-9]+)/', $zalo_url, $matches );
					return isset( $matches[1] ) ? $matches[1] : '';
				} else {
					// Direct phone number
					return preg_replace( '/[^0-9]/', '', $zalo_url );
				}
			}
			return '';
		}
		
		return '';
	}
}

/**
 * Render Floating Contact Buttons
 */
if ( ! function_exists( 'anthome_render_floating_contact' ) ) {
	function anthome_render_floating_contact() {
		// Check if floating contact is enabled
		if ( ! anthome_get_option( 'floating_contact_enable' ) ) {
			return;
		}

		$messenger_url = anthome_get_option( 'floating_messenger_url' );
		$messenger_enable = anthome_get_option( 'floating_messenger_enable' );
		$zalo_url = anthome_get_option( 'floating_zalo_url' );
		$zalo_enable = anthome_get_option( 'floating_zalo_enable' );
		$phone = anthome_get_option( 'floating_phone' );
		$phone_enable = anthome_get_option( 'floating_phone_enable' );

		// If no buttons are enabled, don't render
		if ( ! $messenger_enable && ! $zalo_enable && ! $phone_enable ) {
			return;
		}

		// Format Zalo URL
		$zalo_link = '';
		if ( $zalo_url ) {
			if ( strpos( $zalo_url, 'http' ) === 0 ) {
				$zalo_link = $zalo_url;
			} else {
				// If it's just a phone number, format as zalo.me link
				$zalo_link = 'https://zalo.me/' . preg_replace( '/[^0-9]/', '', $zalo_url );
			}
		}

		// Format phone for tel: link
		$phone_link = '';
		if ( $phone ) {
			$phone_link = 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
		}
		?>
		<div class="floating-contact">
			<?php if ( $messenger_enable && $messenger_url ) : ?>
				<a href="<?php echo esc_url( $messenger_url ); ?>" target="_blank" rel="noopener" class="contact-btn btn-messenger" title="Messenger">
					<i class="fa-brands fa-facebook-messenger"></i>
				</a>
			<?php endif; ?>

			<?php if ( $zalo_enable && $zalo_link ) : ?>
				<a href="<?php echo esc_url( $zalo_link ); ?>" target="_blank" rel="noopener" class="contact-btn btn-zalo" title="Zalo">
					<i>Zalo</i>
				</a>
			<?php endif; ?>

			<?php if ( $phone_enable && $phone_link ) : ?>
				<a href="<?php echo esc_attr( $phone_link ); ?>" class="contact-btn btn-phone animate-ring" title="Gọi điện">
					<i class="fa-solid fa-phone-volume"></i>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}


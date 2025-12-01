<?php
/**
 * Thankyou page
 *
 * @package Anthome
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order text-center py-5" data-aos="zoom-in">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="alert alert-danger mb-4" role="alert">
                <h4 class="alert-heading"><i class="bi bi-x-circle-fill"></i> <?php esc_html_e( 'Payment Failed', 'woocommerce' ); ?></h4>
                <p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
            </div>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

            <div class="mb-4 text-success">
                <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
            </div>
            
            <h2 class="font-playfair fw-bold mb-3"><?php esc_html_e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></h2>
            <p class="text-muted mb-5"><?php esc_html_e( 'We have sent you an email confirmation.', 'woocommerce' ); ?></p>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details list-group list-group-horizontal-md justify-content-center mb-5 shadow-sm">

				<li class="woocommerce-order-overview__order order list-group-item border-0 bg-light p-3">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date list-group-item border-0 bg-light p-3">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email list-group-item border-0 bg-light p-3">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total list-group-item border-0 bg-light p-3">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method list-group-item border-0 bg-light p-3">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<div class="order-details-wrapper text-start mx-auto" style="max-width: 800px;">
            <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
        </div>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>


<?php
/**
 * Template Name: Contact Page
 * Template for displaying contact page
 *
 * @package Anthome
 */

get_header();
?>

<main id="main" class="site-main contact-page">
	<div class="container pt-4">
		<nav aria-label="breadcrumb" class="woocommerce-breadcrumb-wrapper mb-4">
			<ol class="breadcrumb bg-light p-3 rounded-3 mb-0">
				<li class="breadcrumb-item">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a>
				</li><i class="bi bi-chevron-right mx-2 text-muted small"></i>
				<li class="breadcrumb-item active" aria-current="page">
					<?php the_title(); ?>
				</li>
			</ol>
		</nav>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center mb-5">
				<h1 class="page-title font-playfair fw-bold"><?php the_title(); ?></h1>
				<p class="lead text-muted">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
			</div>
		</div>

		<div class="row g-5">
			<!-- Contact Form -->
			<div class="col-lg-7">
				<div class="contact-form-wrapper card border-0 shadow-sm p-4 p-lg-5">
					<h3 class="mb-4">Gửi tin nhắn cho chúng tôi</h3>
					
					<?php
					// Handle form submission
					if ( isset( $_POST['contact_submit'] ) && wp_verify_nonce( $_POST['contact_nonce'], 'submit_contact_form' ) ) {
						$name = sanitize_text_field( $_POST['contact_name'] );
						$email = sanitize_email( $_POST['contact_email'] );
						$phone = sanitize_text_field( $_POST['contact_phone'] );
						$subject = sanitize_text_field( $_POST['contact_subject'] );
						$message = sanitize_textarea_field( $_POST['contact_message'] );

						$to = anthome_get_option( 'contact_email', get_option( 'admin_email' ) );
						$email_subject = '[Liên hệ từ website] ' . $subject;
						$email_body = "Tên: $name\n";
						$email_body .= "Email: $email\n";
						$email_body .= "Số điện thoại: $phone\n\n";
						$email_body .= "Nội dung:\n$message";
						$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>' );

						if ( wp_mail( $to, $email_subject, nl2br( $email_body ), $headers ) ) {
							echo '<div class="alert alert-success" role="alert">
								<i class="bi bi-check-circle me-2"></i>
								Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.
							</div>';
						} else {
							echo '<div class="alert alert-danger" role="alert">
								<i class="bi bi-exclamation-triangle me-2"></i>
								Có lỗi xảy ra. Vui lòng thử lại sau hoặc liên hệ qua số điện thoại.
							</div>';
						}
					}
					?>

					<form method="post" action="" class="contact-form">
						<?php wp_nonce_field( 'submit_contact_form', 'contact_nonce' ); ?>
						
						<div class="row g-3">
							<div class="col-md-6">
								<label for="contact_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="contact_name" name="contact_name" required>
							</div>

							<div class="col-md-6">
								<label for="contact_email" class="form-label">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" id="contact_email" name="contact_email" required>
							</div>

							<div class="col-md-6">
								<label for="contact_phone" class="form-label">Số điện thoại</label>
								<input type="tel" class="form-control" id="contact_phone" name="contact_phone">
							</div>

							<div class="col-md-6">
								<label for="contact_subject" class="form-label">Chủ đề <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="contact_subject" name="contact_subject" required>
							</div>

							<div class="col-12">
								<label for="contact_message" class="form-label">Nội dung <span class="text-danger">*</span></label>
								<textarea class="form-control" id="contact_message" name="contact_message" rows="6" required></textarea>
							</div>

							<div class="col-12">
								<button type="submit" name="contact_submit" class="btn btn-primary btn-lg px-5">
									<i class="bi bi-send me-2"></i> Gửi tin nhắn
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Contact Info -->
			<div class="col-lg-5">
				<div class="contact-info">
					<!-- Company Info Card -->
					<div class="card border-0 shadow-sm mb-4">
						<div class="card-body p-4">
							<h4 class="card-title mb-4">
								<i class="bi bi-building text-primary me-2"></i>
								<?php echo esc_html( anthome_get_option( 'company_name', 'Công ty của bạn' ) ); ?>
							</h4>

							<?php if ( anthome_get_option( 'address' ) ) : ?>
								<div class="info-item mb-3 d-flex">
									<i class="bi bi-geo-alt text-primary me-3 fs-5"></i>
									<div>
										<strong class="d-block mb-1">Địa chỉ:</strong>
										<p class="mb-0 text-muted"><?php echo esc_html( anthome_get_option( 'address' ) ); ?></p>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( anthome_get_option( 'phone' ) ) : ?>
								<div class="info-item mb-3 d-flex">
									<i class="bi bi-telephone text-primary me-3 fs-5"></i>
									<div>
										<strong class="d-block mb-1">Điện thoại:</strong>
										<a href="tel:<?php echo esc_attr( anthome_get_option( 'phone' ) ); ?>" class="text-decoration-none">
											<?php echo esc_html( anthome_get_option( 'phone' ) ); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( anthome_get_option( 'email' ) ) : ?>
								<div class="info-item mb-3 d-flex">
									<i class="bi bi-envelope text-primary me-3 fs-5"></i>
									<div>
										<strong class="d-block mb-1">Email:</strong>
										<a href="mailto:<?php echo esc_attr( anthome_get_option( 'email' ) ); ?>" class="text-decoration-none">
											<?php echo esc_html( anthome_get_option( 'email' ) ); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( anthome_get_option( 'working_hours' ) ) : ?>
								<div class="info-item mb-0 d-flex">
									<i class="bi bi-clock text-primary me-3 fs-5"></i>
									<div>
										<strong class="d-block mb-1">Giờ làm việc:</strong>
										<p class="mb-0 text-muted"><?php echo esc_html( anthome_get_option( 'working_hours' ) ); ?></p>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- Social Media -->
					<?php if ( anthome_get_option( 'facebook_url' ) || anthome_get_option( 'instagram_url' ) || anthome_get_option( 'youtube_url' ) ) : ?>
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-body p-4 text-center">
								<h5 class="card-title mb-4">Kết nối với chúng tôi</h5>
								<div class="social-links d-flex justify-content-center gap-3">
									<?php if ( anthome_get_option( 'facebook_url' ) ) : ?>
										<a href="<?php echo esc_url( anthome_get_option( 'facebook_url' ) ); ?>" 
										   class="btn btn-outline-primary rounded-circle" 
										   style="width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;"
										   target="_blank" rel="noopener">
											<i class="bi bi-facebook fs-5"></i>
										</a>
									<?php endif; ?>

									<?php if ( anthome_get_option( 'instagram_url' ) ) : ?>
										<a href="<?php echo esc_url( anthome_get_option( 'instagram_url' ) ); ?>" 
										   class="btn btn-outline-danger rounded-circle" 
										   style="width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;"
										   target="_blank" rel="noopener">
											<i class="bi bi-instagram fs-5"></i>
										</a>
									<?php endif; ?>

									<?php if ( anthome_get_option( 'youtube_url' ) ) : ?>
										<a href="<?php echo esc_url( anthome_get_option( 'youtube_url' ) ); ?>" 
										   class="btn btn-outline-danger rounded-circle" 
										   style="width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;"
										   target="_blank" rel="noopener">
											<i class="bi bi-youtube fs-5"></i>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<!-- Why Choose Us -->
					<div class="card border-0 shadow-sm bg-primary text-white">
						<div class="card-body p-4">
							<h5 class="card-title mb-3">Tại sao chọn chúng tôi?</h5>
							<ul class="list-unstyled mb-0">
								<li class="mb-2"><i class="bi bi-check-circle me-2"></i> Sản phẩm chất lượng cao</li>
								<li class="mb-2"><i class="bi bi-check-circle me-2"></i> Giá cả cạnh tranh</li>
								<li class="mb-2"><i class="bi bi-check-circle me-2"></i> Tư vấn chuyên nghiệp</li>
								<li class="mb-0"><i class="bi bi-check-circle me-2"></i> Hỗ trợ 24/7</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Google Maps -->
		<?php if ( anthome_get_option( 'google_maps_embed' ) ) : ?>
			<div class="row mt-5">
				<div class="col-12">
					<div class="map-wrapper rounded overflow-hidden shadow">
						<?php echo anthome_get_option( 'google_maps_embed' ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();


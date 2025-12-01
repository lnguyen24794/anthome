<?php
/**
 * The sidebar containing the blog widget area
 *
 * @package Anthome
 */
?>

<aside id="secondary" class="widget-area" data-aos="fade-up">
	<?php dynamic_sidebar( 'sidebar-blog' ); ?>
	
	<!-- Search Widget (if no widgets added) -->
	<?php if ( ! dynamic_sidebar( 'sidebar-blog' ) ) : ?>
		<!-- Search -->
		<div class="widget widget-search mb-4">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<h5 class="widget-title mb-3 pb-3 border-bottom">
						<i class="bi bi-search"></i> Tìm kiếm
					</h5>
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>

		<!-- Recent Posts -->
		<div class="widget widget-recent-posts mb-4">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<h5 class="widget-title mb-3 pb-3 border-bottom">
						<i class="bi bi-clock-history"></i> Bài viết mới
					</h5>
					<ul class="list-unstyled mb-0">
						<?php
						$recent_posts = new WP_Query(
							array(
								'posts_per_page' => 5,
								'post_status'    => 'publish',
								'orderby'        => 'date',
								'order'          => 'DESC',
							)
						);

						if ( $recent_posts->have_posts() ) :
							while ( $recent_posts->have_posts() ) :
								$recent_posts->the_post();
								?>
								<li class="mb-3 pb-3 border-bottom">
									<div class="d-flex gap-3">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="flex-shrink-0">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'rounded', 'style' => 'width: 70px; height: 70px; object-fit: cover;' ) ); ?>
												</a>
											</div>
										<?php endif; ?>
										<div class="flex-grow-1">
											<h6 class="mb-1">
												<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary">
													<?php echo wp_trim_words( get_the_title(), 8 ); ?>
												</a>
											</h6>
											<small class="text-muted">
												<i class="bi bi-calendar3"></i> <?php echo get_the_date(); ?>
											</small>
										</div>
									</div>
								</li>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</ul>
				</div>
			</div>
		</div>

		<!-- Categories -->
		<div class="widget widget-categories mb-4">
			<div class="card border-0 shadow-sm">
				<div class="card-body">
					<h5 class="widget-title mb-3 pb-3 border-bottom">
						<i class="bi bi-folder"></i> Danh mục
					</h5>
					<ul class="list-unstyled mb-0">
						<?php
						$categories = get_categories(
							array(
								'orderby' => 'count',
								'order'   => 'DESC',
								'number'  => 10,
							)
						);

						foreach ( $categories as $category ) :
							?>
							<li class="mb-2">
								<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="text-decoration-none d-flex justify-content-between align-items-center p-2 rounded hover-bg-light">
									<span><i class="bi bi-chevron-right"></i> <?php echo esc_html( $category->name ); ?></span>
									<span class="badge bg-primary rounded-pill"><?php echo $category->count; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>

		<!-- Tags Cloud -->
		<?php
		$tags = get_tags(
			array(
				'orderby' => 'count',
				'order'   => 'DESC',
				'number'  => 20,
			)
		);

		if ( ! empty( $tags ) ) :
			?>
			<div class="widget widget-tags mb-4">
				<div class="card border-0 shadow-sm">
					<div class="card-body">
						<h5 class="widget-title mb-3 pb-3 border-bottom">
							<i class="bi bi-tags"></i> Tags
						</h5>
						<div class="tag-cloud">
							<?php
							foreach ( $tags as $tag ) :
								?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="badge bg-light text-dark me-2 mb-2 text-decoration-none">
									<?php echo esc_html( $tag->name ); ?> (<?php echo $tag->count; ?>)
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- Newsletter (Optional) -->
		<div class="widget widget-newsletter mb-4">
			<div class="card border-0 shadow-sm bg-primary text-white">
				<div class="card-body text-center">
					<i class="bi bi-envelope-heart fs-1 mb-3 d-block"></i>
					<h5 class="widget-title mb-3">Nhận tin tức mới</h5>
					<p class="mb-3 small">Đăng ký để nhận các tin tức và ưu đãi mới nhất từ chúng tôi!</p>
					<form class="newsletter-form">
						<div class="input-group">
							<input type="email" class="form-control" placeholder="Email của bạn" required>
							<button class="btn btn-light" type="submit">
								<i class="bi bi-send"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
</aside>


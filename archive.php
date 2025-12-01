<?php
/**
 * The template for displaying archive pages (blog, categories, tags)
 *
 * @package Anthome
 */

get_header();
?>

<main id="main" class="site-main">
	<!-- Breadcrumb -->
	<div class="bg-light py-3 mb-5">
		<div class="container">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a></li>
					<?php if ( is_category() ) : ?>
						<li class="breadcrumb-item active" aria-current="page"><?php single_cat_title(); ?></li>
					<?php elseif ( is_tag() ) : ?>
						<li class="breadcrumb-item active" aria-current="page">Tag: <?php single_tag_title(); ?></li>
					<?php elseif ( is_date() ) : ?>
						<li class="breadcrumb-item active" aria-current="page"><?php echo get_the_date( 'F Y' ); ?></li>
					<?php else : ?>
						<li class="breadcrumb-item active" aria-current="page">Tin tức</li>
					<?php endif; ?>
				</ol>
			</nav>
		</div>
	</div>

	<div class="container">
		<div class="row g-5">
			<!-- Blog Posts -->
			<div class="col-lg-12">
				<?php if ( have_posts() ) : ?>

					<!-- Posts Loop -->
					<div class="row g-4">
						<?php
						while ( have_posts() ) :
							the_post();
							?>
							<div class="col-md-4" data-aos="fade-up">
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm h-100 hover-lift' ); ?>>
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="card-img-top overflow-hidden" style="height: 250px;">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-100 h-100 object-fit-cover' ) ); ?>
											</a>
										</div>
									<?php endif; ?>
									
									<div class="card-body d-flex flex-column">
										<!-- Meta Info -->
										<div class="post-meta mb-3 d-flex gap-3 flex-wrap text-muted small">
											<span><i class="bi bi-calendar3"></i> <?php echo get_the_date(); ?></span>
											<span><i class="bi bi-person"></i> <?php the_author(); ?></span>
											<?php if ( comments_open() || get_comments_number() ) : ?>
												<span><i class="bi bi-chat"></i> <?php comments_number( '0 bình luận', '1 bình luận', '% bình luận' ); ?></span>
											<?php endif; ?>
										</div>

										<!-- Title -->
										<h2 class="card-title h5 mb-3">
											<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none hover-primary">
												<?php the_title(); ?>
											</a>
										</h2>

										<!-- Excerpt -->
										<div class="card-text text-muted mb-3 flex-grow-1">
											<?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
										</div>

										<!-- Categories -->
										<?php if ( has_category() ) : ?>
											<div class="post-categories mb-3">
												<?php
												$categories = get_the_category();
												foreach ( $categories as $category ) {
													echo '<span class="badge bg-light text-dark me-1">' . esc_html( $category->name ) . '</span>';
												}
												?>
											</div>
										<?php endif; ?>

										<!-- Read More -->
										<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm mt-auto">
											<i class="bi bi-arrow-right-circle"></i> Đọc tiếp
										</a>
									</div>
								</article>
							</div>
						<?php endwhile; ?>
					</div>

					<!-- Pagination -->
					<nav class="mt-5" aria-label="Posts navigation">
						<?php
						the_posts_pagination(
							array(
								'mid_size'           => 2,
								'prev_text'          => '<i class="bi bi-chevron-left"></i> Trước',
								'next_text'          => 'Sau <i class="bi bi-chevron-right"></i>',
								'screen_reader_text' => 'Điều hướng bài viết',
								'class'              => 'pagination justify-content-center',
							)
						);
						?>
					</nav>

				<?php else : ?>

					<div class="alert alert-info" role="alert">
						<h4 class="alert-heading">Không tìm thấy bài viết</h4>
						<p>Rất tiếc, không có bài viết nào được tìm thấy trong danh mục này.</p>
						<hr>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
							<i class="bi bi-house"></i> Về trang chủ
						</a>
					</div>

				<?php endif; ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();


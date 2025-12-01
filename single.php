<?php
/**
 * The template for displaying single blog posts
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
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
					}
					?>
					<li class="breadcrumb-item active" aria-current="page"><?php echo wp_trim_words( get_the_title(), 8 ); ?></li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="container py-5">
		<div class="row g-5">
			<!-- Post Content -->
			<div class="col-lg-8">
				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?> data-aos="fade-up">
						<!-- Featured Image -->
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="post-thumbnail mb-4 rounded overflow-hidden shadow">
								<?php the_post_thumbnail( 'large', array( 'class' => 'w-100' ) ); ?>
							</div>
						<?php endif; ?>

						<!-- Post Header -->
						<header class="entry-header mb-4">
							<h1 class="entry-title font-playfair fw-bold mb-3"><?php the_title(); ?></h1>
							
							<div class="entry-meta d-flex gap-3 flex-wrap text-muted">
								<span><i class="bi bi-calendar3"></i> <?php echo get_the_date(); ?></span>
								<span><i class="bi bi-person"></i> <?php the_author_posts_link(); ?></span>
								<span><i class="bi bi-folder"></i> <?php the_category( ', ' ); ?></span>
								<?php if ( comments_open() || get_comments_number() ) : ?>
									<span><i class="bi bi-chat"></i> <?php comments_number( '0 bình luận', '1 bình luận', '% bình luận' ); ?></span>
								<?php endif; ?>
							</div>
						</header>

						<!-- Post Content -->
						<div class="entry-content post-content">
							<?php
							the_content(
								sprintf(
									wp_kses(
										/* translators: %s: Name of current post. Only visible to screen readers */
										__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'anthome' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									wp_kses_post( get_the_title() )
								)
							);

							wp_link_pages(
								array(
									'before' => '<div class="page-links mt-4"><span class="page-links-title">' . esc_html__( 'Pages:', 'anthome' ) . '</span>',
									'after'  => '</div>',
									'link_before' => '<span class="page-number">',
									'link_after'  => '</span>',
								)
							);
							?>
						</div>

						<!-- Tags -->
						<?php if ( has_tag() ) : ?>
							<footer class="entry-footer mt-5 pt-4 border-top">
								<div class="post-tags">
									<i class="bi bi-tags me-2"></i>
									<?php the_tags( '', ' ' ); ?>
								</div>
							</footer>
						<?php endif; ?>

						<!-- Author Box -->
						<?php if ( get_the_author_meta( 'description' ) ) : ?>
							<div class="author-box mt-5 p-4 bg-light rounded">
								<div class="d-flex gap-3">
									<div class="author-avatar flex-shrink-0">
										<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => 'rounded-circle' ) ); ?>
									</div>
									<div class="author-info">
										<h5 class="mb-2">
											<i class="bi bi-person-circle"></i> <?php the_author(); ?>
										</h5>
										<p class="mb-0 text-muted"><?php the_author_meta( 'description' ); ?></p>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<!-- Post Navigation -->
						<nav class="post-navigation mt-5" aria-label="Điều hướng bài viết">
							<div class="row g-3">
								<?php
								$prev_post = get_previous_post();
								$next_post = get_next_post();
								?>
								
								<?php if ( $prev_post ) : ?>
									<div class="col-md-6">
										<div class="card border-0 shadow-sm h-100 hover-lift">
											<div class="card-body">
												<small class="text-muted d-block mb-2">
													<i class="bi bi-arrow-left"></i> Bài trước
												</small>
												<a href="<?php echo get_permalink( $prev_post ); ?>" class="text-dark text-decoration-none fw-bold">
													<?php echo get_the_title( $prev_post ); ?>
												</a>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php if ( $next_post ) : ?>
									<div class="col-md-6">
										<div class="card border-0 shadow-sm h-100 hover-lift">
											<div class="card-body text-md-end">
												<small class="text-muted d-block mb-2">
													Bài sau <i class="bi bi-arrow-right"></i>
												</small>
												<a href="<?php echo get_permalink( $next_post ); ?>" class="text-dark text-decoration-none fw-bold">
													<?php echo get_the_title( $next_post ); ?>
												</a>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</nav>

					</article>

					<!-- Comments -->
					<?php
					if ( comments_open() || get_comments_number() ) :
						?>
						<div class="comments-wrapper mt-5" data-aos="fade-up">
							<?php comments_template(); ?>
						</div>
						<?php
					endif;
					?>

				<?php endwhile; ?>
			</div>

			<!-- Sidebar -->
			<div class="col-lg-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();


<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Anthome
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$anthome_comment_count = get_comments_number();
			if ( '1' === $anthome_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'Có 1 bình luận về &ldquo;%1$s&rdquo;', 'anthome' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s bình luận về &ldquo;%2$s&rdquo;', '%1$s bình luận về &ldquo;%2$s&rdquo;', $anthome_comment_count, 'comments title', 'anthome' ) ),
					number_format_i18n( $anthome_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 64,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Bình luận đã đóng.', 'anthome' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(
		array(
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h3>',
			'title_reply'        => esc_html__( 'Để lại bình luận', 'anthome' ),
			'label_submit'       => esc_html__( 'Gửi bình luận', 'anthome' ),
			'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Bình luận', 'anthome' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" class="form-control" rows="8" maxlength="65525" required="required"></textarea></p>',
			'fields'             => array(
				'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Tên', 'anthome' ) . ' <span class="required">*</span></label> <input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" required="required" /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'anthome' ) . ' <span class="required">*</span></label> <input id="email" name="email" type="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" required="required" /></p>',
				'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'anthome' ) . '</label> <input id="url" name="url" type="url" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
			),
			'class_submit'       => 'btn btn-primary',
		)
	);
	?>

</div><!-- #comments -->


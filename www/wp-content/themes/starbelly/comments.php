<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
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

<!-- comments -->
<section class="sb-popular sb-p-60-60">
	<div class="sb-bg-3">
		<span></span>
	</div>

	<div class="container">

		<div id="comments" class="post-comments">

		<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
		?>

		<div class="sb-group-title sb-mb-30">
			<div class="sb-left sb-mb-30">
				<h3><?php comments_number( esc_html__( 'No comments found', 'starbelly' ), esc_html__( '1 Comment', 'starbelly' ), esc_html__( '% Comments', 'starbelly' ) ); ?></h3>
			</div>
		</div>

		<!-- comments -->
		<ul class="sb-comments-list">
			<?php
			wp_list_comments( array(
				'style'	  => 'ul',
				'avatar_size' => '80',
				'callback' => 'starbelly_comment'
			) );
			?>
		</ul>

		<?php
		the_comments_navigation( array(
			'screen_reader_text' => ' ',
			'prev_text' => esc_html__( 'Older comments', 'starbelly' ),
			'next_text' => esc_html__( 'Newer comments', 'starbelly' )
		) );

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
		?>
		<p class="sb-text no-comments"><?php esc_html_e( 'Comments are closed.', 'starbelly' ); ?></p>
		<?php endif; ?>

		<?php endif; // Check for have_comments().
		?>

		<div class="form-comment <?php if ( comments_open() ) : ?>form-comment-open<?php endif; ?>">
			<?php
				$req = get_option( 'require_name_email' );
				$aria_req = ( $req ? " aria-required='true'" : '' );

				$comment_args = array(
					'title_reply' => esc_html__( 'Write a comment', 'starbelly' ),
					'title_reply_to' => esc_html__( 'Write a comment to %s', 'starbelly' ),
					'cancel_reply_link' => esc_html__( 'Cancel Reply', 'starbelly' ),
					'title_reply_before' => '<div id="reply-title" class="title comment-reply-title"><h3 class="sb-mb-60">',
					'title_reply_after' => '</h3></div>',
					'label_submit' => esc_html__( 'Submit', 'starbelly' ),
					'comment_field' => '<div class="sb-group-input"><textarea placeholder="' . esc_attr__( 'Comment', 'starbelly' ).'" id="comment" name="comment" aria-required="true" ></textarea></div>',
					'must_log_in' => '<p class="sb-text sb-mb-30 must-log-in">' . esc_html__( 'You must be ', 'starbelly' ) . '<a href="' . esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '">' . esc_html__( 'logged in', 'starbelly' ) . '</a>' . esc_html__( ' to post a comment.', 'starbelly' ) . '</p>',
					'logged_in_as' => '<p class="sb-text sb-mb-30 logged-in-as">' . esc_html__( 'Logged in as ', 'starbelly' ) . '<a href="' . esc_url( admin_url( 'profile.php' ) ) . '">' . esc_html( $user_identity ) . '</a>' . esc_html__( '. ', 'starbelly' ) . '<a href="' . esc_url( wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '" title="' . esc_attr__( 'Log out of this account', 'starbelly' ) . '">' . esc_html__( 'Log out?', 'starbelly' ) . '</a></p>',
					'comment_notes_before' => '',
					'comment_notes_after' => '',
					'fields' => apply_filters( 'comment_form_default_fields', array(
						'author' => '<div class="sb-group-input"><input id="author" name="author" type="text" placeholder="' . esc_attr__( 'Name', 'starbelly' ) . '" value="" ' . $aria_req . ' /></div>',
						'email' => '<div class="sb-group-input"><input id="email" name="email" type="text" placeholder="' . esc_attr__( 'Email', 'starbelly' ) . '" value="" ' . $aria_req . ' /></div>',
					)),
					'class_submit' => 'sb-btn sb-btn-text',
					'submit_field' => '<div class="form-comment-submit">%1$s %2$s</div>',
					'submit_button' => '<button type="submit" name="%1$s" id="%2$s" class="%3$s"><span>%4$s</span></button>'
				);

				comment_form( $comment_args );
			?>
		</div>

		</div>

	</div>
</section>
<!-- comments end -->

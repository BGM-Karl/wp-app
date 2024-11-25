<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 */
?>
<?php
// If the current post is protected by a password and the visitor has not yet 
// entered the password we will return early without loading the comments.
// ----------------------------------------------------------------------------------------
if ( post_password_required() ) {
    return;
}
?>

<?php if ( have_comments() || comments_open()) : ?>
<div id="comments" class="blog-post-comment blog-form mt-40">

    <?php if ( get_comments_number() >= 1 ): ?>
    <div class="comment-widget">

        <?php
            $comment_no = number_format_i18n( get_comments_number() );
            $comment_text = ( !empty( $comment_no ) AND ( $comment_no > 1 ) ) ? esc_html__( ' Comments', 'delishs' ) : esc_html__( ' Comment ', 'delishs' );
            $comment_no = ( !empty( $comment_no ) AND ( $comment_no > 0 ) ) ? '<h4 class="mb-30 mb-xs-25">' . esc_html( $comment_text . "(" .  $comment_no ) . ")" . '</h4>' : ' ';
            print sprintf( "%s", $comment_no );
        ?>

    </div>
    <div class="contact-us-message__form latest-comments">
        <ul>
            <?php
                wp_list_comments( [
                    'style'       => 'ul',
                    'callback'    => 'delishs_comment',
                    'avatar_size' => 90,
                    'short_ping'  => true,
                ] );
            ?>
        </ul>
    </div>
    <?php endif;?>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
        <div class="comment-pagination mb-50 d-none">
            <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'delishs' );?></h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older ', 'delishs' ) );?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer &rarr;', 'delishs' ) );?></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </nav><!-- #comment-nav-below -->
        </div>
    <?php endif; // check for comment navigation ?>


    <?php
    $post_id = '';
    if ( null === $post_id )
        $post_id = get_the_ID();
    else
        $id      = $post_id;

    $commenter       = wp_get_current_commenter();
    $user            = wp_get_current_user();
    $user_identity   = $user->exists() ? $user->display_name : '';


    $req         = get_option( 'require_name_email' );
    $aria_req    = ( $req ? " aria-required='true'" : '' );

    $fields = array(
        'author' => '<div class="row g-20"><div class="col-xl-6"><div class="contact-us-message__form-input"><i class="fa-light fa-user"></i><input placeholder="'.  esc_attr__('Your Name', 'delishs').'" id="author" class="tp-form-control form-control" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" size="30"' . $aria_req . ' /></div></div>',
        'email'  => '<div class="col-xl-6"><div class="contact-us-message__form-input"><i class="fa-light fa-envelope"></i><input placeholder="'.  esc_attr__('Your Email', 'delishs').'" id="email" name="email" class="tp-form-control form-control" type="email" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" size="30"' . $aria_req . ' /></div></div></div>',
    );

    if ( is_user_logged_in() ) {
        $cl = 'loginformuser';
    } else {
        $cl = '';
    }
    $defaults = [
        'fields'             => $fields,
        'comment_field'      => '
                <div class="row g-20"><div class="col-sm-12 ' . $cl . '">
                    <div class="contact-us-message__form-input">
                        <textarea class="tp-form-control form-control" placeholder="'.  esc_attr__('Write a Message', 'delishs').'" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                    </div>
                </div></div>
        ',
        'submit_button'    =>   '<div class="row g-20"><div class="col-12">
                                    <button class="rr-btn-solid" type="submit">
                                        <span class="btn-wrap">
                                            <span class="text-one">' . esc_html__( 'Submit Comment', 'delishs' ) . '</span>
                                            <span class="text-two">' . esc_html__( 'Submit Comment', 'delishs' ) . '</span>
                                        </span>
                                    </button>
                                </div></div>
                            ',
        /** This filter is documented in wp-includes/link-template.php */
        'must_log_in'        => '
            <p class="must-log-in">
            '.esc_html__('You must be','delishs').' <a href="'.esc_url(wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )).'">'.esc_html__('logged in','delishs').'</a> '.esc_html__('to post a comment.','delishs').'
            </p>',
        /** This filter is documented in wp-includes/link-template.php */
        'logged_in_as'       => '
            <p class="logged-in-as">
            '.esc_html__('Logged in as','delishs').' <a href="'.esc_url(get_edit_user_link()).'">'.esc_html($user_identity).'</a>. <a href="'.esc_url(wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )).'" title="'.esc_attr__('Log out of this account','delishs').'">'.esc_html__('Log out?','delishs').'</a>
            </p>',
        'id_form'            => 'commentform',
        'id_submit'          => 'submit',
        'class_submit'       => 'tp-btn',
        'title_reply'        => esc_html__( 'Leave a Reply', 'delishs' ),
        'title_reply_to'     => esc_html__( 'Leave a Reply to %s', 'delishs' ),
        'cancel_reply_link'  => esc_html__( 'Cancel reply', 'delishs' ),
        'label_submit'       => esc_html__( 'Post Comment', 'delishs' ),
        'format'             => 'xhtml',
    ];

    comment_form( $defaults );
    ?>

</div><!-- #comments -->
<?php endif;
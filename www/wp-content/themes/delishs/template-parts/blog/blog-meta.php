<?php 

/**
 * Template part for displaying post meta
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */


$delishs_blog_author = get_theme_mod( 'delishs_blog_author', true );
$delishs_blog_date = get_theme_mod( 'delishs_blog_date', true );
$delishs_blog_comments = get_theme_mod( 'delishs_blog_comments', true );

?>

<ul class="blog-4__item-meta mb-15">
    <?php if ( !empty($delishs_blog_date) ): ?>
        <li><i class="fa-regular fa-calendar"></i><?php the_time( get_option('date_format') ); ?></li>
    <?php endif;?>
    <?php if ( !empty($delishs_blog_author) ): ?>
        <li>
            <a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                <i class="fa-regular fa-user"></i><?php print esc_html( 'by:', 'delishs' ); ?> <?php print get_the_author(); ?>
            </a>
        </li>
    <?php endif;?>
    <?php if ( !empty($delishs_blog_comments) ): ?>
        <li><i class="fa-regular fa-comments"></i><?php comments_number(); ?></li>
    <?php endif;?>
</ul>
<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

?>

<article id="post-<?php the_ID();?>" <?php post_class( 'postbox__item post-card-2 card-3 inner-blog blog-4__item section-bg-2 format-quote mb-30' );?>>
    <div class="blog-grid__single blog-page postbox__quote">
        <div class="blog-grid__single-content">
            <i class="fa-sharp fa-light fa-quote-right"></i>
            <div class="postbox__text">
                <?php the_excerpt();?>
                <cite><?php print get_the_author(); ?></cite>
            </div>
        </div> 
    </div>
</article>
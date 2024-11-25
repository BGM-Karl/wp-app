<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

$gallery_images = function_exists('get_field') ? get_field('gallery_images') : '';
$delishs_blog_cat = get_theme_mod( 'delishs_blog_cat', true );
$categories = get_the_terms( $post->ID, 'category' );
$delishs_blog_author = get_theme_mod( 'delishs_blog_author', true );
$delishs_blog_date = get_theme_mod( 'delishs_blog_date', true ); 

if ( is_single() ): ?>

    <article id="post-<?php the_ID();?>" <?php post_class( 'postbox__item format-gallery mb-30' );?>>
        <?php if ( !empty( $gallery_images ) ): ?>
            <div class="postbox__thumb postbox__slider swiper-container w-img p-relative mb-25">
                <div class="swiper-wrapper">
                    <?php foreach ( $gallery_images as $key => $image ): ?>
                    <div class="postbox__slider-item swiper-slide">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="postbox-nav">
                    <button class="postbox-slider-button-next"><i class="fal fa-arrow-right"></i></button>
                    <button class="postbox-slider-button-prev"><i class="fal fa-arrow-left"></i></button>
                </div>
            </div>
        <?php endif;?>
        <?php get_template_part( 'template-parts/blog/blog-meta' ); ?>
        <div class="blog__details-content">
            <div class="postbox__text">
                <?php the_content();?>
                <?php
                    wp_link_pages( [
                        'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'delishs' ),
                        'after'       => '</div>',
                        'link_before' => '<span class="page-number">',
                        'link_after'  => '</span>',
                    ] );
                ?>
            </div>
        </div>
        <div class="blog__details-bottom mt-25 mb-xs-20 d-flex flex-column flex-md-row align-items-md-center  justify-content-md-between">
            <?php print delishs_get_tag();?>
            <?php print delishs_blog_single_social(); ?>
        </div>
        <?php print delishs_post_navigation();?>
    </article>

<?php else: ?>

    <article id="post-<?php the_ID();?>" <?php post_class( 'postbox__item blog-4__item section-bg-2 mb-30 format-gallery' );?>>
        <?php if ( !empty( $gallery_images ) ): ?>
            <div class="postbox__thumb postbox__slider swiper-container w-img p-relative">
                <div class="swiper-wrapper">
                    <?php foreach ( $gallery_images as $key => $image ): ?>
                    <div class="postbox__slider-item swiper-slide">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="postbox-nav">
                    <button class="postbox-slider-button-next"><i class="fal fa-arrow-right"></i></button>
                    <button class="postbox-slider-button-prev"><i class="fal fa-arrow-left"></i></button>
                </div>
            </div>
        <?php endif;?>

        <div class="blog-4__item-content">
            <?php get_template_part( 'template-parts/blog/blog-meta' ); ?>

            <h4 class="blog-4__item-content-title text-uppercase fw-bold mb-15">
                <a href="<?php the_permalink();?>"><?php the_title();?></a>
            </h4>
            <div class="blog-4__item-content-p mb-20">
                <?php the_excerpt();?>
            </div>

            <?php get_template_part( 'template-parts/blog/blog-btn' ); ?>
        </div>
    </article>

<?php endif; ?>
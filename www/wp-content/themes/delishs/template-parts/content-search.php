<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

$delishs_blog_cat = get_theme_mod( 'delishs_blog_cat', true );
$categories = get_the_terms( $post->ID, 'category' );

if ( is_single() ) : ?>

    <article id="post-<?php the_ID();?>" <?php post_class( 'postbox__item format-search' );?>>
        <?php if ( has_post_thumbnail() ): ?>
            <div class="blog__details-thumb mb-35">
                <?php the_post_thumbnail( 'full', ['class' => 'img-responsive'] );?>
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

    <article id="post-<?php the_ID();?>" <?php post_class( 'postbox__item blog-4__item section-bg-2 mb-30 format-search' );?>>
        <?php if ( has_post_thumbnail() ): ?>
            <div class="blog-4__item-thumb">
                <a class="blog-4__item-thumb-img" href="<?php the_permalink();?>">
                    <?php the_post_thumbnail( 'full', ['class' => 'img-responsive'] );?>
                </a>
                <?php if ( !empty($bizan_blog_cat) ): ?>
                    <?php if ( !empty( $categories[0]->name ) ): ?> 
                        <ul class="blog-4__item-tag">
                            <li>
                                <a href="<?php print esc_url(get_category_link($categories[0]->term_id)); ?>">
                                <?php echo esc_html($categories[0]->name); ?>
                                </a>
                            </li>
                        </ul>
                    <?php endif;?>
                <?php endif;?>
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
    
<?php endif;?>
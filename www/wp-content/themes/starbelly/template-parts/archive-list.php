<?php
/**
 * Template part for displaying archive list
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
 */

?>

<!-- row -->
<div class="row">
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="col-lg-8">
    <?php else : ?>
    <div class="col-lg-12">
    <?php endif; ?>
    <div class="row">
        <?php if ( have_posts() ) : ?>
        <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post(); ?>

        <?php
        /*
         * Include the Post-Type-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
         */

         set_query_var( 'items_per_row', '1' );
         set_query_var( 'masonry', false );
         set_query_var( 'sidebar', true );

         get_template_part( 'template-parts/content' );
        ?>

        <?php endwhile; ?>

        <?php if ( get_the_posts_pagination() ) : ?>
        <div class="col-lg-12">
          <div class="sb-pagination">
              <?php
                echo paginate_links( array(
                    'prev_text'     => esc_html__( 'Prev', 'starbelly' ),
                    'next_text'     => esc_html__( 'Next', 'starbelly' ),
                ) );
              ?>
          </div>
        </div>
        <?php endif; ?>

        <?php else : ?>
          <div class="col-lg-12">
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
          </div>
        <?php endif; ?>

    </div>
    </div>
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="col-lg-4">
      <?php get_sidebar(); ?>
    </div>
    <?php endif; ?>
</div>
<!-- row end -->

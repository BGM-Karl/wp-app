<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package delishs
 */

get_header();

$class_main = 'col-xl-12';
if(is_active_sidebar('blog-sidebar')){ 
  	$class_main = 'col-xl-8';
}

?>

<div class="tp-blog-area blog-details blog section-space">
    <div class="container">
        <div class="row gy-5">
			<div class="<?php echo esc_attr($class_main) ?>">
				<div class="postbox__wrapper postbox__details">
					<?php
						while ( have_posts() ):
						the_post();

						get_template_part( 'template-parts/content', get_post_format() );

    				?>

					<?php

						get_template_part( 'template-parts/biography' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ):
							comments_template();
						endif;

						endwhile; // End of the loop.
					?>	
				</div>
			</div>
			<?php if ( is_active_sidebar( 'blog-sidebar' ) ): ?>
				<div class="col-xl-4">
					<div class="blog-4__right sidebar-rr-sticky">
						<?php get_sidebar();?>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
</div>

<?php
get_footer();
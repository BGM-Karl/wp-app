<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

get_header();

$blog_column = 'col-lg-12 col-md-12';
if(is_active_sidebar('blog-sidebar')){ 
  	$blog_column = 'col-lg-8 col-md-12 grid-post-wrap';
}

?>

<section class="tp-blog-area blog-4 section-space">
    <div class="container">
        <div class="row">
			<div class="<?php echo esc_attr($blog_column) ?>">
				<div class="postbox__wrapper blog-4__left">
					<?php
						if ( have_posts() ):
						if ( is_home() && !is_front_page() ):
					?>
					
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title();?></h1>
					</header>
					<?php
						endif;?>
					<?php
						/* Start the Loop */
						while ( have_posts() ): the_post(); ?>
							<?php
								/*
								* Include the Post-Type-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Type name) and that will be used instead.
								*/
								get_template_part( 'template-parts/content', get_post_format() );
							?>
										
						<?php
							endwhile;
						?>
							<div class="rr-pagination mt-60">
								<?php delishs_pagination( '<i class="fa-regular fa-arrow-left"></i>', '<i class="fa-regular fa-arrow-right"></i>', '', ['class' => ''] );?>
							</div>
						<?php
						else:
							get_template_part( 'template-parts/content', 'none' );
						endif;
					?>
				</div>
			</div>

			<?php if ( is_active_sidebar( 'blog-sidebar' ) ): ?>
		        <div class="col-lg-4">
					<?php get_sidebar();?>
				</div>
			<?php endif;?>
        </div>
    </div>
</section>
<?php
get_footer();

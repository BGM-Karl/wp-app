<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

 get_header();

$blog_column = 'col-xl-12';
if(is_active_sidebar('blog-sidebar') ){ 
  	$blog_column = 'col-xl-8';
}

?>
 
<section class="tp-blog-area blog-4 section-space">
	<div class="container">
		<div class="row">
			<div class="<?php print esc_attr( $blog_column );?>">
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
							get_template_part( 'template-parts/content', get_post_format() );?>
						<?php
							endwhile;
						?>
							<div class="blog-4__pagination d-flex flex-wrap align-items-center justify-content-start">
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
				<div class="col-xl-4">
					<div class="blog-4__right sidebar-rr-sticky">
						<?php get_sidebar();?>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
</section>
 
<?php
get_footer();
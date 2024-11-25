<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package starbelly
 */

get_header();
?>

<?php

$blog_featured_img = get_field( 'blog_featured_img', 'option' );
$theme_lightbox = get_field( 'portfolio_lightbox_disable', 'option' );

?>

	<?php while ( have_posts() ) : the_post(); ?>

		<!-- banner -->
		<section class="sb-banner sb-banner-sm sb-banner-color">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<!-- main title -->
						<div class="sb-main-title-frame">
							<div class="sb-main-title text-center">
								<div class="sb-suptitle sb-mb-30"><?php starbelly_before_title(); ?></div>
								<h1 class="sb-mb-30"><?php the_title(); ?></h1>
								<?php starbelly_breadcrumbs( get_the_ID() ); ?>
							</div>
						</div>
						<!-- main title end -->
					</div>
				</div>
			</div>
		</section>
		<!-- banner end -->

		<!-- publication -->
		<section class="sb-publication sb-p-90-0">

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">

				  <?php if ( has_post_thumbnail() && ! $blog_featured_img ) :
				  $image = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_1920xAuto' ); ?>
				  <div class="sb-post-cover sb-mb-30">
						<a<?php if ( ! $theme_lightbox ) : ?> data-magnific-image<?php endif; ?> href="<?php the_post_thumbnail_url( 'starbelly_1920xAuto' ); ?>">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
						</a>
					</div>
				  <?php endif; ?>


				  <?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php starbelly_single_navigantion(); ?>

				</div>
			</div>
    </div>

	 </section>

	 <?php if ( comments_open() || get_comments_number() ) :
	 // If comments are open or we have at least one comment, load up the comment template.
	 comments_template();
	 endif; ?>

	<?php endwhile; ?>

<?php
get_footer();

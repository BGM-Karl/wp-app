<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
 */

get_header();
?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'template-parts/intro' ); ?>

		<?php
		$is_wc = false;

		if ( class_exists( 'WooCommerce' ) ) {
			$is_wc = is_woocommerce();

			if ( !$is_wc && ( is_cart() || is_checkout() || is_account_page() ) ) {
				$is_wc = true;
			}
		}
		?>

		<section class="sb-p-90-90">
			<div class="container">
				<?php if ( $is_wc ) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php endif; ?>
			</div>
		</section>

		<?php
		if ( comments_open() || get_comments_number() ) :
			// If comments are open or we have at least one comment, load up the comment template.
			comments_template();
		endif; ?>

	<?php endwhile; ?>

<?php
get_footer();

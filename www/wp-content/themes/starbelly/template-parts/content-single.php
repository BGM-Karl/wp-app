<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-post-text">
		<?php
			the_content(); 

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'starbelly' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<div class="post-text-bottom">	
		<?php starbelly_after_content(); ?>
	</div>
</div><!-- #post-<?php the_ID(); ?> -->
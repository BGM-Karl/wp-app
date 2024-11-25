<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package starbelly
 */

get_header();
?>

<?php get_template_part( 'template-parts/intro' ); ?>

<section class="sb-p-90-90">
	<div class="container">

		<?php get_template_part( 'template-parts/archive-list' ); ?>

	</div>
</section>

<?php
get_footer();

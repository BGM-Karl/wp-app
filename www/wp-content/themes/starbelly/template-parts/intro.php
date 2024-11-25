<?php
/**
 * Template part for displaying page intro
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
 */

?>

<?php

$args = array(
	'delimiter'   => '',
	'wrap_before' => '<ul class="sb-breadcrumbs">',
	'wrap_after'  => '</ul>',
	'before'      => '<li><span>',
	'after'       => '</span></li>',
	'home'        => esc_html__( 'Home', 'starbelly' ),
);

$page_id = get_the_ID();

$is_wc = false;

if ( class_exists( 'WooCommerce' ) ) {
	$is_wc = is_woocommerce();
}

?>

<!-- banner -->
<section class="sb-banner sb-banner-xs sb-banner-color">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<!-- main title -->
				<div class="sb-main-title-frame">
          <?php if ( $is_wc ) : ?>
          <div class="sb-main-title">
						<h1 class="sb-h2"><?php woocommerce_page_title(); ?></h1>
						<?php woocommerce_breadcrumb( $args ); ?>
					</div>
          <?php else : ?>
          <div class="sb-main-title">
						<?php
						// get title
						if ( is_page() ) {
							$title = get_the_title();
						} elseif ( is_search() ) {
							$title = esc_html__( 'Search: ', 'starbelly' ) . esc_html( get_search_query() );
						} elseif ( is_archive() ) {
							$title = get_the_archive_title();
						} else {
							$title = esc_html__( 'Latest Posts', 'starbelly' );
						}
						?>
						<h1 class="sb-h2"><?php echo wp_kses_post( $title ); ?></h1>
						<?php starbelly_breadcrumbs( $page_id ); ?>
					</div>
          <?php endif; ?>
				</div>
				<!-- main title end -->
			</div>
		</div>
	</div>
</section>
<!-- banner end -->

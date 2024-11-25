<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :

$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

$product_related_title = get_field( 'product_related_title', 'options' );
$description = get_field( 'product_related_desc', 'options' );

if ( !empty( $product_related_title ) ) {
	$heading = $product_related_title;
}

?>

<!-- short menu -->
<section class="sb-short-menu sb-p-0-90">
	<div class="sb-group-title sb-mb-30">
		<div class="sb-left sb-mb-30">
			<?php if ( $heading ) : ?>
			<h2 class="sb-cate-title sb-mb-30"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( $description ) : ?>
			<p class="sb-text"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		</div>
		<div class="sb-right sb-mb-30">
			<!-- slider navigation -->
			<div class="sb-slider-nav">
				<div class="sb-prev-btn sb-short-menu-prev"><i class="fas fa-arrow-left"></i></div>
				<div class="sb-next-btn sb-short-menu-next"><i class="fas fa-arrow-right"></i></div>
			</div>
			<!-- slider navigation end -->
		</div>
	</div>

	<div class="swiper-container sb-short-menu-slider-3i">
		<div class="swiper-wrapper">
			<?php foreach ( $related_products as $related_product ) : ?>
			<div class="swiper-slide">
				<?php
				$post_object = get_post( $related_product->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				set_query_var( 'is_carousel', true );
				set_query_var( 'items_per_row', 4 );

				wc_get_template_part( 'content', 'product' );
				?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- short menu end -->

	<?php
endif;

wp_reset_postdata();

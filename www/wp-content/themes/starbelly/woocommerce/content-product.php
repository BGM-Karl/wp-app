<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

//taxonomy
$current_categories = get_the_terms( get_the_ID(), 'product_cat' );
$categories_slug = '';
if ( $current_categories && ! is_wp_error( $current_categories ) ) {
	foreach ( $current_categories as $key => $value ) {
		$categories_slug .= 'category-' . $value->slug . ' ';
	}
}

//post data
$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
$title = get_the_title();
$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
$image = $product->get_image( $image_size );

$is_carousel = false;
$is_column = true;
$is_masonry = false;

$items_per_row = get_query_var( 'items_per_row' );

if ( empty( $items_per_row ) ) {
	$items_per_row = get_field( 'shop_items_per_row', 'options' );
}

if ( empty( $items_per_row ) ) {
	$items_per_row = 4;
}

if ( get_query_var( 'is_carousel' ) ) {
		$is_carousel = true;
		$is_masonry = false;
		$is_column = false;
}

if ( get_query_var( 'is_masonry' ) ) {
		$is_masonry = true;
		$is_column = false;
		$is_carousel = false;
}

$grid_class = '';
$col_class = '';

if ( $items_per_row == '3' ) {
	$grid_class = 'sb-item-33';
	$col_class = 'col-lg-4';
} elseif ( $items_per_row == '2' ) {
	$grid_class = 'sb-item-50';
	$col_class = 'col-lg-6';
} else {
	$grid_class = 'sb-item-25';
	$col_class = 'col-lg-3';
}

?>

<?php if ( $is_column ) : ?>
<div class="<?php echo esc_attr( $col_class ); ?>">
<?php elseif ( $is_masonry ) : ?>
<div class="sb-grid-item <?php echo esc_attr( $grid_class ); ?> <?php echo esc_attr( $categories_slug ); ?>">
<?php else : ?>
<!-- Carousel Item -->
<?php endif; ?>

<div <?php wc_product_class( '', $product ); ?>>
	<div class="sb-menu-item<?php if ( ! $is_carousel ) : ?> sb-mb-30<?php endif; ?>">
		<a href="<?php echo esc_url( $link ); ?>" class="sb-cover-frame">
			<?php echo wp_kses_post( $image ); ?>

			<?php
			/**
			 * Hook: woocommerce_before_shop_loop_item_title.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</a>

		<div class="sb-card-tp">
			<h4 class="sb-card-title">
				<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
			</h4>

			<?php
			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

			<?php if ( $average = $product->get_average_rating() ) : ?>
			  <?php echo '<div class="star-rating" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'starbelly' ), $average ) . '"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'starbelly' ) . '</span></div>'; ?>
			<?php endif; ?>
		</div>

		<div class="sb-description">
			<p class="sb-text sb-mb-15">
				<?php
				/**
				 * Hook: woocommerce_shop_loop_item_title.
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' );
				?>
			</p>
		</div>

		<div class="sb-card-buttons-frame">
			<!-- button -->
			<a href="<?php echo esc_url( $link ); ?>" class="sb-btn sb-btn-gray<?php if ( $items_per_row == '4' ) : ?> sb-btn-2 sb-btn-icon sb-m-0<?php endif; ?>">
				<span class="sb-icon">
					<span class="sb-icon-arrow"></span>
				</span>
				<?php if ( $items_per_row != '4' ) : ?>
				<span><?php echo esc_attr__( 'Details', 'starbelly' ); ?></span>
				<?php endif; ?>
			</a>
			<!-- button end -->

			<?php
			/**
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div>

	</div>

</div>

<?php if ( ! $is_carousel ) : ?>
</div>
<?php endif; ?>

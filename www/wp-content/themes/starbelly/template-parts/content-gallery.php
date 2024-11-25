<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
 */

?>

<?php

/*options*/
$theme_lightbox = get_field( 'portfolio_lightbox_disable', 'option' );

/* post content */
$current_categories = get_the_terms( get_the_ID(), 'gallery_categories' );
$categories_string = '';
$categories_slugs_string = '';
if ( $current_categories && ! is_wp_error( $current_categories ) ) {
	$arr_keys = array_keys( $current_categories );
	$last_key = end( $arr_keys );
	foreach ( $current_categories as $key => $value ) {
		if ( $key == $last_key ) {
			$categories_string .= $value->name . ' ';
		} else {
			$categories_string .= $value->name . ', ';
		}
		$categories_slugs_string .= 'category-' . $value->slug . ' ';
	}
}

$image = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_950xAuto' );
$image_full = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_1920xAuto' );
$title = get_the_title();
$subtitle = $categories_string;
$show_per_row = get_query_var( 'show_per_row' );
$masonry_size = get_field( 'masonry_size' );

?>

<div class="sb-grid-item<?php if ( $show_per_row == '2' ) : ?> sb-item-50<?php else : ?> sb-item-33<?php endif; ?> <?php echo esc_attr( $categories_slugs_string ); ?>">
	<div class="sb-gallery-item<?php if ( $masonry_size == '1' ) : ?> sb-gallery-vert<?php endif; ?> sb-mb-30">
		<a data-no-swup href="<?php echo esc_url( $image_full ); ?>" data-elementor-lightbox-slideshow="gallery" data-elementor-lightbox-title="<?php echo esc_attr( $title ); ?>">
			<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
			<?php endif; ?>
			<?php if ( $image_full ) : ?>
			<!-- button -->
			<span class="sb-btn sb-btn-2 sb-btn-icon sb-btn-gray sb-zoom">
				<span class="sb-icon">
					<span class="sb-icon-svg sb-icon-svg-zoom"></span>
				</span>
			</span>
			<!-- button end -->
			<?php endif; ?>
		</a>
	</div>
</div>

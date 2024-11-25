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

//taxonomy
$current_categories = get_the_terms( get_the_ID(), 'restaurant_menu_categories' );
$categories_slug = '';
if ( $current_categories && ! is_wp_error( $current_categories ) ) {
	foreach ( $current_categories as $key => $value ) {
		$categories_slug .= 'category-' . $value->slug . ' ';
	}
}

//options
$currency = get_field( 'restaurant_currency_symbol', 'option' );
$currency_position = get_field( 'restaurant_currency_position', 'option' );

//content
$image = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_950xAuto' );
$image_full = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_1920xAuto' );
$price = get_field( 'price' );
$description = get_field( 'description' );
$rating = get_field( 'rating' );

//vars
$is_carousel = false;

if ( get_query_var( 'is_carousel' ) ) {
	$is_carousel = true;
}

$items_per_row = get_query_var( 'items_per_row' );
$grid_class = '';

if ( $items_per_row == '3' ) {
	$grid_class = 'sb-item-33';
} elseif ( $items_per_row == '2' ) {
	$grid_class = 'sb-item-50';
} else {
	$grid_class = 'sb-item-25';
}

$is_column = false;

if ( get_query_var( 'is_column' ) ) {
	$is_column = true;
}

?>

<?php if ( ! $is_column ) : ?>
<?php if ( $is_carousel ) : ?>
<div class="swiper-slide">
<?php else : ?>
<div class="sb-grid-item <?php echo esc_attr( $grid_class ); ?> <?php echo esc_attr( $categories_slug ); ?>">
<?php endif; ?>
<?php endif; ?>

	<a data-elementor-open-lightbox="yes" data-elementor-lightbox-title="<?php echo esc_attr( get_the_title() ); ?>" data-no-swup href="<?php echo esc_url( $image_full ); ?>" class="sb-menu-item<?php if ( ! $is_carousel ) : ?> sb-mb-30<?php endif; ?>">
		<?php if ( $image ) : ?>
		<div class="sb-cover-frame">
			<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
		</div>
		<?php endif; ?>
		<div class="sb-card-tp">
			<h4 class="sb-card-title"><?php the_title(); ?></h4>
			<?php if ( $price ) : ?>
			<div class="sb-price">
				<?php if ( $currency_position == 'before' ) : ?><sub><?php echo esc_html( $currency ); ?></sub><?php endif; ?>
				<?php echo esc_html( $price ); ?>
				<?php if ( $currency_position == 'after' ) : ?><sub><?php echo esc_html( $currency ); ?></sub><?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="sb-description">
			<?php if ( $description ) : ?>
			<p class="sb-text sb-mb-15"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
			<ul class="sb-stars" data-rating="<?php echo esc_attr( $rating ); ?>">
				<?php for ( $i=0; $i<=5; $i++ ) : ?>
				<li<?php if ( $rating<$i || $rating == 0 ) : ?> class="sb-empty"<?php endif; ?>><i class="fas fa-star"></i></li>
				<?php endfor; ?>
			</ul>
		</div>
	</a>

<?php if ( !$is_column ) : ?>
</div>
<?php endif; ?>

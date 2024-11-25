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

//options
$blog_excerpt = get_field( 'blog_excerpt', 'option' );

//vars
$items_per_row = get_query_var( 'items_per_row' );
$is_sidebar = true;
$is_masonry = false;
$is_column = true;
$is_carousel = false;

//content
if ( $items_per_row == '2' || $items_per_row == '3' || $items_per_row == '4' ) {
	$image = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_950xAuto' );
} else {
	$image = get_the_post_thumbnail_url( get_the_ID(), 'starbelly_1920xAuto' );
}
$masonry_size = false;

if ( !empty( get_query_var( 'sidebar' ) ) ) {
	$is_sidebar = true;
} else {
	$is_sidebar = false;
}

if ( get_query_var( 'masonry' ) ) {
	$is_masonry = true;
	$is_column = false;
	$is_carousel = false;
}

if ( get_query_var( 'is_carousel' ) ) {
	$is_masonry = false;
	$is_column = false;
	$is_carousel = true;
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
	$grid_class = 'sb-item-100';
	$col_class = 'col-lg-12';
}

if ( $is_masonry ) {
	$masonry_size = get_field( 'masonry_size' );
}

$badge = false;

if ( get_query_var( 'badge' ) ) {
	$badge = get_query_var( 'badge' );
}

?>

<?php if ( $is_column ) : ?>
<div class="<?php echo esc_attr( $col_class ); ?>">
<?php elseif ( $is_masonry ) : ?>
<div class="sb-grid-item <?php echo esc_attr( $grid_class ); ?>">
<?php else : ?>
<!-- carousel item -->
<?php endif; ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="sb-blog-card sb-mb-30">
			<?php if ( $image ) : ?>
			<div class="sb-cover-frame<?php if ( $masonry_size == '1' ) : ?> sb-cover-vert<?php endif; ?> sb-mb-30">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" /></a>
				<?php if ( $badge ) : ?><div class="sb-badge"><?php echo esc_html( $badge ); ?></div><?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="sb-blog-card-descr">
				<h3 class="sb-mb-10"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h3>
				<div class="sb-suptitle sb-mb-15">
					<?php if ( ! empty( get_the_title() ) ) : ?>
					<span><?php echo esc_html( get_the_date() ); ?></span> <span><?php the_author(); ?></span>
					<?php else : ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>"><span><?php echo esc_html( get_the_date() ); ?></span> <span><?php the_author(); ?></span></a>
					<?php endif; ?>
				</div>
				<div class="sb-text">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</div>
	</div>

<?php if ( ! $is_carousel ) : ?>
</div>
<?php endif; ?>

<?php
/**
 * Template part for displaying woocommerce shop page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starbelly
*/

get_header( 'shop' );
?>

<?php
$page_type = false;

if ( is_shop() ) {
	$page_type = 'shop';
} elseif ( is_product_tag() || is_product_category() || is_product_taxonomy() ) {
	$page_type = 'product-category';
} elseif ( is_product() ) {
	$page_type = 'product';
}

$shop_sidebar = get_field( 'shop_sidebar', 'option' );

if ( ! $shop_sidebar ) {
	$shop_sidebar = 'hide';
}

$is_product = is_product();

?>

<?php get_template_part( 'template-parts/intro' ); ?>

<div class="shop-page sb-shop-page" id="card-shop-page">
	<div class="container">
	<?php if ( 'left' == $shop_sidebar && ! $is_product ) : ?>
	<div class="row">
		<div class="col-md-3 col-padding-right">
			<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
			 <div id="sidebar" class="widget-area content-sidebar" role="complementary">
	        <?php dynamic_sidebar( 'shop-sidebar' ); ?>
	     </div>
	     <?php endif; ?>
		</div>
		<div class="col-md-9">
			<?php woocommerce_content(); ?>
		</div>
	</div>
	<?php elseif ( 'right' == $shop_sidebar && ! $is_product ) : ?>
	<div class="row">
		<div class="col-md-9">
			<?php woocommerce_content(); ?>
		</div>
		<div class="col-md-3 col-padding-left">
			 <?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
			 <div id="sidebar" class="widget-area content-sidebar" role="complementary">
	         <?php dynamic_sidebar( 'shop-sidebar' ); ?>
	     </div>
	     <?php endif; ?>
		</div>
	</div>
	<?php else : ?>

		<?php if ( ! $is_product ) : ?><div class="row"><div class="col-md-12"><?php endif; ?>

			<?php woocommerce_content(); ?>

		<?php if ( ! $is_product ) : ?></div></div><?php endif; ?>

	<?php endif; ?>
	</div>
</div>

<?php
	// Shop Promo Template
	$promo_builder = get_field( 'promo_builder', 'options' );
	if ( ! empty( $promo_builder ) ) :
		foreach ( $promo_builder as $promo ) :
			if ( $promo['page_type'] == $page_type ) :
				$args = array( 'post_type' => 'hf_templates', 'p' => $promo['template'] );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					the_content();
				endwhile; wp_reset_postdata();
			endif;
		endforeach;
	endif;
?>

<?php get_footer(); ?>

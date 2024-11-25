<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$badges = get_field( 'badges_list' );

?>

<div class="sb-badges">
	<?php if ( $product->is_on_sale() ) : ?>
		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="sb-badge sb-badge-i sb-onsale"><i class="fas fa-tag"></i>' . esc_html__( 'Sale!', 'starbelly' ) . '</span>', $post, $product ); ?>
	<?php endif; ?>

	<?php if ( ! empty( $badges ) ) : ?>
	<?php foreach ( $badges as $badge ) : ?>
	<div class="sb-badge sb-badge-i" style="background-color: <?php echo esc_attr( $badge['color'] ); ?>"><?php echo wp_kses_post( $badge['icon'] ); ?> <?php echo esc_html( $badge['text'] ); ?></div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>

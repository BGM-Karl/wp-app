<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );

?>

<!-- button -->
<a href="<?php echo esc_url( $shop_page_url ); ?>" class="sb-btn sb-btn-2 sb-btn-gray">
	<span class="sb-icon">
		<span class="sb-icon-arrow-2"></span>
	</span>
	<span>繼續購物</span>
</a>
<!-- button end -->

<!-- button -->
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="sb-btn sb-m-0">
	<span class="sb-icon">
		<span class="sb-icon-arrow"></span>
	</span>
	<span>立即結帳</span>
</a>
<!-- button end -->

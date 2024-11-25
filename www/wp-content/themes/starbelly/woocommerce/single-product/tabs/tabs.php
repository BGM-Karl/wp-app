<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

$product_additional_title = get_field( 'product_additional_title', 'options' );
$product_make_additional_first = get_field( 'product_make_additional_first', 'options' );

if ( $product_make_additional_first == 1 && isset( $product_tabs['additional_information'] ) ) {
	$result = array();
	$result['additional_information'] = $product_tabs['additional_information'];
	unset( $product_tabs['additional_information'] );
  $product_tabs = array_merge( $result, $product_tabs );
}

if ( ! empty( $product_tabs ) ) : ?>
	<div class="clear"></div>
	<div class="sb-filter">
		<?php $i = 0; foreach ( $product_tabs as $key => $product_tab ) : $i++; ?>
		<a href="#." data-filter=".sb-<?php echo esc_attr( $key ); ?>-tab" class="sb-filter-link<?php if ( $i == 1 ) : ?> sb-active<?php endif; ?>">
			<?php
				if ( !empty( $product_additional_title ) && $key == 'additional_information' ) {
					echo esc_html( $product_additional_title );
				} else {
					echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) );
				}
			?>
		</a>
		<?php endforeach; ?>
	</div>

	<div class="sb-masonry-grid sb-tabs">
		<div class="sb-grid-sizer"></div>

		<?php $i = 0; foreach ( $product_tabs as $key => $product_tab ) : $i++; ?>
		<div class="sb-grid-item sb-<?php echo esc_attr( $key ); ?>-tab"<?php if ( $i != 1 ) : ?> style="position: absolute"<?php endif; ?>>
			<div class="sb-tab">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>

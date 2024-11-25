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
 * @version 4.8.0
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

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper shop-description section-space__bottom mt-45">
		<ul class="tabs wc-tabs nav tab-navigation" id="product-tab-navigation" role="tablist">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <li role="presentation">
                    <button class="nav-links <?php echo esc_attr( $key ); ?> <?php echo $key === array_key_first($product_tabs) ? 'active' : ''; ?>" 
                            id="home-tab-<?php echo esc_attr( $key ); ?>" 
                            data-bs-toggle="tab" 
                            data-bs-target="#home-<?php echo esc_attr( $key ); ?>" 
                            type="button"
                            role="tab" 
                            aria-controls="tab-<?php echo esc_attr( $key ); ?>" 
                            aria-selected="<?php echo $key === array_key_first($product_tabs) ? 'true' : 'false'; ?>">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content" id="product-tab-content">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <div class="bd-content-tab woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab tab-pane fade <?php echo $key === array_key_first($product_tabs) ? 'show active' : ''; ?> description" 
                     id="home-<?php echo esc_attr( $key ); ?>" 
                     role="tabpanel" 
                     aria-labelledby="home-tab-<?php echo esc_attr( $key ); ?>">
                    <div class="shop-description__content">
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
	</div>

<?php endif; ?>
<?php
/**
 * Functions which enhance the theme by hooking into WooCommerce
 *
 * @package starbelly
 */

 /* WooCommerce Init Settings */
 function starbelly_add_woocommerce_support() {
  add_theme_support( 'woocommerce', array(
    'thumbnail_image_width' => 600,
    'single_image_width' => 1140,
    'product_grid' => array(
      'default_rows' => 3,
      'min_rows' => 3,
      'max_rows' => 3,
      'default_columns' => 3,
      'min_columns' => 3,
      'max_columns' => 3,
    ),
  ) );
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );
 }
 add_action( 'after_setup_theme', 'starbelly_add_woocommerce_support' );

/* Loop Products */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/* Single Product */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'starbelly_woo_template_info_steps', 20 );
function starbelly_woo_template_info_steps() {
  $result = '';

  $product_info_steps = get_field( 'product_info_steps', 'options' );
  if ( !empty($product_info_steps) ) {
    $result .= '<div class="row">';

    foreach ( $product_info_steps as $item ) {
      $result .= '<div class="col-lg-4">';
        $result .= '<div class="sb-features-item sb-features-item-sm sb-mb-30">';
          $result .= '<div class="sb-number">' . esc_html( $item['num'] ) . '</div>';
          $result .= '<div class="sb-feature-text">';
            $result .= '<h4 class="sb-mb-15">' . wp_kses_post( $item['label'] ) . '</h4>';
            $result .= '<p class="sb-text sb-text-sm">' . wp_kses_post( $item['value'] ) . '</p>';
          $result .= '</div>';
        $result .= '</div>';
      $result .= '</div>';
    }

    $result .= '</div>';
  }

  echo wp_kses_post( $result );
}

/* Woocommerce Page */
function starbelly_woo_hide_shop_page_title( $title ) {
 $title = false;
 return $title;
}
add_filter( 'woocommerce_show_page_title', 'starbelly_woo_hide_shop_page_title' );

function starbelly_woo_small_decimal_price( $formatted_price, $price, $decimal_places, $decimal_separator, $thousand_separator ) {
 $unit = number_format( intval( $price ), 0, $decimal_separator, $thousand_separator );
 $decimal = ( $price - intval( $price ) ) * 100;
 return $unit . '<small>' . $decimal_separator . str_pad( $decimal, 2, '0', STR_PAD_LEFT ) . '</small>';
}
add_filter( 'formatted_woocommerce_price', 'starbelly_woo_small_decimal_price', 10, 5 );

function starbelly_woo_excerpt_in_product_archives() {
   echo wp_trim_words( get_the_excerpt(), 10 );
}
add_action( 'woocommerce_shop_loop_item_title', 'starbelly_woo_excerpt_in_product_archives', 40 );

/* Update contents AJAX mini-cart */
function starbelly_woocommerce_update_count_mini_cart( $fragments ) {
 ob_start();
 ?>

 <span class="cart-count">
   <?php echo sprintf (_n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'starbelly' ), WC()->cart->get_cart_contents_count() ); ?>
 </span>

 <?php
 $fragments['span.cart-count'] = ob_get_clean();
 return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'starbelly_woocommerce_update_count_mini_cart' );

function starbelly_woocommerce_update_content_mini_cart( $fragments ) {
 ob_start();
 ?>

 <div class="cart-widget">
      <?php woocommerce_mini_cart(); ?>
   </div>

 <?php
 $fragments['div.cart-widget'] = ob_get_clean();
 return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'starbelly_woocommerce_update_content_mini_cart' );

/* Change default related product count */
function starbelly_woocommerce_related_products_per_page( $args ) {
 $args['posts_per_page'] = 6;
 $related_limit = get_field( 'product_related_limit', 'options' );
 if ( !empty( $related_limit ) ) {
   $args['posts_per_page'] = $related_limit;
 }
 return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'starbelly_woocommerce_related_products_per_page', 20 );

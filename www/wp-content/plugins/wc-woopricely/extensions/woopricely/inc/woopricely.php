<?php

if ( !class_exists( 'WCWooPricely' ) ) {

    class WCWooPricely {

        public function __construct() {

            //======================
            //Products pricing hooks
            //======================

            add_filter( 'woocommerce_product_get_regular_price', 'WooPricely_Product_Prices::get_product_regular_price', 999999, 2 );
            add_filter( 'woocommerce_product_variation_get_regular_price', 'WooPricely_Product_Prices::get_product_regular_price', 999999, 2 );

            add_filter( 'woocommerce_product_get_sale_price', 'WooPricely_Product_Prices::get_product_sale_price', 999999, 2 );
            add_filter( 'woocommerce_product_variation_get_sale_price', 'WooPricely_Product_Prices::get_product_sale_price', 999999, 2 );

            add_filter( 'woocommerce_product_get_price', 'WooPricely_Product_Prices::get_product_sale_price', 999999, 2 );
            add_filter( 'woocommerce_product_variation_get_price', 'WooPricely_Product_Prices::get_product_sale_price', 999999, 2 );

            add_filter( 'woocommerce_product_get_date_on_sale_from', 'WooPricely_Product_Prices::get_product_date_on_sale_from', 999999, 2 );
            add_filter( 'woocommerce_product_variation_get_date_on_sale_from', 'WooPricely_Product_Prices::get_product_date_on_sale_from', 999999, 2 );

            add_filter( 'woocommerce_product_get_date_on_sale_to', 'WooPricely_Product_Prices::get_product_date_on_sale_to', 999999, 2 );
            add_filter( 'woocommerce_product_variation_get_date_on_sale_to', 'WooPricely_Product_Prices::get_product_date_on_sale_to', 999999, 2 );

            add_filter( 'woocommerce_is_purchasable', 'WooPricely_Product_Prices::get_is_purchasable', 999999, 2 );
            add_filter( 'woocommerce_product_is_on_sale', 'WooPricely_Product_Prices::get_is_on_sale', 999999, 2 );


            add_filter( 'woocommerce_variation_prices_regular_price', array( $this, 'get_variation_regular_price' ), 999999, 3 );
            add_filter( 'woocommerce_variation_prices_sale_price', array( $this, 'get_variation_sale_price' ), 999999, 3 );
            add_filter( 'woocommerce_variation_prices_price', array( $this, 'get_variation_price' ), 999999, 3 );

            add_filter( 'woocommerce_get_variation_prices_hash', array( $this, 'get_variation_prices_hash' ), 999999, 3 );


            //=================================
            //Checkout Discounts and Fees hooks
            //=================================

            add_action( 'woocommerce_cart_calculate_fees', array( $this, 'calculate_fees' ), 99999900, 1 );
            add_filter( 'woocommerce_get_shop_coupon_data', 'WooPricely_Checkout_Discounts::get_coupon_data', 99999900, 2 );
            add_filter( 'woocommerce_cart_totals_get_fees_from_cart_taxes', array( $this, 'get_fee_taxes' ), 100, 3 );

            //===============
            //View HTML hooks
            //===============
            add_filter( 'woocommerce_cart_totals_fee_html', 'WooPricely_Views::fee_html', 30, 2 );
            add_filter( 'woocommerce_cart_totals_coupon_label', 'WooPricely_Views::coupon_label', 10, 2 );
            add_filter( 'woocommerce_cart_totals_coupon_html', 'WooPricely_Views::coupon_html', 10, 3 );

            add_filter( 'woocommerce_cart_item_price', 'WooPricely_Views::cart_item_price_display', 50, 3 );
            add_filter( 'woocommerce_widget_cart_item_quantity', 'WooPricely_Views::mini_cart_item_price_display', 50, 3 );
            add_filter( 'woocommerce_checkout_cart_item_quantity', 'WooPricely_Views::mini_cart_item_price_display', 50, 3 );

            add_filter( 'transient_wc_products_onsale', array( $this, 'get_onsale_ids_cache' ), 99999, 2 );
        }

        public function calculate_fees( $cart ) {

            WooPricely_Checkout_Discounts::apply_discounts();

            WooPricely_Checkout_Fees::apply_fees();
        }

        public function get_fee_taxes( $fee_taxes, $fee, $cart_totals ) {

            // remove discount taxes
            return WooPricely_Checkout_Discounts::remove_discount_taxes( $fee_taxes, $fee->object->id );
        }

        public function get_variation_regular_price( $price, $variation, $product ) {

            return WooPricely_Product_Prices::get_product_regular_price( $price, $variation );
        }

        public function get_variation_sale_price( $price, $variation, $product ) {

            return WooPricely_Product_Prices::get_product_sale_price( $price, $variation );
        }

        public function get_variation_price( $price, $variation, $product ) {

            return WooPricely_Product_Prices::get_product_sale_price( $price, $variation );
        }

        public function get_variation_prices_hash( $price_hash, $product, $for_display ) {

            if ( is_string( $price_hash ) ) {

                $price_hash . WooPricely_Product_Prices::get_hash();
            }

            if ( is_array( $price_hash ) ) {

                $price_hash[ 'woopricely' ] = WooPricely_Product_Prices::get_hash();
            }
            
            return $price_hash;
        }

        public function get_onsale_ids_cache( $product_ids, $transient ) {

            return WooPricely_Product_Prices::get_on_sale_products( $product_ids );
        }

    }

    new WCWooPricely();
}




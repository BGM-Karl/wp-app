<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WCWooPricely_Cart' ) ) {

    class WCWooPricely_Cart {

        private static $can_set_prices = true;
        private static $cart_data = array();
        private static $parent_products = array();

        public static function get_can_set_prices() {
            return self::$can_set_prices;
        }

        public static function get_data( $level = 0 ) {
            self::$can_set_prices = false;

            if ( isset( self::$cart_data[ $level ] ) ) {
                self::$can_set_prices = true;
                return self::$cart_data[ $level ];
            }

            $cart = self::get_cart( false );

            if ( !$cart ) {
                self::$can_set_prices = true;
                return false;
            }

            self::$cart_data[ $level ] = self::get_contents_data( array(), $cart );
            self::$can_set_prices = true;
            return self::$cart_data[ $level ];
        }

        private static function get_contents_data( $cart_data, $cart ) {

            $cart_data[ 'items' ] = array();

            foreach ( $cart->cart_contents as $key => $item ) {

                $cart_data[ 'items' ][ $key ] = self::get_item( $item );
                $cart_data[ 'items' ][ $key ][ 'data' ] = self::get_product_data( $item[ 'data' ], $key );
            }

            return self::get_totals_data( $cart_data, $cart );
        }

        private static function get_item( $cart_item ) {

            $item = array(
                'key' => $cart_item[ 'product_id' ] . '_' . $cart_item[ 'variation_id' ],
                'product_id' => $cart_item[ 'product_id' ],
                'variation_id' => $cart_item[ 'variation_id' ],
                'quantity' => $cart_item[ 'quantity' ],
                'line_price' => (isset( $cart_item[ 'line_subtotal' ] ) && $cart_item[ 'line_subtotal' ] > 0) ? ($cart_item[ 'line_subtotal' ] / $cart_item[ 'quantity' ]) : 0,
                'line_price_tax' => (isset( $cart_item[ 'line_subtotal_tax' ] ) && $cart_item[ 'line_subtotal_tax' ] > 0) ? ($cart_item[ 'line_subtotal_tax' ] / $cart_item[ 'quantity' ]) : 0,
                'line_total_price' => (isset( $cart_item[ 'line_total' ] ) && $cart_item[ 'line_total' ] > 0) ? ($cart_item[ 'line_total' ] / $cart_item[ 'quantity' ]) : 0,
                'line_total_price_tax' => (isset( $cart_item[ 'line_tax' ] ) && $cart_item[ 'line_tax' ] > 0) ? ($cart_item[ 'line_tax' ] / $cart_item[ 'quantity' ]) : 0,
                'line_subtotal' => isset( $cart_item[ 'line_subtotal' ] ) ? $cart_item[ 'line_subtotal' ] : 0,
                'line_subtotal_tax' => isset( $cart_item[ 'line_subtotal_tax' ] ) ? $cart_item[ 'line_subtotal_tax' ] : 0,
                'line_total' => isset( $cart_item[ 'line_subtotal' ] ) ? $cart_item[ 'line_subtotal' ] : 0,
                'line_tax' => isset( $cart_item[ 'line_subtotal_tax' ] ) ? $cart_item[ 'line_subtotal_tax' ] : 0,
            );

            if ( isset( $cart_item[ 'line_total' ] ) ) {

                $item[ 'line_total' ] = $cart_item[ 'line_total' ];
            }

            if ( isset( $cart_item[ 'line_tax' ] ) ) {

                $item[ 'line_tax' ] = $cart_item[ 'line_tax' ];
            }

            if ( has_filter( 'zcpri/get-cart-item' ) ) {

                $item = apply_filters( 'zcpri/get-cart-item', $item, $cart_item );
            }

            return $item;
        }

        private static function get_product_data( $product, $item_key ) {

            $item_data = array(
                'regular_price' => $product->get_regular_price(),
                'sale_price' => $product->get_sale_price(),
                'price' => $product->get_price(),
                'total_sales' => 0,
                'stock_status' => $product->get_stock_status(),
                'stock_quantity' => $product->get_stock_quantity(),
                'sold_individually' => $product->get_sold_individually(),
                'is_featured' => false,
                'is_on_sale' => $product->is_on_sale(),
                'is_virtual' => $product->is_virtual(),
                'is_downloadable' => $product->is_downloadable(),
                'is_taxable' => $product->is_taxable(),
                'tax_status' => $product->get_tax_status(),
                'tax_class' => $product->get_tax_class(),
                'shipping_class_id' => $product->get_shipping_class_id(),
                'weight' => $product->get_weight(),
                'dimensions' => $product->get_dimensions( false ),
            );

            if ( $product->get_parent_id() > 0 ) {

                $v_product = self::get_parent_product( $product->get_parent_id() );

                $item_data[ 'total_sales' ] = $v_product->get_total_sales();
                $item_data[ 'is_featured' ] = $v_product->is_featured();
                $item_data[ 'category_ids' ] = $v_product->get_category_ids();
                $item_data[ 'tag_ids' ] = $v_product->get_tag_ids();

                $db_attrs = $v_product->get_attributes();
            } else {

                $item_data[ 'total_sales' ] = $product->get_total_sales();
                $item_data[ 'is_featured' ] = $product->is_featured();
                $item_data[ 'category_ids' ] = $product->get_category_ids();
                $item_data[ 'tag_ids' ] = $product->get_tag_ids();

                $db_attrs = $product->get_attributes();
            }

            $attrs = array();

            foreach ( $db_attrs as $db_attr ) {

                foreach ( $db_attr->get_options() as $attr_option ) {

                    $attrs[] = $attr_option;
                }
            }

            $item_data[ 'attribute_ids' ] = $attrs;


            if ( has_filter( 'zcpri/get-cart-product-data' ) ) {

                $item_data = apply_filters( 'zcpri/get-cart-product-data', $item_data, $product, $item_key );
            }
            return $item_data;
        }

        private static function get_totals_data( $cart_data, $cart ) {

            $cart_data[ 'totals' ] = $cart->get_totals();

            if ( has_filter( 'zcpri/get-cart-totals' ) ) {

                $cart_data[ 'totals' ] = apply_filters( 'zcpri/get-cart-totals', $cart_data[ 'totals' ], $cart );
            }

            return self::get_applied_coupons( $cart_data, $cart );
        }

        private static function get_applied_coupons( $cart_data, $cart ) {

            $cart_data[ 'applied_coupons' ] = array();

            $coupon_discount_totals = WC()->session->get( 'coupon_discount_totals', array() );
            $coupon_discount_tax_totals = WC()->session->get( 'coupon_discount_tax_totals', array() );
            $coupons = WC()->session->get( 'applied_coupons', array() );

            foreach ( $coupons as $coupon ) {

                $cart_coupon = array(
                    'coupon_code' => $coupon,
                    'coupon_totals' => 0,
                    'coupon_totals_tax' => 0
                );

                if ( isset( $coupon_discount_totals[ $coupon ] ) ) {
                    $cart_coupon[ 'coupon_totals' ] = $coupon_discount_totals[ $coupon ];
                }

                if ( isset( $coupon_discount_tax_totals[ $coupon ] ) ) {
                    $cart_coupon[ 'coupon_totals_tax' ] = $coupon_discount_tax_totals[ $coupon ];
                }

                $cart_data[ 'applied_coupons' ][] = $cart_coupon;
            }

            if ( has_filter( 'zcpri/get-cart-applied-coupons' ) ) {
                $cart_data[ 'applied_coupons' ] = apply_filters( 'zcpri/get-cart-applied-coupons', $cart_data[ 'applied_coupons' ], $cart );
            }

            return self::get_shipping_rate( $cart_data, $cart );
        }

        private static function get_shipping_rate( $cart_data, $cart ) {

            $needs_shipping = $cart->needs_shipping();

            $cart_data[ 'needs_shipping' ] = $needs_shipping;

            $cart_data[ 'shipping_rates' ] = array();

            $chosen_rate = WC()->session->get( 'chosen_shipping_methods', array() );

            $cnt = 0;

            while ( $package = WC()->session->get( 'shipping_for_package_' . $cnt, false ) ) {

                if ( isset( $package[ 'rates' ] ) && $needs_shipping ) {
                    foreach ( $package[ 'rates' ] as $key => $shipping_rate ) {

                        if ( in_array( $shipping_rate->get_id(), $chosen_rate ) ) {
                            $rate_id = $shipping_rate->get_id();
                            $cart_data[ 'shipping_rates' ][] = array(
                                'id' => $rate_id,
                                'method_id' => $shipping_rate->get_method_id(),
                                'instance_id' => $shipping_rate->get_instance_id(),
                                'cost' => $shipping_rate->get_cost(),
                                'shipping_tax' => $shipping_rate->get_shipping_tax(),
                                'taxes' => $shipping_rate->get_taxes(),
                            );
                        }
                    }
                }
                $cnt++;
            }


            if ( has_filter( 'zcpri/get-cart-shipping-rates' ) ) {
                $cart_data[ 'shipping_rates' ] = apply_filters( 'zcpri/get-cart-shipping-rates', $cart_data[ 'shipping_rates' ], $cart );
            }

            return self::get_payment_method( $cart_data, $cart );
        }

        private static function get_payment_method( $cart_data, $cart ) {

            $cart_data[ 'method_id' ] = WC()->session->get( 'chosen_payment_method', '' );

            if ( has_filter( 'zcpri/get-cart-method-id' ) ) {
                $cart_data[ 'method_id' ] = apply_filters( 'zcpri/get-cart-method-id', $cart_data[ 'method_id' ], $cart );
            }

            return self::get_customer( $cart_data, $cart );
        }

        private static function get_customer( $cart_data, $cart ) {

            $cart_data[ 'customer' ] = array();

            $customer = WC()->session->get( 'customer', false );

            if ( $customer ) {

                $cart_data[ 'customer' ] = array(
                    'id' => $customer[ 'id' ],
                    'email' => $customer[ 'email' ],
                );
            }

            if ( has_filter( 'zcpri/get-cart-customer' ) ) {
                $cart_data[ 'method_id' ] = apply_filters( 'zcpri/get-cart-customer', $cart_data[ 'customer' ], $cart );
            }

            return $cart_data;
        }

        private static function get_parent_product( $parent_id ) {

            if ( isset( self::$parent_products[ $parent_id ] ) ) {

                return self::$parent_products[ $parent_id ];
            }

            self::$parent_products[ $parent_id ] = wc_get_product( $parent_id );

            return self::$parent_products[ $parent_id ];
        }

        private static function get_cart() {

            if ( !WC()->cart ) {

                return false;
            }

            if ( method_exists( WC()->cart, 'is_empty' ) && WC()->cart->is_empty() ) {

                return false;
            }

            return WC()->cart;
        }

    }

}
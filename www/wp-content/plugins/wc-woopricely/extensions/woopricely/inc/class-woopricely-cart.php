<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists( 'WooPricely_Cart' ) ) {

    class WooPricely_Cart {

        private static $cart_products = array();
        private static $calculating = false;
        private static $is_mini_cart = false;
        private static $is_cart_or_checkout = false;

        public static function init() {

            add_action( 'woocommerce_before_calculate_totals', array( new self(), 'do_before_calculate_totals' ) );
            add_action( 'woocommerce_after_calculate_totals', array( new self(), 'do_after_calculate_totals' ) );

            add_action( 'woocommerce_before_cart_table', array( new self(), 'do_before_cart_table' ) );
            add_action( 'woocommerce_after_cart_table', array( new self(), 'do_after_cart_table' ) );

            add_action( 'woocommerce_before_cart_totals', array( new self(), 'do_before_totals' ) );
            add_action( 'woocommerce_after_cart_totals', array( new self(), 'do_after_totals' ) );

            add_action( 'woocommerce_review_order_before_cart_contents', array( new self(), 'do_before_totals' ) );
            add_action( 'woocommerce_review_order_after_order_total', array( new self(), 'do_after_totals' ) );

            add_action( 'woocommerce_before_mini_cart', array( new self(), 'do_mini_cart_before' ) );
            add_action( 'woocommerce_after_mini_cart', array( new self(), 'do_mini_cart_after' ) );

            add_action( 'wp_loaded', 'WooPricely::clear_cart_auto_add' );

            add_filter( 'woocommerce_product_get_price', array( new self(), 'get_product_sale_price' ), 9999999, 2 );
            add_filter( 'woocommerce_product_variation_get_price', array( new self(), 'get_product_sale_price' ), 9999999, 2 );


            add_filter( 'woocommerce_cart_hash', array( new self(), 'get_cart_hash' ), 10, 2 );
        }

        public static function get_cart_discounts( $catch = true ) {

            if ( $catch == true ) {

                if ( count( self::$cart_products ) == 0 ) {

                    self::$cart_products = WooPricely_Checkout_Prices::calculate_product_prices();
                }
            } else {

                self::$cart_products = WooPricely_Checkout_Prices::calculate_product_prices();
            }

            return self::$cart_products;
        }

        public static function get_cart_discount( $key ) {

            self::get_cart_discounts();

            foreach ( self::$cart_products as $cart_discount ) {

                if ( $cart_discount[ 'cart_key' ] == $key ) {

                    return $cart_discount;
                }
            }

            return array();
        }

        public static function do_before_calculate_totals( $cart_object ) {

            self::$is_cart_or_checkout = true;

            if ( WC()->cart->is_empty() ) {

                WooPricely::clear_cart_auto_add();
            }
        }

        public static function do_after_calculate_totals( $cart_object ) {

            self::$is_cart_or_checkout = false;
        }

        public static function do_before_cart_table() {

            self::$is_cart_or_checkout = true;
        }

        public static function do_after_cart_table() {

            self::$is_cart_or_checkout = false;
        }

        public static function do_before_totals() {

            self::$is_cart_or_checkout = true;
        }

        public static function do_after_totals() {

            self::$is_cart_or_checkout = false;
        }

        public static function do_mini_cart_before() {

            self::$is_mini_cart = true;
        }

        public static function do_mini_cart_after() {

            self::$is_mini_cart = false;
        }

        public static function get_product_sale_price( $price, $src_product ) {

            if ( !WCWooPricely_Cart::get_can_set_prices() ) {

                return $price;
            }

            if ( self::$calculating == true ) {

                return $price;
            }

            self::$calculating = true;

            if ( !self::is_cart_or_checkout_price() ) {

                self::$calculating = false;

                return $price;
            }

            $product_id = $src_product->get_id();

            self::get_cart_discounts();

            foreach ( self::$cart_products as $product ) {

                if ( $product[ 'id' ] == $product_id ) {

                    self::$calculating = false;

                    if ( has_filter( 'zcpri/applied_product_price' ) ) {

                        return apply_filters( 'zcpri/applied_product_price', $product[ 'discount_price' ] );
                    }

                    return $product[ 'discount_price' ];
                }
            }

            self::$calculating = false;

            return $price;
        }

        public static function get_cart_hash( $hash, $cart_session ) {

            self::get_cart_discounts();

            if ( !count( self::$cart_products ) ) {

                return $hash;
            }

            $hash_data = array(
                'cart_session' => $cart_session,
                'woopricely' => self::$cart_products
            );

            return md5( wp_json_encode( $hash_data ) );
        }

        public static function is_cart_or_checkout_price() {

            if ( self::$is_cart_or_checkout ) {

                return true;
            }

            if ( self::$is_mini_cart ) {

                return true;
            }

            return false;
        }

        public static function is_mini_cart_price() {

            if ( self::$is_mini_cart ) {

                return true;
            }

            return false;
        }

    }

    WooPricely_Cart::init();
}




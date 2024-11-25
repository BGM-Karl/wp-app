<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WCWooPricely_WMC' ) && function_exists( 'wmc_get_price' ) ) {

    class WCWooPricely_WMC {

        public function __construct() {

            add_filter( 'zcpri/applied_product_price', array( $this, 'convert_product_price' ) );
            add_filter( 'zcpri/get-checkout-prices', array( $this, 'convert_checkout_prices' ) );
            add_filter( 'zcpri/get-product-prices-data', array( $this, 'convert_product_prices_data' ) );
            add_filter( 'zcpri/get-applied-discount', array( $this, 'convert_discount_amount' ) );
            add_filter( 'zcpri/get-applied-discount-totals', array( $this, 'convert_discount_amount' ) );
            add_filter( 'zcpri/get-applied-fee', array( $this, 'convert_fee_amount' ) );

            add_filter( 'zcpri/get-contidtion-subtotals', array( $this, 'revert_product_price' ) );
            add_filter( 'zcpri/get-cart-shipping-rates', array( $this, 'revert_shipping_rates' ) );

            add_filter( 'zcpri/get-cart-item', array( $this, 'revert_cart_item_prices' ), 10, 2 );
            add_filter( 'zcpri/get-cart-product-data', array( $this, 'revert_cart_item_data_prices' ), 10, 3 );
            add_filter( 'zcpri/get-cart-totals', array( $this, 'revert_cart_totals' ) );
        }

        public function convert_product_price( $price ) {

            return wmc_get_price( $price );
        }

        public function convert_product_prices_data( $prices_data ) {

            if ( !isset( $prices_data[ 'prices_table' ] ) ) {
                return $prices_data;
            }

            $keys = array_keys( $prices_data[ 'prices_table' ] );

            foreach ( $keys as $key ) {

                $p_keys = array_keys( $prices_data[ 'prices_table' ][ $key ][ 'price' ] );

                foreach ( $p_keys as $p_key ) {
                    $prices_data[ 'prices_table' ][ $key ][ 'price' ][ $p_key ] = wmc_get_price( $prices_data[ 'prices_table' ][ $key ][ 'price' ][ $p_key ] );
                }
            }

            return $prices_data;
        }

        public function convert_checkout_prices( $checkout_prices ) {

            if ( isset( $checkout_prices[ 'discount_price' ] ) ) {
                $checkout_prices[ 'discount_price' ] = wmc_get_price( $checkout_prices[ 'discount_price' ] );
            }

            if ( isset( $checkout_prices[ 'discount_detail' ] ) ) {
                $checkout_prices[ 'discount_detail' ] = $this->convert_checkout_prices_details( $checkout_prices[ 'discount_detail' ] );
            }

            return $checkout_prices;
        }

        private function convert_checkout_prices_details( $price_details ) {

            $keys = array_keys( $price_details );

            foreach ( $keys as $key ) {
                $price_details[ $key ][ 'price' ] = wmc_get_price( $price_details[ $key ][ 'price' ] );
            }
            return $price_details;
        }

        public function convert_discount_amount( $amount ) {

            return wmc_get_price( $amount );
        }

        public function convert_fee_amount( $amount ) {

            return wmc_get_price( $amount );
        }

        public function revert_product_price( $price ) {

            return wmc_revert_price( $price );
        }

        public function revert_cart_item_prices( $item, $cart_item ) {

            $item[ 'line_price' ] = wmc_revert_price( $item[ 'line_price' ] );
            $item[ 'line_price_tax' ] = wmc_revert_price( $item[ 'line_price_tax' ] );
            $item[ 'line_total_price' ] = wmc_revert_price( $item[ 'line_total_price' ] );
            $item[ 'line_total_price_tax' ] = wmc_revert_price( $item[ 'line_total_price_tax' ] );
            $item[ 'line_subtotal' ] = wmc_revert_price( $item[ 'line_subtotal' ] );
            $item[ 'line_subtotal_tax' ] = wmc_revert_price( $item[ 'line_subtotal_tax' ] );
            $item[ 'line_total' ] = wmc_revert_price( $item[ 'line_total' ] );
            $item[ 'line_tax' ] = wmc_revert_price( $item[ 'line_tax' ] );

            return $item;
        }

        public function revert_cart_item_data_prices( $item_data, $product, $item_key ) {

            if ( is_numeric( $item_data[ 'regular_price' ] ) ) {
                $item_data[ 'regular_price' ] = wmc_revert_price( $item_data[ 'regular_price' ] );
            }

            if ( is_numeric( $item_data[ 'sale_price' ] ) ) {
                $item_data[ 'sale_price' ] = wmc_revert_price( $item_data[ 'sale_price' ] );
            }

            if ( is_numeric( $item_data[ 'price' ] ) ) {
                $item_data[ 'price' ] = wmc_revert_price( $item_data[ 'price' ] );
            }

            return $item_data;
        }

        public function revert_cart_totals( $totals ) {

            $totals[ 'subtotal' ] = wmc_revert_price( $totals[ 'subtotal' ] );
            $totals[ 'subtotal_tax' ] = wmc_revert_price( $totals[ 'subtotal_tax' ] );
            $totals[ 'shipping_total' ] = wmc_revert_price( $totals[ 'shipping_total' ] );
            $totals[ 'shipping_tax' ] = wmc_revert_price( $totals[ 'shipping_tax' ] );
            $totals[ 'shipping_taxes' ] = $this->revert_taxes( $totals[ 'shipping_taxes' ] );

            return $totals;
        }

        public function revert_shipping_rates( $shipping_rates ) {

            $keys = array_keys( $shipping_rates );
            foreach ( $keys as $key ) {

                $shipping_rates[ $key ][ 'cost' ] = wmc_revert_price( $shipping_rates[ $key ][ 'cost' ] );
                $shipping_rates[ $key ][ 'shipping_tax' ] = wmc_revert_price( $shipping_rates[ $key ][ 'shipping_tax' ] );
                $shipping_rates[ $key ][ 'taxes' ] = $this->revert_taxes( $shipping_rates[ $key ][ 'taxes' ] );
            }

            return $shipping_rates;
        }

        private function revert_taxes( $taxes ) {

            $keys = array_keys( $taxes );

            foreach ( $keys as $key ) {
                $taxes[ $key ] = wmc_revert_price( $taxes[ $key ] );
            }

            return $taxes;
        }

    }

    new WCWooPricely_WMC();
}

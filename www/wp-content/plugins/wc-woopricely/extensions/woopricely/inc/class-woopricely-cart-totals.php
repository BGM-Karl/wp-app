<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists( 'WooPricely_Cart_Totals' ) ) {

    class WooPricely_Cart_Totals {

        private static $cart_totals = array();

        public static function get_subtotals( $inc_tax = false, $value_id = 0 ) {



            if ( !isset( self::$cart_totals[ $value_id ][ 'subtotal' ] ) ) {
                $subtotal = 0;
                $subtotal_tax = 0;

                if ( $value_id == 0 ) {

                    $cart_data = WCWooPricely_Cart::get_data();

                    if ( !$cart_data ) {

                        return 0;
                    }

                    if ( !isset( $cart_data[ 'items' ] ) ) {
                        return 0;
                    }

                    foreach ( $cart_data[ 'items' ] as $key => $item ) {

                        $qty = $item[ 'quantity' ];

                        $subtotal += ($item[ 'data' ][ 'price' ] * $qty);

                        if ( self::is_item_taxable( $item ) ) {

                            $subtotal_tax += self::get_subtotal_tax( $item[ 'data' ][ 'price' ] * $qty, $item[ 'data' ][ 'tax_class' ] );
                        }
                    }
                } else if ( $value_id == 1 ) {

                    $cart_data = WCWooPricely_Cart::get_data();

                    if ( !$cart_data ) {

                        return 0;
                    }

                    if ( !isset( $cart_data[ 'items' ] ) ) {
                        return 0;
                    }

                    foreach ( $cart_data[ 'items' ] as $key => $item ) {

                        $qty = $item[ 'quantity' ];

                        $subtotal += ($item[ 'line_total_price' ] * $qty);
                        $subtotal_tax += ($item[ 'line_total_price_tax' ] * $qty);
                    }
                } else {

                    $cart_data = WCWooPricely_Cart::get_data( $value_id );

                    if ( !$cart_data ) {

                        return 0;
                    }

                    if ( !isset( $cart_data[ 'totals' ] ) ) {
                        return 0;
                    }

                    $subtotal += $cart_data[ 'totals' ][ 'subtotal' ];
                    $subtotal_tax += $cart_data[ 'totals' ][ 'subtotal_tax' ];
                }

                if ( $subtotal > 0 ) {
                    self::$cart_totals[ $value_id ][ 'subtotal' ] = $subtotal;
                    self::$cart_totals[ $value_id ][ 'subtotal_tax' ] = $subtotal_tax;
                }
            }

            if ( isset( self::$cart_totals[ $value_id ][ 'subtotal' ] ) ) {

                if ( $inc_tax == true ) {
                    return (self::$cart_totals[ $value_id ][ 'subtotal' ] + self::$cart_totals[ $value_id ][ 'subtotal_tax' ]);
                } else {
                    return self::$cart_totals[ $value_id ][ 'subtotal' ];
                }
            }

            return 0;
        }

        private static function get_subtotal_tax( $subtotal, $tax_class ) {

            $tax_rates = WC_Tax::get_rates( $tax_class );

            $taxes = WC_Tax::calc_tax( $subtotal, $tax_rates, wc_prices_include_tax() );

            if ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) {
                $taxes_total = array_sum( $taxes );
            } else {
                $taxes_total = array_sum( array_map( 'wc_round_tax_total', $taxes ) );
            }

            return round( $taxes_total, wc_get_price_decimals() );
        }

        private static function is_item_taxable( $cart_item ) {

            if ( !wc_tax_enabled() ) {
                return false;
            }

            if ( !$cart_item[ 'data' ][ 'is_taxable' ] ) {
                return false;
            }

            if ( 'taxable' != $cart_item[ 'data' ][ 'tax_status' ] ) {
                return false;
            }

            return true;
        }

        public static function get_totals_id_by_module_id( $module_id = '' ) {

            if ( $module_id == 'checkout_prices' ) {
                return 1;
            }
            if ( $module_id == 'checkout_discounts' ) {
                return 2;
            }
            if ( $module_id == 'checkout_fees' ) {
                return 2;
            }

            return 0;
        }

    }

}

<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists( 'WooPricely_Views' ) ) {

    class WooPricely_Views {

        private static $discounts_total = 0;
        private static $prices_discounts_total = 0;
        private static $coupon_views = array();
        private static $fee_descs = array();

        public static function set_discounts_total( $amount ) {
            self::$discounts_total = $amount;
        }

        public static function set_prices_discounts_total( $amount ) {
            self::$prices_discounts_total = $amount;
        }

        public static function set_fee_descs( $id, $desc ) {
            self::$fee_descs[ $id ] = $desc;
        }

        public static function set_coupon_label( $coupon_code, $coupon_view ) {

            self::$coupon_views[ $coupon_code ] = $coupon_view;
        }

        public static function promo_message() {
            $product_id = get_the_ID();
            $message = WooPricely_Product_Prices::get_product_promo_message( $product_id );
            $product_prop = WooPricely_Checkout_Prices::get_single_product_data( $product_id );

            if ( isset( $product_prop[ 'message' ] ) && $product_prop[ 'message' ] != '' ) {
                $message = $product_prop[ 'message' ];
            }
            if ( $message == '' ) {
                return;
            }

            include 'views/views-promo.php';
        }

        public static function metrics_table() {
            global $zc_pri;

            $metrics_table = array(
                'enable' => 'yes',
                'layout' => 'horizontal',
                'show_headers' => 'yes',
            );

            if ( isset( $zc_pri[ 'metrics_tables' ] ) ) {
                $metrics_table = $zc_pri[ 'metrics_tables' ];
            }

            if ( $metrics_table[ 'enable' ] == 'no' ) {
                return;
            }

            $product_id = get_the_ID();
            $product_prop = WooPricely_Checkout_Prices::get_single_product_data( $product_id );
            if ( !isset( $product_prop[ 'mode' ] ) ) {
                return;
            }

            if ( $product_prop[ 'mode' ] != 'bulk' && $product_prop[ 'mode' ] != 'tiered' ) {
                return;
            }

            $m_table = self::get_metrics_table( $product_prop[ 'table_id' ] );

            if ( $m_table[ 'show_missed_ranges' ] != 'yes' ) {
                if ( isset( $product_prop[ 'prices_table' ] ) && is_array( $product_prop[ 'prices_table' ] ) ) {
                    for ( $i = 0; $i < count( $product_prop[ 'prices_table' ] ); $i++ ) {
                        if ( $product_prop[ 'prices_table' ][ $i ][ 'is_missing' ] == true ) {
                            unset( $product_prop[ 'prices_table' ][ $i ] );
                        }
                    }
                }
            }

            include 'views/views-metrics-table.php';
        }

        public static function countdown_timer() {

            global $zc_pri;

            $countdown_timer = array(
                'enable' => 'no',
            );

            if ( isset( $zc_pri[ 'countdown_timer' ] ) ) {

                $countdown_timer = $zc_pri[ 'countdown_timer' ];
            }

            if ( $countdown_timer[ 'enable' ] == 'no' ) {

                return;
            }

            $product_id = get_the_ID();

            $product_prop = WooPricely_Checkout_Prices::get_single_product_data( $product_id );

            $time_left = WooPricely_Product_Prices::get_prices_time_left( $product_id );

            if ( isset( $product_prop[ 'time_left' ] ) ) {

                $time_left = $product_prop[ 'time_left' ];
            }

            if ( $time_left == '' ) {

                return;
            }


            $t_left = date_format( DateTime::createFromFormat( 'Y-m-d H:i:s', $time_left ), 'U' ) - current_time( 'timestamp' );


            if ( $countdown_timer[ 'time_left_mode' ] != 'no' && $countdown_timer[ 'time_left_mode' ] != '' ) {

                $total_t_left = $countdown_timer[ 'time_left' ];

                if ( $countdown_timer[ 'time_left_mode' ] == 'minutes' ) {

                    $total_t_left = MINUTE_IN_SECONDS * $countdown_timer[ 'time_left' ];
                }
                if ( $countdown_timer[ 'time_left_mode' ] == 'hours' ) {

                    $total_t_left = HOUR_IN_SECONDS * $countdown_timer[ 'time_left' ];
                }

                if ( $countdown_timer[ 'time_left_mode' ] == 'days' ) {

                    $total_t_left = DAY_IN_SECONDS * $countdown_timer[ 'time_left' ];
                }
                if ( $countdown_timer[ 'time_left_mode' ] == 'weeks' ) {

                    $total_t_left = WEEK_IN_SECONDS * $countdown_timer[ 'time_left' ];
                }

                if ( $countdown_timer[ 'time_left_mode' ] == 'months' ) {

                    $total_t_left = MONTH_IN_SECONDS * $countdown_timer[ 'time_left' ];
                }

                if ( $t_left > $total_t_left ) {

                    return;
                }
            }


            $pri_days = esc_html__( 'Days', 'zcpri-woopricely' );
            $pri_hours = esc_html__( 'Hours', 'zcpri-woopricely' );
            $pri_minutes = esc_html__( 'Minutes', 'zcpri-woopricely' );
            $pri_seconds = esc_html__( 'Seconds', 'zcpri-woopricely' );


            $timer_title = apply_filters( 'zcpri/get-countdown-timer-title', $countdown_timer[ 'title' ] );

            include 'views/views-countdown-timer.php';
        }

        public static function fee_html( $fee_html, $fee ) {

            if ( isset( self::$fee_descs[ $fee->id ] ) && self::$fee_descs[ $fee->id ] != '' ) {

                return $fee_html . '<span class="zc_zri_fee zc_zri_fee_rel  dashicons dashicons-editor-help" title="' . wc_sanitize_tooltip( self::$fee_descs[ $fee->id ] ) . '"></span>';
            }

            return $fee_html;
        }

        public static function coupon_label( $label, $coupon ) {

            global $zc_pri;

            $replace_labels = array(
                'enable' => 'no',
                'replace_labels' => 'no',
            );

            if ( isset( $zc_pri[ 'discount_coupon' ] ) ) {

                $replace_labels = $zc_pri[ 'discount_coupon' ];
            }

            if ( $replace_labels[ 'enable' ] == 'no' ) {

                return $label;
            }

            if ( $replace_labels[ 'replace_labels' ] == 'no' ) {

                return $label;
            }

            $code = '';

            if ( is_array( $coupon ) ) {

                $code = $coupon[ 'code' ];
            } else {

                $code = $coupon->get_code();
            }

            if ( isset( self::$coupon_views[ $code ][ 'title' ] ) ) {

                $title = self::$coupon_views[ $code ][ 'title' ];

                if ( isset( self::$coupon_views[ $code ][ 'desc' ] ) && self::$coupon_views[ $code ][ 'desc' ] != '' ) {

                    $title = $title . '<span class="zc_zri_fee dashicons dashicons-editor-help" title="' . wc_sanitize_tooltip( self::$coupon_views[ $code ][ 'desc' ] ) . '"></span>';
                }

                return $title;
            }

            return $label;
        }

        public static function coupon_html( $coupon_html, $coupon, $discount_amount_html ) {

            $code = '';

            if ( is_array( $coupon ) ) {

                $code = $coupon[ 'code' ];
            } else {

                $code = $coupon->get_code();
            }

            if ( !isset( self::$coupon_views[ $code ] ) ) {

                return $coupon_html;
            }

            $amount = 0;

            if ( is_array( $coupon ) ) {

                $amount = $coupon[ 'amount' ];
            } else {

                $amount = $coupon->get_amount();
            }

            if ( $amount > 0 ) {

                return $discount_amount_html;
            }
            return '-' . wc_price( $amount );
        }

        public static function cart_discounts_total() {

            global $zc_pri;

            if ( self::$discounts_total <= 0 && self::$prices_discounts_total <= 0 ) {

                return;
            }

            $discounts_total_text = esc_html__( 'Discounts Total:', 'zcpri-woopricely' );

            $mode_total = 'yes_neg';

            if ( isset( $zc_pri[ 'discounts_total' ][ 'titles' ][ 'cart' ] ) ) {

                $discounts_total_text = $zc_pri[ 'discounts_total' ][ 'titles' ][ 'cart' ];

                if ( has_filter( 'zcpri/get-cart-total-discounts' ) ) {

                    $discounts_total_text = apply_filters( 'zcpri/get-cart-total-discounts', $discounts_total_text );
                }
            }

            if ( isset( $zc_pri[ 'discounts_total' ][ 'enable' ][ 'on_cart' ] ) ) {

                $mode_total = $zc_pri[ 'discounts_total' ][ 'enable' ][ 'on_cart' ];
            }

            $discounts_total = self::$discounts_total + self::$prices_discounts_total;

            if ( $mode_total == 'yes_neg' ) {

                $discounts_total = 0 - (self::$discounts_total + self::$prices_discounts_total);
            }

            include 'views/views-discounts-total.php';
        }

        public static function checkout_discounts_total() {

            global $zc_pri;

            if ( self::$discounts_total <= 0 && self::$prices_discounts_total <= 0 ) {

                return;
            }

            $discounts_total_text = 'Discounts Total:';

            $mode_total = 'yes_neg';

            if ( isset( $zc_pri[ 'discounts_total' ][ 'titles' ][ 'checkout' ] ) ) {

                $discounts_total_text = $zc_pri[ 'discounts_total' ][ 'titles' ][ 'checkout' ];

                if ( has_filter( 'zcpri/get-checkout-total-discounts' ) ) {

                    $discounts_total_text = apply_filters( 'zcpri/get-checkout-total-discounts', $discounts_total_text );
                }
            }

            if ( isset( $zc_pri[ 'discounts_total' ][ 'enable' ][ 'on_checkout' ] ) ) {

                $mode_total = $zc_pri[ 'discounts_total' ][ 'enable' ][ 'on_checkout' ];
            }

            $discounts_total = self::$discounts_total + self::$prices_discounts_total;

            if ( $mode_total == 'yes_neg' ) {

                $discounts_total = 0 - (self::$discounts_total + self::$prices_discounts_total);
            }

            include 'views/views-discounts-total.php';
        }

        public static function cart_item_price_display( $price, $cart_item, $cart_item_key ) {

            $cart_discount = self::get_cart_discount( $cart_item_key );

            if ( isset( $cart_discount[ 'mode' ] ) ) {

                return self::get_cart_item_price_display( $price, $cart_item, $cart_item_key, $cart_discount );
            }

            return $price;
        }

        public static function mini_cart_item_price_display( $price, $cart_item, $cart_item_key ) {

            $cart_discount = self::get_cart_discount( $cart_item_key );

            if ( isset( $cart_discount[ 'mode' ] ) ) {

                $result = '<span class="quantity">';

                $result .= self::get_cart_item_price_display( $price, $cart_item, $cart_item_key, $cart_discount, true );

                $result .= '</span>';

                return wp_kses_post( $result );
            }

            return $price;
        }

        private static function get_cart_item_price_display( $price, $cart_item, $cart_item_key, $cart_discount, $is_mini_cart = false ) {

            if ( !isset( $cart_discount[ 'mode' ] ) ) {

                return $price;
            }


            if ( isset( $cart_discount[ 'discount_detail' ] ) ) {

                $result = '';

                $qty = 0;

                if ( count( $cart_discount[ 'discount_detail' ] ) == 1 ) {

                    $discount_detail = $cart_discount[ 'discount_detail' ][ 0 ];

                    $qty += $discount_detail[ 'qty' ];

                    if ( $qty < $cart_item[ 'quantity' ] ) {

                        $result .= '<div class="zcpri_cart_item_price">';

                        $result .= '<div class="zcpri_cart_item_price_value">';
                        $result .= sprintf( '<ins>%s</ins>', wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ) );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_qty_value">';
                        $result .= sprintf( '&times; %d', ($cart_item[ 'quantity' ] - $qty ) );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_clear"></div>';

                        $result .= '<div class="zcpri_cart_item_price_value">';
                        $result .= sprintf( '<del>%s</del> <ins>%s</ins>', wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ), wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $discount_detail[ 'price' ] ) ) );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_qty_value">';
                        $result .= sprintf( '&times; %d', $discount_detail[ 'qty' ] );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_clear"></div>';

                        $result .= '</div>';
                    } else {

                        $result .= '<div class="zcpri_cart_item_price">';

                        if ( $is_mini_cart == true ) {

                            if ( $discount_detail[ 'price' ] > $cart_discount[ 'cart_price' ] ) {

                                $result .= sprintf( '%d &times; %s', $cart_item[ 'quantity' ], wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $discount_detail[ 'price' ] ) ) );
                            } else {

                                $result .= sprintf( '%d &times; <del>%s</del> <ins>%s</ins>', $cart_item[ 'quantity' ], wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ), wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $discount_detail[ 'price' ] ) ) );
                            }
                        } else {

                            if ( $discount_detail[ 'price' ] > $cart_discount[ 'cart_price' ] ) {

                                $result .= wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $discount_detail[ 'price' ] ) );
                            } else {

                                $result .= sprintf( '<del>%s</del> <ins>%s</ins>', wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ), wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $discount_detail[ 'price' ] ) ) );
                            }
                        }

                        $result .= '</div>';
                    }
                } else {

                    $result .= '<div class="zcpri_cart_item_price">';

                    foreach ( $cart_discount[ 'discount_detail' ] as $disc_detail ) {

                        $qty += $disc_detail[ 'qty' ];
                    }

                    if ( $qty < $cart_item[ 'quantity' ] ) {

                        $result .= '<div class="zcpri_cart_item_price_value">';
                        $result .= sprintf( '<ins>%s</ins>', wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ) );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_qty_value">';
                        $result .= sprintf( '&times; %d', ($cart_item[ 'quantity' ] - $qty ) );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_clear"></div>';
                    }

                    foreach ( self::sort_price_qty( $cart_discount[ 'discount_detail' ] ) as $discount_detail ) {

                        $result .= '<div class="zcpri_cart_item_price_value">';
                        $result .= sprintf( '<del>%s</del> <ins>%s</ins>', wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ), wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $discount_detail[ 'price' ] ) ) );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_qty_value">';
                        $result .= sprintf( '&times; %d', $discount_detail[ 'qty' ] );
                        $result .= '</div>';
                        $result .= '<div class="zcpri_cart_item_clear"></div>';
                    }

                    $result .= '</div>';
                }

                return wp_kses_post( $result );
            }

            if ( $cart_discount[ 'cart_price' ] <> $cart_discount[ 'discount_price' ] ) {

                $result = '<div class="zcpri_cart_item_price">';

                if ( $is_mini_cart == true ) {

                    if ( $cart_discount[ 'discount_price' ] > $cart_discount[ 'cart_price' ] ) {

                        $result .= sprintf( '%d &times; %s', $cart_item[ 'quantity' ], wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'discount_price' ] ) ) );
                    } else {

                        $result .= sprintf( '%d &times; <del>%s</del> <ins>%s</ins>', $cart_item[ 'quantity' ], wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ), wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'discount_price' ] ) ) );
                    }
                } else {

                    if ( $cart_discount[ 'discount_price' ] > $cart_discount[ 'cart_price' ] ) {

                        $result .= wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'discount_price' ] ) );
                    } else {

                        $result .= sprintf( '<del>%s</del> <ins>%s</ins>', wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'cart_price' ] ) ), wc_price( self::get_cart_price_to_display( $cart_discount[ 'key' ], $cart_discount[ 'discount_price' ] ) ) );
                    }
                }

                $result .= '</div>';

                return wp_kses_post( $result );
            }


            return $price;
        }

        private static function sort_price_qty( $price_qty ) {

            $pri_qty = array();

            $prices = array();

            foreach ( $price_qty as $price ) {

                if ( isset( $price[ 'price' ] ) ) {

                    $prices[] = $price[ 'price' ];
                }
            }

            sort( $prices );


            $prices = array_reverse( $prices );

            foreach ( $prices as $price ) {

                foreach ( $price_qty as $key => $p_qty ) {

                    if ( !isset( $price_qty[ $key ][ 'added' ] ) && $p_qty[ 'price' ] == $price ) {

                        $pri_qty[] = $p_qty;

                        $price_qty[ $key ][ 'added' ] = true;
                    }
                }
            }

            return $pri_qty;
        }

        private static function get_metrics_table( $table_id ) {
            global $zc_pri;

            $metrics_tables = array(
                'id' => $table_id,
                'table_title' => array(
                    'enable' => 'yes',
                    'title' => esc_html__( 'Volume Pricing', 'zcpri-woopricely' ),
                ),
                'quatity_row' => array(
                    'enable' => 'yes',
                    'label' => esc_html__( 'Qty', 'zcpri-woopricely' ),
                ),
                'price_row' => array(
                    'enable' => 'yes',
                    'label' => esc_html__( 'Price', 'zcpri-woopricely' ),
                ),
                'price_per_row' => array(
                    'enable' => 'no',
                    'label' => esc_html__( 'Price (%)', 'zcpri-woopricely' ),
                ),
                'discount_row' => array(
                    'enable' => 'yes',
                    'label' => esc_html__( 'Discount', 'zcpri-woopricely' ),
                ),
                'discount_per_row' => array(
                    'enable' => 'no',
                    'label' => esc_html__( 'Discount (%)', 'zcpri-woopricely' ),
                ),
                'show_missed_ranges' => 'yes',
            );


            if ( isset( $zc_pri[ 'metrics_tables' ][ 'tables' ] ) ) {
                $tb = array();
                $cnt = 0;
                foreach ( $zc_pri[ 'metrics_tables' ][ 'tables' ] as $table ) {

                    $option_id = $table[ 'option_id' ];

                    if ( $option_id == $table_id ) {
                        $tb[ 'id' ] = $option_id;
                        $tb[ 'table_title' ] = $table[ 'table_title' ];
                        $tb[ 'quatity_row' ] = $table[ 'quatity_row' ];
                        $tb[ 'price_row' ] = $table[ 'price_row' ];
                        $tb[ 'price_per_row' ] = $table[ 'price_per_row' ];
                        $tb[ 'discount_row' ] = $table[ 'discount_row' ];
                        $tb[ 'discount_per_row' ] = $table[ 'discount_per_row' ];
                        $tb[ 'show_missed_ranges' ] = isset( $table[ 'show_missed_ranges' ] ) ? $table[ 'show_missed_ranges' ] : 'yes';
                        $metrics_tables = $tb;
                        break;
                    }
                }
            }

            if ( has_filter( 'zcpri/get-metrics-table' ) ) {
                
                $metrics_tables = apply_filters( 'zcpri/get-metrics-table', $metrics_tables, $table_id );
            }

            return $metrics_tables;
        }

        private static function get_cart_price_to_display( $product_key, $price ) {

            if ( $product_key == '' ) {

                return $price;
            }

            $product = WooPricely::get_product_by_key( $product_key );

            if ( !$product ) {

                return $price;
            }

            $price_args = array(
                'qty' => 1,
                'price' => $price
            );

            if ( WC()->cart->display_prices_including_tax() ) {

                return wc_get_price_including_tax( $product, $price_args );
            }

            return wc_get_price_excluding_tax( $product, $price_args );
        }

        private static function get_cart_discount( $cart_item_key ) {

            $cart_discount = WooPricely_Cart::get_cart_discount( $cart_item_key );

            if ( has_filter( 'zcpri/get-checkout-prices' ) ) {

                return apply_filters( 'zcpri/get-checkout-prices', $cart_discount );
            }

            return $cart_discount;
        }

    }

}

    

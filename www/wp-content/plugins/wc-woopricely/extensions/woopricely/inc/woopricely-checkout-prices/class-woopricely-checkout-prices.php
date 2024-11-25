<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

require_once (dirname( __FILE__ ) . '/class-woopricely-checkout-simple-prices.php');
require_once (dirname( __FILE__ ) . '/class-woopricely-checkout-bulk-prices.php');
require_once (dirname( __FILE__ ) . '/class-woopricely-checkout-group-prices.php');
require_once (dirname( __FILE__ ) . '/class-woopricely-checkout-bogo-prices.php');

if ( !class_exists( 'WooPricely_Checkout_Prices' ) ) {

    class WooPricely_Checkout_Prices {

        private static $products_data = array();
        private static $total_discounts = 0;

        public static function get_single_product_data( $product_id ) {

            if ( !isset( self::$products_data[ $product_id ] ) ) {

                foreach ( self::process_product_data( $product_id ) as $data ) {

                    self::$products_data[ $data[ 'id' ] ] = $data;
                }
            }

            if ( isset( self::$products_data[ $product_id ] ) ) {

                if ( has_filter( 'zcpri/get-product-prices-data' ) ) {

                    self::$products_data[ $product_id ] = apply_filters( 'zcpri/get-product-prices-data', self::$products_data[ $product_id ] );
                }

                return self::$products_data[ $product_id ];
            }

            return array();
        }

        public static function get_total_discounts() {

            return self::$total_discounts;
        }

        private static function process_product_data( $product_id ) {

            global $zc_pri;
            $rls_mode = isset( $zc_pri[ 'checkout_prices' ][ 'mode' ] ) ? $zc_pri[ 'checkout_prices' ][ 'mode' ] : 'all';
            if ( $rls_mode == 'no' ) {
                return array();
            }


            $rules = self::get_checkout_prices_valid_rules( $product_id );
            $rules_count = count( $rules );

            if ( $rules_count == 0 ) {
                return array();
            }
            $r_data = array();


            if ( $rls_mode == 'first' ) {
                $r_data = apply_filters( 'zcpri/get-checkout-prices-' . $rules[ 0 ][ 'mode' ] . '-product-data', array(), $rules[ 0 ] );
            } else {
                $r_d = array();
                foreach ( $rules as $rule ) {
                    $r_p_data = apply_filters( 'zcpri/get-checkout-prices-' . $rule[ 'mode' ] . '-product-data', array(), $rule );
                    foreach ( $r_p_data as $r_dt ) {
                        $r_data[] = $r_dt;
                    }
                }
            }

            return $r_data;
        }

        public static function calculate_product_prices() {

            global $zc_pri;

            $rls_mode = isset( $zc_pri[ 'checkout_prices' ][ 'mode' ] ) ? $zc_pri[ 'checkout_prices' ][ 'mode' ] : 'all';

            if ( $rls_mode == 'no' ) {

                return array();
            }

            $max_discount_amount = isset( $zc_pri[ 'checkout_prices' ][ 'max_discount_amount' ] ) ? $zc_pri[ 'checkout_prices' ][ 'max_discount_amount' ] : 0;
            $max_discount_type = isset( $zc_pri[ 'checkout_prices' ][ 'max_discount_type' ] ) ? $zc_pri[ 'checkout_prices' ][ 'max_discount_type' ] : 'no';
            $max_discount_base_on = isset( $zc_pri[ 'checkout_prices' ][ 'base_on' ] ) ? $zc_pri[ 'checkout_prices' ][ 'base_on' ] : 'subtotal';
            $enable_notifications = isset( $zc_pri[ 'notifications' ][ 'checkout_prices' ] ) ? $zc_pri[ 'notifications' ][ 'checkout_prices' ] : 'no';


            $cart_discounts = self::calc_products_prices( self::get_checkout_prices_valid_rules( 0 ), $rls_mode );

            return self::get_discounts( $cart_discounts, $max_discount_amount, $max_discount_type, $max_discount_base_on, $enable_notifications );
        }

        private static function calc_products_prices( $rules, $rls_mode ) {

            $cart_discounts = array();
            if ( $rls_mode == 'first' ) {
                foreach ( $rules as $rule ) {
                    $discounts = self::calc_products_prices_by_mode( $rule );
                    if ( $discounts[ 'discounts_total' ] != 0 ) {
                        $cart_discounts[] = $discounts;

                        break;
                    }
                }
            } else if ( $rls_mode == 'last' ) {

                for ( $i = count( $rules ) - 1; $i >= 0; $i-- ) {
                    $discounts = self::calc_products_prices_by_mode( $rules[ $i ] );
                    if ( $discounts[ 'discounts_total' ] != 0 ) {
                        $cart_discounts[] = $discounts;
                        break;
                    }
                }
            } else if ( $rls_mode == 'bigger' ) {
                $prv_discount = array();
                foreach ( $rules as $rule ) {
                    $discounts = self::calc_products_prices_by_mode( $rule );
                    if ( $discounts[ 'discounts_total' ] != 0 && !isset( $prv_discount[ 'discounts_total' ] ) ) {
                        $prv_discount = $discounts;
                    } else if ( $discounts[ 'discounts_total' ] > 0 && $prv_discount[ 'discounts_total' ] < $discounts[ 'discounts_total' ] ) {
                        $prv_discount = $discounts;
                    }
                }
                $cart_discounts[] = $prv_discount;
            } else if ( $rls_mode == 'smaller' ) {
                $prv_discount = array();
                foreach ( $rules as $rule ) {
                    $discounts = self::calc_products_prices_by_mode( $rule );
                    if ( $discounts[ 'discounts_total' ] != 0 && !isset( $prv_discount[ 'discounts_total' ] ) ) {
                        $prv_discount = $discounts;
                    } else if ( $discounts[ 'discounts_total' ] > 0 && $prv_discount[ 'discounts_total' ] > $discounts[ 'discounts_total' ] ) {
                        $prv_discount = $discounts;
                    }
                }
                $cart_discounts[] = $prv_discount;
            } else {
                foreach ( $rules as $rule ) {
                    $discounts = self::calc_products_prices_by_mode( $rule );
                    if ( $discounts[ 'discounts_total' ] != 0 ) {
                        $cart_discounts[] = $discounts;
                    }
                }
            }

            return $cart_discounts;
        }

        private static function calc_products_prices_by_mode( $rule ) {

            $cart_discount = array(
                'products' => array(),
                'discounts_total' => 0,
                'mode' => $rule[ 'mode' ]
            );

            $cart_discount = apply_filters( 'zcpri/get-checkout-prices-' . $rule[ 'mode' ] . '-discounts', $cart_discount, $rule );

            $cart_discount[ 'notification' ] = $rule[ 'notification' ];

            return $cart_discount;
        }

        private static function get_discounts( $discounts, $max, $max_type, $base_on, $enable_notifications = 'no' ) {

            $notifications = array();

            if ( !is_numeric( $max ) ) {
                $max = 0;
            }
            $r_discounts = array();

            if ( $max_type == 'no' ) {
                
                foreach ( $discounts as $key => $discount ) {
                    
                    if ( isset( $discount[ 'products' ] ) ) {
                    
                        foreach ( $discount[ 'products' ] as $key => $product ) {
                        
                            $r_discounts[] = $product;
                        }
                    }

                    self::$total_discounts += $discount[ 'discounts_total' ];

                    if ( $discount[ 'discounts_total' ] != 0 && $enable_notifications == 'yes' ) {
                        
                        $notifications[] = array(
                            'message' => $discount[ 'notification' ],
                            'applied_value' => $discount[ 'discounts_total' ],
                        );
                    }
                }

                WooPricely_Cart_Notifications::set_notication_message( 'checkout-prices', $notifications );
                WooPricely_Views::set_prices_discounts_total( self::$total_discounts );

                return $r_discounts;
            }

            $max_amount = $max;

            if ( $max_type == 'per' ) {
                
                $max_amount = ( float ) ($max / 100) * WooPricely_Cart_Totals::get_subtotals( true, WooPricely_Cart_Totals::get_totals_id_by_module_id( 'checkout_prices' ) );
                
                if ( $base_on == 'subtotal_ex_tax' ) {
                
                    $max_amount = ( float ) ($max / 100) * WooPricely_Cart_Totals::get_subtotals( false, WooPricely_Cart_Totals::get_totals_id_by_module_id( 'checkout_prices' ) );
                }
            }

            foreach ( $discounts as $key => $discount ) {

                $c_ttl = self::$total_discounts + $discount[ 'discounts_total' ];

                if ( $c_ttl < $max_amount ) {
                    self::$total_discounts = $c_ttl;

                    if ( isset( $discount[ 'products' ] ) ) {
                        foreach ( $discount[ 'products' ] as $key => $product ) {
                            $r_discounts[] = $product;
                        }
                    }
                    if ( $discount[ 'discounts_total' ] != 0 && $enable_notifications == 'yes' ) {
                        $notifications[] = array(
                            'message' => $discount[ 'notification' ],
                            'applied_value' => $discount[ 'discounts_total' ],
                        );
                    }
                } else {
                    break;
                }
            }

            WooPricely_Cart_Notifications::set_notication_message( 'checkout-prices', $notifications );
            WooPricely_Views::set_prices_discounts_total( self::$total_discounts );
            
            return $r_discounts;
        }

        private static function get_checkout_prices_valid_rules( $product_id ) {
           
            global $zc_pri;
           
            $valid_rules = array();


            if ( !isset( $zc_pri[ 'checkout_price_rules' ] ) ) {
             
                return $valid_rules;
            }

            foreach ( $zc_pri[ 'checkout_price_rules' ] as $rule ) {
                if ( $rule[ 'enable' ] == 'yes' ) {
                    $rl = array();

                    if ( self::validate_checkout_prices_conditions( $rule, $product_id ) == true ) {
                        $rl[ 'apply_mode' ] = $rule[ 'apply_mode' ];
                        $rl[ 'mode' ] = $rule[ 'mode' ];
                        $rl[ 'admin_note' ] = $rule[ 'admin_note' ];
                        $rl[ 'message' ] = apply_filters( 'zcpri/get-promo-message', $rule[ 'message' ], $rule[ 'option_id' ] );
                        $rl[ 'notification' ] = '';
                        if ( isset( $rule[ 'notification' ] ) ) {
                            $rl[ 'notification' ] = apply_filters( 'zcpri/get-cart-notification', $rule[ 'notification' ], $rule[ 'option_id' ] );
                            ;
                        }

                        if ( $product_id > 0 && WooPricely_CountDown::is_datetime_set() == true ) {
                            $rl[ 'time_left' ] = WooPricely_CountDown::get_datetime();
                        }
                        $rl = apply_filters( 'zcpri/process-checkout-prices-' . $rule[ 'mode' ] . '-rule', $rl, $rule, $product_id );

                        if ( $rule[ 'apply_mode' ] == 'only_this' ) {
                            $valid_rules = array();
                            $valid_rules[] = $rl;
                            break;
                        }
                        $valid_rules[] = $rl;
                    }
                }
            }


            //Remove unwanted rules
            $valid_rls = $valid_rules;
            $valid_rules = array();
           
            for ( $i = 0; $i < count( $valid_rls ); $i++ ) {
               
                if ( $valid_rls[ $i ][ 'apply_mode' ] == 'if_others' && count( $valid_rls ) == 1 ) {
               
                    continue;
                }
               
                if ( $valid_rls[ $i ][ 'apply_mode' ] == 'if_no_others' && count( $valid_rls ) > 1 ) {
               
                    continue;
                }
               
                $valid_rules[] = $valid_rls[ $i ];
            }

            return $valid_rules;
        }

        private static function validate_checkout_prices_conditions( $rule, $product_id ) {

            WooPricely_CountDown::clear_datetime();

            if ( !isset( $rule[ 'conditions' ] ) ) {

                return true;
            }

            $is_valid = true;

            $rule_args = array(
                'section' => 'checkout_prices',
                'panel' => 'conditions',
                'is_single' => false,
            );

            if ( $product_id > 0 ) {
               
                $rule_args[ 'is_single' ] = true;
                $rule_args[ 'product_id' ] = $product_id;
            }

            WooPricely_CountDown::clear_datetime();

            if ( isset( $rule[ 'conditions' ] ) ) {
               
                $is_valid = WooPricely::validate_conditions( $rule[ 'conditions' ], $rule_args );
            }

            return $is_valid;
        }

    }

}


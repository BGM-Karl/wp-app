<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists( 'WooPricely_Product_Prices' ) ) {

    class WooPricely_Product_Prices {

        private static $valid_rules_hash = '';
        private static $products = array();
        private static $calculating = false;

        public static function get_hash() {

            return self::$valid_rules_hash;
        }

        public static function get_product_regular_price( $price, $src_product ) {

            if ( self::is_admin() ) {

                return $price;
            }

            if ( self::$calculating == true ) {

                return $price;
            }

            $product = WooPricely::create_product_identifier( $src_product );

            self::$calculating = true;

            $product = self::calculate_product_prices( $product );

            self::$calculating = false;

            if ( isset( $product[ 'calc_regular_price' ] ) && $product[ 'type' ] != 'variable' ) {

                if ( has_filter( 'zcpri/applied_product_price' ) ) {

                    return apply_filters( 'zcpri/applied_product_price', $product[ 'calc_regular_price' ] );
                }

                return $product[ 'calc_regular_price' ];
            }

            return $price;
        }

        public static function get_product_sale_price( $price, $src_product ) {

            if ( self::is_admin() ) {
                
                return $price;
            }

            if ( self::$calculating == true ) {
            
                return $price;
            }

            $product = WooPricely::create_product_identifier( $src_product );
            
            self::$calculating = true;
           
            $product = self::calculate_product_prices( $product );

            self::$calculating = false;

            if ( isset( $product[ 'calc_sale_price' ] ) && $product[ 'type' ] != 'variable' ) {

                if ( has_filter( 'zcpri/applied_product_price' ) ) {

                    return apply_filters( 'zcpri/applied_product_price', $product[ 'calc_sale_price' ] );
                }

                return $product[ 'calc_sale_price' ];
            }

            return $price;
        }

        public static function get_is_purchasable( $is_purchasable, $src_product ) {
            
            if ( self::is_admin() ) {
            
                return $is_purchasable;
            }
            
            if ( self::$calculating == true ) {
            
                return $is_purchasable;
            }

            self::$calculating = true;
            
            $product = self::calculate_product_prices( WooPricely::create_product_identifier( $src_product ) );
            
            self::$calculating = false;
            
            if ( isset( $product[ 'calc_sale_price' ] ) || isset( $product[ 'calc_regular_price' ] ) ) {

                return true;
            }
           
            return $is_purchasable;
        }

        public static function get_is_on_sale( $is_on_sale, $src_product ) {

            if ( self::is_admin() ) {

                return $is_on_sale;
            }

            if ( self::$calculating == true ) {

                return $is_on_sale;
            }

            self::$calculating = true;

            $product = self::calculate_product_prices( WooPricely::create_product_identifier( $src_product ) );

            self::$calculating = false;

            if ( count( $product ) == 0 ) {

                return $is_on_sale;
            }

            $regular_price = 0;
            $sale_price = 0;

            if ( $product[ 'type' ] == 'variable' ) {

                $is_variables_on_sale = false;

                foreach ( self::$products as $prod ) {

                    if ( $prod[ 'id' ] == $product[ 'id' ] ) {

                        if ( isset( $prod[ 'regular_price' ] ) && $prod[ 'regular_price' ] != '' ) {

                            $regular_price = $prod[ 'regular_price' ];
                        }

                        if ( isset( $prod[ 'sale_price' ] ) && $prod[ 'sale_price' ] != '' ) {

                            $sale_price = $prod[ 'sale_price' ];
                        }

                        if ( isset( $prod[ 'calc_regular_price' ] ) && $prod[ 'calc_regular_price' ] != '' ) {

                            $regular_price = $prod[ 'calc_regular_price' ];
                        }

                        if ( isset( $prod[ 'calc_sale_price' ] ) && $prod[ 'calc_sale_price' ] != '' ) {

                            $sale_price = $prod[ 'calc_sale_price' ];
                        }

                        $is_variables_on_sale = ($regular_price > $sale_price);

                        if ( $is_variables_on_sale == true ) {

                            return true;
                        }
                    }
                }
            }

            if ( isset( $product[ 'regular_price' ] ) && $product[ 'regular_price' ] != '' ) {

                $regular_price = $product[ 'regular_price' ];
            }

            if ( isset( $product[ 'sale_price' ] ) && $product[ 'sale_price' ] != '' ) {

                $sale_price = $product[ 'sale_price' ];
            }

            if ( isset( $product[ 'calc_regular_price' ] ) && $product[ 'calc_regular_price' ] != '' ) {

                $regular_price = $product[ 'calc_regular_price' ];
            }

            if ( isset( $product[ 'calc_sale_price' ] ) && $product[ 'calc_sale_price' ] != '' ) {

                $sale_price = $product[ 'calc_sale_price' ];
            }

            return ($regular_price > $sale_price);
        }

        public static function get_on_sale_products( $product_ids ) {

            if ( self::is_admin() ) {

                return $product_ids;
            }

            global $zc_pri;


            $debug_mode = isset( $zc_pri[ 'on_sale_products' ][ 'debug_mode' ] ) ? $zc_pri[ 'on_sale_products' ][ 'debug_mode' ] : 'no';

            if ( 'no' == $debug_mode ) {

                $prod_ids = get_transient( 'woopricely_onsale' );

                if ( $prod_ids ) {
                    return $prod_ids;
                }
            }



            if ( !isset( $zc_pri[ 'on_sale_products' ][ 'enable' ] ) || $zc_pri[ 'on_sale_products' ][ 'enable' ] == 'no' ) {

                return $product_ids;
            }

            $product_count = isset( $zc_pri[ 'on_sale_products' ][ 'product_count' ] ) ? $zc_pri[ 'on_sale_products' ][ 'product_count' ] : 50;
            $replace_default = isset( $zc_pri[ 'on_sale_products' ][ 'replace_default' ] ) ? $zc_pri[ 'on_sale_products' ][ 'replace_default' ] : 'no';
            $cache_duration = isset( $zc_pri[ 'on_sale_products' ][ 'cache_duration' ] ) ? $zc_pri[ 'on_sale_products' ][ 'cache_duration' ] : 30;


            if ( $replace_default == 'yes' ) {

                $product_ids = array();
            }

            $args = array(
                'post_type' => 'product',
                'fields' => 'ids',
                'posts_per_page' => $product_count
            );

            $db_products = get_posts( $args );

            foreach ( $db_products as $prod_id ) {

                if ( count( $product_ids ) >= $product_count ) {
                    break;
                }

                $prod = wc_get_product( $prod_id );

                if ( $replace_default == 'yes' ) {

                    if ( self::get_is_on_sale( false, $prod ) && !in_array( $prod_id, $product_ids ) ) {

                        $product_ids[] = $prod_id;
                    }
                } else {

                    if ( $prod->is_on_sale() && !in_array( $prod_id, $product_ids ) ) {

                        $product_ids[] = $prod_id;
                    }
                }
            }

            set_transient( 'woopricely_onsale', $product_ids, MINUTE_IN_SECONDS * $cache_duration );

            return $product_ids;
        }

        public static function get_product_price( $price, $src_product ) {

            return self::get_product_sale_price( $price, $src_product );
        }

        public static function get_product_date_on_sale_from( $on_sale_from, $src_product ) {

            if ( self::is_admin() ) {

                return $on_sale_from;
            }
            if ( self::$calculating == true ) {

                return $on_sale_from;
            }

            self::$calculating = true;

            $product = self::calculate_product_prices( WooPricely::create_product_identifier( $src_product ) );

            self::$calculating = false;

            if ( isset( $product[ 'schedule_sale_from' ] ) && $product[ 'schedule_sale_from' ] != '' ) {

                return get_the_time( 'Y-m-d', $product[ 'schedule_sale_from' ] );
            }

            return $on_sale_from;
        }

        public static function get_product_date_on_sale_to( $on_sale_to, $src_product ) {

            if ( self::is_admin() ) {

                return $on_sale_to;
            }

            if ( self::$calculating == true ) {

                return $on_sale_to;
            }

            self::$calculating = true;

            $product = self::calculate_product_prices( WooPricely::create_product_identifier( $src_product ) );

            self::$calculating = false;

            if ( isset( $product[ 'schedule_sale_to' ] ) && $product[ 'schedule_sale_to' ] != '' ) {

                return get_the_time( 'Y-m-d', $product[ 'schedule_sale_to' ] );
            }

            return $on_sale_to;
        }

        public static function get_product_promo_message( $product_id ) {

            if ( self::is_admin() ) {

                return '';
            }
            if ( self::$calculating == true ) {

                return '';
            }

            self::$calculating = true;

            $src_product = wc_get_product( $product_id );

            $product = self::calculate_product_prices( WooPricely::create_product_identifier( $src_product ) );

            self::$calculating = false;

            if ( isset( $product[ 'promo_message' ] ) ) {

                return $product[ 'promo_message' ];
            }

            return '';
        }

        public static function get_prices_time_left( $product_id ) {

            if ( self::is_admin() ) {
                return '';
            }
            if ( self::$calculating == true ) {
                return '';
            }

            self::$calculating = true;
            $src_product = wc_get_product( $product_id );
            $product = self::calculate_product_prices( WooPricely::create_product_identifier( $src_product ) );
            self::$calculating = false;
            if ( isset( $product[ 'time_left' ] ) ) {
                return $product[ 'time_left' ];
            }

            return '';
        }

        public static function get_calculated_product_prices( $key ) {

            if ( !isset( self::$products[ $key ] ) ) {

                return array();
            }

            return self::$products[ $key ];
        }

        private static function calculate_product_prices( $product ) {

            self::init_cart_data();

            global $zc_pri;

            $rls_mode = isset( $zc_pri[ 'products_pricing' ][ 'mode' ] ) ? $zc_pri[ 'products_pricing' ][ 'mode' ] : 'all';
            $max_discount_amount = isset( $zc_pri[ 'products_pricing' ][ 'max_discount_amount' ] ) ? $zc_pri[ 'products_pricing' ][ 'max_discount_amount' ] : 0;
            $max_discount_type = isset( $zc_pri[ 'products_pricing' ][ 'max_discount_type' ] ) ? $zc_pri[ 'products_pricing' ][ 'max_discount_type' ] : 'no';



            if ( $rls_mode == 'no' ) {

                return array();
            }

            // Return cached product prices
            if ( isset( self::$products[ $product[ 'key' ] ] ) ) {

                return self::$products[ $product[ 'key' ] ];
            }

            $rules = self::get_product_price_valid_rules( $product );

            if ( count( $rules ) == 0 ) {

                return array();
            }

            //Get product source prices
            $product[ 'regular_price' ] = self::get_src_regular_price( $product );
            $product[ 'sale_price' ] = self::get_src_sale_price( $product );


            // Calculate Products prices by each pricing rule
            foreach ( $rules as $rule ) {

                //Calculate product regular price
                if ( $rule[ 'price_mode' ] == 'regular_price' || $rule[ 'price_mode' ] == 'regular_sale_price' ) {

                    $reg_adj = $rule[ 'regular_adj' ][ 'adjustment' ];
                    $reg_base_on = $rule[ 'regular_adj' ][ 'base_on' ];
                    $reg_amount = $rule[ 'regular_adj' ][ 'amount' ];

                    $reg_price = self::get_calc_price( $product, $reg_adj, $reg_base_on, $reg_amount, $max_discount_type, $max_discount_amount );


                    //Adjust bigger or smaller regular price

                    $old_price = $reg_price;

                    if ( isset( $product[ 'calc_regular_price' ] ) ) {

                        $old_price = $product[ 'calc_regular_price' ];
                    }

                    $product[ 'calc_regular_price' ] = self:: get_bigger_or_smaller_price( $rls_mode, $old_price, $reg_price );
                }

                if ( $rule[ 'price_mode' ] == 'regular_price' && isset( $rule[ 'clear_sale_price' ] ) && $rule[ 'clear_sale_price' ] == 'yes' ) {

                    $product[ 'calc_sale_price' ] = $product[ 'calc_regular_price' ];
                }

                if ( isset( $product[ 'calc_regular_price' ] ) && $product[ 'sale_price' ] == '' ) {

                    $product[ 'calc_sale_price' ] = $product[ 'calc_regular_price' ];
                }

                //Calculate product sale price
                if ( $rule[ 'price_mode' ] == 'sale_price' || $rule[ 'price_mode' ] == 'regular_sale_price' ) {

                    $sal_adj = $rule[ 'sale_adj' ][ 'adjustment' ];
                    $sal_base_on = $rule[ 'sale_adj' ][ 'base_on' ];
                    $sal_amount = $rule[ 'sale_adj' ][ 'amount' ];

                    if ( !isset( $product[ 'calc_regular_price' ] ) ) {

                        $product[ 'calc_regular_price' ] = $product[ 'regular_price' ];
                    }

                    $sale_price = self::get_calc_price( $product, $sal_adj, $sal_base_on, $sal_amount, $max_discount_type, $max_discount_amount );


                    //Adjust bigger or smaller sale price

                    $old_price = $sale_price;

                    if ( isset( $product[ 'calc_sale_price' ] ) ) {

                        $old_price = $product[ 'calc_sale_price' ];
                    }

                    $product[ 'calc_sale_price' ] = self:: get_bigger_or_smaller_price( $rls_mode, $old_price, $sale_price );


                    if ( $rule[ 'schedule_sale' ][ 'enable' ] == 'yes' ) {

                        $product[ 'schedule_sale_from' ] = $rule[ 'schedule_sale' ][ 'from' ];
                        $product[ 'schedule_sale_to' ] = $rule[ 'schedule_sale' ][ 'to' ];
                    }
                }

                if ( $rule[ 'message' ] != '' ) {

                    $product[ 'promo_message' ] = apply_filters( 'zcpri/get-promo-message', $rule[ 'message' ], $rule[ 'option_id' ] );
                }

                if ( isset( $rule[ 'time_left' ] ) ) {

                    $product[ 'time_left' ] = $rule[ 'time_left' ];
                }
            }

            //Cache product prices            
            self::$products[ $product[ 'key' ] ] = $product;

            return $product;
        }

        private static function get_product_price_valid_rules( $product ) {

            global $zc_pri;

            $valid_rules = array();


            if ( !isset( $zc_pri[ 'products_pricing_rules' ] ) ) {

                return $valid_rules;
            }

            // validate rules
            foreach ( $zc_pri[ 'products_pricing_rules' ] as $rule ) {

                if ( $rule[ 'enable' ] == 'yes' ) {

                    $products = self::validate_product_price_rule( $rule, $product );

                    if ( count( $products ) > 0 ) {

                        $rl = array(
                            'option_id' => $rule[ 'option_id' ],
                            'apply_mode' => $rule[ 'apply_mode' ],
                            'price_mode' => $rule[ 'price_mode' ],
                            'admin_note' => $rule[ 'admin_note' ],
                            'message' => $rule[ 'message' ],
                        );

                        if ( WooPricely_CountDown::is_datetime_set() == true ) {

                            $rl[ 'time_left' ] = WooPricely_CountDown::get_datetime();
                        }

                        if ( isset( $rule[ 'clear_sale_price' ] ) ) {

                            $rl[ 'clear_sale_price' ] = $rule[ 'clear_sale_price' ];
                        }

                        if ( isset( $rule[ 'regular_adj' ] ) ) {

                            $rl[ 'regular_adj' ] = $rule[ 'regular_adj' ];
                        }

                        if ( isset( $rule[ 'sale_adj' ] ) ) {

                            $rl[ 'sale_adj' ] = $rule[ 'sale_adj' ];
                        }

                        if ( isset( $rule[ 'schedule_sale' ] ) ) {

                            $rl[ 'schedule_sale' ] = $rule[ 'schedule_sale' ];
                        }

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

            $rls_mode = isset( $zc_pri[ 'products_pricing' ][ 'mode' ] ) ? $zc_pri[ 'products_pricing' ][ 'mode' ] : 'all';

            if ( $rls_mode == 'first' && count( $valid_rules ) > 1 ) {

                $first_rule = $valid_rules[ 0 ];
                $valid_rules = array();
                $valid_rules[] = $first_rule;
            }

            if ( $rls_mode == 'last' && count( $valid_rules ) > 1 ) {

                $last_rule = $valid_rules[ (count( $valid_rules ) - 1) ];
                $valid_rules = array();
                $valid_rules[] = $last_rule;
            }

            self::$valid_rules_hash = md5( json_encode( $valid_rules ) );

            return $valid_rules;
        }

        private static function validate_product_price_rule( $rule, $product ) {

            $valid_products = array( $product );

            $is_valid = true;

            $rule_args = array(
                'section' => 'product_prices',
                'panel' => 'products',
            );

            if ( isset( $rule[ 'products' ] ) ) {

                $valid_products = WooPricely::validate_products( $rule[ 'products' ], $valid_products, $rule_args );
            }

            WooPricely_CountDown::clear_datetime();

            if ( isset( $rule[ 'conditions' ] ) ) {

                $rule_args[ 'panel' ] = 'conditions';
                $is_valid = WooPricely::validate_conditions( $rule[ 'conditions' ], $rule_args );
            }

            if ( count( $valid_products ) > 0 && $is_valid == true ) {

                return $valid_products;
            }

            return array();
        }

        private static function get_calc_price( $product, $adjustment, $base_on, $amount, $max_discount_type, $max_discount_amount ) {


            if ( !is_numeric( $amount ) ) {
                $amount = 0;
            }

            $price = self::get_base_on( $product, $base_on );


            $new_price = $amount;

            if ( !is_numeric( $price ) && $adjustment != 'fixed_price' ) {
                $new_price = $price;
            } else if ( is_numeric( $price ) ) {
                // Calculate percentage amount
                if ( $adjustment == 'per_discount' || $adjustment == 'per_fee' ) {
                    $amount = ($amount / 100) * $price;
                }

                // Adjust discount amount to maximun if needed
                if ( $amount > $max_discount_amount && is_numeric( $max_discount_amount ) ) {
                    if ( $max_discount_type == 'per' ) {

                        $amount = $max_discount_amount;
                    } else if ( $max_discount_type == 'amount' ) {
                        $amount = $max_discount_amount;
                    }
                }

                // Adjust new price from discount amount
                if ( $adjustment == 'fixed_discount' || $adjustment == 'per_discount' ) {
                    $new_price = $price - $amount;
                }

                if ( $adjustment == 'fixed_fee' || $adjustment == 'per_fee' ) {
                    $new_price = $price + $amount;
                }
            }







            if ( $new_price < 0 ) {
                return 0;
            }
            return $new_price;
        }

        private static function get_base_on( $product, $base_on ) {
            $b_price = $product[ 'regular_price' ];

            if ( $base_on == 'sale_price' && is_numeric( $product[ 'sale_price' ] ) ) {
                $b_price = $product[ 'sale_price' ];
            } else if ( $base_on == 'calc_reg_price' && isset( $product[ 'calc_regular_price' ] ) ) {

                $b_price = $product[ 'calc_regular_price' ];
            } else if ( $base_on == 'calc_sale_price' ) {
                if ( isset( $product[ 'calc_sale_price' ] ) && is_numeric( $product[ 'calc_sale_price' ] ) ) {
                    $b_price = $product[ 'calc_sale_price' ];
                } else if ( is_numeric( $product[ 'sale_price' ] ) ) {
                    $b_price = $product[ 'sale_price' ];
                }
            }

            return $b_price;
        }

        private static function get_src_regular_price( $product ) {
            try {

                if ( isset( $product[ 'variation_id' ] ) ) {
                    return wc_get_product( $product[ 'variation_id' ] )->get_regular_price( false );
                } else {
                    return wc_get_product( $product[ 'id' ] )->get_regular_price( false );
                }
            } catch ( Exception $ex ) {
                
            }
            return '';
        }

        private static function get_src_sale_price( $product ) {
            try {

                if ( isset( $product[ 'variation_id' ] ) ) {
                    return wc_get_product( $product[ 'variation_id' ] )->get_sale_price( false );
                } else {
                    return wc_get_product( $product[ 'id' ] )->get_sale_price( false );
                }
            } catch ( Exception $ex ) {
                
            }
            return '';
        }

        private static function get_bigger_or_smaller_price( $bigger_or_smaller, $old_price, $new_price ) {
            $the_price = $new_price;
            if ( $bigger_or_smaller == 'bigger' && $old_price < $new_price ) {
                $the_price = $old_price;
            } else if ( $bigger_or_smaller == 'bigger' ) {
                $the_price = $new_price;
            }
            if ( $bigger_or_smaller == 'smaller' && $old_price < $new_price ) {
                $the_price = $new_price;
            } else if ( $bigger_or_smaller == 'smaller' ) {
                $the_price = $old_price;
            }

            return $the_price;
        }

        private static function is_admin() {

            if ( (defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

                return false;
            }

            return is_admin();
        }

        private static function init_cart_data() {
            WCWooPricely_Cart::get_data();
        }

    }

}
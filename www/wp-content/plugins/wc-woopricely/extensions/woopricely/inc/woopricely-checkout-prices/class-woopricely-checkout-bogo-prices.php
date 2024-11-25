<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WooPricely_Checkout_BoGo_Prices' ) ) {

    class WooPricely_Checkout_BoGo_Prices {

        public static function init() {
            add_filter( 'zcpri/process-checkout-prices-buy_x_get_x-rule', array( new self(), 'process_rule' ), 1, 3 );
            add_filter( 'zcpri/process-checkout-prices-buy_x_get_y-rule', array( new self(), 'process_rule' ), 1, 3 );

            add_filter( 'zcpri/get-checkout-prices-buy_x_get_x-product-data', array( new self(), 'get_products_data' ), 1, 2 );
            add_filter( 'zcpri/get-checkout-prices-buy_x_get_y-product-data', array( new self(), 'get_products_data' ), 1, 2 );

            add_filter( 'zcpri/get-checkout-prices-buy_x_get_x-discounts', array( new self(), 'calc_products_prices' ), 1, 2 );
            add_filter( 'zcpri/get-checkout-prices-buy_x_get_y-discounts', array( new self(), 'calc_products_prices' ), 1, 2 );
        }

        public static function process_rule( $rule, $raw_rule, $product_id ) {

            $rule[ 'qty_base_on' ] = $raw_rule[ 'qty_base_on' ];
            $rule[ 'bogo_qty' ] = $raw_rule[ 'bogo_qty' ];
            $rule[ 'bogo_discount' ] = $raw_rule[ 'bogo_discount' ];
            $rule[ 'products' ] = self::get_checkout_purchased_products( $raw_rule, $product_id );

            if ( $raw_rule[ 'mode' ] == 'buy_x_get_y' && isset( $raw_rule[ 'discount_products' ] ) ) {

                $rule[ 'discount_products' ] = self::get_checkout_discount_products( $raw_rule[ 'discount_products' ], $product_id );

                if ( count( $rule[ 'discount_products' ] ) <= 0 ) {

                    $rule[ 'discount_products_filter' ] = $raw_rule[ 'discount_products' ];
                }
            }
            return $rule;
        }

        public static function calc_products_prices( $r_products, $rule ) {
            $discounts_total = 0;
            if ( $rule[ 'mode' ] == 'buy_x_get_y' ) {
                $prds_qty = 0;
                if ( isset( $rule[ 'discount_products' ] ) ) {
                    foreach ( $rule[ 'discount_products' ] as $key => $prd ) {
                        $prds_qty += $prd[ 'quantity' ];
                    }
                }
                $prds = array();
                if ( isset( $rule[ 'discount_products' ] ) ) {
                    $prds[ 'qty' ] = $prds_qty;
                    $prds[ 'products' ] = $rule[ 'discount_products' ];
                }
            }
            foreach ( WooPricely::get_quantities( $rule[ 'products' ], $rule[ 'qty_base_on' ] ) as $products ) {
                $prods = array();
                if ( $rule[ 'mode' ] == 'buy_x_get_x' ) {
                    $prods = self::get_bogo_x_discount( $products, $rule[ 'bogo_discount' ], $rule[ 'bogo_qty' ] );
                } else if ( $rule[ 'mode' ] == 'buy_x_get_y' ) {

                    if ( isset( $rule[ 'discount_products_filter' ] ) ) {
                        $prods = self::get_bogo_y_discount( $products[ 'qty' ], $prds, $rule[ 'bogo_discount' ], $rule[ 'bogo_qty' ], $rule[ 'discount_products_filter' ] );
                    } else {
                        $prods = self::get_bogo_y_discount( $products[ 'qty' ], $prds, $rule[ 'bogo_discount' ], $rule[ 'bogo_qty' ] );
                    }
                }



                foreach ( $prods[ 'products' ] as $key => $prod ) {
                    if ( isset( $prod[ 'discount_price' ] ) ) {
                        $r_products[ 'products' ][ $key ][ 'id' ] = $prod[ 'id' ];
                        $r_products[ 'products' ][ $key ][ 'key' ] = $prod[ 'key' ];
                        $r_products[ 'products' ][ $key ][ 'qty' ] = $prod[ 'quantity' ];
                        $r_products[ 'products' ][ $key ][ 'cart_key' ] = $prod[ 'cart_key' ];
                        $r_products[ 'products' ][ $key ][ 'cart_price' ] = $prod[ 'cart_price' ];
                        $r_products[ 'products' ][ $key ][ 'discount_price' ] = $prod[ 'discount_price' ];
                        $r_products[ 'products' ][ $key ][ 'discount_detail' ] = $prod[ 'discount_detail' ];
                        $r_products[ 'products' ][ $key ][ 'mode' ] = $rule[ 'mode' ];
                    }
                }

                $discounts_total += $prods[ 'discounts_total' ];
                if ( isset( $prods[ 'stop_loop' ] ) && $prods[ 'stop_loop' ] == 'yes' ) {
                    break;
                }
            }


            $r_products[ 'discounts_total' ] = $discounts_total;


            return $r_products;
        }

        public static function get_products_data( $r_data, $rule ) {
            if ( isset( $rule[ 'products' ] ) ) {
                foreach ( $rule[ 'products' ] as $key => $product ) {
                    $r_dat = array(
                        'id' => $product[ 'id' ],
                        'message' => $rule[ 'message' ],
                        'mode' => $rule[ 'mode' ],
                    );
                    if ( isset( $rule[ 'time_left' ] ) ) {
                        $r_dat[ 'time_left' ] = $rule[ 'time_left' ];
                    }
                    $r_data[] = $r_dat;
                }
            }



            return $r_data;
        }

        private static function get_checkout_purchased_products( $rule, $product_id ) {

            if ( !isset( $rule[ 'products' ] ) ) {

                if ( !isset( $rule[ 'purchased_products' ] ) ) {

                    return array();
                }
            }

            $option_id = 0;

            if ( isset( $rule[ 'option_id' ] ) ) {

                $option_id = $rule[ 'option_id' ];
            }

            if ( $product_id > 0 ) {

                $valid_products = array();

                $product = WooPricely::create_product_identifier( wc_get_product( $product_id ) );

                if ( isset( $product[ 'key' ] ) ) {

                    $valid_products[ $product[ 'key' ] ] = $product;
                }
            } else {

                $valid_products = WooPricely::get_products_from_cart();
            }

            $is_valid = true;

            $rule_args = array(
                'section' => 'checkout_prices',
                'panel' => 'products',
                'is_single' => false,
                'option_id' => $option_id
            );

            if ( $product_id > 0 ) {

                $rule_args[ 'is_single' ] = true;
                $rule_args[ 'product_id' ] = $product_id;
            }

            if ( isset( $rule[ 'products' ] ) ) {

                $valid_products = WooPricely::validate_products( $rule[ 'products' ], $valid_products, $rule_args );
            } else if ( isset( $rule[ 'purchased_products' ] ) ) {

                $valid_products = WooPricely::validate_products( $rule[ 'purchased_products' ], $valid_products, $rule_args );
            }

            $sorted_products = self::get_sorted_products( $valid_products, $rule_args );

            return $sorted_products;
        }

        private static function get_checkout_discount_products( $products_filters, $product_id, $catch = true ) {

            if ( count( $products_filters ) == 0 ) {

                return array();
            }

            $valid_products = WooPricely::get_products_from_cart( $catch );

            $is_valid = true;

            $rule_args = array(
                'section' => 'checkout_prices',
                'panel' => 'discount_products',
                'is_single' => false,
                'option_id' => 0
            );

            if ( $product_id > 0 ) {
                $rule_args[ 'is_single' ] = true;
                $rule_args[ 'product_id' ] = $product_id;
            }

            if ( count( $products_filters ) > 0 ) {

                $valid_products = WooPricely::validate_products( $products_filters, $valid_products, $rule_args );
            } else {

                $valid_products = array();
            }

            if ( count( $products_filters ) == 0 ) {

                return $valid_products;
            }

            $sorted_products = self::get_sorted_products( $valid_products, $rule_args );

            return $sorted_products;
        }

        private static function get_bogo_x_discount( $products, $bogo_discount, $bogo_qty ) {

            if ( $bogo_qty[ 'purchase_qty' ] == '' || $bogo_qty[ 'discount_qty' ] == '' || !isset( $products[ 'products' ] ) ) {
                $products[ 'products' ] = array();
                $products[ 'discounts_total' ] = 0;
                return $products;
            }

            $rep_count = 0;
            if ( $bogo_discount[ 'repeat' ] == 'yes' ) {
                $rep_count = ( int ) ($products[ 'qty' ] / ($bogo_qty[ 'purchase_qty' ]));

                if ( $products[ 'qty' ] - (($bogo_qty[ 'purchase_qty' ]) * $rep_count) >= $bogo_qty[ 'purchase_qty' ] ) {
                    $rep_count++;
                }
            } else if ( $products[ 'qty' ] >= $bogo_qty[ 'purchase_qty' ] ) {
                $rep_count = 1;
            }


            $discounts_total = 0;
            $p_count = 0;
            $d_count = 0;


            $total_qty = 0;
            $total_price = 0;

            foreach ( $products[ 'products' ] as $key => $product ) {
                $p_qty = 0;
                for ( $i = 0; $i < $product[ 'quantity' ]; $i++ ) {
                    $p_count++;



                    if ( $p_count >= (($bogo_qty[ 'purchase_qty' ] - $bogo_qty[ 'discount_qty' ]) * $rep_count) ) {

                        if ( $d_count < ($bogo_qty[ 'discount_qty' ] * $rep_count) ) {
                            $p_qty++;
                            $d_count++;
                        }
                    }
                }


                if ( $p_qty > 0 ) {
                    if ( $bogo_discount[ 'discount_type' ] == 'fixed_price' || $bogo_discount[ 'discount_type' ] == 'fixed_discount' ) {
                        $total_qty += $p_qty;
                        $total_price += self::get_product_price( $product, $bogo_discount[ 'base_on' ], $p_qty );
                    } else {
                        $calc_price = self::calc_products_discount( $product, $bogo_discount, $p_qty );

                        $d_price = (($calc_price * $p_qty) + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $p_qty))) / $product[ 'quantity' ];

                        $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                        $products[ 'products' ][ $key ][ 'discount_detail' ][] = array( 'qty' => $p_qty, 'price' => $calc_price );

                        $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                    }
                }
            }

            if ( ($bogo_discount[ 'discount_type' ] == 'fixed_price' || $bogo_discount[ 'discount_type' ] == 'fixed_discount') && $total_qty > 0 ) {

                if ( $bogo_discount[ 'amount' ] == '' ) {
                    $bogo_discount[ 'amount' ] = 0;
                }
                $amount = $bogo_discount[ 'amount' ];
                if ( $bogo_discount[ 'discount_type' ] == 'fixed_discount' ) {
                    $amount = $total_price - $bogo_discount[ 'amount' ];
                }

                if ( $rep_count > 1 ) {
                    $amount = $amount * $rep_count;
                }


                $s_calc_price = round( $amount / $total_qty, wc_get_price_decimals() );



                $prices = array();
                $prices_total = 0;
                for ( $i = 0; $i < $total_qty; $i++ ) {
                    $prices[] = $s_calc_price;
                    $prices_total += $s_calc_price;
                }

                if ( $prices_total <> $amount && count( $prices ) > 0 ) {
                    $prices[ count( $prices ) - 1 ] += $amount - $prices_total;
                }

                $prices_pointer = 0;

                foreach ( $products[ 'products' ] as $key => $product ) {
                    if ( $total_qty <= 0 ) {
                        break;
                    }
                    $prod_qty = $products[ 'products' ][ $key ][ 'quantity' ];


                    $calc_price = 0;

                    $p_qt = $prod_qty;
                    if ( $total_qty < $prod_qty ) {
                        $p_qt = $prod_qty - $total_qty;
                        $p_qt = $prod_qty - $p_qt;
                    }
                    $p_prices = array();
                    $last_p_prices = 0;

                    for ( $i = 0; $i < $p_qt; $i++ ) {
                        $p_prices[] = $prices[ $prices_pointer ];
                        $calc_price += $prices[ $prices_pointer ];
                        $last_p_prices = $prices[ $prices_pointer ];
                        $prices_pointer++;
                    }

                    $calc_price = $calc_price / count( $p_prices );

                    if ( $calc_price < 0 ) {
                        $calc_price = 0;
                    }
                    if ( $total_qty >= $prod_qty ) {
                        $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                        $products[ 'products' ][ $key ][ 'discount_price' ] = $calc_price;
                        $products[ 'products' ][ $key ][ 'discount_detail' ] = self::get_group_prices_details( $p_prices );
                    } else {
                        $d_price = (($calc_price * $total_qty) + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $total_qty))) / $product[ 'quantity' ];
                        $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                        $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                        $d_qty = $prod_qty - $total_qty;
                        $products[ 'products' ][ $key ][ 'discount_detail' ] = self::get_group_prices_details( $p_prices );
                    }

                    $discounts_total += (($products[ 'products' ][ $key ][ 'cart_price' ] * $products[ 'products' ][ $key ][ 'quantity' ]) - ($products[ 'products' ][ $key ][ 'discount_price' ] * $products[ 'products' ][ $key ][ 'quantity' ]));

                    $total_qty -= $prod_qty;
                }
            }

            if ( $bogo_discount[ 'repeat' ] != 'yes' && $discounts_total > 0 ) {
                $products[ 'stop_loop' ] = 'yes';
            }
            $products[ 'discounts_total' ] = $discounts_total;


            return $products;
        }

        private static function get_bogo_y_discount( $qty, $products, $bogo_discount, $bogo_qty, $discount_products_filter = array() ) {

            if ( $bogo_qty[ 'purchase_qty' ] == '' || $bogo_qty[ 'discount_qty' ] == '' || !isset( $products[ 'products' ] ) ) {
                $products[ 'products' ] = array();
                $products[ 'discounts_total' ] = 0;
                return $products;
            }

            $rep_count = 0;

            if ( $bogo_discount[ 'repeat' ] == 'yes' ) {
                $rep_count = ( int ) ($qty / $bogo_qty[ 'purchase_qty' ]);
            } else if ( $qty >= $bogo_qty[ 'purchase_qty' ] ) {
                $rep_count = 1;
            }

            if ( $bogo_qty[ 'auto_add' ] == 'yes' ) {
                
                if ( $products[ 'qty' ] < ( $bogo_qty[ 'discount_qty' ] * $rep_count) ) {
                    $auto_add_qty = ( $bogo_qty[ 'discount_qty' ] * $rep_count) - $products[ 'qty' ];
                    if ( count( $products[ 'products' ] ) > 0 ) {
                        $products = self::auto_add_x_products( $products, $auto_add_qty );
                    } else {
                        $products = self::auto_add_y_products( $discount_products_filter, $auto_add_qty );
                        if ( !isset( $products[ 'products' ] ) ) {
                            $products[ 'discounts_total' ] = 0;
                            $products[ 'products' ] = array();
                            return $products;
                        }
                    }
                }
            }


            $total_qty = 0;
            $total_price = 0;

            $discounts_total = 0;
            $d_count = 0;

            foreach ( $products[ 'products' ] as $key => $product ) {
                $p_qty = 0;
                for ( $i = 0; $i < $product[ 'quantity' ]; $i++ ) {
                    if ( $d_count < ($bogo_qty[ 'discount_qty' ] * $rep_count) ) {
                        $p_qty++;
                        $d_count++;
                    }
                }


                if ( $p_qty > 0 ) {

                    if ( $bogo_discount[ 'discount_type' ] == 'fixed_price' || $bogo_discount[ 'discount_type' ] == 'fixed_discount' ) {
                        $total_qty += $p_qty;
                        $total_price += self::get_product_price( $product, $bogo_discount[ 'base_on' ], $p_qty );
                    } else {
                        $calc_price = self::calc_products_discount( $product, $bogo_discount, $p_qty );

                        $d_price = (($calc_price * $p_qty) + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $p_qty))) / $product[ 'quantity' ];
                        $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                        $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                        $products[ 'products' ][ $key ][ 'discount_detail' ][] = array( 'qty' => $p_qty, 'price' => $calc_price );
                        $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                    }
                }
            }

            if ( ($bogo_discount[ 'discount_type' ] == 'fixed_price' || $bogo_discount[ 'discount_type' ] == 'fixed_discount') && $total_qty > 0 ) {

                if ( $bogo_discount[ 'amount' ] == '' ) {
                    $bogo_discount[ 'amount' ] = 0;
                }
                $amount = $bogo_discount[ 'amount' ];
                $discount_amount = $total_price - $amount;
                if ( $bogo_discount[ 'discount_type' ] == 'fixed_discount' ) {
                    $amount = $total_price - $bogo_discount[ 'amount' ];
                }

                if ( $rep_count > 1 ) {
                    $amount = $amount * $rep_count;
                }


                $s_calc_price = round( $amount / $total_qty, wc_get_price_decimals() );

                $prices = array();
                $prices_total = 0;
                for ( $i = 0; $i < $total_qty; $i++ ) {
                    $prices[] = $s_calc_price;
                    $prices_total += $s_calc_price;
                }

                if ( $prices_total <> $amount && count( $prices ) > 0 ) {
                    $prices[ count( $prices ) - 1 ] += $amount - $prices_total;
                }

                $prices_pointer = 0;
                foreach ( $products[ 'products' ] as $key => $product ) {
                    if ( $total_qty <= 0 ) {
                        break;
                    }
                    $prod_qty = $products[ 'products' ][ $key ][ 'quantity' ];


                    $calc_price = 0;

                    $p_qt = $prod_qty;
                    if ( $total_qty < $prod_qty ) {
                        $p_qt = $prod_qty - $total_qty;
                        $p_qt = $prod_qty - $p_qt;
                    }
                    $p_prices = array();
                    $last_p_prices = 0;

                    for ( $i = 0; $i < $p_qt; $i++ ) {
                        $p_prices[] = $prices[ $prices_pointer ];
                        $calc_price += $prices[ $prices_pointer ];
                        $last_p_prices = $prices[ $prices_pointer ];
                        $prices_pointer++;
                    }

                    $calc_price = $calc_price / count( $p_prices );


                    if ( $calc_price < 0 ) {
                        $calc_price = 0;
                    }

                    if ( $total_qty >= $prod_qty ) {
                        $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                        $products[ 'products' ][ $key ][ 'discount_price' ] = $calc_price;
                        $products[ 'products' ][ $key ][ 'discount_detail' ] = self::get_group_prices_details( $p_prices );
                    } else {
                        $d_price = (($calc_price * $total_qty) + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $total_qty))) / $product[ 'quantity' ];
                        $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                        $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                        $d_qty = $prod_qty - $total_qty;
                        $products[ 'products' ][ $key ][ 'discount_detail' ] = self::get_group_prices_details( $p_prices );
                    }

                    $discounts_total += (($products[ 'products' ][ $key ][ 'cart_price' ] * $products[ 'products' ][ $key ][ 'quantity' ]) - ($products[ 'products' ][ $key ][ 'discount_price' ] * $products[ 'products' ][ $key ][ 'quantity' ]));

                    $total_qty -= $prod_qty;
                }
            }


            if ( $bogo_discount[ 'repeat' ] != 'yes' && $discounts_total > 0 ) {
                $products[ 'stop_loop' ] = 'yes';
            }

            $products[ 'discounts_total' ] = $discounts_total;

            return $products;
        }

        private static function calc_products_discount( $product, $discount_opt, $qty ) {

            if ( $discount_opt[ 'discount_type' ] == 'free' ) {
                return 0;
            }

            $disc_price = 0;
            if ( is_numeric( $discount_opt[ 'amount' ] ) ) {
                $disc_price = $discount_opt[ 'amount' ];
            }


            if ( $discount_opt[ 'discount_type' ] == 'fixed_price' || $discount_opt[ 'discount_type' ] == '' ) {
                return round( $disc_price / $qty, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'fixed_price_unit' ) {
                return round( $disc_price, wc_get_price_decimals() );
            }



            $item_price = $product[ 'cart_price' ];

            $base_on = $discount_opt[ 'base_on' ];

            if ( $base_on != '' && $base_on != 'cart_price' ) {
                $src_price = WooPricely::get_product_price( $product[ 'key' ], $base_on );
                if ( is_numeric( $src_price ) ) {
                    $item_price = $src_price;
                }
            }


            if ( $discount_opt[ 'discount_type' ] == 'fixed_discount' ) {
                $disc_price = ($item_price * $qty) - $disc_price;
                if ( $disc_price < 0 ) {
                    $disc_price = $item_price;
                }
                return round( $disc_price / $qty, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'fixed_discount_unit' ) {
                $disc_price = $item_price - $disc_price;
                if ( $disc_price <= 0 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                return round( $disc_price, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'per_discount' ) {
                if ( $disc_price <= 0 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                if ( $disc_price >= 100 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                $disc_price = $item_price - (($disc_price / 100) * $item_price);
                return round( $disc_price, wc_get_price_decimals() );
            }
        }

        private static function auto_add_x_products( $products, $qty ) {

            end( $products[ 'products' ] );

            $key = key( $products[ 'products' ] );

            $x_auto_added = WC()->session->get( 'bogo_auto_added', 'no' );

            if ( isset( $products[ 'products' ][ $key ] ) && $x_auto_added != 'yes' ) {

                WC()->session->set( 'bogo_auto_added', 'yes' );

                WC()->cart->set_quantity( $products[ 'products' ][ $key ][ 'cart_key' ], $products[ 'products' ][ $key ][ 'quantity' ] + $qty );

                $products[ 'qty' ] += $qty;
            }
            return $products;
        }

        private static function auto_add_y_products( $products_filters, $qty ) {
            
            $y_auto_added = WC()->session->get( 'bogo_auto_added', 'no' );

            if ( $y_auto_added == 'yes' ) {

                return array();
            }

            $db_products = self::get_y_products_to_add( $products_filters, $qty );

            foreach ( $db_products as $key => $product ) {

                if ( isset( $product[ 'variation_id' ] ) ) {

                    WC()->cart->add_to_cart( $product[ 'id' ], $product[ 'qty' ], $product[ 'variation_id' ] );
                } else {

                    WC()->cart->add_to_cart( $product[ 'id' ], $product[ 'qty' ] );
                }
            }

            $prds_qty = 0;

            if ( count( $db_products ) > 0 ) {

                $products = self::get_checkout_discount_products( $products_filters, 0, false );

                foreach ( $products as $key => $prd ) {

                    $prds_qty += $prd[ 'quantity' ];
                }

                $prds = array();

                if ( count( $products ) > 0 ) {

                    $prds[ 'qty' ] = $prds_qty;
                    $prds[ 'products' ] = $products;
                }

                WC()->session->set( 'bogo_auto_added', 'yes' );

                return $prds;
            }
            return array();
        }

        private static function get_y_products_to_add( $products_filters, $qty ) {

            $products = WooPricely::get_products( $products_filters, $qty );
            
            $p_count = count( $products );

            $p_qty = 0;

            foreach ( $products as $key => $product ) {

                $products[ $key ][ 'qty' ] = 1;

                $p_qty++;
            }
            if ( $p_qty < $qty && $p_count > 0 ) {

                end( $products );

                $key = key( $products );

                $products[ $key ][ 'qty' ] += ($qty - $p_qty);
            }

            return $products;
        }

        private static function get_product_price( $product, $base_on, $qty ) {

            $item_price = WC()->cart->get_cart_item( $product[ 'cart_key' ] )[ 'data' ]->get_price();

            if ( $base_on != '' && $base_on != 'cart_price' ) {

                $src_price = WooPricely::get_product_price( $product[ 'key' ], $base_on );

                if ( is_numeric( $src_price ) ) {

                    $item_price = $src_price;
                }
            }

            return $item_price * $qty;
        }

        private static function get_group_prices_details( $prices ) {
            $k_p = array();
            for ( $i = 0; $i < count( $prices ); $i++ ) {
                $pri = '' . $prices[ $i ] . '';
                if ( isset( $k_p[ $pri ] ) ) {
                    $k_p[ $pri ]++;
                } else {
                    $k_p[ $pri ] = 1;
                }
            }
            $qty_details = array();
            foreach ( $k_p as $key => $qty ) {
                $qty_details[] = array(
                    'qty' => $qty,
                    'price' => $key
                );
            }
            return $qty_details;
        }

        private static function get_sorted_products( $valid_products, $rule_args ) {

            $sort_mode = apply_filters( 'zcpri/get-sort-by-price-mode', 'asc', $rule_args );

            if ( 'asc' == $sort_mode ) {

                uasort( $valid_products, array( new self(), 'asc_sort_products' ) );
            }

            if ( 'desc' == $sort_mode ) {

                uasort( $valid_products, array( new self(), 'desc_sort_products' ) );
            }

            return $valid_products;
        }

        private static function asc_sort_products( $product_a, $product_b ) {

            if ( $product_a[ 'cart_price' ] > $product_b[ 'cart_price' ] ) {

                return 1;
            }

            if ( $product_a[ 'cart_price' ] < $product_b[ 'cart_price' ] ) {

                return -1;
            }


            return 0;
        }

        private static function desc_sort_products( $product_a, $product_b ) {

            if ( $product_a[ 'cart_price' ] > $product_b[ 'cart_price' ] ) {

                return -1;
            }

            if ( $product_a[ 'cart_price' ] < $product_b[ 'cart_price' ] ) {

                return 1;
            }


            return 0;
        }

    }

    WooPricely_Checkout_BoGo_Prices::init();
}

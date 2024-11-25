<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WooPricely_Checkout_Group_Prices' ) ) {

    class WooPricely_Checkout_Group_Prices {

        public static function init() {
            add_filter( 'zcpri/process-checkout-prices-products_group-rule', array( new self(), 'process_rule' ), 1, 3 );
            add_filter( 'zcpri/get-checkout-prices-products_group-product-data', array( new self(), 'get_products_data' ), 1, 2 );
            add_filter( 'zcpri/get-checkout-prices-products_group-discounts', array( new self(), 'calc_products_prices' ), 1, 2 );
        }

        public static function process_rule( $rule, $raw_rule, $product_id ) {
            $rule[ 'qty_base_on' ] = $raw_rule[ 'qty_base_on' ];
            $rule[ 'group_discount' ] = $raw_rule[ 'group_discount' ];
            $rule[ 'products_in_group' ] = $raw_rule[ 'products_in_group' ];
            if ( isset( $raw_rule[ 'group_product_rules' ] ) ) {
                $rule[ 'group_product_rules' ] = $raw_rule[ 'group_product_rules' ];
            }
            $rule[ 'grouped_products' ] = self::get_checkout_products( $raw_rule, $product_id );
            return $rule;
        }

        public static function calc_products_prices( $r_products, $rule ) {
            $in_group = 0;
            if ( isset( $rule[ 'products_in_group' ] ) ) {
                $in_group = count( $rule[ 'products_in_group' ] );
            }

            $discounts_total = 0;

            foreach ( self::get_group_quantities( $rule[ 'grouped_products' ], $rule[ 'qty_base_on' ] ) as $products_group ) {
                if ( $in_group > 0 ) {
                    $prods = self::get_group_discount( $products_group, $rule[ 'group_discount' ], $in_group );
                    foreach ( $prods[ 'products' ] as $key => $prod ) {
                        $r_products[ 'products' ][ $key ][ 'key' ] = $prod[ 'key' ];
                        $r_products[ 'products' ][ $key ][ 'qty' ] = $prod[ 'quantity' ];
                        $r_products[ 'products' ][ $key ][ 'cart_key' ] = $prod[ 'cart_key' ];
                        $r_products[ 'products' ][ $key ][ 'cart_price' ] = $prod[ 'cart_price' ];
                        $r_products[ 'products' ][ $key ][ 'discount_price' ] = $prod[ 'discount_price' ];
                        $r_products[ 'products' ][ $key ][ 'discount_detail' ] = $prod[ 'discount_detail' ];
                        $r_products[ 'products' ][ $key ][ 'mode' ] = $rule[ 'mode' ];
                    }
                    $discounts_total += $prods[ 'discounts_total' ];
                    if ( isset( $prods[ 'stop_loop' ] ) && $prods[ 'stop_loop' ] == 'yes' ) {
                        break;
                    }
                }
            }


            $r_products[ 'discounts_total' ] = $discounts_total;


            return $r_products;
        }

        public static function get_products_data( $r_data, $rule ) {
            if ( isset( $rule[ 'grouped_products' ] ) ) {
                foreach ( self::merge_grouped_products( $rule[ 'grouped_products' ] ) as $key => $product ) {
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

        private static function get_checkout_products( $rule, $product_id ) {
            $products = array();
            if ( !isset( $rule[ 'products_in_group' ] ) ) {
                return $products;
            }
            foreach ( $rule[ 'products_in_group' ] as $p_filters ) {
                $products_filters = array();

                if ( isset( $rule[ 'group_product_rules' ] ) ) {
                    foreach ( $rule[ 'group_product_rules' ] as $g_filters ) {
                        $products_filters[] = $g_filters;
                    }
                }

                $pr_filters[ 'rule_type' ] = $p_filters[ 'rule_type' ];

                $pr_filters[ 'rule_type_' . $p_filters[ 'rule_type' ] ] = $p_filters[ 'rule_type_' . $p_filters[ 'rule_type' ] ];
                $pr_filters[ 'rule_type_' . $p_filters[ 'rule_type' ] ][ 'is_req' ] = 'yes';

                $products_filters[] = $pr_filters;

                $products[] = array(
                    'qty' => $p_filters[ 'qty' ],
                    'group' => self::get_group_products( $products_filters, $product_id )
                );
            }

            return $products;
        }

        private static function get_group_products( $products_filters, $product_id ) {

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
                'option_id' => 0
            );

            if ( $product_id > 0 ) {

                $rule_args[ 'is_single' ] = true;
                $rule_args[ 'product_id' ] = $product_id;
            }

            if ( count( $products_filters ) > 0 ) {

                $valid_products = WooPricely::validate_products( $products_filters, $valid_products, $rule_args );
            } else {

                return array();
            }

            $sorted_products = self::get_sorted_products( $valid_products, $rule_args );

            return $sorted_products;
        }

        private static function get_group_discount( $grouped_products, $group_discount, $in_group ) {
            $products = array(
                'products' => array(),
                'discounts_total' => 0
            );


            if ( count( $grouped_products ) < $in_group ) {
                return $products;
            }


            $rep_count = 0;

            foreach ( $grouped_products as $g_products ) {
                $r_count = self::get_group_part_repeat_count( $g_products );
                if ( $r_count == 0 ) {
                    return $products;
                }
                if ( $r_count < $rep_count || $rep_count == 0 ) {
                    $rep_count = $r_count;
                }
            }


            if ( $rep_count > 1 && $group_discount[ 'repeat' ] != 'yes' ) {
                $rep_count = 1;
            }
            if ( $rep_count == 0 ) {
                return $products;
            }

            $total_qty = 0;
            $total_price = 0;

            $discounts_total = 0;

            $all_qty = self::get_all_group_count( $grouped_products, $rep_count );

            foreach ( $grouped_products as $g_products ) {
                $d_count = 0;
                if ( $g_products[ 'qty' ] == '' ) {
                    return $products;
                }



                foreach ( $g_products[ 'group' ] as $gg_products ) {
                    foreach ( $gg_products[ 'products' ] as $key => $product ) {
                        $p_qty = 0;
                        for ( $i = 0; $i < $product[ 'quantity' ]; $i++ ) {
                            if ( $d_count < ($g_products[ 'qty' ] * $rep_count) ) {
                                $p_qty++;
                                $d_count++;
                            }
                        }



                        if ( $p_qty > 0 ) {
                            if ( $group_discount[ 'discount_type' ] == 'fixed_group_price' || $group_discount[ 'discount_type' ] == 'fixed_group_discount' ) {
                                $total_qty += $p_qty;
                                $total_price += self::get_product_price( $product, $group_discount[ 'base_on' ], $p_qty );
                            } else {
                                $calc_price = self::calc_products_discount( $product, $group_discount, $all_qty );

                                $d_price = (($calc_price * $p_qty) + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $p_qty))) / $product[ 'quantity' ];

                                $products[ 'products' ][ $key ] = $product;
                                $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                                $products[ 'products' ][ $key ][ 'discount_detail' ][] = array( 'qty' => $p_qty, 'price' => $calc_price );
                                $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                            }
                        }
                    }
                }
            }



            if ( $group_discount[ 'discount_type' ] == 'fixed_group_price' || $group_discount[ 'discount_type' ] == 'fixed_group_discount' ) {

                if ( $group_discount[ 'amount' ] == '' ) {
                    $group_discount[ 'amount' ] = 0;
                }
                $amount = $group_discount[ 'amount' ];
                if ( $group_discount[ 'discount_type' ] == 'fixed_group_discount' ) {
                    $amount = $total_price - $group_discount[ 'amount' ];
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
                foreach ( $grouped_products as $g_products ) {
                    $g_qty = $g_products[ 'qty' ] * $rep_count;

                    foreach ( $g_products[ 'group' ] as $gg_products ) {
                        foreach ( $gg_products[ 'products' ] as $key => $product ) {

                            if ( $total_qty <= 0 ) {
                                break;
                            }
                            $products[ 'products' ][ $key ] = $product;
                            $prod_qty = $products[ 'products' ][ $key ][ 'quantity' ];

                            $calc_price = 0;


                            $p_prices = array();
                            $last_p_prices = 0;
                            for ( $i = 0; $i < $g_qty; $i++ ) {
                                $p_prices[] = $prices[ $prices_pointer ];
                                $calc_price += $prices[ $prices_pointer ];
                                $last_p_prices = $prices[ $prices_pointer ];
                                $prices_pointer++;
                            }


                            $calc_price = $calc_price / count( $p_prices );



                            if ( $calc_price < 0 ) {
                                $calc_price = 0;
                            }


                            if ( $g_qty >= $prod_qty ) {
                                $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                                $products[ 'products' ][ $key ][ 'discount_price' ] = $calc_price;
                                $products[ 'products' ][ $key ][ 'discount_detail' ] = self::get_group_prices_details( $p_prices );
                            } else {
                                $d_price = (($calc_price * $g_qty) + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $g_qty))) / $product[ 'quantity' ];
                                $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                                $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                                $d_qty = $prod_qty - $g_qty;
                                $products[ 'products' ][ $key ][ 'discount_detail' ] = self::get_group_prices_details( $p_prices );
                            }


                            $discounts_total += (($products[ 'products' ][ $key ][ 'cart_price' ] * $products[ 'products' ][ $key ][ 'quantity' ]) - ($products[ 'products' ][ $key ][ 'discount_price' ] * $products[ 'products' ][ $key ][ 'quantity' ]));

                            $total_qty -= $g_qty;
                        }
                    }
                }
            }

            if ( $group_discount[ 'repeat' ] != 'yes' && $discounts_total > 0 ) {
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


            if ( $discount_opt[ 'discount_type' ] == 'fixed_price_unit' || $discount_opt[ 'discount_type' ] == '' ) {
                return round( $disc_price, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'fixed_group_price' ) {
                return round( $disc_price / $qty, wc_get_price_decimals() );
            }




            $item_price = $product[ 'cart_price' ];

            $base_on = $discount_opt[ 'base_on' ];

            if ( $base_on != '' && $base_on != 'cart_price' ) {
                $src_price = WooPricely::get_product_price( $product[ 'key' ], $base_on );
                if ( is_numeric( $src_price ) ) {
                    $item_price = $src_price;
                }
            }


            if ( $discount_opt[ 'discount_type' ] == 'fixed_discount_unit' ) {
                $disc_price = $item_price - $disc_price;
                if ( $disc_price <= 0 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                return round( $disc_price, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'fixed_group_discount' ) {
                $disc_price = ($item_price * $qty) - $disc_price;
                if ( $disc_price < 0 ) {
                    $disc_price = $item_price;
                }
                return round( $disc_price / $qty, wc_get_price_decimals() );
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

        private static function get_group_part_repeat_count( $part_products ) {
            $total_qty = 0;
            foreach ( $part_products[ 'group' ] as $key => $p_products ) {
                $total_qty += $p_products[ 'qty' ];
            }
            return floor( $total_qty / $part_products[ 'qty' ] );
        }

        private static function get_all_group_count( $grouped_products, $rep_count ) {
            $all_qty = 0;
            $all_d_count = 0;
            foreach ( $grouped_products as $g_products ) {
                foreach ( $g_products[ 'group' ] as $gg_products ) {
                    foreach ( $gg_products[ 'products' ] as $key => $product ) {
                        for ( $i = 0; $i < $product[ 'quantity' ]; $i++ ) {
                            if ( $all_d_count < ($g_products[ 'qty' ] * $rep_count) ) {
                                $all_qty++;
                                $all_d_count++;
                            } else {
                                return $all_qty;
                            }
                        }
                    }
                }
            }
            return $all_qty;
        }

        private static function get_group_quantities( $products, $qty_base_on ) {

            $r_products = array();

            foreach ( $products as $key => $g_products ) {

                $cnt = 0;

                foreach ( self::sort_quantities( WooPricely::get_quantities( $g_products[ 'group' ], $qty_base_on ) ) as $d_key => $d_products ) {

                    $r_products[ $cnt ][ 'g_' . $key ][ 'qty' ] = $g_products[ 'qty' ];
                    $r_products[ $cnt ][ 'g_' . $key ][ 'group' ][ $d_key ] = $d_products;

                    $cnt++;
                }

                $products[ $key ][ 'group' ] = self::sort_quantities( WooPricely::get_quantities( $g_products[ 'group' ], $qty_base_on ) );
            }

            return $r_products;
        }

        private static function sort_quantities( $products ) {

            $r_products = array();

            $max_qty = 0;

            foreach ( $products as $key => $product ) {

                if ( $product[ 'qty' ] > $max_qty ) {

                    $max_qty = $product[ 'qty' ];
                }
            }

            for ( $i = $max_qty; $i >= 0; $i-- ) {

                foreach ( $products as $key => $product ) {

                    if ( $product[ 'qty' ] == $i ) {

                        $r_products[ $key ] = $product;
                    }
                }
            }

            return $r_products;
        }

        private static function merge_grouped_products( $grouped_products ) {

            $products = array();

            foreach ( $grouped_products as $g_products ) {

                foreach ( $g_products[ 'group' ] as $key => $product ) {

                    $products[ $key ] = $product;
                }
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

    WooPricely_Checkout_Group_Prices::init();
}


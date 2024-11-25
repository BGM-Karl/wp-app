<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WooPricely_Checkout_Bulk_Prices' ) ) {

    class WooPricely_Checkout_Bulk_Prices {

        public static function init() {
            add_filter( 'zcpri/process-checkout-prices-bulk-rule', array( new self(), 'process_rule' ), 1, 3 );
            add_filter( 'zcpri/process-checkout-prices-tiered-rule', array( new self(), 'process_rule' ), 1, 3 );

            add_filter( 'zcpri/get-checkout-prices-bulk-product-data', array( new self(), 'get_products_data' ), 1, 2 );
            add_filter( 'zcpri/get-checkout-prices-tiered-product-data', array( new self(), 'get_products_data' ), 1, 2 );

            add_filter( 'zcpri/get-checkout-prices-bulk-discounts', array( new self(), 'calc_products_prices' ), 1, 2 );
            add_filter( 'zcpri/get-checkout-prices-tiered-discounts', array( new self(), 'calc_products_prices' ), 1, 2 );
        }

        public static function process_rule( $rule, $raw_rule, $product_id ) {
            $rule[ 'qty_base_on' ] = $raw_rule[ 'qty_base_on' ];
            $rule[ 'range_discount' ] = $raw_rule[ 'range_discount' ];
            $rule[ 'quantity_ranges' ] = $raw_rule[ 'quantity_ranges' ];
            $rule[ 'products' ] = self::get_checkout_products( $raw_rule, $product_id );
            return $rule;
        }

        public static function calc_products_prices( $r_products, $rule ) {

            $discounts_total = 0;

            foreach ( WooPricely::get_quantities( $rule[ 'products' ], $rule[ 'qty_base_on' ] ) as $products ) {
                $prods = array();
                if ( $rule[ 'mode' ] == 'bulk' ) {
                    $prods = self::get_bulk_discounts( $products, self::prepare_metrics_table( $rule[ 'quantity_ranges' ] ), $rule[ 'range_discount' ][ 'base_on' ] );
                } else if ( $rule[ 'mode' ] == 'tiered' ) {
                    $prods = self::get_tiered_discounts( $products, self::prepare_metrics_table( $rule[ 'quantity_ranges' ] ), $rule[ 'range_discount' ][ 'base_on' ] );
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
                        'table_id' => 'table_0',
                    );
                    if ( isset( $rule[ 'time_left' ] ) ) {
                        $r_dat[ 'time_left' ] = $rule[ 'time_left' ];
                    }
                    if ( isset( $rule[ 'range_discount' ][ 'base_on' ] ) && isset( $rule[ 'quantity_ranges' ] ) ) {
                        $r_dat = self::get_prices_table( $product, $r_dat, $rule[ 'range_discount' ][ 'base_on' ], self::prepare_metrics_table( $rule[ 'quantity_ranges' ] ) );
                    }
                    if ( isset( $rule[ 'range_discount' ][ 'metrics_table' ] ) ) {
                        $r_dat[ 'table_id' ] = $rule[ 'range_discount' ][ 'metrics_table' ];
                    }

                    $r_data[] = $r_dat;
                }
            }

            return $r_data;
        }

        private static function get_checkout_products( $rule, $product_id ) {

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
            }

            $sorted_products = self::get_sorted_products( $valid_products, $rule_args );

            return $sorted_products;
        }

        private static function get_bulk_discounts( $products, $metric_ranges, $base_on ) {
            $metric = self::get_metrics( $products[ 'qty' ], $metric_ranges );

            if ( !isset( $metric[ 'min_qty' ] ) ) {
                return $products;
            }

            if ( isset( $metric[ 'max_qty' ] ) && $metric[ 'max_qty' ] != '' ) {
                $items_total = 0;
                $discounts_total = 0;
                foreach ( $products[ 'products' ] as $key => $product ) {
                    if ( $items_total > $metric[ 'max_qty' ] ) {
                        continue;
                    }

                    if ( $items_total + $product[ 'quantity' ] > $metric[ 'max_qty' ] ) {



                        $extra_disc = ($items_total + $product[ 'quantity' ]) - $metric[ 'max_qty' ];
                        $disc_item_count = $product[ 'quantity' ] - $extra_disc;

                        $disc = self::calc_products_discount( $product, $metric, $base_on, $disc_item_count );
                        $d_price = (($disc * $disc_item_count) + ($extra_disc * $product[ 'cart_price' ])) / $product[ 'quantity' ];
                        if ( $d_price != $products[ 'products' ][ $key ][ 'cart_price' ] ) {
                            $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                            $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                            $products[ 'products' ][ $key ][ 'discount_detail' ][] = array( 'qty' => $disc_item_count, 'price' => $disc );
                            $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                        }
                    } else {
                        $d_price = self::calc_products_discount( $product, $metric, $base_on, $product[ 'quantity' ] );
                        if ( $d_price != $products[ 'products' ][ $key ][ 'cart_price' ] ) {
                            $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                            $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                            $products[ 'products' ][ $key ][ 'discount_detail' ][] = array( 'qty' => $product[ 'quantity' ], 'price' => $d_price );
                            $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                        }
                    }
                    $items_total += $product[ 'quantity' ];

                    $products[ 'products' ][ $key ][ 'discount_detail' ] = self::prepare_discount_detail( $products[ 'products' ][ $key ][ 'discount_detail' ], $products[ 'products' ][ $key ][ 'cart_price' ] );
                }
                $products[ 'discounts_total' ] = $discounts_total;
            } else {
                $discounts_total = 0;
                foreach ( $products[ 'products' ] as $key => $product ) {
                    $d_price = self::calc_products_discount( $product, $metric, $base_on, $product[ 'quantity' ] );
                    if ( $d_price != $products[ 'products' ][ $key ][ 'cart_price' ] ) {
                        $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                        $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;
                        $products[ 'products' ][ $key ][ 'discount_detail' ][] = array( 'qty' => $product[ 'quantity' ], 'price' => $d_price );
                        $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                    }
                    $products[ 'products' ][ $key ][ 'discount_detail' ] = self::prepare_discount_detail( $products[ 'products' ][ $key ][ 'discount_detail' ], $products[ 'products' ][ $key ][ 'cart_price' ] );
                }
                $products[ 'discounts_total' ] = $discounts_total;
            }


            return $products;
        }

        private static function get_tiered_discounts( $products, $metrics_ranges, $base_on ) {

            $total_m_pointer = 0;
            $discounts_total = 0;
            foreach ( $products[ 'products' ] as $key => $product ) {
                $d_d = array();
                for ( $m_pointer = $total_m_pointer + 1; $m_pointer <= ($total_m_pointer + $product[ 'quantity' ]); $m_pointer++ ) {
                    $metrics = self::get_metrics( $m_pointer, $metrics_ranges );
                    if ( isset( $metrics[ 'max_qty' ] ) && $metrics[ 'max_qty' ] != '' ) {
                        if ( $m_pointer <= $metrics[ 'max_qty' ] ) {
                            $d_p = self::calc_products_discount( $product, $metrics, $base_on, 1 );

                            $d_p_str = '' . $d_p . '';
                            if ( !isset( $d_d[ $d_p_str ] ) ) {
                                $d_d[ $d_p_str ] = 0;
                            }
                            $d_d[ $d_p_str ] += 1;
                        }
                    } else {
                        $d_p = self::calc_products_discount( $product, $metrics, $base_on, 1 );
                        $d_p_str = '' . $d_p . '';
                        if ( !isset( $d_d[ $d_p_str ] ) ) {
                            $d_d[ $d_p_str ] = 0;
                        }
                        $d_d[ $d_p_str ] += 1;
                    }
                }
                $total_m_pointer += $product[ 'quantity' ];


                $total_price = 0;
                $total_qty = 0;

                $d_details = array();
                foreach ( $d_d as $d_pp => $d_qty ) {
                    if ( $d_pp == '' && $products[ 'products' ][ $key ][ 'cart_price' ] ) {
                        $d_pp = $products[ 'products' ][ $key ][ 'cart_price' ];
                    }

                    $total_price = $total_price + ($d_pp * $d_qty);
                    $total_qty += $d_qty;
                    $d_details[] = array( 'qty' => $d_qty, 'price' => $d_pp );
                }

                $d_price = round( ($total_price + ($product[ 'cart_price' ] * ($product[ 'quantity' ] - $total_qty))) / $product[ 'quantity' ], 2 );

                if ( $d_price != $product[ 'cart_price' ] ) {
                    $products[ 'products' ][ $key ][ 'id' ] = $product[ 'id' ];
                    $products[ 'products' ][ $key ][ 'discount_price' ] = $d_price;

                    $products[ 'products' ][ $key ][ 'discount_detail' ] = self::prepare_discount_detail( $d_details, $products[ 'products' ][ $key ][ 'cart_price' ] );
                    $discounts_total += ($products[ 'products' ][ $key ][ 'cart_price' ] - $d_price) * $products[ 'products' ][ $key ][ 'quantity' ];
                }
            }
            $products[ 'discounts_total' ] = $discounts_total;
            return $products;
        }

        private static function calc_products_discount( $product, $discount_opt, $base_on, $qty ) {
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


            if ( $base_on != '' && $base_on != 'cart_price' ) {
                $src_price = WooPricely::get_product_price( $product[ 'key' ], $base_on );
                if ( is_numeric( $src_price ) ) {
                    $item_price = $src_price;
                }
            }

            if ( $discount_opt == 'no' ) {
                return round( $item_price, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'fixed_discount' ) {
                $disc_price = ($item_price * $qty) - $disc_price;
                if ( $disc_price < 0 ) {
                    $disc_price = $item_price;
                }

                return round( $disc_price / $qty, wc_get_price_decimals() );
            }

            if ( $discount_opt[ 'discount_type' ] == 'fixed_discount_unit' ) {
                $disc_price = (( float ) ($item_price)) - $disc_price;

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

        private static function get_metrics( $qty, $quantity_ranges ) {

            $r_range = array();

            foreach ( $quantity_ranges as $range ) {
                $r_range = $range;
                if ( isset( $range[ 'max_qty' ] ) && $range[ 'max_qty' ] != '' ) {
                    if ( $qty >= $range[ 'min_qty' ] && $qty <= $range[ 'max_qty' ] ) {
                        return $r_range;
                    }
                } else {
                    if ( $qty >= $range[ 'min_qty' ] ) {
                        return $r_range;
                    }
                }
            }

            return $r_range;
        }

        private static function get_prices_table( $product, $data, $base_on, $quantity_ranges ) {
            $src_product = wc_get_product( $product[ 'id' ] );
            $variable_range = array();
            $data[ 'price' ] = array();
            if ( $src_product->has_child() == true ) {
                $variable_range = self::get_variable_price_range( $src_product->get_children() );
                $data[ 'price' ][] = $variable_range[ 'min' ];
                if ( $variable_range[ 'min' ] <> $variable_range[ 'max' ] ) {
                    $data[ 'price' ][] = $variable_range[ 'max' ];
                }
            } else {
                $data[ 'price' ][] = $src_product->get_price();
            }


            $prices_table = array();
            foreach ( $quantity_ranges as $metric ) {
                $m_price = array();
                if ( count( $variable_range ) > 0 ) {

                    $m_price[] = self::get_prices_table_discount( $variable_range[ 'min_id' ], $metric[ 'amount' ], $metric[ 'discount_type' ], $base_on );

                    if ( $m_price[ 0 ] < 0 ) {
                        $m_price[ 0 ] = 0;
                    }

                    if ( $variable_range[ 'min' ] <> $variable_range[ 'max' ] ) {
                        $m_price[] = self::get_prices_table_discount( $variable_range[ 'max_id' ], $metric[ 'amount' ], $metric[ 'discount_type' ], $base_on );
                        if ( $m_price[ 1 ] < 0 ) {
                            $m_price[ 1 ] = 0;
                        }
                    }
                } else {
                    $m_price[] = self::get_prices_table_discount( $product[ 'id' ], $metric[ 'amount' ], $metric[ 'discount_type' ], $base_on );
                    if ( $m_price[ 0 ] < 0 ) {
                        $m_price[ 0 ] = 0;
                    }
                }



                if ( $metric[ 'max_qty' ] != '' ) {
                    $prices_table[] = array(
                        'qty' => array( $metric[ 'min_qty' ], $metric[ 'max_qty' ] ),
                        'price' => $m_price,
                        'is_missing' => $metric[ 'is_missing' ],
                    );
                } else {
                    $prices_table[] = array(
                        'qty' => array( $metric[ 'min_qty' ] ),
                        'price' => $m_price,
                        'is_missing' => $metric[ 'is_missing' ],
                    );
                }
            }

            $data[ 'prices_table' ] = $prices_table;
            return $data;
        }

        private static function get_prices_table_discount( $product_id, $amount, $discount_type, $base_on ) {

            $disc_price = 0;
            if ( is_numeric( $amount ) ) {
                $disc_price = $amount;
            }


            if ( $discount_type == 'fixed_price_unit' ) {
                return round( $disc_price, wc_get_price_decimals() );
            }


            if ( $base_on == '' || $base_on == 'cart_price' ) {
                $base_on = 'calc_sale_price';
            }

            $product = WooPricely::create_product_identifier( wc_get_product( $product_id ) );

            $item_price = WooPricely::get_product_price( $product[ 'key' ], $base_on );
            if ( !is_numeric( $item_price ) ) {
                round( 0, wc_get_price_decimals() );
            }

            if ( $discount_type == 'no' ) {
                return round( $item_price, wc_get_price_decimals() );
            }

            if ( $discount_type == 'fixed_discount_unit' ) {
                $disc_price = (( float ) ($item_price)) - $disc_price;

                if ( $disc_price <= 0 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                return round( $disc_price, wc_get_price_decimals() );
            }

            if ( $discount_type == 'per_discount' ) {
                if ( $disc_price <= 0 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                if ( $disc_price >= 100 ) {
                    return round( $item_price, wc_get_price_decimals() );
                }
                $disc_price = $item_price - (($disc_price / 100) * $item_price);
                return round( $disc_price, wc_get_price_decimals() );
            }
            return 5;
        }

        private static function get_variable_price_range( $variations ) {
            $min_price = 0;
            $max_price = 0;
            $min_id = 0;
            $max_id = 0;
            foreach ( $variations as $products_id ) {
                $src_product = wc_get_product( $products_id );
                $price = $src_product->get_price();
                if ( $min_price == 0 || $price < $min_price ) {
                    $min_price = $price;
                    $min_id = $src_product->get_id();
                }
                if ( $price > $max_price ) {
                    $max_price = $price;
                    $max_id = $src_product->get_id();
                }
            }
            return array(
                'min' => $min_price,
                'max' => $max_price,
                'min_id' => $min_id,
                'max_id' => $max_id
            );
        }

        private static function prepare_metrics_table( $quantity_ranges ) {


            $max_q = 0;

            foreach ( $quantity_ranges as $key => $qty_rng ) {
                $quantity_ranges[ $key ][ 'key' ] = 'f' . $key;
                $quantity_ranges[ $key ][ 'is_missing' ] = false;
                if ( $qty_rng[ 'min_qty' ] != '' && $qty_rng[ 'min_qty' ] > $max_q ) {
                    $max_q = $qty_rng[ 'min_qty' ];
                }
                if ( $qty_rng[ 'max_qty' ] != '' && $qty_rng[ 'max_qty' ] > $max_q ) {
                    $max_q = $qty_rng[ 'max_qty' ];
                }
            }


            $prep_ramges = array();

            $missed_min = 0;
            $missed_max = 0;

            $miss_count = 0;
            for ( $i = 1; $i <= $max_q; $i++ ) {
                $nex_range = self::get_metrics_range( $i, $quantity_ranges );
                if ( count( $nex_range ) > 0 ) {
                    if ( $missed_min > 0 ) {
                        $miss_count++;
                        $prep_ramges[ 'm' . $miss_count ] = array(
                            'min_qty' => $missed_min,
                            'max_qty' => $missed_max,
                            'discount_type' => 'no',
                            'amount' => 0,
                            'is_missing' => true,
                            'key' => 'm' . $miss_count
                        );
                        $missed_min = 0;
                        $missed_max = 0;
                    }
                    $prep_ramges[ $nex_range[ 'key' ] ] = $nex_range;
                } else {
                    if ( $missed_min == 0 ) {
                        $missed_min = $i;
                    }
                    $missed_max = $i;
                }
            }


            foreach ( $prep_ramges as $key => $rng ) {
                unset( $prep_ramges[ $key ][ 'key' ] );
            }
            return array_values( $prep_ramges );
        }

        private static function get_metrics_range( $qty, $quantity_ranges ) {
            $is_missing = false;
            foreach ( $quantity_ranges as $range ) {

                if ( isset( $range[ 'max_qty' ] ) && $range[ 'max_qty' ] != '' ) {
                    if ( $qty >= $range[ 'min_qty' ] && $qty <= $range[ 'max_qty' ] ) {
                        return $range;
                    }
                } else {
                    if ( $qty >= $range[ 'min_qty' ] ) {
                        return $range;
                    }
                }
            }

            return array();
        }

        private static function prepare_discount_detail( $discount_details, $cart_price ) {
            $details = array();
            foreach ( $discount_details as $discount_detail ) {
                if ( $discount_detail[ 'price' ] == $cart_price ) {
                    continue;
                }
                $details[] = $discount_detail;
            }
            return $details;
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

    WooPricely_Checkout_Bulk_Prices::init();
}


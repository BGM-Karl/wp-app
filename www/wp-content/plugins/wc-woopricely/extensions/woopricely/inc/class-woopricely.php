<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists( 'WooPricely' ) ) {

    class WooPricely {

        private static $cart_items = array();

        public static function validate_products( $rules, $products, $rule_args ) {

            $valid_products = array();

            foreach ( $products as $key => $product ) {

                $is_valid = false;

                foreach ( $rules as $rule ) {

                    $arg_key = $rule[ 'rule_type' ];

                    $filter_args = $rule[ 'rule_type_' . $arg_key ];
                    $vld = apply_filters( 'zcpri/validate-product-filter-' . $arg_key, $product, $filter_args, $rule_args );

                    if ( $vld == true ) {
                        $is_valid = true;
                    }

                    if ( isset( $filter_args[ 'is_req' ] ) && $filter_args[ 'is_req' ] == 'yes' ) {

                        if ( $vld == false ) {

                            $is_valid = false;

                            break;
                        }
                    }
                }

                if ( $is_valid == true ) {

                    $valid_products[ $key ] = $product;
                }
            }
            return $valid_products;
        }

        public static function get_products( $rules, $qty ) {

            $products = array();

            foreach ( $rules as $rule ) {

                $arg_key = $rule[ 'rule_type' ];

                foreach ( apply_filters( 'zcpri/get-products-' . $arg_key, array(), $rule[ 'rule_type_' . $arg_key ], $qty ) as $key => $prod ) {

                    $products[ $key ] = $prod;

                    if ( count( $products ) >= $qty ) {

                        break;
                    }
                }

                if ( count( $products ) >= $qty ) {

                    break;
                }
            }

            return $products;
        }

        public static function get_products_from_database( $result, $args, $qty, $exclude = false ) {

            $args[ 'status' ] = array( 'publish' );
            $args[ 'offset' ] = 0;


            if ( $exclude == true ) {
               
                $args[ 'return' ] = 'ids';
                $exc_products = wc_get_products( $args );

                $args[ 'exclude' ] = $exc_products;
                
                unset( $args[ 'return' ] );
            }

            $args[ 'limit' ] = $qty;
            $args[ 'orderby' ] = '_price';
            $args[ 'order' ] = 'ASC';

            $db_products = wc_get_products( apply_filters( 'zcpri/process-auto-add-products-args', $args ) );

            foreach ( $db_products as $prod ) {

                $product = self::create_product_identifier( $prod );
               
                if ( isset( $product[ 'id' ] ) ) {
                   
                    $result[ $product[ 'key' ] ] = $product;
                }
            }
            
            return $result;
        }

        public static function validate_conditions( $rules, $rule_args ) {



            $is_valid = false;

            foreach ( $rules as $rule ) {

                $arg_key = $rule[ 'rule_type' ];

                if ( self::get_condition_needs_validation( $arg_key, $rule_args ) == false ) {
                    $is_valid = true;
                    continue;
                }

                $condition_args = $rule[ 'rule_type_' . $arg_key ];
                $vld = apply_filters( 'zcpri/validate-condition-' . $arg_key, $condition_args, $rule_args );

                if ( $vld == true ) {
                    $is_valid = true;
                }

                if ( isset( $condition_args[ 'is_req' ] ) && $condition_args[ 'is_req' ] == 'yes' ) {
                    if ( $vld == false ) {
                        $is_valid = false;
                        break;
                    }
                }
            }


            return $is_valid;
        }

        public static function get_product_identifier_key( $id, $variation_id = 0 ) {

            if ( $variation_id > 0 ) {
                return $id . ':' . $variation_id;
            } else {
                return $id;
            }
        }

        public static function get_products_from_cart( $cache = true ) {

            foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
                $same_product_count = 0;
                $product = array(
                    'id' => 0,
                    'cart_key' => $key,
                    'key' => $key,
                    'quantity' => $cart_item[ 'quantity' ],
                    'categories' => $cart_item[ 'data' ]->get_category_ids(),
                    'tags' => $cart_item[ 'data' ]->get_tag_ids()
                );

                $product[ 'cart_price' ] = $cart_item[ 'data' ]->get_price();


                if ( isset( $cart_item[ 'product_id' ] ) ) {
                    $product[ 'id' ] = $cart_item[ 'product_id' ];
                    $product[ 'key' ] = WooPricely::get_product_identifier_key( $cart_item[ 'product_id' ] );
                }
                if ( isset( $cart_item[ 'variation_id' ] ) && $cart_item[ 'variation_id' ] > 0 ) {
                    $prod = wc_get_product( $cart_item[ 'product_id' ] );
                    if ( $prod == false ) {
                        $product[ 'categories' ] = array();
                        $product[ 'tags' ] = array();
                    } else {
                        $product[ 'categories' ] = $prod->get_category_ids();

                        $product[ 'tags' ] = $prod->get_tag_ids();
                    }
                    $product[ 'variation_id' ] = $cart_item[ 'variation_id' ];
                    $product[ 'key' ] = WooPricely::get_product_identifier_key( $cart_item[ 'product_id' ], $cart_item[ 'variation_id' ] );
                }

                if ( isset( self::$cart_items[ 'key' ] ) ) {

                    //Fix same product on multiple cart line issue.
                    self::$cart_items[ $product[ 'key' ] . '_' . $same_product_count ] = $product;
                    $same_product_count++;
                } else {
                    self::$cart_items[ $product[ 'key' ] ] = $product;
                }
            }
            return self::$cart_items;
        }

        public static function create_product_identifier( $src_product ) {

            $product = array();

            if ( !method_exists( $src_product, 'get_id' ) ) {
                return $product;
            }

            $parent_id = $src_product->get_parent_id();

            if ( $src_product->is_type( 'variation' ) || $parent_id > 0 ) {
                $product[ 'key' ] = WooPricely::get_product_identifier_key( $src_product->get_parent_id(), $src_product->get_id() );
                $product[ 'id' ] = $src_product->get_parent_id();
                $product[ 'variation_id' ] = $src_product->get_id();
            } else {
                $product[ 'key' ] = WooPricely::get_product_identifier_key( $src_product->get_id() );
                $product[ 'id' ] = $src_product->get_id();
            }

            $product[ 'type' ] = $src_product->get_type();

            if ( isset( $product[ 'variation_id' ] ) && $product[ 'variation_id' ] > 0 ) {
                $p_product = wc_get_product( $product[ 'id' ] );
                $product[ 'categories' ] = $p_product->get_category_ids();
                $product[ 'tags' ] = $p_product->get_tag_ids();
            } else {
                $product[ 'categories' ] = $src_product->get_category_ids();
                $product[ 'tags' ] = $src_product->get_tag_ids();
            }


            return $product;
        }

        public static function get_product_price( $key, $price_type ) {

            $price = WooPricely_Product_Prices::get_calculated_product_prices( $key );

            if ( $price_type == 'reg_price' ) {
                if ( isset( $price[ 'regular_price' ] ) ) {
                    return $price[ 'regular_price' ];
                }
            }

            if ( $price_type == 'sale_price' ) {
                if ( isset( $price[ 'sale_price' ] ) && is_numeric( $price[ 'sale_price' ] ) ) {
                    return $price[ 'sale_price' ];
                } else if ( isset( $price[ 'regular_price' ] ) ) {
                    return $price[ 'regular_price' ];
                }
            }




            if ( $price_type == 'calc_reg_price' ) {

                if ( isset( $price[ 'calc_regular_price' ] ) ) {

                    return $price[ 'calc_regular_price' ];
                } else if ( isset( $price[ 'regular_price' ] ) ) {
                    return $price[ 'regular_price' ];
                }
            }

            if ( $price_type == 'calc_sale_price' ) {
                if ( isset( $price[ 'calc_sale_price' ] ) ) {
                    return $price[ 'calc_sale_price' ];
                } else if ( isset( $price[ 'calc_regular_price' ] ) ) {
                    return $price[ 'calc_regular_price' ];
                } else if ( isset( $price[ 'sale_price' ] ) && is_numeric( $price[ 'sale_price' ] ) ) {
                    return $price[ 'sale_price' ];
                } else if ( isset( $price[ 'regular_price' ] ) ) {
                    return $price[ 'regular_price' ];
                }
            }


            $product = self::get_product_by_key( $key );

            if ( $price_type == 'reg_price' || $price_type == 'calc_reg_price' ) {
                return $product->get_regular_price( false );
            } else {
                return $product->get_price( false );
            }
        }

        public static function get_product_by_key( $key ) {
            $ar_key = explode( ':', $key );
            $count = count( $ar_key );
            if ( $count == 1 ) {
                return wc_get_product( $ar_key[ 0 ] );
            } else if ( $count == 2 ) {
                return wc_get_product( $ar_key[ 1 ] );
            }

            return null;
        }

        public static function clear_cart_auto_add() {

            if ( is_admin() ) {
                return;
            }

            if ( is_null( WC()->cart ) ) {
                return;
            }

            if ( WC()->cart->is_empty() ) {

                WC()->session->set( 'bogo_auto_added', 'no' );
            }
        }

        public static function get_quantities( $products, $qty_base_on ) {
            if ( $qty_base_on == '' ) {
                $qty_base_on = 'product_id';
            }

            $qty_products = array();

            if ( $qty_base_on == 'category_id' ) {
                $qty_products = self::get_quantities_by_category_id( $products );
            }

            if ( $qty_base_on == 'product_id' ) {
                $qty_products = self::get_quantities_by_product_id( $products );
            }

            if ( $qty_base_on == 'variation_id' ) {
                $qty_products = self::get_quantities_by_variation_id( $products );
            }

            if ( $qty_base_on == 'cart_key' ) {
                $qty_products = self::get_quantities_by_line_item( $products );
            }

            if ( $qty_base_on == 'cart' ) {
                $qty_products = self::get_quantities_by_all_in_cart( $products );
            }

            return apply_filters( 'zcpri/get-checkout-prices-quantity-based-on-' . $qty_base_on, $qty_products, $products, $qty_base_on );
        }

        private static function get_quantities_by_category_id( $products ) {
            $sorted = array();
            foreach ( $products as $key => $product ) {
                $added = false;
                foreach ( $product[ 'categories' ] as $category ) {
                    if ( $added != true ) {
                        if ( !isset( $sorted[ $category ][ 'qty' ] ) ) {
                            $sorted[ $category ][ 'qty' ] = 0;
                        }
                        $sorted[ $category ][ 'qty' ] += $product[ 'quantity' ];
                        $sorted[ $category ][ 'products' ][ $key ] = $product;
                        $added = true;
                    }
                }
            }

            return $sorted;
        }

        private static function get_quantities_by_product_id( $products ) {
            $sorted = array();
            foreach ( $products as $key => $product ) {
                if ( !isset( $sorted[ $product[ 'id' ] ][ 'qty' ] ) ) {
                    $sorted[ $product[ 'id' ] ][ 'qty' ] = 0;
                }
                $sorted[ $product[ 'id' ] ][ 'qty' ] += $product[ 'quantity' ];
                $sorted[ $product[ 'id' ] ][ 'products' ][ $key ] = $product;
            }

            return $sorted;
        }

        private static function get_quantities_by_variation_id( $products ) {
            $sorted = array();
            foreach ( $products as $key => $product ) {
                if ( !isset( $product[ 'variation_id' ] ) ) {
                    continue;
                }

                if ( !isset( $sorted[ $product[ 'variation_id' ] ][ 'qty' ] ) ) {
                    $sorted[ $product[ 'variation_id' ] ][ 'qty' ] = 0;
                }
                $sorted[ $product[ 'variation_id' ] ][ 'qty' ] += $product[ 'quantity' ];
                $sorted[ $product[ 'variation_id' ] ][ 'products' ][ $key ] = $product;
            }

            return $sorted;
        }

        private static function get_quantities_by_line_item( $products ) {
            $sorted = array();
            $cnt = 0;
            foreach ( $products as $key => $product ) {
                $p_key = 'cart_' . $cnt;
                if ( !isset( $sorted[ $p_key ][ 'qty' ] ) ) {
                    $sorted[ $p_key ][ 'qty' ] = 0;
                }
                $sorted[ $p_key ][ 'qty' ] += $product[ 'quantity' ];
                $sorted[ $p_key ][ 'products' ][ $key ] = $product;
                $cnt++;
            }

            return $sorted;
        }

        private static function get_quantities_by_all_in_cart( $products ) {
            $sorted = array();

            foreach ( $products as $key => $product ) {
                $p_key = 'cart';
                if ( !isset( $sorted[ $p_key ][ 'qty' ] ) ) {
                    $sorted[ $p_key ][ 'qty' ] = 0;
                }
                $sorted[ $p_key ][ 'qty' ] += $product[ 'quantity' ];
                $sorted[ $p_key ][ 'products' ][ $key ] = $product;
            }

            return $sorted;
        }

        private static function get_condition_needs_validation( $rule_type, $rule_args ) {
            global $zc_pri;
            if ( $rule_args[ 'section' ] != 'checkout_prices' ) {
                return true;
            }
            $validation_mode = 'cart_checkout_product';
            if ( isset( $zc_pri[ 'checkout_prices_conditions_modes' ] ) ) {
                foreach ( $zc_pri[ 'checkout_prices_conditions_modes' ] as $condition_mode ) {
                    if ( $condition_mode[ 'rule_type' ] == '' || $condition_mode[ 'rule_type' ] == $rule_type ) {
                        $validation_mode = $condition_mode[ 'mode' ];
                    }
                }
            }

            if ( !isset( $rule_args[ 'is_single' ] ) ) {
                return true;
            }

            if ( $rule_args[ 'is_single' ] == true && $validation_mode == 'cart_checkout' ) {
                return false;
            }
            return true;
        }

    }

}
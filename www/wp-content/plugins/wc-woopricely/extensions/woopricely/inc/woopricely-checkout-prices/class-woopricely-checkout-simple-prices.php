<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooPricely_Checkout_Simple_Prices')) {

    class WooPricely_Checkout_Simple_Prices {

        public static function init() {

            add_filter('zcpri/process-checkout-prices-simple-rule', array(new self(), 'process_rule'), 1, 3);
            add_filter('zcpri/get-checkout-prices-simple-product-data', array(new self(), 'get_products_data'), 1, 2);
            add_filter('zcpri/get-checkout-prices-simple-discounts', array(new self(), 'calc_products_prices'), 1, 2);
        }

        public static function process_rule($rule, $raw_rule, $product_id) {
            $rule['simple_discount'] = $raw_rule['simple_discount'];
            $rule['products'] = self::get_checkout_products($raw_rule, $product_id);
            return $rule;
        }

        public static function calc_products_prices($r_products, $rule) {
            $products = array();
            $discounts_total = 0;
            if (isset($rule['products'])) {
                foreach ($rule['products'] as $key => $product) {
                    if ($rule['simple_discount']['discount_type'] == 'fixed_discount' || $rule['simple_discount']['discount_type'] == 'fixed_price') {
                        $p_price = self::get_product_price($product, $rule['simple_discount']['base_on'], $rule['products'][$key]['quantity']);
                        $price_amount = $rule['simple_discount']['amount'];
                        if ($rule['simple_discount']['discount_type'] == 'fixed_discount') {
                            $price_amount = $p_price - $rule['simple_discount']['amount'];
                        }

                        $r_products['products'][$key]['id'] = $product['id'];
                        $r_products['products'][$key]['key'] = $product['key'];
                        $r_products['products'][$key]['qty'] = $product['quantity'];
                        $r_products['products'][$key]['cart_key'] = $product['cart_key'];
                        $r_products['products'][$key]['cart_price'] = $product['cart_price'];
                        $r_products['products'][$key]['discount_price'] = $price_amount / $rule['products'][$key]['quantity'];
                        $r_products['products'][$key]['discount_detail'][] = array('qty' => $rule['products'][$key]['quantity'], 'price' => $price_amount / $rule['products'][$key]['quantity']);
                        $r_products['products'][$key]['mode'] = $rule['mode'];
                        $r_products['products'][$key]['discount_detail'] = self::round_pricing_details($r_products['products'][$key]['discount_detail']);
                        $discounts_total += ($p_price - $price_amount);
                    } else {
                        $discount_price = self::calc_products_discount($product, $rule['simple_discount']);
                        $r_products['products'][$key]['id'] = $product['id'];
                        $r_products['products'][$key]['key'] = $product['key'];
                        $r_products['products'][$key]['qty'] = $product['quantity'];
                        $r_products['products'][$key]['cart_key'] = $product['cart_key'];
                        $r_products['products'][$key]['cart_price'] = $product['cart_price'];
                        $r_products['products'][$key]['discount_price'] = $discount_price;
                        $r_products['products'][$key]['mode'] = $rule['mode'];

                        $discounts_total += ($rule['products'][$key]['cart_price'] - $discount_price) * $rule['products'][$key]['quantity'];
                    }
                }
            }
            $r_products['discounts_total'] = $discounts_total;
            return $r_products;
        }

        public static function get_products_data($r_data, $rule) {

            if (isset($rule['products'])) {
                foreach ($rule['products'] as $key => $product) {
                    $r_dat = array(
                        'id' => $product['id'],
                        'message' => $rule['message'],
                        'mode' => $rule['mode'],
                    );
                    if (isset($rule['time_left'])) {
                        $r_dat['time_left'] = $rule['time_left'];
                    }
                    $r_data[] = $r_dat;
                }
            }

            return $r_data;
        }

        private static function get_checkout_products($rule, $product_id) {

            if ($product_id > 0) {
                $valid_products = array();
                $product = WooPricely::create_product_identifier(wc_get_product($product_id));
                if (isset($product['key'])) {
                    $valid_products[$product['key']] = $product;
                }
            } else {
                $valid_products = WooPricely::get_products_from_cart();
            }


            $is_valid = true;


            $rule_args = array(
                'section' => 'checkout_prices',
                'panel' => 'products',
                'is_single' => false,
            );

            if ($product_id > 0) {
                $rule_args['is_single'] = true;
                $rule_args['product_id'] = $product_id;
            }

            if (isset($rule['products'])) {
               
                $valid_products = WooPricely::validate_products($rule['products'], $valid_products, $rule_args);
            }
            
            return $valid_products;
        }

        private static function calc_products_discount($product, $discount_opt) {

            if ($discount_opt['discount_type'] == 'free') {
  
                return 0;
            }

            $disc_price = 0;
            
            if (is_numeric($discount_opt['amount'])) {
                
                $disc_price = $discount_opt['amount'];
            }


            if ($discount_opt['discount_type'] == 'fixed_price' || $discount_opt['discount_type'] == '') {
                
                return round($disc_price / $product['quantity'], wc_get_price_decimals());
            }

            if ($discount_opt['discount_type'] == 'fixed_price_unit') {
                
                return round($disc_price, wc_get_price_decimals());
            }



            $item_price = WC()->cart->get_cart_item($product['cart_key'])['data']->get_price();


            if ($discount_opt['base_on'] != '' && $discount_opt['base_on'] != 'cart_price') {
                
                $src_price = WooPricely::get_product_price($product['key'], $discount_opt['base_on']);
                
                if (is_numeric($src_price)) {
                    
                    $item_price = $src_price;
                }
            }



            if ($discount_opt['discount_type'] == 'fixed_discount') {
                $disc_price = ($item_price * $product['quantity']) - $disc_price;
                if ($disc_price < 0) {
                    $disc_price = $item_price;
                }
                return round($disc_price / $product['quantity'], wc_get_price_decimals());
            }

            if ($discount_opt['discount_type'] == 'fixed_discount_unit') {
                $disc_price = $item_price - $disc_price;
                if ($disc_price <= 0) {
                    return round($item_price, wc_get_price_decimals());
                }
                return round($disc_price, wc_get_price_decimals());
            }

            if ($discount_opt['discount_type'] == 'per_discount') {
                if ($disc_price <= 0) {
                    return round($item_price, wc_get_price_decimals());
                }
                if ($disc_price >= 100) {
                    return round($item_price, wc_get_price_decimals());
                }
                $disc_price = $item_price - (($disc_price / 100) * $item_price);
                return round($disc_price, wc_get_price_decimals());
            }
        }

        private static function get_discount_subtotal($product, $discount_opt) {

            if ($discount_opt['discount_type'] == 'free') {
                return 0;
            }

            $disc_price = 0;
            if (is_numeric($discount_opt['amount'])) {
                $disc_price = $discount_opt['amount'];
            }


            if ($discount_opt['discount_type'] == 'fixed_price' || $discount_opt['discount_type'] == '') {
                return round($disc_price, wc_get_price_decimals());
            }

            $item_price = WC()->cart->get_cart_item($product['cart_key'])['data']->get_price();

            if ($discount_opt['base_on'] != '' && $discount_opt['base_on'] != 'cart_price') {
                $src_price = WooPricely::get_product_price($product['key'], $discount_opt['base_on']);
                if (is_numeric($src_price)) {
                    $item_price = $src_price;
                }
            }

            if ($discount_opt['discount_type'] == 'fixed_discount') {
                $disc_price = ($item_price * $product['quantity']) - $disc_price;
                if ($disc_price < 0) {
                    $disc_price = $item_price;
                }

                return round($disc_price, wc_get_price_decimals());
            }

            return 0;
        }

        private static function get_product_price($product, $base_on, $qty) {

            $item_price = WC()->cart->get_cart_item($product['cart_key'])['data']->get_price();
            if ($base_on != '' && $base_on != 'cart_price') {
                $src_price = WooPricely::get_product_price($product['key'], $base_on);
                if (is_numeric($src_price)) {
                    $item_price = $src_price;
                }
            }

            return $item_price * $qty;
        }

        private static function round_pricing_details($discount_details) {
            $d_details = array();

            foreach ($discount_details as $details) {
                $subtotal = $details['price'] * $details['qty'];
                $round_subtotal = round($details['price'], wc_get_price_decimals()) * $details['qty'];
                if ($subtotal <> $round_subtotal) {
                    $details['qty'] --;
                    if ($details['qty'] > 0) {
                        $d_details[] = $details;
                    }
                    $d_details[] = array(
                        'qty' => 1,
                        'price' => $details['price'] + ($subtotal - $round_subtotal)
                    );
                } else {
                    $d_details[] = $details;
                }
            }
            return $d_details;
        }

    }

    WooPricely_Checkout_Simple_Prices::init();
}


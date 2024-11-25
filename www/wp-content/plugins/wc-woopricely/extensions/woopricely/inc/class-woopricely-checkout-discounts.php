<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooPricely_Checkout_Discounts')) {

    class WooPricely_Checkout_Discounts {

        private static $discount_groups = array();
        
        private static $total_discounts = 0;

        public static function apply_discounts() {
            if (is_admin()) {
                return;
            }

            if (is_admin() && !defined('DOING_AJAX')) {
                return;
            }

            global $zc_pri;

            $discount_coupons = array(
                'enable' => 'no',
                'allow_others' => 'yes',
            );

            if (isset($zc_pri['discount_coupon'])) {
                $discount_coupons = $zc_pri['discount_coupon'];
            }

            self::$discount_groups = self::calculate_all_discounts();

            $discounts_total = 0;
            $coupon_codes = array();
            foreach (self::$discount_groups as $discount_id => $group) {
               
                $discount_title = $group[ 'title' ];

                if ( has_filter( 'zcpri/get-applied-discount-title' ) ) {
                    $discount_title = apply_filters( 'zcpri/get-applied-discount-title', $discount_title, $discount_id );
                }

                $discount_desc = $group[ 'desc' ];

                if ( has_filter( 'zcpri/get-applied-discount-desc' ) ) {
                    $discount_desc = apply_filters( 'zcpri/get-applied-discount-desc', $discount_desc, $discount_id );
                }

                $discounts_total += $group['discount'];
                if ($discount_coupons['enable'] == 'yes' && $group['coupon_code'] != '') {
                    WooPricely_Views::set_coupon_label($group['coupon_code'], array('title' => $discount_title, 'desc' => $discount_desc));
                    $coupon_codes[] = $group['coupon_code'];
                } else {
                    
                    WooPricely_Views::set_fee_descs('pri_disc_' . $discount_id, $discount_desc);
                    
                    $discount_amount = $group[ 'discount' ];
                    
                    if( has_filter( 'zcpri/get-applied-discount')){
                       $discount_amount = apply_filters('zcpri/get-applied-discount', $discount_amount);
                    }
                    
                    WC()->cart->fees_api()->add_fee(array(
                        'id' => 'pri_disc_' . $discount_id,
                        'name' => $discount_title,
                        'amount' => (float) (0 -  $discount_amount),
                        'taxable' => false,
                        'tax_class' => '',
                    ));
                }
            }

            $allow_other_coupons = true;
            if ($discount_coupons['enable'] == 'yes' && $discount_coupons['allow_others'] == 'no') {
                $allow_other_coupons = false;
            }

            self::apply_coupons($coupon_codes, $allow_other_coupons);
            self::$total_discounts = $discounts_total;
            WooPricely_Views::set_discounts_total(apply_filters('zcpri/get-applied-discount-totals',$discounts_total) );
        }
        
        public static function get_total_discounts() {
            return self::$total_discounts;
        }

        public static function get_coupon_data($coupon_data, $coupon_code) {
            
            if ( is_admin() ) {
                
                return $coupon_data;
            }
            
            global $zc_pri;


            $discount_coupons = array(
                'enable' => 'no',
                'allow_others' => 'yes',
            );

            if (isset($zc_pri['discount_coupon'])) {
                $discount_coupons = $zc_pri['discount_coupon'];
            }

            if ($discount_coupons['enable'] == 'no') {
                return $coupon_data;
            }
            if (count(self::$discount_groups) == 0) {
                self::$discount_groups = self::calculate_all_discounts();
            }


            foreach (self::$discount_groups as $key => $group) {
                if ($group['coupon_code'] != '' && $group['coupon_code'] == $coupon_code) {
                    return array(
                        'code' => $coupon_code,
                        'amount' => $group['discount'],
                        'discount_type' => 'fixed_cart',
                        'individual_use' => false,
                        'product_ids' => array(),
                        'exclude_product_ids' => array(),
                        'usage_limit' => '',
                        'usage_limit_per_user' => '',
                        'limit_usage_to_x_items' => '',
                        'usage_count' => '',
                        'expiry_date' => '',
                        'free_shipping' => false,
                        'product_categories' => array(),
                        'exclude_product_categories' => array(),
                        'exclude_sale_items' => false,
                        'minimum_amount' => '',
                        'maximum_amount' => '',
                        'customer_email' => array(),
                        'virtual' => true,
                    );
                }
            }
            return $coupon_data;
        }

        public static function remove_discount_taxes( $discount_taxes, $discount_id ) {

            foreach ( self::$discount_groups as $key => $group ) {
                $disc_id = 'pri_disc_' . $key;
                if ( $disc_id == $discount_id ) {
                    return array();
                }
            }

            return $discount_taxes;
        }

        private static function calculate_all_discounts() {
            global $zc_pri;
            $rls_mode = isset($zc_pri['checkout_discounts']['mode']) ? $zc_pri['checkout_discounts']['mode'] : 'all';
            if ($rls_mode == 'no') {
                return array();
            }

            $max_discount_amount = isset($zc_pri['checkout_discounts']['max_discount_amount']) ? $zc_pri['checkout_discounts']['max_discount_amount'] : 0;
            $max_discount_type = isset($zc_pri['checkout_discounts']['max_discount_type']) ? $zc_pri['checkout_discounts']['max_discount_type'] : 'no';
            $max_discount_base_on = isset($zc_pri['checkout_discounts']['base_on']) ? $zc_pri['checkout_discounts']['base_on'] : 'subtotal';


            $rules = self::get_checkout_discounts_valid_rules();



            //Create discount groups
            $groups = self::get_discount_groups();

            foreach ($rules as $rule) {
                $discount_opt = $rule['discount'];
                $discount_type = $discount_opt['discount_type'];
                if ($discount_type == 'fixed_discount' || $discount_type == 'per_discount') {
                    $g_dic = array('discount' => self::calc_cart_discount($discount_opt));
                } else {
                    $g_dic = array('discount' => self::calc_product_discount($discount_opt, $rule['products']));
                }


                if ($rule['send_to_group'] == 'yes' && isset($groups[$rule['group']['group_id']])) {
                    $g_dic['inc_method'] = $rule['group']['inc_method'];
                    $groups[$rule['group']['group_id']]['discounts'][] = $g_dic;
                } else {
                    $groups[$rule['option_id']] = self::create_group($rule['single'], $rule['title'], 'no');
                    $groups[$rule['option_id']]['discounts'][] = $g_dic;
                    $groups[$rule['option_id']]['notification'] = $rule['notification'];

                }
            }

            //Merge group discounts

            foreach ($groups as $key => $group) {
                if (isset($group['discounts'])) {
                    $groups[$key]['discount'] = self::merge_group_discounts($group['discounts'], $group['min'], $group['max'], $group['is_group']);
                }

                if (is_numeric($group['min']) && $groups[$key]['discount'] < $group['min']) {
                    $groups[$key]['discount'] = $group['min'];
                }

                if (is_numeric($group['max']) && $groups[$key]['discount'] > $group['max']) {
                    $groups[$key]['discount'] = $group['max'];
                }

                unset($groups[$key]['discounts']);
                unset($groups[$key]['min']);
                unset($groups[$key]['max']);
            }


            //Remove groups with zero discounts and apply first only
            if ($rls_mode == 'first' && count($groups) > 0) {
                $groups = self::get_first_discount(self::get_valid_discounts($groups));
            }

            //Remove groups with zero discounts and apply last only
            else if ($rls_mode == 'last' && count($groups) > 0) {
                $groups = self::get_last_discount(self::get_valid_discounts($groups));
            }
            //Remove groups with zero discounts and apply bigger only
            else if ($rls_mode == 'bigger' && count($groups) > 0) {
                $groups = self::get_bigger_discount(self::get_valid_discounts($groups));
            }
            //Remove groups with zero discounts and apply bigger only
            else if ($rls_mode == 'smaller' && count($groups) > 0) {
                $groups = self::get_smaller_discount(self::get_valid_discounts($groups));
            }
            //Remove groups with zero discounts
            else {
                $groups = self::get_valid_discounts($groups);
            }



            //Get max total discounts
            if ($max_discount_type != 'no' && $max_discount_amount > 0) {
                $groups = self::get_max_totals($groups, $max_discount_amount, $max_discount_type, $max_discount_base_on);
                $groups = self::get_valid_discounts($groups);
            }

            $notifications = array();

            if (isset($zc_pri['notifications']['checkout_discounts']) && $zc_pri['notifications']['checkout_discounts'] == 'yes') {
                foreach ($groups as $key => $group) {
                    $notifications[] = array(
                        'message' => apply_filters( 'zcpri/get-applied-discount-notification', $group[ 'notification' ], $key ),
                        'applied_value' => $group['discount'],
                    );
                }
            }
            WooPricely_Cart_Notifications::set_notication_message('checkout-dicounts', $notifications);


            return $groups;
        }

        private static function get_checkout_discounts_valid_rules() {
            global $zc_pri;
            $valid_rules = array();


            if (!isset($zc_pri['checkout_discounts_rules'])) {
                return $valid_rules;
            }


            foreach ($zc_pri['checkout_discounts_rules'] as $rule) {
                if ($rule['enable'] == 'yes') {

                    if (self::validate_checkout_discount_conditions($rule) == true) {
                        $rl = array(
                            'apply_mode' => $rule['apply_mode'],
                            'title' => $rule['title'],
                            'option_id' => $rule[ 'option_id' ],
                            'admin_note' => $rule['admin_note'],
                            'send_to_group' => $rule['send_to_group'],
                            'notification' => ''
                        );

                        if ($rule['discount']['discount_type'] != 'fixed_discount' && $rule['discount']['discount_type'] != 'per_discount') {
                            $rl['products'] = self::get_checkout_discount_products($rule);
                        }

                        if (isset($rule['single'])) {
                            $rl['single'] = $rule['single'];
                        }
                        if (isset($rule['group'])) {
                            $rl['group'] = $rule['group'];
                        }

                        $rl['discount'] = $rule['discount'];

                        if (isset($rule['notification'])) {
                            $rl['notification'] = $rule['notification'];
                        }

                        if ($rule['apply_mode'] == 'only_this') {
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
            for ($i = 0; $i < count($valid_rls); $i++) {
                if ($valid_rls[$i]['apply_mode'] == 'if_others' && count($valid_rls) == 1) {
                    continue;
                }
                if ($valid_rls[$i]['apply_mode'] == 'if_no_others' && count($valid_rls) > 1) {
                    continue;
                }
                $valid_rules[] = $valid_rls[$i];
            }
            return $valid_rules;
        }

        private static function validate_checkout_discount_conditions($rule) {
            if (!isset($rule['conditions'])) {
                return true;
            }
            $is_valid = true;
            $rule_args = array(
                'section' => 'checkout_discounts',
                'panel' => 'conditions',
            );
            if (isset($rule['conditions'])) {
                $is_valid = WooPricely::validate_conditions($rule['conditions'], $rule_args);
            }

            return $is_valid;
        }

        private static function get_checkout_discount_products($rule) {

            $valid_products = WooPricely::get_products_from_cart();
            $is_valid = true;


            $rule_args = array(
                'section' => 'checkout_discounts',
                'panel' => 'products',
            );

            if (isset($rule['products'])) {
                $valid_products = WooPricely::validate_products($rule['products'], $valid_products, $rule_args);
            }




            return $valid_products;
        }

        private static function calc_cart_discount($discount_option) {
            $disc_amount = 0;
            $amount = 0;
            if (is_numeric($discount_option['amount'])) {
                $disc_amount = $discount_option['amount'];
                $amount = $disc_amount;
            }

            if ($discount_option['discount_type'] == 'per_discount') {
                $amount = (float) ($disc_amount / 100) * WooPricely_Cart_Totals::get_subtotals(true, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_discounts'));
                if ($discount_option['cart_base_on'] == 'subtotal_ex_tax') {
                    $amount = (float) ($disc_amount / 100) * WooPricely_Cart_Totals::get_subtotals(false, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_discounts'));
                }
            }

            return $amount;
        }

        private static function calc_product_discount($discount_option, $products) {
            $total_amount = 0;

            foreach ($products as $key => $product) {

                $disc_amount = 0;
                $amount = 0;
                if (is_numeric($discount_option['amount'])) {
                    $disc_amount = $discount_option['amount'];
                    $amount = $discount_option['amount'];
                }
                if ($discount_option['discount_type'] == 'fixed_unit_discount') {
                    $amount = (float) ($disc_amount * $product['quantity']);
                } else if ($discount_option['discount_type'] == 'per_item_discount') {
                    $cart_item = WC()->cart->get_cart_item($product['cart_key']);
                    if (isset($cart_item['data'])) {
                        $item_price = $cart_item['data']->get_price() * $product['quantity'];
                        if ($discount_option['item_base_on'] != '' && $discount_option['item_base_on'] != 'cart_price') {
                            $src_price = WooPricely::get_product_price($product['key'], $discount_option['item_base_on']);
                            if (!is_numeric($src_price)) {
                                $src_price = 0;
                            }
                            $item_price = $src_price * $product['quantity'];
                        }

                        $amount = (float) (($disc_amount / 100) * $item_price);
                    } else {
                        $amount = 0;
                    }
                }


                $total_amount += $amount;
            }


            return $total_amount;
        }

        private static function merge_group_discounts($discounts, $min, $max, $is_group) {

            global $zc_pri;
            if (count($discounts) == 0) {
                if (is_numeric($min)) {
                    return $min;
                }
                return 0;
            }
            $g_mode = 'all';
            if (isset($zc_pri['discount_groups_mode'])) {
                $g_mode = $zc_pri['discount_groups_mode'];
            }

            $discount = 0;


            if ($g_mode == 'first' && $is_group == 'yes') {
                $f_discount = $discounts[0];
                if ($f_discount['inc_method'] == 'increment') {
                    $discount += $f_discount['discount'];
                } else if ($f_discount['inc_method'] == 'decrement') {
                    $discount -= $f_discount['discount'];
                } else {
                    $discount = $f_discount['discount'];
                }
            } else if ($g_mode == 'last' && $is_group == 'yes') {
                $l_discount = $discounts[(count($discounts) - 1)];
                if ($l_discount['inc_method'] == 'increment') {
                    $discount += $l_discount['discount'];
                } else if ($l_discount['inc_method'] == 'decrement') {
                    $discount -= $l_discount['discount'];
                } else {
                    $discount = $l_discount['discount'];
                }
            } else if ($g_mode == 'bigger' && $is_group == 'yes') {

                foreach ($discounts as $b_discount) {
                    if ($b_discount['discount'] > $discount && $b_discount['inc_method'] != 'decrement') {
                        $discount = $b_discount['discount'];
                    }
                }
            } else if ($g_mode == 'smaller' && $is_group == 'yes') {
                foreach ($discounts as $s_discount) {
                    if ($discount == 0 && $s_discount['inc_method'] != 'decrement') {
                        $discount = $s_discount['discount'];
                    } else if ($s_discount['discount'] < $discount && $s_discount['inc_method'] != 'decrement') {
                        $discount = $s_discount['discount'];
                    }
                }
            } else {
                foreach ($discounts as $one_discount) {
                    if ($is_group == 'yes' && $one_discount['inc_method'] == 'increment') {
                        $discount += $one_discount['discount'];
                    } else if ($is_group == 'yes' && $one_discount['inc_method'] == 'decrement') {
                        $discount -= $one_discount['discount'];
                    } else {
                        $discount = $one_discount['discount'];
                    }
                }
            }

            if ($is_group != 'yes') {
                $discount = $discounts[0]['discount'];
            }


            if ($discount < 0) {
                $discount = 0;
            }

            if (is_numeric($max)) {
                if ($discount > $max) {
                    return $max;
                }
            }
            return $discount;
        }

        private static function get_valid_discounts($discounts) {
            $grps = array();

            foreach ($discounts as $key => $discount) {

                if ($discount['discount'] > 0 || $discount['always_show'] == 'yes') {
                    $grps[$key] = $discount;
                }
            }
            return $grps;
        }

        private static function get_first_discount($discounts) {
            $grps = array();
            reset($discounts);
            $key = key($discounts);
            $grps[$key] = $discounts[$key];

            return $grps;
        }

        private static function get_last_discount($discounts) {
            $grps = array();
            end($discounts);
            $key = key($discounts);
            $grps[$key] = $discounts[$key];

            return $grps;
        }

        private static function get_bigger_discount($discounts) {
            $grps = array();
            $bigger = 0;
            foreach ($discounts as $key => $discount) {
                if ($discount['discount'] > $bigger) {
                    $grps = array();
                    $grps[$key] = $discount;
                    $bigger = $discount['discount'];
                }
            }
            return $grps;
        }

        private static function get_smaller_discount($discounts) {
            $grps = array();
            $smaller = 0;

            if (count($discounts) > 0) {
                reset($discounts);
                $key = key($discounts);
                $grps[$key] = $discounts[$key];
                $smaller = $discounts[$key]['discount'];
            }
            foreach ($discounts as $key => $discount) {
                if ($discount['discount'] > 0 && $discount['discount'] < $smaller) {
                    $grps = array();
                    $grps[$key] = $discount;
                    $smaller = $discount['discount'];
                }
            }
            return $grps;
        }

        private static function get_max_totals($discounts, $max, $max_type, $base_on) {
            $total_discounts = 0;
            $max_amount = $max;
            if ($max_type == 'per') {
                $max_amount = (float) ($max / 100) *WooPricely_Cart_Totals::get_subtotals(true, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_discounts'));
                if ($base_on == 'subtotal_ex_tax') {
                    $max_amount = (float) ($max / 100) * WooPricely_Cart_Totals::get_subtotals(false, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_discounts'));
                }
            }

            $grps = array();
            foreach ($discounts as $key => $discount) {

                if (($total_discounts) >= $max_amount) {
                    $discount['discount'] = 0;
                } else if (($total_discounts + $discount['discount']) > $max_amount) {
                    $discount['discount'] = $max_amount - $total_discounts;
                }
                $grps[$key] = $discount;
                $total_discounts += $discount['discount'];
            }
            return $grps;
        }

        private static function get_discount_groups() {
            global $zc_pri;
            $db_groups = array();
            if (isset($zc_pri['discount_groups'])) {
                $db_groups = $zc_pri['discount_groups'];
            }
            $groups = array();

            foreach ($db_groups as $db_group) {
                $groups[$db_group[ 'option_id' ]] = self::create_group($db_group, $db_group['title'], 'yes');
                if (isset($db_group['notification'])) {
                    $groups[$db_group[ 'option_id' ]]['notification'] = $db_group['notification'];
                } else {
                    $groups[$db_group[ 'option_id' ]]['notification'] = '';
                }

            }
            return $groups;
        }

        private static function create_group($db_group, $title, $is_group) {
            $group = array(
                'title' => $title,
                'desc' => $db_group['desc'],
                'min' => $db_group['min'],
                'max' => $db_group['max'],
                'coupon_code' => $db_group['coupon_code'],
                'always_show' => 'no',
                'is_group' => $is_group,
                'discount' => 0
            );
            if (isset($db_group['always_show'])) {
                $group['always_show'] = $db_group['always_show'];
            }

            return $group;
        }

        private static function apply_coupons($coupon_codes, $allow_others) {
            $prev_coupons = get_option('zcpri_prev_coupons', array());
            foreach ($prev_coupons as $p_code) {
                self::remove_coupon($p_code);
            }
            foreach ($coupon_codes as $code) {
                self::apply_coupon($code);
            }
            update_option('zcpri_prev_coupons', $coupon_codes);
            if ($allow_others != true) {

                foreach (WC()->cart->get_applied_coupons() as $d_code) {
                    if (self::is_discount_coupon($coupon_codes, $d_code) == false) {

                        WC()->cart->remove_coupon($d_code);
                    }
                }
            }
        }

        private static function is_discount_coupon($coupon_codes, $code) {

            foreach ($coupon_codes as $p_code) {
                if (strtolower($code) == strtolower($p_code)) {

                    return true;
                }
            }

            return false;
        }

        private static function apply_coupon($coupon_code) {
            $is_applied = false;
            foreach (WC()->cart->get_applied_coupons() as $code) {
                if (strtolower($code) == strtolower($coupon_code)) {
                    $is_applied = true;
                    break;
                }
            }
            if ($is_applied != true) {
                WC()->cart->add_discount($coupon_code);
            }
        }

        private static function remove_coupon($coupon_code) {
            $is_applied = false;
            foreach (WC()->cart->get_applied_coupons() as $code) {
                if (strtolower($code) == strtolower($coupon_code)) {
                    $is_applied = true;
                    break;
                }
            }
            if ($is_applied != true) {
                WC()->cart->remove_coupon($coupon_code);
            }
        }

    }

}
<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooPricely_Checkout_Fees')) {

    class WooPricely_Checkout_Fees {

        private static $fee_groups = array();
        private static $total_fees = 0;
        private static $calculating = false;

        public static function apply_fees() {
            if (is_admin()) {
                return;
            }
            if (self::$calculating == true) {
                return;
            }
            if (is_admin() && !defined('DOING_AJAX')) {
                return;
            }
            self::$calculating = true;
            self::$fee_groups = self::calculate_all_fees();
            self::$calculating = false;
            foreach (self::$fee_groups as $fee_id => $group) {
                
                $fee_desc = $group[ 'desc' ];

                if ( has_filter( 'zcpri/get-applied-fee-desc' ) ) {
                    $fee_desc = apply_filters( 'zcpri/get-applied-fee-desc', $fee_desc ,$fee_id);
                }

                WooPricely_Views::set_fee_descs('pri_fee_' . $fee_id, $fee_desc);
              
                $fee_amount = $group[ 'fee' ];

                $fee_title = $group[ 'title' ];

                if ( has_filter( 'zcpri/get-applied-fee' ) ) {
                    $fee_amount = apply_filters( 'zcpri/get-applied-fee', $fee_amount );
                }

                if ( has_filter( 'zcpri/get-applied-fee-title' ) ) {
                    $fee_title = apply_filters( 'zcpri/get-applied-fee-title', $fee_title, $fee_id );
                }

                WC()->cart->fees_api()->add_fee(array(
                    'id' => 'pri_fee_' . $fee_id,
                    'name' => $fee_title,
                    'amount' => (float) ($fee_amount),
                    'taxable' => ($group['taxable'] != '--1'),
                    'tax_class' => ($group['taxable'] != '--1') ? $group['taxable'] : '',
                ));
            }
        }

        private static function calculate_all_fees() {
            global $zc_pri;
            $rls_mode = isset($zc_pri['checkout_fees']['mode']) ? $zc_pri['checkout_fees']['mode'] : 'all';
            if ($rls_mode == 'no') {
                return array();
            }

            $max_fee_amount = isset($zc_pri['checkout_fees']['max_fee_amount']) ? $zc_pri['checkout_fees']['max_fee_amount'] : 0;
            $max_fee_type = isset($zc_pri['checkout_fees']['max_fee_type']) ? $zc_pri['checkout_fees']['max_fee_type'] : 'no';
            $max_fee_base_on = isset($zc_pri['checkout_fees']['base_on']) ? $zc_pri['checkout_fees']['base_on'] : 'subtotal';


            $rules = self::get_checkout_fees_valid_rules();



            //Create fee groups
            $groups = self::get_fee_groups();

            foreach ($rules as $rule) {

                $fee_opt = $rule['fee'];
                $fee_type = $fee_opt['fee_type'];
                if ($fee_type == 'fixed_fee' || $fee_type == 'per_fee') {
                    $g_dic = array('fee' => self::calc_cart_fee($fee_opt));
                } else {
                    $g_dic = array('fee' => self::calc_product_fee($fee_opt, $rule['products']));
                }

                if ($rule['send_to_group'] == 'yes' && isset($groups[$rule['group']['group_id']])) {
                    $g_dic['inc_method'] = $rule['group']['inc_method'];
                    $groups[$rule['group']['group_id']]['fees'][] = $g_dic;
                } else {
                    $groups[$rule['option_id']] = self::create_group($rule['single'], $rule['title'], 'no');
                    $groups[$rule['option_id']]['fees'][] = $g_dic;
                    $groups[$rule['option_id']]['notification'] = $rule['notification'];

                }
            }

            //Merge group fees

            foreach ($groups as $key => $group) {
                if (isset($group['fees'])) {
                    $groups[$key]['fee'] = self::merge_group_fees($group['fees'], $group['min'], $group['max'], $group['is_group']);
                }

                if (is_numeric($group['min']) && $groups[$key]['fee'] < $group['min']) {
                    $groups[$key]['fee'] = $group['min'];
                }

                if (is_numeric($group['max']) && $groups[$key]['fee'] > $group['max']) {
                    $groups[$key]['fee'] = $group['max'];
                }

                unset($groups[$key]['fees']);
                unset($groups[$key]['min']);
                unset($groups[$key]['max']);
            }

            //Remove groups with zero fees and apply first only
            if ($rls_mode == 'first' && count($groups) > 0) {
                $groups = self::get_first_fee(self::get_valid_fees($groups));
            }

            //Remove groups with zero fees and apply last only
            else if ($rls_mode == 'last' && count($groups) > 0) {
                $groups = self::get_last_fee(self::get_valid_fees($groups));
            }
            //Remove groups with zero fees and apply bigger only
            else if ($rls_mode == 'bigger' && count($groups) > 0) {
                $groups = self::get_bigger_fee(self::get_valid_fees($groups));
            }
            //Remove groups with zero fees and apply bigger only
            else if ($rls_mode == 'smaller' && count($groups) > 0) {
                $groups = self::get_smaller_fee(self::get_valid_fees($groups));
            }
            //Remove groups with zero fees
            else {
                $groups = self::get_valid_fees($groups);
            }



            //Get max total fees
            if ($max_fee_type != 'no' && $max_fee_amount > 0) {
                $groups = self::get_max_totals($groups, $max_fee_amount, $max_fee_type, $max_fee_base_on);
                $groups = self::get_valid_fees($groups);
            }



            $notifications = array();
            if (isset($zc_pri['notifications']['checkout_fees']) && $zc_pri['notifications']['checkout_fees'] == 'yes') {
                foreach ($groups as $key => $group) {
                    $notifications[] = array(
                        'message' => apply_filters('zcpri/get-applied-fee-notification', $group['notification'],$key) ,
                        'applied_value' => $group['fee'],
                    );
                }
            }
            WooPricely_Cart_Notifications::set_notication_message('checkout-fees', $notifications);

            return $groups;
        }

        private static function get_checkout_fees_valid_rules() {
            global $zc_pri;
            $valid_rules = array();


            if (!isset($zc_pri['checkout_fees_rules'])) {
                return $valid_rules;
            }


            foreach ($zc_pri['checkout_fees_rules'] as $rule) {
                if ($rule['enable'] == 'yes') {

                    if (self::validate_checkout_fee_conditions($rule) == true) {
                        $rl = array(
                            'apply_mode' => $rule['apply_mode'],
                            'title' => $rule[ 'title' ],
                            'option_id' => $rule[ 'option_id' ],
                            'admin_note' => $rule['admin_note'],
                            'send_to_group' => $rule['send_to_group'],
                            'notification' => ''
                        );

                        if ($rule['fee']['fee_type'] != 'fixed_fee' && $rule['fee']['fee_type'] != 'per_fee') {
                            $rl['products'] = self::get_checkout_fee_products($rule);
                        }

                        if (isset($rule['single'])) {
                            $rl['single'] = $rule['single'];
                        }
                        if (isset($rule['group'])) {
                            $rl['group'] = $rule['group'];
                        }

                        $rl['fee'] = $rule['fee'];

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

        private static function validate_checkout_fee_conditions($rule) {
            if (!isset($rule['conditions'])) {
                return true;
            }
            $is_valid = true;
            $rule_args = array(
                'section' => 'checkout_fees',
                'panel' => 'conditions',
            );
            if (isset($rule['conditions'])) {
                $is_valid = WooPricely::validate_conditions($rule['conditions'], $rule_args);
            }

            return $is_valid;
        }

        private static function get_checkout_fee_products($rule) {

            $valid_products = WooPricely::get_products_from_cart();
            $is_valid = true;


            $rule_args = array(
                'section' => 'checkout_fees',
                'panel' => 'products',
            );

            if (isset($rule['products'])) {
                $valid_products = WooPricely::validate_products($rule['products'], $valid_products, $rule_args);
            }




            return $valid_products;
        }

        private static function calc_cart_fee($fee_option) {
            $disc_amount = 0;
            $amount = 0;
            if (is_numeric($fee_option['amount'])) {
                $disc_amount = $fee_option['amount'];
                $amount = $disc_amount;
            }

            if ($fee_option['fee_type'] == 'per_fee') {
                $amount = (float) ($disc_amount / 100) * WooPricely_Cart_Totals::get_subtotals(true, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_fees'));
                if ($fee_option['cart_base_on'] == 'subtotal_ex_tax') {
                    $amount = (float) ($disc_amount / 100) * WooPricely_Cart_Totals::get_subtotals(false, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_fees'));
                }
               
            }

            return $amount;
        }

        private static function calc_product_fee($fee_option, $products) {

            $total_amount = 0;


            foreach ($products as $key => $product) {
                $disc_amount = 0;
                $amount = 0;
                if (is_numeric($fee_option['amount'])) {
                    $disc_amount = $fee_option['amount'];
                    $amount = $fee_option['amount'];
                }
                if ($fee_option['fee_type'] == 'fixed_unit_fee') {
                    $amount = (float) ($disc_amount * $product['quantity']);
                } else if ($fee_option['fee_type'] == 'per_item_fee') {
                    $cart_item = WC()->cart->get_cart_item($product['cart_key']);
                    if (isset($cart_item['data'])) {
                        $item_price = $cart_item['data']->get_price() * $product['quantity'];
                        if ($fee_option['item_base_on'] != '' && $fee_option['item_base_on'] != 'cart_price') {
                            $src_price = WooPricely::get_product_price($product['key'], $fee_option['item_base_on']);
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

        private static function merge_group_fees($fees, $min, $max, $is_group) {

            global $zc_pri;
            if (count($fees) == 0) {
                if (is_numeric($min)) {
                    return $min;
                }
                return 0;
            }
            $g_mode = $zc_pri['fee_groups_mode'];

            $fee = 0;


            if ($g_mode == 'first' && $is_group == 'yes') {
                $f_fee = $fees[0];
                if ($f_fee['inc_method'] == 'increment') {
                    $fee += $f_fee['fee'];
                } else if ($f_fee['inc_method'] == 'decrement') {
                    $fee -= $f_fee['fee'];
                } else {
                    $fee = $f_fee['fee'];
                }
            } else if ($g_mode == 'last' && $is_group == 'yes') {
                $l_fee = $fees[(count($fees) - 1)];
                if ($l_fee['inc_method'] == 'increment') {
                    $fee += $l_fee['fee'];
                } else if ($l_fee['inc_method'] == 'decrement') {
                    $fee -= $l_fee['fee'];
                } else {
                    $fee = $l_fee['fee'];
                }
            } else if ($g_mode == 'bigger' && $is_group == 'yes') {

                foreach ($fees as $b_fee) {
                    if ($b_fee['fee'] > $fee && $b_fee['inc_method'] != 'decrement') {
                        $fee = $b_fee['fee'];
                    }
                }
            } else if ($g_mode == 'smaller' && $is_group == 'yes') {
                foreach ($fees as $s_fee) {
                    if ($fee == 0 && $s_fee['inc_method'] != 'decrement') {
                        $fee = $s_fee['fee'];
                    } else if ($s_fee['fee'] < $fee && $s_fee['inc_method'] != 'decrement') {
                        $fee = $s_fee['fee'];
                    }
                }
            } else {
                foreach ($fees as $one_fee) {
                    if ($is_group == 'yes' && $one_fee['inc_method'] == 'increment') {
                        $fee += $one_fee['fee'];
                    } else if ($is_group == 'yes' && $one_fee['inc_method'] == 'decrement') {
                        $fee -= $one_fee['fee'];
                    } else {
                        $fee = $one_fee['fee'];
                    }
                }
            }

            if ($is_group != 'yes') {
                $fee = $fees[0]['fee'];
            }


            if ($fee < 0) {
                $fee = 0;
            }
            if (is_numeric($max)) {
                if ($fee > $max) {
                    return $max;
                }
            }
            return $fee;
        }

        private static function get_valid_fees($fees) {
            $grps = array();

            foreach ($fees as $key => $fee) {
                if ($fee['is_group'] == 'yes') {
                    if ($fee['fee'] > 0 || $fee['always_show'] == 'yes') {
                        $grps[$key] = $fee;
                    }
                } else if ($fee['is_group'] != 'yes') {
                    $grps[$key] = $fee;
                }
            }
            return $grps;
        }

        private static function get_first_fee($fees) {
            $grps = array();
            reset($fees);
            $key = key($fees);
            $grps[$key] = $fees[$key];

            return $grps;
        }

        private static function get_last_fee($fees) {
            $grps = array();
            end($fees);
            $key = key($fees);
            $grps[$key] = $fees[$key];

            return $grps;
        }

        private static function get_bigger_fee($fees) {
            $grps = array();
            $bigger = 0;
            foreach ($fees as $key => $fee) {
                if ($fee['fee'] > $bigger) {
                    $grps = array();
                    $grps[$key] = $fee;
                    $bigger = $fee['fee'];
                }
            }
            return $grps;
        }

        private static function get_smaller_fee($fees) {
            $grps = array();
            $smaller = 0;

            if (count($fees) > 0) {
                reset($fees);
                $key = key($fees);
                $grps[$key] = $fees[$key];
                $smaller = $fees[$key]['fee'];
            }
            foreach ($fees as $key => $fee) {
                if ($fee['fee'] > 0 && $fee['fee'] < $smaller) {
                    $grps = array();
                    $grps[$key] = $fee;
                    $smaller = $fee['fee'];
                }
            }
            return $grps;
        }

        private static function get_max_totals($fees, $max, $max_type, $base_on) {

            $max_amount = $max;
            if ($max_type == 'per') {
                $max_amount = (float) ($max / 100) * WooPricely_Cart_Totals::get_subtotals(true, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_fees'));
                if ($base_on == 'subtotal_ex_tax') {
                    $max_amount = (float) ($max / 100) * WooPricely_Cart_Totals::get_subtotals(false, WooPricely_Cart_Totals::get_totals_id_by_module_id('checkout_fees'));
                }
                
            }

            $grps = array();
            foreach ($fees as $key => $fee) {

                if ((self::$total_fees) >= $max_amount) {
                    $fee['fee'] = 0;
                } else if ((self::$total_fees + $fee['fee']) > $max_amount) {
                    $fee['fee'] = $max_amount - self::$total_fees;
                }
                $grps[$key] = $fee;
                self::$total_fees += $fee['fee'];
            }
            return $grps;
        }

        private static function get_fee_groups() {
            global $zc_pri;
            $db_groups = array();
            if (isset($zc_pri['fee_groups'])) {
                $db_groups = $zc_pri['fee_groups'];
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
                'desc' => $db_group[ 'desc' ],
                'min' => $db_group[ 'min' ],
                'max' => $db_group[ 'max' ],
                'taxable' => $db_group[ 'taxable' ],
                'always_show' => 'no',
                'is_group' => $is_group,
                'fee' => 0
            );
            if (isset($db_group['always_show'])) {
                $group['always_show'] = $db_group['always_show'];
            }

            return $group;
        }

    }

}
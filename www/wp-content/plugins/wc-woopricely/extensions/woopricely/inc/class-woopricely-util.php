<?php

if (!defined('ABSPATH')) {
    exit;
}


if (!class_exists('WooPricelyUtil')) {
    
    require_once dirname( __FILE__ ) . '/order-history-utils/class-order-history-util.php';
    require_once dirname( __FILE__ ) . '/order-history-utils/class-order-history-posts-util.php';
    require_once dirname( __FILE__ ) . '/order-history-utils/class-order-history-hpos-util.php';

    class WooPricelyUtil {

        private static $order_cache = array();

        public static function get_chosen_shipping_method_cost() {
            
            $cart_data = WCWooPricely_Cart::get_data();
            
            if ( !isset( $cart_data[ 'shipping_rates' ] ) ) {
                return 0;
            }

            $cost = 0;

            foreach ( $cart_data[ 'shipping_rates' ] as $rate ) {
                
                $cost += $rate[ 'cost' ];
                
                $cost += $rate[ 'shipping_tax' ];
            }

            return $cost;
        }

        public static function get_chosen_shipping_methods() {

            $cart_data = WCWooPricely_Cart::get_data();

            if ( !isset( $cart_data[ 'shipping_rates' ] ) ) {
                return array();
            }

            $method_ids = array();

            foreach ( $cart_data[ 'shipping_rates' ] as $rate ) {

                $method_ids[] = $rate[ 'method_id' ];
            }

            return $method_ids;
        }

        public static function get_chosen_shipping_rates() {

            $cart_data = WCWooPricely_Cart::get_data();

            if ( !isset( $cart_data[ 'shipping_rates' ] ) ) {
                return array();
            }

            $instance_ids = array();

            foreach ( $cart_data[ 'shipping_rates' ] as $rate ) {

                $instance_ids[] = $rate[ 'instance_id' ];
            }

            return $instance_ids;
        }

        public static function get_chosen_shipping_zones() {

            $cart_data = WCWooPricely_Cart::get_data();

            if ( !isset( $cart_data[ 'shipping_rates' ] ) ) {
                return array();
            }

            $zone_ids = array();

            foreach ( $cart_data[ 'shipping_rates' ] as $rate ) {

                $zone_ids[] = self::get_shipping_zone_by_shipping_method( $rate[ 'instance_id' ] );
            }

            return $zone_ids;
        }

        public static function get_applied_coupons_ids() {
            $coupon_ids = array();

            foreach (WC()->cart->get_applied_coupons() as $coupon_code) {
                $coupon_id = wc_get_coupon_id_by_code($coupon_code);
                if ($coupon_id > 0) {
                    $coupon_ids[] = $coupon_id;
                }
            }
            return $coupon_ids;
        }

        public static function get_customer_amount_spent($amount_type, $user_id, $from_date = '') {

            $order_history = WooPricely_Order_History_Util::get_instance();

            return $order_history->get_order_total( $user_id, $from_date, $amount_type, 0 );
        }
        
        public static function get_customer_last_amount_spent( $user_id ) {
            
            $order_history = WooPricely_Order_History_Util::get_instance();

            return $order_history->get_last_order_totals( $user_id, 0 );
        }

        public static function get_customer_orders_count($user_id, $from_date = '') {

            $order_history = WooPricely_Order_History_Util::get_instance();

            return $order_history->get_order_total( $user_id, $from_date, 'COUNT', 0 );
        }

        public static function get_customer_reviews_count($customer_id, $from_date = '') {

            global $wpdb;
            try {
                $db_date = "";
                if ($from_date != '') {
                    $db_date = " AND (comment_date>='" . esc_sql($from_date) . "')";
                }
                $sql = "SELECT COUNT(comment_ID) FROM {$wpdb->prefix}comments WHERE (user_id = " . $customer_id . ")" . $db_date . " AND (comment_approved=1)";

                return $wpdb->get_var($sql);
            } catch (Exception $ex) {
                return 0;
            }
        }

        public static function get_customer_coupon_used($user_id, $from_date = '') {

            $order_history = WooPricely_Order_History_Util::get_instance();

            $coupon_codes = $order_history->get_coupon_used( $user_id, $from_date, array() );

            $coupon_ids = array();

            foreach ( $coupon_codes as $coupon_code ) {
                
                $coupon_id = wc_get_coupon_id_by_code( $coupon_code );
                
                if ( $coupon_id > 0 ) {
                
                    $coupon_ids[] = $coupon_id;
                }
            }

            return $coupon_ids;
        }

        public static function get_date_from_rule_value($rule_value) {

            $result = '';
            if ($rule_value['date_type'] == 'current') {
                $current_type = 'day';
                if ($rule_value['current'] != '') {
                    $current_type = $rule_value['current'];
                }
                $result = self::get_date_from_current($current_type);
            } else if ($rule_value['date_type'] == 'hours' || $rule_value['date_type'] == 'days' || $rule_value['date_type'] == 'weeks' || $rule_value['date_type'] == 'months' || $rule_value['date_type'] == 'years') {
                $result = self::get_date_from_offset($rule_value['date_type'], $rule_value['date_offset']);
            }
            return $result;
        }

        public static function get_current_date($include_time = true) {
            if ($include_time == true) {
                return date("Y-m-d H:i:s", current_time('timestamp'));
            }
            return date("Y-m-d", current_time('timestamp'));
        }

        public static function get_date_from_week_days($compare, $week_days) {



            $current_week = date('W', current_time('timestamp'));
            $current_year = date("Y", current_time('timestamp'));
            $c_date = new DateTime();
            $c_date->setISODate($current_year, $current_week);
            $c_date->setTime(0, 0, 0);
            $date_from_monday = $c_date->format('U');


            $selected_day_range = self::get_selected_week_days($compare, $week_days);

            if (count($selected_day_range) > 0) {
                return array(
                    'from' => date('Y-m-d', ($date_from_monday + (DAY_IN_SECONDS * $selected_day_range[0]))) . ' 00:00:00',
                    'to' => date('Y-m-d', ($date_from_monday + (DAY_IN_SECONDS * $selected_day_range[1]))) . ' 23:59:59',
                );
            } else {
                return '';
            }
        }

        public static function get_date_from_month_days($compare, $month_days) {

            $selected_day_range = self::get_selected_month_days($compare, $month_days);

            if (count($selected_day_range) > 0) {
                $current_month = date('m', current_time('timestamp'));
                $current_year = date("Y", current_time('timestamp'));
                $c_date = new DateTime();


                $date_range = array();

                $c_date->setDate($current_year, $current_month, $selected_day_range[0]);
                $c_date->setTime(0, 0, 0);
                $date_u = $c_date->format('U');
                $date_range['from'] = date('Y-m-d', $date_u) . ' 00:00:00';

                $c_date->setDate($current_year, $current_month, $selected_day_range[1]);
                $c_date->setTime(0, 0, 0);
                $date_u = $c_date->format('U');
                $date_range['to'] = date('Y-m-d', $date_u) . ' 23:59:59';
                return $date_range;
            } else {
                return '';
            }
        }

        public static function get_date_from_year_months($compare, $months) {
            $selected_month_range = self::get_selected_months($compare, $months);

            if (count($selected_month_range) > 0) {


                $current_year = date("Y", current_time('timestamp'));
                $c_date = new DateTime();


                $date_range = array();

                $c_date->setDate($current_year, $selected_month_range[0]['month'], $selected_month_range[0]['day']);
                $c_date->setTime(0, 0, 0);
                $date_u = $c_date->format('U');
                $date_range['from'] = date('Y-m-d', $date_u) . ' 00:00:00';

                $c_date->setDate($current_year, $selected_month_range[1]['month'], $selected_month_range[1]['day']);
                $c_date->setTime(0, 0, 0);
                $date_u = $c_date->format('U');
                $date_range['to'] = date('Y-m-d', $date_u) . ' 23:59:59';
                return $date_range;
            } else {
                return '';
            }
        }

        public static function get_purchase_history($customer_id, $data_type, $from_date = '', $paid_orders = true, $get_cache = true) {
            $order_products = self::get_purchase_history_data($customer_id, $from_date, $paid_orders, $get_cache);

            if ($data_type == 'product_ids') {
                $product_ids = array();
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        $product_ids[$product['id']] = $product['id'];
                    }
                }
                return array_values($product_ids);
            }

            if ($data_type == 'variation_ids') {
                $variation_ids = array();
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        if (isset($product['variation_id'])) {
                            $variation_ids[$product['variation_id']] = $product['variation_id'];
                        }
                    }
                }
                return array_values($variation_ids);
            }

            if ($data_type == 'category_ids') {
                $category_ids = array();
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        foreach ($product['categories'] as $category_id) {
                            $category_ids[$category_id] = $category_id;
                        }
                    }
                }
                return array_values($category_ids);
            }

            if ($data_type == 'tag_ids') {
                $tag_ids = array();
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        foreach ($product['tags'] as $tag_id) {
                            $tag_ids[$tag_id] = $tag_id;
                        }
                    }
                }
                return array_values($tag_ids);
            }

            if ($data_type == 'attribute_ids') {
                $attribute_ids = array();
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        $db_attrs = wc_get_product($product['id'])->get_attributes();
                        foreach ($db_attrs as $db_attr) {
                            foreach ($db_attr->get_options() as $attr_option) {
                                if (is_numeric($attr_option)) {
                                    $attribute_ids[$attr_option] = $attr_option;
                                }
                            }
                        }
                    }
                }

                return array_values($attribute_ids);
            }

            return array();
        }

        public static function get_purchase_history_quantity($customer_id, $data_type, $data_ids, $from_date = '', $paid_orders = true, $get_cache = true) {
            $order_products = self::get_purchase_history_data($customer_id, $from_date, $paid_orders, $get_cache);

            $qty = 0;
            if ($data_type == 'product_ids') {
                foreach ($order_products as $order_product) {
                    $product_ids = array();
                    foreach ($order_product as $product) {
                        if (WooPricely_Validation_Util::validate_value_list($product['id'], $data_ids, 'in_list') == true) {
                            $qty += $product['quantity'];
                        }
                    }
                }
            }

            if ($data_type == 'variation_ids') {
                foreach ($order_products as $order_product) {
                    $product_ids = array();
                    foreach ($order_product as $product) {
                        if (isset($product['variation_id']) == true) {
                            if (WooPricely_Validation_Util::validate_value_list($product['variation_id'], $data_ids, 'in_list') == true) {
                                $qty += $product['quantity'];
                            }
                        }
                    }
                }
            }

            if ($data_type == 'category_ids') {
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        if (WooPricely_Validation_Util::validate_list_list($product['categories'], $data_ids, 'in_list') == true) {
                            $qty += $product['quantity'];
                        }
                    }
                }
            }

            if ($data_type == 'tag_ids') {
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        if (WooPricely_Validation_Util::validate_list_list($product['tags'], $data_ids, 'in_list') == true) {
                            $qty += $product['quantity'];
                        }
                    }
                }
            }


            if ($data_type == 'attribute_ids') {
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        $attribute_ids = array();
                        $db_attrs = wc_get_product($product['id'])->get_attributes();
                        foreach ($db_attrs as $db_attr) {
                            foreach ($db_attr->get_options() as $attr_option) {
                                if (is_numeric($attr_option)) {
                                    $attribute_ids[] = $attr_option;
                                }
                            }
                        }
                        if (WooPricely_Validation_Util::validate_list_list($attribute_ids, $data_ids, 'in_list') == true) {
                            $qty += $product['quantity'];
                        }
                    }
                }
            }

            return $qty;
        }

        public static function get_purchase_history_subtotal($customer_id, $data_type, $data_ids, $from_date = '', $paid_orders = true, $get_cache = true) {
            $order_products = self::get_purchase_history_data($customer_id, $from_date, $paid_orders, $get_cache);

            $subtotal = 0;
            if ($data_type == 'product_ids') {
                foreach ($order_products as $order_product) {
                    $product_ids = array();
                    foreach ($order_product as $product) {
                        if (WooPricely_Validation_Util::validate_value_list($product['id'], $data_ids, 'in_list') == true) {
                            $subtotal += $product['subtotal'];
                        }
                    }
                }
            }

            if ($data_type == 'variation_ids') {
                foreach ($order_products as $order_product) {
                    $product_ids = array();
                    foreach ($order_product as $product) {
                        if (isset($product['variation_id']) == true) {
                            if (WooPricely_Validation_Util::validate_value_list($product['variation_id'], $data_ids, 'in_list') == true) {
                                $subtotal += $product['subtotal'];
                            }
                        }
                    }
                }
            }

            if ($data_type == 'category_ids') {
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        if (WooPricely_Validation_Util::validate_list_list($product['categories'], $data_ids, 'in_list') == true) {
                            $subtotal += $product['subtotal'];
                        }
                    }
                }
            }

            if ($data_type == 'tag_ids') {
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        if (WooPricely_Validation_Util::validate_list_list($product['tags'], $data_ids, 'in_list') == true) {
                            $subtotal += $product['subtotal'];
                        }
                    }
                }
            }

            if ($data_type == 'attribute_ids') {
                foreach ($order_products as $order_product) {
                    foreach ($order_product as $product) {
                        $attribute_ids = array();
                        $db_attrs = wc_get_product($product['id'])->get_attributes();
                        foreach ($db_attrs as $db_attr) {
                            foreach ($db_attr->get_options() as $attr_option) {
                                if (is_numeric($attr_option)) {
                                    $attribute_ids[] = $attr_option;
                                }
                            }
                        }
                        if (WooPricely_Validation_Util::validate_list_list($attribute_ids, $data_ids, 'in_list') == true) {
                            $subtotal += $product['subtotal'];
                        }
                    }
                }
            }

            return $subtotal;
        }

        private static function get_purchase_history_data($customer_id, $from_date = '', $paid_orders = true, $get_cache = true) {

            $cache_id = $customer_id . '_' . $from_date . '_' . $paid_orders;

            if ($get_cache == true && isset(self::$order_cache[$cache_id])) {
                return self::$order_cache[$cache_id];
            }
            try {

                $orders_args = array(
                    'customer_id' => $customer_id,
                );

                if ($from_date != '') {
                    if ($paid_orders == true) {
                        $orders_args['date_paid'] = '>=' . $from_date;
                    } else {
                        $orders_args['date_created'] = '>=' . $from_date;
                    }
                }


                $order_products = array();

                $paid_statuses = wc_get_is_paid_statuses();

                foreach (wc_get_orders($orders_args) as $order) {
                    $order_id = $order->get_id();

                    if ($paid_orders == true) {
                        $order_is_paid = false;
                        $order_status = $order->get_status(false);

                        foreach ($paid_statuses as $status) {
                            if ($status == $order_status) {
                                $order_is_paid = true;
                            }
                        }
                        if ($order_is_paid != true) {
                            continue;
                        }
                    }


                    foreach ($order->get_items('line_item') as $order_item) {
                        $variation_id = $order_item->get_variation_id();

                        $product = array();
                        $product['id'] = $order_item->get_product_id();
                        if ($variation_id > 0) {
                            $product['variation_id'] = $variation_id;
                            $product['key'] = WooPricely::get_product_identifier_key($product['id'], $variation_id);
                        } else {
                            $product['key'] = WooPricely::get_product_identifier_key($product['id']);
                        }
                        $product['quantity'] = $order_item->get_quantity();
                        $product['subtotal'] = $order_item->get_subtotal();

                        $prod = wc_get_product($product['id']);

                        if ($prod) {
                            $product['categories'] = wp_get_post_terms($product['id'], 'product_cat', array('fields' => 'ids'));
                            $product['tags'] = wp_get_post_terms($product['id'], 'product_tag', array('fields' => 'ids'));
                        } else {
                            $product['categories'] = array();
                            $product['tags'] = array();
                        }

                        $order_products[$order_id][] = $product;
                    }
                }
                self::$order_cache[$cache_id] = $order_products;
                return $order_products;
            } catch (Exception $ex) {
                return array();
            }
        }

        private static function get_shipping_zone_by_shipping_method($instance_id) {
            
            
            global $wpdb;
            
            try {
                $sql = "SELECT zone_id FROM {$wpdb->prefix}woocommerce_shipping_zone_methods "
                        . "WHERE (instance_id=%d) LIMIT 1";
                $sql = $wpdb->prepare($sql, $instance_id);
                return $wpdb->get_var($sql);
            } catch (Exception $ex) {
                return 0;
            }
        }

        private static function get_date_from_current($date_mode = 'day') {

            switch ($date_mode) {
                case 'week':
                    $current_week = date('W', current_time('timestamp'));
                    $current_year = date("Y", current_time('timestamp'));
                    $c_date = new DateTime();
                    $c_date->setISODate($current_year, $current_week);
                    return $c_date->format('Y-m-d') . " 00:00:00";
                case 'month':
                    $current_month = date('m', current_time('timestamp'));
                    $current_year = date("Y", current_time('timestamp'));
                    $c_date = new DateTime();
                    $c_date->setDate($current_year, $current_month, 1);
                    return $c_date->format('Y-m-d') . " 00:00:00";
                case 'year':
                    $current_year = date("Y", current_time('timestamp'));
                    $c_date = new DateTime();
                    $c_date->setDate($current_year, 1, 1);
                    return $c_date->format('Y-m-d') . " 00:00:00";
                default :
                    $current_year = date("Y", current_time('timestamp'));
                    $current_month = date("m", current_time('timestamp'));
                    $current_day = date("d", current_time('timestamp'));
                    $c_date = new DateTime();
                    $c_date->setDate($current_year, $current_month, $current_day);
                    return $c_date->format('Y-m-d') . " 00:00:00";
            }
        }

        private static function get_date_from_offset($offset_mode = 'hours', $offset = 1) {


            $current_time = current_time('timestamp');



            switch ($offset_mode) {
                case 'years':
                    return date("Y-m-d", $current_time - (YEAR_IN_SECONDS * $offset)) . " 00:00:00";
                case 'months':
                    return date("Y-m-d", $current_time - (MONTH_IN_SECONDS * $offset)) . " 00:00:00";
                case 'weeks':
                    return date("Y-m-d", $current_time - (WEEK_IN_SECONDS * $offset)) . " 00:00:00";
                case 'days':
                    return date("Y-m-d", $current_time - (DAY_IN_SECONDS * $offset)) . " 00:00:00";
                default:
                    return date("Y-m-d H:i", $current_time - (HOUR_IN_SECONDS * $offset)) . ":00";
            }
        }

        private static function get_selected_week_days($compare, $week_days) {

            if ($compare != 'in_list') {
                $selected_week_days = array();
                for ($i = 0; $i < 7; $i++) {
                    if (!in_array($i, $week_days)) {
                        $selected_week_days[] = $i;
                    }
                }
            } else {
                $selected_week_days = $week_days;
            }


            $weeks_range = array();

            $range = array();
            for ($i = 0; $i < 7; $i++) {

                if (in_array($i, $selected_week_days) && count($range) == 0) {
                    $range[0] = $i;
                    $range[1] = $i;
                } else if (in_array($i, $selected_week_days) && count($range) > 0) {
                    $range[1] = $i;
                } else if (count($range) > 0) {
                    $weeks_range[] = $range;
                    $range = array();
                }
            }
            if (count($range) > 0) {
                $weeks_range[] = $range;
            }



            $jd = cal_to_jd(CAL_GREGORIAN, date("m", current_time('timestamp')), date("d", current_time('timestamp')), date("Y", current_time('timestamp')));
            $week_day = self::map_week_day(jddayofweek($jd, 0));

            foreach ($weeks_range as $week_day_range) {
                if ($week_day >= $week_day_range[0] && $week_day <= $week_day_range[1]) {

                    return $week_day_range;
                }
            }

            return array();
        }

        private static function get_selected_months($compare, $months) {
            if ($compare != 'in_list') {
                $selected_months = array();
                for ($i = 1; $i <= 12; $i++) {
                    if (!in_array($i, $months)) {
                        $selected_months[] = $i;
                    }
                }
            } else {
                $selected_months = $months;
            }

            $months_range = array();


            $range = array();
            for ($i = 1; $i <= 31; $i++) {

                if (in_array($i, $selected_months) && count($range) == 0) {
                    $range[0] = $i;
                    $range[1] = $i;
                } else if (in_array($i, $selected_months) && count($range) > 0) {
                    $range[1] = $i;
                } else if (count($range) > 0) {
                    $months_range[] = $range;
                    $range = array();
                }
            }
            if (count($range) > 0) {
                $months_range[] = $range;
            }


            $month = date("m", current_time('timestamp'));


            foreach ($months_range as $month_range) {
                if ($month >= $month_range[0] && $month <= $month_range[1]) {

                    $sl_month_range = array();
                    $sl_month_range[0]['month'] = $month_range[0];
                    $sl_month_range[0]['day'] = 1;
                    $sl_month_range[1]['month'] = $month_range[1];
                    $sl_month_range[1]['day'] = self::get_month_max_days($month_range[1]);

                    return $sl_month_range;
                }
            }

            return array();
        }

        private static function get_selected_month_days($compare, $month_days) {
            if ($compare != 'in_list') {
                $selected_month_days = array();
                for ($i = 1; $i <= 31; $i++) {
                    if (!in_array($i, $month_days)) {
                        $selected_month_days[] = $i;
                    }
                }
            } else {
                $selected_month_days = $month_days;
            }

            $days_range = array();

            $range = array();
            for ($i = 1; $i <= 31; $i++) {

                if (in_array($i, $selected_month_days) && count($range) == 0) {
                    $range[0] = $i;
                    $range[1] = $i;
                } else if (in_array($i, $selected_month_days) && count($range) > 0) {
                    $range[1] = $i;
                } else if (count($range) > 0) {
                    $days_range[] = $range;
                    $range = array();
                }
            }
            if (count($range) > 0) {
                $days_range[] = $range;
            }


            $month_day = date("d", current_time('timestamp'));
            $current_month = date("m", current_time('timestamp'));

            foreach ($days_range as $month_day_range) {
                if ($month_day >= $month_day_range[0] && $month_day <= $month_day_range[1]) {
                    $max_day = self::get_month_max_days($current_month);
                    if ($month_day_range[0] > $max_day) {
                        $month_day_range[0] = $max_day;
                    }
                    if ($month_day_range[1] > $max_day) {
                        $month_day_range[1] = $max_day;
                    }
                    return $month_day_range;
                }
            }

            return array();
        }

        private static function get_month_max_days($month) {
            switch ($month) {
                case 2:
                    $is_leap_year = (date('L', current_time('timestamp')) === 1);
                    if ($is_leap_year == true) {
                        return 29;
                    }
                    return 28;
                case 4:
                case 6:
                case 9:
                case 11:
                    return 30;
                default :
                    return 31;
            }
        }

        private static function map_week_day($jd_day) {
            $days = array(
                0 => 6,
                1 => 0,
                2 => 1,
                3 => 2,
                4 => 3,
                5 => 4,
                6 => 5,
            );
            return $days[$jd_day];
        }

    }

}
<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}

if ( !class_exists( 'WooPricely_Order_History_HPOS_Util' ) ) {

    class WooPricely_Order_History_HPOS_Util {

        public function get_coupon_used( $user_id, $from_date, $default ) {

            $coupons_used = array();

            try {

                global $wpdb;

                $sql = "SELECT DISTINCT posts.post_name AS coupon_code FROM {$wpdb->prefix}wc_order_coupon_lookup AS order_coupons"
                        . " LEFT JOIN {$wpdb->prefix}wc_orders AS orders ON order_coupons.order_id = orders.id"
                        . " LEFT JOIN {$wpdb->prefix}wc_orders_meta AS mt_paid ON order_coupons.order_id = mt_paid.order_id"
                        . " LEFT JOIN {$wpdb->prefix}posts AS posts ON posts.ID = order_coupons.coupon_id"
                        . " WHERE (posts.post_type = 'shop_coupon')"
                        . " AND (orders.customer_id = " . esc_sql( $user_id ) . ")"
                        . " AND (orders.status IN ('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))";

                if ( !empty( $from_date ) ) {

                    $sql = $sql . " AND (mt_paid.meta_key = '_paid_date')"
                            . " AND (mt_paid.meta_value >= '" . esc_sql( $from_date ) . "')";
                }

                $results = $wpdb->get_results( $sql, ARRAY_A );

                if ( !is_array( $results ) ) {

                    return $default;
                }

                foreach ( $results as $row ) {

                    $coupons_used[] = $row[ 'coupon_code' ];
                }
            } catch ( Exception $ex ) {

                return $default;
            }

            return $coupons_used;
        }

        public function get_order_total( $user_id, $from_date, $total_type, $default ) {

            if ( 'COUNT' == $total_type ) {

                return $this->get_order_total_count( $user_id, $from_date, $default );
            }

            if ( 'MIN' == $total_type || 'MAX' == $total_type ) {

                return $this->get_order_total_min_max( $user_id, $from_date, $total_type, $default );
            }

            if ( 'SUM' == $total_type || 'AVG' == $total_type ) {

                return $this->get_order_total_sum_avg( $user_id, $from_date, $total_type, $default );
            }

            return $default;
        }

        public function get_last_order_totals( $user_id, $default ) {

            try {

                global $wpdb;

                $sql = "SELECT orders.currency AS currency, orders.total_amount AS total_amount FROM {$wpdb->prefix}wc_orders AS orders"
                        . " LEFT JOIN {$wpdb->prefix}wc_orders_meta AS mt_paid ON orders.id = mt_paid.order_id"
                        . " WHERE (orders.customer_id = " . esc_sql( $user_id ) . ")"
                        . " AND (orders.status IN ('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))"
                        . " AND (orders.type IN('shop_order'))"
                        . " AND (mt_paid.meta_key = '_paid_date')"
                        . " ORDER BY mt_paid.meta_value DESC LIMIT 1";


                $results = $wpdb->get_results( $sql, ARRAY_A );

                if ( !is_array( $results ) ) {

                    return $default;
                }

                if ( !isset( $results[ 0 ][ 'total_amount' ] ) ) {

                    return 0;
                }

                return self::round_num( $results[ 0 ][ 'total_amount' ], wc_get_price_decimals() );
            } catch ( Exception $ex ) {
                
            }


            return $default;
        }

        private function get_order_total_count( $user_id, $from_date, $default ) {

            try {

                global $wpdb;

                $select_sql = "SELECT COUNT(orders.id) AS order_count FROM {$wpdb->prefix}wc_orders AS orders";

                $from_date_join_sql = "";

                if ( !empty( $from_date ) ) {

                    $from_date_join_sql = " LEFT JOIN {$wpdb->prefix}wc_orders_meta AS mt_paid ON orders.id = mt_paid.order_id";
                }

                $where_sql = " WHERE (orders.customer_id = " . esc_sql( $user_id ) . ")"
                        . " AND (orders.status IN ('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))"
                        . " AND (orders.type IN('shop_order'))";



                $from_date_where_sql = "";

                if ( !empty( $from_date ) ) {

                    $from_date_where_sql = " AND (mt_paid.meta_key = '_paid_date')"
                            . " AND (mt_paid.meta_value >= '" . esc_sql( $from_date ) . "')";
                }

                $sql = $select_sql . $from_date_join_sql . $where_sql . $from_date_where_sql;

                $results = $wpdb->get_results( $sql, ARRAY_A );

                if ( !is_array( $results ) ) {

                    return $default;
                }

                if ( !isset( $results[ 0 ][ 'order_count' ] ) ) {

                    return $default;
                }

                return $results[ 0 ][ 'order_count' ];
            } catch ( Exception $ex ) {
                
            }


            return $default;
        }

        private function get_order_total_min_max( $user_id, $from_date, $total_type, $default ) {

            try {

                global $wpdb;

                $select_sql = "SELECT orders.currency AS currency, orders.total_amount AS total_amount FROM {$wpdb->prefix}wc_orders AS orders";

                $from_date_join_sql = "";

                if ( !empty( $from_date ) ) {

                    $from_date_join_sql = " LEFT JOIN {$wpdb->prefix}wc_orders_meta AS mt_paid ON orders.id = mt_paid.order_id";
                }

                $where_sql = " WHERE (orders.customer_id = " . esc_sql( $user_id ) . ")"
                        . " AND (orders.status IN ('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))"
                        . " AND (orders.type IN('shop_order'))";



                $from_date_where_sql = "";

                if ( !empty( $from_date ) ) {

                    $from_date_where_sql = " AND (mt_paid.meta_key = '_paid_date')"
                            . " AND (mt_paid.meta_value >= '" . esc_sql( $from_date ) . "')";
                }

                $order_by_limit_sql = " ORDER BY orders.total_amount ASC LIMIT 1";

                if ( 'MAX' == $total_type ) {

                    $order_by_limit_sql = " ORDER BY orders.total_amount DESC LIMIT 1";
                }

                $sql = $select_sql . $from_date_join_sql . $where_sql . $from_date_where_sql . $order_by_limit_sql;

                $results = $wpdb->get_results( $sql, ARRAY_A );

                if ( !is_array( $results ) ) {

                    return $default;
                }

                if ( !isset( $results[ 0 ][ 'total_amount' ] ) ) {

                    return 0;
                }

                return self::round_num( $results[ 0 ][ 'total_amount' ], wc_get_price_decimals() );
            } catch ( Exception $ex ) {
                
            }


            return $default;
        }

        private function get_order_total_sum_avg( $user_id, $from_date, $total_type, $default ) {

            try {

                global $wpdb;

                $select_sql = "SELECT orders.currency AS currency, orders.total_amount AS total_amount FROM {$wpdb->prefix}wc_orders AS orders";

                $from_date_join_sql = "";

                if ( !empty( $from_date ) ) {

                    $from_date_join_sql = " LEFT JOIN {$wpdb->prefix}wc_orders_meta AS mt_paid ON orders.id = mt_paid.order_id";
                }

                $where_sql = " WHERE (orders.customer_id = " . esc_sql( $user_id ) . ")"
                        . " AND (orders.status IN ('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))"
                        . " AND (orders.type IN('shop_order'))";



                $from_date_where_sql = "";

                if ( !empty( $from_date ) ) {

                    $from_date_where_sql = " AND (mt_paid.meta_key = '_paid_date')"
                            . " AND (mt_paid.meta_value >= '" . esc_sql( $from_date ) . "')";
                }

                $sql = $select_sql . $from_date_join_sql . $where_sql . $from_date_where_sql;

                $results = $wpdb->get_results( $sql, ARRAY_A );

                if ( !is_array( $results ) ) {

                    return $default;
                }

                $order_totals = array();

                foreach ( $results as $row ) {

                    $order_totals[] = $row[ 'total_amount' ];
                }


                $order_totals_count = count( $order_totals );

                if ( !$order_totals_count ) {

                    return 0;
                }

                $order_totals_sum = array_sum( $order_totals );

                if ( 'SUM' == $total_type ) {

                    return self::round_num( $order_totals_sum, wc_get_price_decimals() );
                }

                $order_totals_avg = $order_totals_sum / $order_totals_count;

                return self::round_num( $order_totals_avg, wc_get_price_decimals() );
            } catch ( Exception $ex ) {
                
            }

            return $default;
        }

        private static function round_num( $val, int $precision = 0, int $mode = PHP_ROUND_HALF_UP ): float {

            if ( !is_numeric( $val ) ) {

                $val = floatval( $val );
            }

            return round( $val, $precision, $mode );
        }

    }

}
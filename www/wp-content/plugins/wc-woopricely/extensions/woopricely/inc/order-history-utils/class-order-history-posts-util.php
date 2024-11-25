<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}


if ( !class_exists( 'WModes_Order_History_Posts_Util' ) ) {

    class WooPricely_Order_History_Posts_Util {

        public function get_coupon_used( $user_id, $from_date, $default ) {

            $coupons_used = array();

            try {

                global $wpdb;

                $sql = "SELECT DISTINCT order_items.order_item_name as coupon_code FROM {$wpdb->prefix}posts AS posts"
                        . " LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON posts.id = order_items.order_id"
                        . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_user ON posts.id = mt_user.post_id"
                        . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_paid ON posts.id = mt_paid.post_id"
                        . " WHERE (posts.post_type = 'shop_order')";

                if ( !empty( $from_date ) ) {

                    $sql = $sql . " AND (mt_paid.meta_key = '_paid_date')"
                            . " AND (mt_paid.meta_value >= '" . esc_sql( $from_date ) . "')";
                }

                $sql = $sql . " AND (mt_user.meta_key = '_customer_user')"
                        . " AND (mt_user.meta_value = " . esc_sql( $user_id ) . ")"
                        . " AND (order_items.order_item_type = 'coupon')"
                        . " AND (posts.post_status IN ('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))";


                $results = $wpdb->get_results( $sql, ARRAY_A );

                $coupon_codes = array();

                foreach ( $results as $row ) {

                    $coupon_codes[] = $row[ 'coupon_code' ];
                }

                $sql = "SELECT post_name as coupon_slug FROM {$wpdb->prefix}posts"
                        . " WHERE (post_type='shop_coupon')"
                        . " AND (post_title IN('" . implode( "','", array_map( 'esc_sql', $coupon_codes ) ) . "'))";

                $results = $wpdb->get_results( $sql, ARRAY_A );

                foreach ( $results as $row ) {

                    $coupons_used[] = $row[ 'coupon_slug' ];
                }
            } catch ( Exception $ex ) {

                return $default;
            }

            return $coupons_used;
        }

        public function get_order_total( $user_id, $from_date, $total_type, $default ) {

            try {

                global $wpdb;

                $sql_select = "SELECT SUM(mt_total.meta_value)";

                $round_decimal = false;

                switch ( $total_type ) {
                    case 'COUNT':
                        $sql_select = "SELECT COUNT(posts.id)";
                        break;
                    case 'MIN':
                        $sql_select = "SELECT MIN(mt_total.meta_value)";
                        break;
                    case 'MAX':
                        $sql_select = "SELECT MAX(mt_total.meta_value)";
                        break;
                    case 'AVG':
                        $round_decimal = true;
                        $sql_select = "SELECT AVG(mt_total.meta_value)";
                        break;
                    default:
                        break;
                }

                $sql = $sql_select . " FROM {$wpdb->prefix}posts AS posts"
                        . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_user ON posts.id = mt_user.post_id";

                if ( $from_date != '' ) {
                    $sql = $sql . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_paid ON posts.id = mt_paid.post_id";
                }

                $sql = $sql . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_total ON posts.id = mt_total.post_id"
                        . " WHERE (posts.post_type = 'shop_order')"
                        . " AND (posts.post_status IN('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))"
                        . " AND (mt_user.meta_key = '_customer_user')"
                        . " AND (mt_user.meta_value = " . esc_sql( $user_id ) . ")"
                        . " AND (mt_total.meta_key = '_order_total')";

                if ( $from_date != '' ) {
                    $sql = $sql . " AND (mt_paid.meta_key = '_paid_date')"
                            . " AND (mt_paid.meta_value >= '" . esc_sql( $from_date ) . "')";
                }

                $results = $wpdb->get_var( $sql );

                if ( !$results ) {

                    return $default;
                }

                if ( $round_decimal == true ) {

                    return self::round_num( $results, wc_get_price_decimals() );
                }

                return $results;
            } catch ( Exception $ex ) {
                
            }

            return $default;
        }

        public function get_last_order_totals( $user_id, $default ) {

            try {

                global $wpdb;

                $sql = "SELECT mt_total.meta_value FROM {$wpdb->prefix}posts AS posts"
                        . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_user ON posts.id = mt_user.post_id"
                        . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_paid ON posts.id = mt_paid.post_id"
                        . " LEFT JOIN {$wpdb->prefix}postmeta AS mt_total ON posts.id = mt_total.post_id"
                        . " WHERE (posts.post_type = 'shop_order')"
                        . " AND (posts.post_status IN('wc-" . implode( "','wc-", array_map( 'esc_sql', wc_get_is_paid_statuses() ) ) . "'))"
                        . " AND (mt_user.meta_key = '_customer_user')"
                        . " AND (mt_user.meta_value = " . esc_sql( $user_id ) . ")"
                        . " AND (mt_total.meta_key = '_order_total')"
                        . " AND (mt_paid.meta_key = '_paid_date')"
                        . " ORDER BY mt_paid.meta_value DESC"
                        . " LIMIT 1";

                $results = $wpdb->get_var( $sql );

                if ( !$results ) {

                    return $default;
                }

                return self::round_num( $results, wc_get_price_decimals() );
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

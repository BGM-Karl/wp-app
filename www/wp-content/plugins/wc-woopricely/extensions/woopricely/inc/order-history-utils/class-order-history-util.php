<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}


if ( !class_exists( 'WooPricely_Order_History_Util' ) ) {

    class WooPricely_Order_History_Util {
        private static $instance = null;
        private $order_history_posts_utils;
        private $order_history_hpos_utils;

        public static function get_instance(): self {

            if ( null == self::$instance ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        private function __construct() {

            $this->order_history_posts_utils = new WooPricely_Order_History_Posts_Util();
            $this->order_history_hpos_utils = new WooPricely_Order_History_HPOS_Util();
        }
        
        public function get_coupon_used( $user_id, $from_date, $default ) {

            if ( defined( 'WCWOOPRICELY_USING_HPOS' ) ) {

                return $this->order_history_hpos_utils->get_coupon_used( $user_id, $from_date, $default );
            }

            return $this->order_history_posts_utils->get_coupon_used( $user_id, $from_date, $default );
        }
      
        public function get_order_total( $user_id, $from_date, $total_type, $default ) {

            if ( defined( 'WCWOOPRICELY_USING_HPOS' ) ) {

                return $this->order_history_hpos_utils->get_order_total( $user_id, $from_date, $total_type, $default );
            }

            return $this->order_history_posts_utils->get_order_total( $user_id, $from_date, $total_type, $default );
        }
        
        public function get_last_order_totals( $user_id, $default ) {

            if ( defined( 'WCWOOPRICELY_USING_HPOS' ) ) {

                return $this->order_history_hpos_utils->get_last_order_totals( $user_id, $default );
            }

            return $this->order_history_posts_utils->get_last_order_totals( $user_id, $default );
        }
        
    }

}


<?php

if (!class_exists('WooPricely_Cart_Notifications')) {

    class WooPricely_Cart_Notifications {

        private static $notifications_applied = false;
        private static $notification_messages = array();

        public static function init() {
            add_action('woocommerce_before_calculate_totals', array(new self(), 'before_calculate_totals'), 100000);
            add_action('woocommerce_cart_loaded_from_session', array(new self(), 'before_calculate_totals'), 6600);
        }

        public static function set_notication_message($key, $msg) {
            self::$notification_messages[$key] = $msg;
        }

        public static function before_calculate_totals($cart_object) {
           
            if (!is_cart() && !is_checkout()) {
                return;
            }

            if (self::$notifications_applied == true) {
                return;
            }

            $cart_hash = WC()->session->get('pricely_notify_cart_hash', '');

            $c_hash = md5(wp_json_encode(self::$notification_messages));
            
            if ($cart_hash != $c_hash) {
                $cart_hash = $c_hash;
                self::apply_notifications();
            }

            WC()->session->set('pricely_notify_cart_hash', $c_hash);
            
            self::$notifications_applied = true;
        }

        private static function apply_notifications() {
            foreach (self::$notification_messages as $noti) {
                foreach ($noti as $noti_nd) {
                    if ($noti_nd['message'] != '') {                        
                        $message = preg_replace('/{{applied_value}}/', wc_price($noti_nd['applied_value']), $noti_nd['message']);
                        wc_add_notice(wp_kses_post($message), 'success');
                    }
                }
            }
        }

    }

    WooPricely_Cart_Notifications::init();
}
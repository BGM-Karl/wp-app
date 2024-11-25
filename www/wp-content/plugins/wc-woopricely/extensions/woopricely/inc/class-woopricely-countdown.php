<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooPricely_CountDown')) {

    class WooPricely_CountDown {

        private static $datetime_left = '';

        public static function get_datetime() {
            return self::$datetime_left;
        }

        public static function set_datetime($datetime) {
            self::$datetime_left = $datetime;
        }

        public static function clear_datetime() {
            self::$datetime_left = '';
        }

        public static function is_datetime_set() {
            return (self::$datetime_left != '');
        }

    }

}
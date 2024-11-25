<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WCWooPricely_WPML' ) && function_exists( 'SitePress' ) ) {

    class WCWooPricely_WPML {

        public function __construct() {
            
            $option_name = "zc_pri";

            add_filter( 'reon/process-save-options-' . $option_name, array( $this, 'register_translations' ), 10 );

            add_filter( 'zcpri/get-applied-fee-title', array( $this, 'get_translated_fee_title' ), 10, 2 );
            add_filter( 'zcpri/get-applied-fee-desc', array( $this, 'get_translated_fee_desc' ), 10, 2 );
            add_filter( 'zcpri/get-applied-fee-notification', array( $this, 'get_translated_fee_notification' ), 10, 2 );

            add_filter( 'zcpri/get-applied-discount-title', array( $this, 'get_translated_discount_title' ), 10, 2 );
            add_filter( 'zcpri/get-applied-discount-desc', array( $this, 'get_translated_discount_desc' ), 10, 2 );
            add_filter( 'zcpri/get-applied-discount-notification', array( $this, 'get_translated_discount_notification' ), 10, 2 );

            add_filter( 'zcpri/get-cart-total-discounts', array( $this, 'get_translated_cart_total_discounts' ), 10, 1 );
            add_filter( 'zcpri/get-checkout-total-discounts', array( $this, 'get_translated_checkout_total_discounts' ), 10, 1 );

            add_filter( 'zcpri/get-countdown-timer-title', array( $this, 'get_translated_countdown_timer_title' ), 10, 1 );

            add_filter( 'zcpri/get-metrics-table', array( $this, 'get_translated_metrics_table' ), 10, 2 );

            add_filter( 'zcpri/get-promo-message', array( $this, 'get_translated_promo_message' ), 10, 2 );
            add_filter( 'zcpri/get-cart-notification', array( $this, 'get_translated_notification' ), 10, 2 );
        }

        public function register_translations( $options ) {

            $this->register_fee_rule_strings( $options );

            $this->register_fee_group_strings( $options );

            $this->register_discount_rule_strings( $options );

            $this->register_discount_group_strings( $options );

            $this->register_total_saved_strings( $options );

            $this->register_countdown_timer_strings( $options );

            $this->register_metrics_table_strings( $options );

            $this->register_checkout_pricing_rule_strings( $options );

            $this->register_product_pricing_rule_strings( $options );

            return $options;
        }

        public function get_translated_fee_title( $fee_title, $fee_id ) {

            return $this->get_translated_string( $fee_title, 'fee_' . $fee_id . '_title' );
        }

        public function get_translated_fee_desc( $fee_desc, $fee_id ) {

            return $this->get_translated_string( $fee_desc, 'fee_' . $fee_id . '_desc' );
        }

        public function get_translated_fee_notification( $fee_notification, $fee_id ) {

            return $this->get_translated_string( $fee_notification, 'fee_' . $fee_id . '_notification' );
        }

        public function get_translated_discount_title( $fee_title, $fee_id ) {

            return $this->get_translated_string( $fee_title, 'discount_' . $fee_id . '_title' );
        }

        public function get_translated_discount_desc( $fee_desc, $fee_id ) {

            return $this->get_translated_string( $fee_desc, 'discount_' . $fee_id . '_desc' );
        }

        public function get_translated_discount_notification( $fee_notification, $fee_id ) {

            return $this->get_translated_string( $fee_notification, 'discount_' . $fee_id . '_notification' );
        }

        public function get_translated_cart_total_discounts( $total_discounts_string ) {

            return $this->get_translated_string( $total_discounts_string, 'totals_saved_cart' );
        }

        public function get_translated_checkout_total_discounts( $total_discounts_string ) {

            return $this->get_translated_string( $total_discounts_string, 'totals_saved_checkout' );
        }

        public function get_translated_countdown_timer_title( $timer_title_string ) {

            return $this->get_translated_string( $timer_title_string, 'countdown_timer_title' );
        }

        public function get_translated_metrics_table( $metrics_table, $table_id ) {

            $metrics_table[ 'table_title' ][ 'title' ] = $this->get_translated_string( $metrics_table[ 'table_title' ][ 'title' ], 'metrics_table_' . $table_id . '_title' );

            $metrics_table[ 'quatity_row' ][ 'label' ] = $this->get_translated_string( $metrics_table[ 'quatity_row' ][ 'label' ], 'metrics_table_' . $table_id . '_qty_label' );

            $metrics_table[ 'price_row' ][ 'label' ] = $this->get_translated_string( $metrics_table[ 'price_row' ][ 'label' ], 'metrics_table_' . $table_id . '_price_label' );

            $metrics_table[ 'price_per_row' ][ 'label' ] = $this->get_translated_string( $metrics_table[ 'price_per_row' ][ 'label' ], 'metrics_table_' . $table_id . '_price_per_label' );

            $metrics_table[ 'discount_row' ][ 'label' ] = $this->get_translated_string( $metrics_table[ 'discount_row' ][ 'label' ], 'metrics_table_' . $table_id . '_discount_label' );

            $metrics_table[ 'discount_per_row' ][ 'label' ] = $this->get_translated_string( $metrics_table[ 'discount_per_row' ][ 'label' ], 'metrics_table_' . $table_id . '_discount_per_label' );

            return $metrics_table;
        }

        public function get_translated_promo_message( $promo_message, $rule_id ) {

            return $this->get_translated_string( $promo_message, 'promo_message_' . $rule_id );
        }

        public function get_translated_notification( $notification_message, $rule_id ) {

            return $this->get_translated_string( $notification_message, 'notification_' . $rule_id );
        }

        private function register_fee_group_strings( $options ) {

            if ( !isset( $options[ 'fee_groups' ] ) ) {
                return;
            }

            foreach ( $options[ 'fee_groups' ] as $group ) {

                if ( !empty( $group[ 'title' ] ) ) {

                    $this->register_string( 'fee_' . $group[ 'option_id' ] . '_title', $group[ 'title' ], false );
                }

                if ( !empty( $group[ 'desc' ] ) ) {

                    $this->register_string( 'fee_' . $group[ 'option_id' ] . '_desc', $group[ 'desc' ] );
                }

                if ( !empty( $group[ 'notification' ] ) ) {

                    $this->register_string( 'fee_' . $group[ 'option_id' ] . '_notification', $group[ 'notification' ] );
                }
            }
        }

        private function register_fee_rule_strings( $options ) {

            if ( !isset( $options[ 'checkout_fees_rules' ] ) ) {
                return;
            }

            foreach ( $options[ 'checkout_fees_rules' ] as $rule ) {

                if ( !empty( $rule[ 'title' ] ) ) {

                    $this->register_string( 'fee_' . $rule[ 'option_id' ] . '_title', $rule[ 'title' ], false );
                }

                if ( !empty( $rule[ 'single' ][ 'desc' ] ) ) {

                    $this->register_string( 'fee_' . $rule[ 'option_id' ] . '_desc', $rule[ 'single' ][ 'desc' ] );
                }

                if ( !empty( $rule[ 'notification' ] ) ) {

                    $this->register_string( 'fee_' . $rule[ 'option_id' ] . '_notification', $rule[ 'notification' ] );
                }
            }
        }

        private function register_discount_group_strings( $options ) {

            if ( !isset( $options[ 'discount_groups' ] ) ) {
                return;
            }

            foreach ( $options[ 'discount_groups' ] as $group ) {

                if ( !empty( $group[ 'title' ] ) ) {

                    $this->register_string( 'discount_' . $group[ 'option_id' ] . '_title', $group[ 'title' ], false );
                }

                if ( !empty( $group[ 'desc' ] ) ) {

                    $this->register_string( 'discount_' . $group[ 'option_id' ] . '_desc', $group[ 'desc' ] );
                }

                if ( !empty( $group[ 'notification' ] ) ) {

                    $this->register_string( 'discount_' . $group[ 'option_id' ] . '_notification', $group[ 'notification' ] );
                }
            }
        }

        private function register_discount_rule_strings( $options ) {

            if ( !isset( $options[ 'checkout_discounts_rules' ] ) ) {
                return;
            }

            foreach ( $options[ 'checkout_discounts_rules' ] as $rule ) {

                if ( !empty( $rule[ 'title' ] ) ) {

                    $this->register_string( 'discount_' . $rule[ 'option_id' ] . '_title', $rule[ 'title' ], false );
                }

                if ( !empty( $rule[ 'single' ][ 'desc' ] ) ) {

                    $this->register_string( 'discount_' . $rule[ 'option_id' ] . '_desc', $rule[ 'single' ][ 'desc' ] );
                }

                if ( !empty( $rule[ 'notification' ] ) ) {

                    $this->register_string( 'discount_' . $rule[ 'option_id' ] . '_notification', $rule[ 'notification' ] );
                }
            }
        }

        private function register_total_saved_strings( $options ) {

            if ( isset( $options[ 'discounts_total' ][ 'titles' ][ 'cart' ] ) ) {

                $cart_title = $options[ 'discounts_total' ][ 'titles' ][ 'cart' ];

                if ( !empty( $cart_title ) ) {

                    $this->register_string( 'totals_saved_cart', $cart_title, false );
                }
            }

            if ( isset( $options[ 'discounts_total' ][ 'titles' ][ 'checkout' ] ) ) {

                $checkout_title = $options[ 'discounts_total' ][ 'titles' ][ 'checkout' ];

                if ( !empty( $checkout_title ) ) {

                    $this->register_string( 'totals_saved_checkout', $checkout_title, false );
                }
            }
        }

        private function register_countdown_timer_strings( $options ) {

            if ( isset( $options[ 'countdown_timer' ][ 'title' ] ) ) {

                $timer_title = $options[ 'countdown_timer' ][ 'title' ];

                if ( !empty( $timer_title ) ) {

                    $this->register_string( 'countdown_timer_title', $timer_title, false );
                }
            }
        }

        private function register_metrics_table_strings( $options ) {

            if ( !isset( $options[ 'metrics_tables' ][ 'tables' ] ) ) {
                return;
            }

            foreach ( $options[ 'metrics_tables' ][ 'tables' ] as $table ) {

                $option_id = $table[ 'option_id' ];


                $table_title = $table[ 'table_title' ][ 'title' ];
                if ( !empty( $table_title ) ) {
                    $this->register_string( 'metrics_table_' . $option_id . '_title', $table_title, false );
                }

                $table_qty_label = $table[ 'quatity_row' ][ 'label' ];
                if ( !empty( $table_qty_label ) ) {
                    $this->register_string( 'metrics_table_' . $option_id . '_qty_label', $table_qty_label, false );
                }

                $table_price_label = $table[ 'price_row' ][ 'label' ];
                if ( !empty( $table_price_label ) ) {
                    $this->register_string( 'metrics_table_' . $option_id . '_price_label', $table_price_label, false );
                }

                $table_price_per_label = $table[ 'price_per_row' ][ 'label' ];
                if ( !empty( $table_price_per_label ) ) {
                    $this->register_string( 'metrics_table_' . $option_id . '_price_per_label', $table_price_per_label, false );
                }

                $table_discount_label = $table[ 'discount_row' ][ 'label' ];
                if ( !empty( $table_discount_label ) ) {
                    $this->register_string( 'metrics_table_' . $option_id . '_discount_label', $table_discount_label, false );
                }

                $table_discount_per_label = $table[ 'discount_per_row' ][ 'label' ];
                if ( !empty( $table_discount_per_label ) ) {
                    $this->register_string( 'metrics_table_' . $option_id . '_discount_per_label', $table_discount_per_label, false );
                }
            }
        }

        private function register_checkout_pricing_rule_strings( $options ) {

            if ( !isset( $options[ 'checkout_price_rules' ] ) ) {
                return;
            }

            foreach ( $options[ 'checkout_price_rules' ] as $rule ) {

                $message = $rule[ 'message' ];

                if ( !empty( $message ) ) {
                    $this->register_string( 'promo_message_' . $rule[ 'option_id' ], $message, false );
                }

                $notification = $rule[ 'notification' ];

                if ( !empty( $notification ) ) {
                    $this->register_string( 'notification_' . $rule[ 'option_id' ], $notification, false );
                }
            }
        }

        private function register_product_pricing_rule_strings( $options ) {

            if ( !isset( $options[ 'products_pricing_rules' ] ) ) {
                return;
            }

            foreach ( $options[ 'products_pricing_rules' ] as $rule ) {

                $message = $rule[ 'message' ];

                if ( !empty( $message ) ) {
                    $this->register_string( 'promo_message_' . $rule[ 'option_id' ], $message, false );
                }
            }
        }

        private function register_string( $string_id, $string_value ) {

            if ( function_exists( 'icl_register_string' ) ) {

                icl_register_string( 'zcpri-woopricely', $string_id, $string_value );
            }
        }

        private function get_translated_string( $string_value, $string_id ) {

            if ( function_exists( 'icl_t' ) ) {

                return icl_t( 'zcpri-woopricely', $string_id, $string_value );
            }

            return $string_value;
        }

    }

    new WCWooPricely_WPML();
}
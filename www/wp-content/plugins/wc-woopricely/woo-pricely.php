<?php

/*
 * Plugin Name: WooPricely - WooCommerce Dynamic Pricing & Discounts
 * Plugin URI: https://codecanyon.net/item/woopricely-dynamic-pricing-fees-discounts/23844181?ref=zendcrew
 * Description: A multi-purpose pricing and discount toolkit for your WooCommerce store.
 * Author: zendcrew
 * Author URI: https://codecanyon.net/user/zendcrew?ref=zendcrew
 * Tags: discounts, pricing, dynamic discounts, dynamic pricing, ecommerce, woocommerce, woocommerce prices, woocommerce bulk pricing, woocommerce discounts, woocommerce dynamic discounts, woocommerce dynamic pricing, woocommerce pricing, woocommerce bulk discounts, woocommerce wholesale pricing
 * Text Domain: zcpri-woopricely
 * Domain Path: /languages/
 * 
 * Version: 1.3.15
 * WC tested up to: 9.2
 * Tested up to: 6.6
 * 
 * Requires at least: 5.8
 * Requires PHP: 5.6
 * WC requires at least: 5.6
 * 
 */

if ( !defined( 'WCWOOPRICELY_VERSION' ) ) {
    
    define( 'WCWOOPRICELY_VERSION', 'v1.3.15' );
}

require_once (dirname( __FILE__ ) . '/framework/reon_loader.php');

if ( !class_exists( 'WCWooPricely_Plugin' ) ) {

    class WCWooPricely_Plugin {

        public function __construct() {

            add_action( 'plugins_loaded', array( $this, 'plugin_loaded' ), 1 );
            
            add_action( 'before_woocommerce_init', array( $this, 'before_woocommerce_init' ) );

            load_plugin_textdomain( 'zcpri-woopricely', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        public function plugin_loaded() {

            if ( function_exists( 'WC' ) ) { // Check if WooCommerce is active
                
                $this->main();
            }
        }
        
        public function before_woocommerce_init() {

            // Check for HPOS
            if ( !class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {

                return;
            }

            // Adds support for HPOS
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );

            
            //Check if HPOS tables are used
            if ( !(\Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled()) ) {

                return;
            }

            //Adds support for HPOS Tables
            if ( !defined( 'WCWOOPRICELY_USING_HPOS' ) ) {

                define( 'WCWOOPRICELY_USING_HPOS', true );
            }
        }

        private function main() {

            include_once('extensions/extensions.php');
        }

    }

    new WCWooPricely_Plugin();
}

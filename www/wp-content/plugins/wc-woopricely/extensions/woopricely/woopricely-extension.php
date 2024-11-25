<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WCWooPricely_Extension' ) ) {

    class WCWooPricely_Extension {

        public function __construct() {

            if ( !defined( 'WCWOOPRICELY_ASSETS_URL' ) ) {
                define( 'WCWOOPRICELY_ASSETS_URL', plugins_url( 'assets/', __FILE__ ) );
            }

            add_action( 'reon/init', array( $this, 'reon_loaded' ) );
            add_action( 'woocommerce_init', array( $this, 'pricely_init' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'init_addmin_scripts' ), 20 );
            add_action( 'admin_enqueue_scripts', array( $this, 'init_addmin_scripts' ), 20 );
            add_action( 'wp_enqueue_scripts', array( $this, 'init_frontend_scripts' ) );
        }

        public function reon_loaded() {

            require_once (dirname( __FILE__ ) . '/admin/settings-page.php');
        }

        public function pricely_init() {

            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-util.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-validation-util.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-cart-totals.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-countdown.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-product-prices.php');
            require_once (dirname( __FILE__ ) . '/inc/woopricely-checkout-prices/class-woopricely-checkout-prices.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-checkout-discounts.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-checkout-fees.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-views.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-cart-notifications.php');
            require_once (dirname( __FILE__ ) . '/inc/class-woopricely-cart.php');
            require_once (dirname( __FILE__ ) . '/inc/woopricely-cart.php');
            require_once (dirname( __FILE__ ) . '/inc/woopricely.php');
            require_once (dirname( __FILE__ ) . '/inc/hooks-discounts-total.php');
            require_once (dirname( __FILE__ ) . '/inc/hooks-metrics-table.php');
            require_once (dirname( __FILE__ ) . '/inc/hooks-promo-message.php');
            require_once (dirname( __FILE__ ) . '/inc/hooks-countdown.php');
            require_once (dirname( __FILE__ ) . '/inc/integrations/integrations.php');
        }

        public function init_addmin_scripts() {
            
            wp_enqueue_style( 'wcwoopricely-admin-styles', WCWOOPRICELY_ASSETS_URL . 'admin-syles.css', array(), '1.0', 'all' );
        }

        public function init_frontend_scripts() {

            global $zc_pri;

            wp_enqueue_style( 'dashicons' );
            wp_enqueue_style( 'tipTip', WCWOOPRICELY_ASSETS_URL . 'tipTip.css', array(), '1.2', 'all' );
            wp_enqueue_style( 'wcwoopricely-styles', WCWOOPRICELY_ASSETS_URL . 'styles.css', array(), '1.0', 'all' );
            wp_enqueue_script( 'jquery-tipTip', WCWOOPRICELY_ASSETS_URL . 'jquery.tipTip.min.js', array( 'jquery' ), '1.3', true );
            wp_enqueue_script( 'jquery-countdown', WCWOOPRICELY_ASSETS_URL . 'jquery.countdown.min.js', array( 'jquery' ), '2.1.0', true );
            wp_enqueue_script( 'wcwoopricely-script', WCWOOPRICELY_ASSETS_URL . 'script.js', array( 'jquery' ), '1.0', true );

            //Custom CSS
            if ( isset( $zc_pri[ 'custom_css' ] ) && $zc_pri[ 'custom_css' ] != '' ) {
               
                $custom_css = $zc_pri[ 'custom_css' ];
                
                wp_add_inline_style( 'wcwoopricely-styles', $custom_css );
            }
        }

    }

}





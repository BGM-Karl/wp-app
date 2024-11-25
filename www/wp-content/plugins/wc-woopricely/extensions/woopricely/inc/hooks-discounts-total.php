<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('zcpri_pricely_hook_discounts_total')) {

    function zcpri_pricely_hook_discounts_total() {
        global $zc_pri;
        $discounts_total = array(
            'enable' => array(
                'on_car' => 'yes_neg',
                'on_checkout' => 'yes_neg',
            ),
            'positions' => array(
                'car' => 'after_order_total',
                'checkout' => 'after_order_total',
            ),
        );

        if (isset($zc_pri['discounts_total'])) {
            $discounts_total = $zc_pri['discounts_total'];
        }

        if ($discounts_total['enable']['on_car'] != 'no') {
            if ($discounts_total['positions']['car'] == 'before_shipping') {
                add_action('woocommerce_cart_totals_before_shipping', 'WooPricely_Views::cart_discounts_total', 999);
            }
            if ($discounts_total['positions']['car'] == 'after_shipping') {
                add_action('woocommerce_cart_totals_after_shipping', 'WooPricely_Views::cart_discounts_total', 999);
            }
            if ($discounts_total['positions']['car'] == 'before_order_total') {
                add_action('woocommerce_cart_totals_before_order_total', 'WooPricely_Views::cart_discounts_total', 999);
            }
            if ($discounts_total['positions']['car'] == 'after_order_total') {
                add_action('woocommerce_cart_totals_after_order_total', 'WooPricely_Views::cart_discounts_total', 999);
            }
        }


        if ($discounts_total['enable']['on_checkout'] != 'no') {
            if ($discounts_total['positions']['checkout'] == 'before_cart_contents') {
                add_action('woocommerce_review_order_before_cart_contents', 'WooPricely_Views::checkout_discounts_total', 999);
            }
            if ($discounts_total['positions']['checkout'] == 'after_cart_contents') {
                add_action('woocommerce_review_order_after_cart_contents', 'WooPricely_Views::checkout_discounts_total', 999);
            }
            
            
            if ($discounts_total['positions']['checkout'] == 'before_shipping') {
                add_action('woocommerce_review_order_before_shipping', 'WooPricely_Views::checkout_discounts_total', 999);
            }
            if ($discounts_total['positions']['checkout'] == 'after_shipping') {
                add_action('woocommerce_review_order_after_shipping', 'WooPricely_Views::checkout_discounts_total', 999);
            }
            
            
            if ($discounts_total['positions']['checkout'] == 'before_order_total') {
                add_action('woocommerce_review_order_before_order_total', 'WooPricely_Views::checkout_discounts_total', 999);
            }
            if ($discounts_total['positions']['checkout'] == 'after_order_total') {
                add_action('woocommerce_review_order_after_order_total', 'WooPricely_Views::checkout_discounts_total', 999);
            }
            
        }

        

    }

}
zcpri_pricely_hook_discounts_total();

<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('zcpri_pricely_hook_promo_message')) {

    function zcpri_pricely_hook_promo_message() {
        global $zc_pri;
        $promo_message = array(
            'enable' => 'yes',
            'position' => 'product_summary_21',
        );

        if (isset($zc_pri['promo_message'])) {
            $promo_message = $zc_pri['promo_message'];
        }

        if ($promo_message['enable'] != 'no') {

            if ($promo_message['position'] == 'product_summary_4') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 4);
            }
            if ($promo_message['position'] == 'product_summary_6') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 6);
            }
            if ($promo_message['position'] == 'product_summary_11') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 11);
            }   
            if ($promo_message['position'] == 'product_summary_21') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 21);
            }
            if ($promo_message['position'] == 'product_summary_31') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 31);
            }
            if ($promo_message['position'] == 'product_summary_41') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 41);
            }
            if ($promo_message['position'] == 'product_summary_51') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::promo_message', 51);
            }
        }
    }

}

zcpri_pricely_hook_promo_message();




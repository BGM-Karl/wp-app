<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('zcpri_pricely_hook_countdown_timer')) {

    function zcpri_pricely_hook_countdown_timer() {
        global $zc_pri;
        $countdown_timer = array(
            'enable' => 'no',
            'position' => 'product_summary_21',
        );

        if (isset($zc_pri['countdown_timer'])) {
            $countdown_timer = $zc_pri['countdown_timer'];
        }
        
        
        if ($countdown_timer['enable'] != 'no') {

            if ($countdown_timer['position'] == 'product_summary_4') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 4);
            }
            if ($countdown_timer['position'] == 'product_summary_6') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 6);
            }
            if ($countdown_timer['position'] == 'product_summary_11') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 11);
            }
            if ($countdown_timer['position'] == 'product_summary_21') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 21);
            }
            if ($countdown_timer['position'] == 'product_summary_31') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 31);
            }
            if ($countdown_timer['position'] == 'product_summary_41') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 41);
            }
            if ($countdown_timer['position'] == 'product_summary_51') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::countdown_timer', 51);
            }
        }
        
    }

}

zcpri_pricely_hook_countdown_timer();

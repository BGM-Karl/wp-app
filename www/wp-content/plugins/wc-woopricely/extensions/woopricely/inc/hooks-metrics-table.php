<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('zcpri_pricely_hook_metrics_table')) {

    function zcpri_pricely_hook_metrics_table() {
        global $zc_pri;
        $metrics_table = array(
            'enable' => 'yes',
            'position' => 'product_summary_21',
        );

        if (isset($zc_pri['metrics_tables'])) {
            $metrics_table = $zc_pri['metrics_tables'];
        }
        


        if ($metrics_table['enable'] != 'no') {

            if ($metrics_table['position'] == 'product_summary_4') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 4);
            }
            if ($metrics_table['position'] == 'product_summary_6') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 6);
            }
            if ($metrics_table['position'] == 'product_summary_11') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 11);
            }   
            if ($metrics_table['position'] == 'product_summary_21') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 21);
            }
            if ($metrics_table['position'] == 'product_summary_31') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 31);
            }
            if ($metrics_table['position'] == 'product_summary_41') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 41);
            }
            if ($metrics_table['position'] == 'product_summary_51') {
                add_action('woocommerce_single_product_summary', 'WooPricely_Views::metrics_table', 51);
            }
        }
    }

}

zcpri_pricely_hook_metrics_table();





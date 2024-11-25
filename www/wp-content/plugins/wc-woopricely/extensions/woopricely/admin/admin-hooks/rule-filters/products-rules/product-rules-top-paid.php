<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_top_paid', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_top_paid')) {

    function zcpri_get_product_rule_type_product_top_paid($list, $args) {
        $list['top_paid'] = esc_html__('Top Paid Product', 'zcpri-woopricely');
        return $list;
    }

}


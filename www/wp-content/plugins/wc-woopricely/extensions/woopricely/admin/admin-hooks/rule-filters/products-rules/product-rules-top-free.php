<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_top_free', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_top_free')) {

    function zcpri_get_product_rule_type_product_top_free($list, $args) {
        $list['top_free'] = esc_html__('Top Free Product', 'zcpri-woopricely');
        return $list;
    }

}
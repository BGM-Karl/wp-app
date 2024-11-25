<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_reviews', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_reviews')) {

    function zcpri_get_product_rule_type_product_reviews($list, $args) {
        $list['reviews'] = esc_html__('Product Reviews', 'zcpri-woopricely');
        return $list;
    }

}

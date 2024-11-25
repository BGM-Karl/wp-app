<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_best_selling', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_best_selling')) {

    function zcpri_get_product_rule_type_product_best_selling($list, $args) {
        $list['best_selling'] = esc_html__('Best Selling Product', 'zcpri-woopricely');
        return $list;
    }

}


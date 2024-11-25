<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_is_virtual', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_is_virtual')) {

    function zcpri_get_product_rule_type_is_virtual($list, $args) {
        $list['is_virtual'] = esc_html__('Virtual Product', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_is_virtual_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_is_virtual_fields')) {

    function zcpri_get_product_rule_type_is_virtual_fields($fields, $args) {

        $fields['is_virtual'] = array(
            array(
                'id' => 'is_virtual',
                'type' => 'select2',
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                 'width' => '100%',
                'box_width' => '81%',
            )
        );
        return $fields;
    }

}

add_filter('zcpri/validate-product-filter-is_virtual', 'zcpri_validate_product_filter__is_virtual', 10, 3);
if (!function_exists('zcpri_validate_product_filter__is_virtual')) {

    function zcpri_validate_product_filter__is_virtual($product, $rule, $args) {
        $is_virtual = wc_get_product($product['id'])->is_virtual();
        return WooPricely_Validation_Util::validate_yes_no($is_virtual, $rule['is_virtual']);
    }

}
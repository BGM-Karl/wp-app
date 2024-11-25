<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_is_featured', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_is_featured')) {

    function zcpri_get_product_rule_type_is_featured($list, $args) {
        $list['is_featured'] = esc_html__('Featured Product', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_is_featured_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_is_featured_fields')) {

    function zcpri_get_product_rule_type_is_featured_fields($fields, $args) {

        $fields['is_featured'] = array(
            array(
                'id' => 'is_featured',
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


add_filter('zcpri/validate-product-filter-is_featured', 'zcpri_validate_product_filter_is_featured', 10, 3);
if (!function_exists('zcpri_validate_product_filter_is_featured')) {

    function zcpri_validate_product_filter_is_featured($product, $rule, $args) {
        $is_featured = wc_get_product($product['id'])->is_featured();
        return WooPricely_Validation_Util::validate_yes_no($is_featured, $rule['is_featured']);
    }

}
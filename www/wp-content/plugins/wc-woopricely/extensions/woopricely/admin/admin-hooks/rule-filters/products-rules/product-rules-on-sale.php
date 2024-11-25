<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_on_sale', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_on_sale')) {

    function zcpri_get_product_rule_type_product_on_sale($list, $args) {
        $list['on_sale'] = esc_html__('Product Is On Sale', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_on_sale_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_on_sale_fields')) {

    function zcpri_get_product_rule_type_on_sale_fields($fields, $args) {

        $fields['on_sale'] = array(
            array(
                'id' => 'is_on_sale',
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


add_filter('zcpri/validate-product-filter-on_sale', 'zcpri_validate_product_filter_on_sale', 10, 3);
if (!function_exists('zcpri_validate_product_filter_on_sale')) {

    function zcpri_validate_product_filter_on_sale($product, $rule, $args) {
        $is_on_sale = wc_get_product($product['id'])->is_on_sale(false);
        return WooPricely_Validation_Util::validate_yes_no($is_on_sale, $rule['is_on_sale']);
    }

}
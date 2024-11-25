<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_is_downloadable', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_is_downloadable')) {

    function zcpri_get_product_rule_type_is_downloadable($list, $args) {
        $list['is_downloadable'] = esc_html__('Downloadable Product', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_is_downloadable_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_is_downloadable_fields')) {

    function zcpri_get_product_rule_type_is_downloadable_fields($fields, $args) {

        $fields['is_downloadable'] = array(
            array(
                'id' => 'is_downloadable',
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


add_filter('zcpri/validate-product-filter-is_downloadable', 'zcpri_validate_product_filter_is_downloadable', 10, 3);
if (!function_exists('zcpri_validate_product_filter_is_downloadable')) {

    function zcpri_validate_product_filter_is_downloadable($product, $rule, $args) {
        $is_downloadable = wc_get_product($product['id'])->is_downloadable();
        return WooPricely_Validation_Util::validate_yes_no($is_downloadable, $rule['is_downloadable']);
    }

}

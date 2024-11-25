<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_stock_status', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_stock_status')) {

    function zcpri_get_product_rule_type_stock_status($list, $args) {
        $list['stock_status'] = esc_html__('Product Stock Status', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_stock_status_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_stock_status_fields')) {

    function zcpri_get_product_rule_type_stock_status_fields($fields, $args) {

        $fields['stock_status'] = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'stock_status',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Stock status...',
                'allow_clear' => true,
                'options' => wc_get_product_stock_status_options(),
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}

add_filter('zcpri/validate-product-filter-stock_status', 'zcpri_validate_product_filter_stock_status', 10, 3);
if (!function_exists('zcpri_validate_product_filter_stock_status')) {

    function zcpri_validate_product_filter_stock_status($product, $rule, $args) {
        if (!is_array($rule['stock_status'])) {
            return false;
        }
        $stock_status = wc_get_product($product['id'])->get_stock_status(false);

        return WooPricely_Validation_Util::validate_value_list($stock_status, $rule['stock_status'], $rule['compare']);
    }

}
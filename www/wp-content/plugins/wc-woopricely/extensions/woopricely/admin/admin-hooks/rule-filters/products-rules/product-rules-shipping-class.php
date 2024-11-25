<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_shipping_class', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_shipping_class')) {

    function zcpri_get_product_rule_type_shipping_class($list, $args) {
        $list['shipping_class'] = esc_html__('Product Shipping Class', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_shipping_class_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_shipping_class_fields')) {

    function zcpri_get_product_rule_type_shipping_class_fields($fields, $args) {

        $fields['shipping_class'] = array(
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
                'id' => 'shipping_class',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Shipping classes...',
                'allow_clear' => true,
                'data'=>'wc:shipping_classes',
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-shipping_class', 'zcpri_validate_product_filter_shipping_class', 10, 3);
if (!function_exists('zcpri_validate_product_filter_shipping_class')) {

    function zcpri_validate_product_filter_shipping_class($product, $rule, $args) {
         if (!is_array($rule['shipping_class'])) {
            return false;
        }
        $stock_status = wc_get_product($product['id'])->get_shipping_class_id();

        return WooPricely_Validation_Util::validate_value_list($stock_status, $rule['shipping_class'], $rule['compare']);
    }

}
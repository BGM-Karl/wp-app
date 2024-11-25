<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_type', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_type')) {

    function zcpri_get_product_rule_type_type($list, $args) {
        $list['product_types'] = esc_html__('Product Types', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_product_types_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_product_types_fields')) {

    function zcpri_get_product_rule_type_product_types_fields($fields, $args) {

        $fld = array(
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
                'id' => 'product_types',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => 'Product types...',
                'data' => 'wc:product_types',
                'width' => '100%',
                'box_width' => '56%',
            )
        );


        $fields['product_types'] = $fld;
        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-product_types', 'zcpri_validate_product_filter_product_types', 10, 3);
if (!function_exists('zcpri_validate_product_filter_product_types')) {

    function zcpri_validate_product_filter_product_types($product, $rule, $args) {
        if (!is_array($rule['product_types'])) {
            return false;
        }

        $product_type = wc_get_product($product['id'])->get_type();
        return WooPricely_Validation_Util::validate_value_list($product_type, $rule['product_types'], $rule['compare']);
    }

}






add_filter('zcpri/get-products-product_types', 'zcpri_get_products_product_types', 10, 3);
if (!function_exists('zcpri_get_products_product_types')) {

    function zcpri_get_products_product_types($result, $rule, $qty) {

        if (!is_array($rule['product_types'])) {
            return $result;
        }
        $args = array(
            'type' => $rule['product_types'],
            'orderby' => 'name',
        );

        if ($rule['compare'] != 'none') {
            return WooPricely::get_products_from_database($result, $args, $qty, false);
        } else {
            return WooPricely::get_products_from_database($result, $args, $qty, true);
        }
    }

}

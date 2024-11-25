<?php

add_filter('zcpri/get-product-rule-type-group-products', 'zcpri_get_product_rule_type_specific', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_specific')) {

    function zcpri_get_product_rule_type_specific($list, $args) {
        $list['products'] = esc_html__('Specific Products', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_specific_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_specific_fields')) {

    function zcpri_get_product_rule_type_specific_fields($fields, $args) {

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
                'id' => 'product_ids',
                'type' => 'select2',
                'multiple' => true,
                'minimum_input_length' => 2,
                'placeholder' => 'Search products...',
                'allow_clear' => true,
                'minimum_results_forsearch' => 10,
                'data' => array(
                    'source' => 'wc:products',
                    'ajax' => true,
                    'value_col' => 'id',
                    'value_col_pre' => '#',
                    'show_value' => true,
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );


        $fields['products'] = $fld;
        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-products', 'zcpri_validate_product_filter_products', 10, 3);
if (!function_exists('zcpri_validate_product_filter_products')) {

    function zcpri_validate_product_filter_products($product, $rule, $args) {
        if (!is_array($rule['product_ids'])) {
            return false;
        }

        return WooPricely_Validation_Util::validate_value_list($product['id'], $rule['product_ids'], $rule['compare']);
    }

}


add_filter('zcpri/get-products-products', 'zcpri_get_products_products', 10, 3);
if (!function_exists('zcpri_get_products_products')) {

    function zcpri_get_products_products($result, $rule, $qty) {

        if (!is_array($rule['product_ids'])) {
            return $result;
        }
        $args = array(
            'include' => $rule['product_ids'],
            'orderby' => 'name',
        );

        if ($rule['compare'] != 'none') {
            return WooPricely::get_products_from_database($result, $args, $qty, false);
        } else {
            return WooPricely::get_products_from_database($result, $args, $qty, true);
        }
    }

}

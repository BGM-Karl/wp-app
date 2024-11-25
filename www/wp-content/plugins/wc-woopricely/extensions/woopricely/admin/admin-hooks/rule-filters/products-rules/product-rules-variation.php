<?php

add_filter('zcpri/get-product-rule-type-group-products', 'zcpri_get_product_rule_type_variation', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_variation')) {

    function zcpri_get_product_rule_type_variation($list, $args) {
        $list['product_variations'] = esc_html__('Product Variations', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_variation_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_variation_fields')) {

    function zcpri_get_product_rule_type_variation_fields($fields, $args) {

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
                'id' => 'variation_ids',
                'type' => 'select2',
                'multiple' => true,
                'minimum_input_length' => 2,
                'placeholder' => 'Search variations...',
                'allow_clear' => true,
                'minimum_results_forsearch' => 10,
                'data' => array(
                    'source' => 'wc:product_variations',
                    'ajax' => true,
                    'value_col' => 'id',
                    'value_col_pre' => '#',
                    'show_value' => true,
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );


        $fields['product_variations'] = $fld;
        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-product_variations', 'zcpri_validate_product_filter_product_variations', 10, 3);
if (!function_exists('zcpri_validate_product_filter_product_variations')) {

    function zcpri_validate_product_filter_product_variations($product, $rule, $args) {
        if (!is_array($rule['variation_ids'])) {
            return false;
        }
        if(!isset($product['variation_id'])){
            return false;
        }
        return (isset($product['variation_id']) && WooPricely_Validation_Util::validate_value_list($product['variation_id'], $rule['variation_ids'], $rule['compare']));
    }

}

add_filter('zcpri/get-products-product_variations', 'zcpri_get_products_product_variations', 10, 3);
if (!function_exists('zcpri_get_products_product_variations')) {

    function zcpri_get_products_product_variations($result, $rule, $qty) {

        if (!is_array($rule['variation_id'])) {
            return $result;
        }
        $args = array(
            'include' => $rule['variation_id'],
            'orderby' => 'name',
        );

        if ($rule['compare'] != 'none') {
            return WooPricely::get_products_from_database($result, $args, $qty, false);
        } else {
            return WooPricely::get_products_from_database($result, $args, $qty, true);
        }
    }

}
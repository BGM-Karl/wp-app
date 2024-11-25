<?php

add_filter('zcpri/get-condition-type-group-cart_items', 'zcpri_get_condition_type_cart_items_variations', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_variations')) {

    function zcpri_get_condition_type_cart_items_variations($list, $args) {
        $list['cart_items_variations'] = esc_html__('Variations In Cart', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_variations_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_variations_fields')) {

    function zcpri_get_condition_type_cart_items_variations_fields($fields, $args) {

        $fields['cart_items_variations'] = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in the list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in the list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all in the list', 'zcpri-woopricely'),
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
        return $fields;
    }

}


add_filter('zcpri/validate-condition-cart_items_variations', 'zcpri_validate_condition_cart_items_variations', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_variations')) {

    function zcpri_validate_condition_cart_items_variations($rule, $args) {
     
        $variation_ids = array();
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (isset($product['variation_id'])) {
                $variation_ids[] = $product['variation_id'];
            }
        }
        
        if (!is_array($rule['variation_ids'])) {
            return false;
        }
        
        if (count($variation_ids) == 0) {
            return false;
        }

        return WooPricely_Validation_Util::validate_list_list($variation_ids, $rule['variation_ids'], $rule['compare']);
    }

}

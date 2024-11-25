<?php

add_filter('zcpri/get-condition-type-group-cart_items', 'zcpri_get_condition_type_cart_items_products', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_products')) {

    function zcpri_get_condition_type_cart_items_products($list, $args) {

        $list['cart_items_products'] = esc_html__('Products In Cart', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_products_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_products_fields')) {

    function zcpri_get_condition_type_cart_items_products_fields($fields, $args) {

        $fields['cart_items_products'] = array(
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
        return $fields;
    }

}

add_filter('zcpri/validate-condition-cart_items_products', 'zcpri_validate_condition_cart_items_products', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_products')) {

    function zcpri_validate_condition_cart_items_products($rule, $args) {
        $products = array();
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (isset($product['id'])) {
                $products[] = $product['id'];
            }
        }
        if (!is_array($rule['product_ids'])) {
            return false;
        }
        if (count($products) == 0) {
            return false;
        }
        
        return WooPricely_Validation_Util::validate_list_list($products, $rule['product_ids'], $rule['compare']);
    }

}

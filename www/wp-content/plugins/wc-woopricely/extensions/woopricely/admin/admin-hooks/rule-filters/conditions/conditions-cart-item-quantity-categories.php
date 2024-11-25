<?php

add_filter('zcpri/get-condition-type-group-cart_items_quantity', 'zcpri_get_condition_type_cart_items_quantity_categories', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_quantity_categories')) {

    function zcpri_get_condition_type_cart_items_quantity_categories($list, $args) {
        $list['cart_items_qty_categories'] = esc_html__('Categories Quantity', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_qty_categories_fields', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_qty_categories_fields')) {

    function zcpri_get_condition_type_cart_items_qty_categories_fields($fields, $args) {

        $fields['cart_items_qty_categories'] = array(
            array(
                'id' => 'category_ids',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Product categories...',
                'data' => 'categories:product_cat',
                'width' => '99%',
                'box_width' => '38%',
            ),
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => '>',
                'options' => array(
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '31%',
            ),
            array(
                'id' => 'quantity',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0',
                'placeholder' => esc_html__('0', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '12%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
        );
        return $fields;
    }

}

add_filter('zcpri/validate-condition-cart_items_qty_categories', 'zcpri_validate_condition_cart_items_qty_categories', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_qty_categories')) {

    function zcpri_validate_condition_cart_items_qty_categories($rule, $args) {
        if (!is_array($rule['category_ids'])) {
            return false;
        }
        $quantity = 0;
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (WooPricely_Validation_Util::validate_list_list($product['categories'], $rule['category_ids'], 'in_list') != true) {
                continue;
            }
            if (isset($product['quantity'])) {
                $quantity += $product['quantity'];
            }
        }


        return WooPricely_Validation_Util::validate_value($rule['compare'], $quantity, $rule['quantity'], 'no');
    }

}
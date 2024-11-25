<?php

add_filter('zcpri/get-condition-type-group-cart_items_quantity', 'zcpri_get_condition_type_cart_items_quantity_tags', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_quantity_tags')) {

    function zcpri_get_condition_type_cart_items_quantity_tags($list, $args) {
        $list['cart_items_qty_tags'] = esc_html__('Tags Quantity', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_qty_tags_fields', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_qty_tags_fields')) {

    function zcpri_get_condition_type_cart_items_qty_tags_fields($fields, $args) {

        $fields['cart_items_qty_tags'] = array(
            array(
                'id' => 'tag_ids',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Product tags...',
                'data' => 'categories:product_tag',
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

add_filter('zcpri/validate-condition-cart_items_qty_tags', 'zcpri_validate_condition_cart_items_qty_tags', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_qty_tags')) {

    function zcpri_validate_condition_cart_items_qty_tags($rule, $args) {
        if (!is_array($rule['tag_ids'])) {
            return false;
        }
        $quantity = 0;
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (WooPricely_Validation_Util::validate_list_list($product['tags'], $rule['tag_ids'], 'in_list') != true) {
                continue;
            }
            if (isset($product['quantity'])) {
                $quantity += $product['quantity'];
            }
        }


        return WooPricely_Validation_Util::validate_value($rule['compare'], $quantity, $rule['quantity'], 'no');
    }

}
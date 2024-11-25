<?php

add_filter('zcpri/get-condition-type-group-cart_items_subtotal', 'zcpri_get_condition_type_cart_items_subtotal_exc_tax_categories', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_subtotal_exc_tax_categories')) {

    function zcpri_get_condition_type_cart_items_subtotal_exc_tax_categories($list, $args) {
        $list['cart_items_subtotal_exc_tax_categories'] = esc_html__('Categories Subtotal', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_subtotal_exc_tax_categories_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_subtotal_exc_tax_categories_fields')) {

    function zcpri_get_condition_type_cart_items_subtotal_exc_tax_categories_fields($fields, $args) {

        $fields['cart_items_subtotal_exc_tax_categories'] = array(
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
                'id' => 'subtotal_exc_tax',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '12%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );
        return $fields;
    }

}

add_filter('zcpri/validate-condition-cart_items_subtotal_exc_tax_categories', 'zcpri_validate_condition_cart_items_subtotal_exc_tax_categories', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_subtotal_exc_tax_categories')) {

    function zcpri_validate_condition_cart_items_subtotal_exc_tax_categories($rule, $args) {
        if (!is_array($rule['category_ids'])) {
            return false;
        }
        $subtotals = 0;
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (WooPricely_Validation_Util::validate_list_list($product['categories'], $rule['category_ids'], 'in_list') != true) {
                continue;
            }
            if (isset($product['cart_price'])) {
                $qty = 1;
                if (isset($product['quantity'])) {
                    $qty = $product['quantity'];
                }
                $subtotals += ((float) ($product['cart_price'] * $qty));
            }
        }
        
        if ( has_filter( 'zcpri/get-contidtion-subtotals' ) ) {
            $subtotals = apply_filters( 'zcpri/get-contidtion-subtotals', $subtotals );
        }

        return WooPricely_Validation_Util::validate_value($rule['compare'], $subtotals, $rule['subtotal_exc_tax'], 'no');
    }

}


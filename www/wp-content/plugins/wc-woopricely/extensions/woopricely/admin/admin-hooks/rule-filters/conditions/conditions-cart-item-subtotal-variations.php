<?php

add_filter('zcpri/get-condition-type-group-cart_items_subtotal', 'zcpri_get_condition_type_cart_items_subtotal_exc_tax_variations', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_subtotal_exc_tax_variations')) {

    function zcpri_get_condition_type_cart_items_subtotal_exc_tax_variations($list, $args) {
        $list['cart_items_subtotal_exc_tax_variations'] = esc_html__('Variations Subtotal', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_subtotal_exc_tax_variations_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_subtotal_exc_tax_variations_fields')) {

    function zcpri_get_condition_type_cart_items_subtotal_exc_tax_variations_fields($fields, $args) {

        $fields['cart_items_subtotal_exc_tax_variations'] = array(
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

add_filter('zcpri/validate-condition-cart_items_subtotal_exc_tax_variations', 'zcpri_validate_condition_cart_items_subtotal_exc_tax_variations', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_subtotal_exc_tax_variations')) {

    function zcpri_validate_condition_cart_items_subtotal_exc_tax_variations($rule, $args) {
        if (!is_array($rule['variation_ids'])) {
            return false;
        }
        $subtotals = 0;
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (!isset($product['variation_id'])) {
                continue;
            }
            
            if (WooPricely_Validation_Util::validate_value_list($product['variation_id'], $rule['variation_ids'], 'in_list') != true) {
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


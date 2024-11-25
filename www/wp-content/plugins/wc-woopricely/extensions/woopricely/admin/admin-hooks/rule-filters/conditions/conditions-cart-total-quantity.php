<?php

add_filter('zcpri/get-condition-type-group-cart', 'zcpri_get_condition_type_total_quantity', 10, 2);
if (!function_exists('zcpri_get_condition_type_total_quantity')) {

    function zcpri_get_condition_type_total_quantity($list, $args) {
        $list['cart_total_quantity'] = esc_html__('Cart Total Quantity','zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_total_quantity_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_total_quantity_fields')) {

    function zcpri_get_condition_type_total_quantity_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => '>=',
                'options' => array(
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                ),
                'width' => '99%',
                'box_width' => '44%',
            ),
            array(
                'id' => 'total_quantity',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0',
                'placeholder' => esc_html__('0', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '37%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
        );

        $fields['cart_total_quantity'] = $flds;
        return $fields;
    }

}



add_filter('zcpri/validate-condition-cart_total_quantity', 'zcpri_validate_condition_cart_total_quantity', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_total_quantity')) {

    function zcpri_validate_condition_cart_total_quantity($rule, $args) {
        $rule_total_quantity = 0;
        if ($rule['total_quantity'] != '') {
            $rule_total_quantity = $rule['total_quantity'];
        }

        $total_quantity = 0;
        foreach (WC()->cart->get_cart_item_quantities() as $key => $qty) {
            $total_quantity += $qty;
        }
        return WooPricely_Validation_Util::validate_value($rule['compare'], $total_quantity, $rule_total_quantity, 'no');
    }

}
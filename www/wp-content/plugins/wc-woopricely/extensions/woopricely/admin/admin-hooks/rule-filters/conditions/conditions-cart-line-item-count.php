<?php

add_filter('zcpri/get-condition-type-group-cart', 'zcpri_get_condition_type_line_count', 10, 2);
if (!function_exists('zcpri_get_condition_type_line_count')) {

    function zcpri_get_condition_type_line_count($list, $args) {
        $list['cart_line_count'] = esc_html__('Number Of Cart Items','zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_line_count_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_line_count_fields')) {

    function zcpri_get_condition_type_line_count_fields($fields, $args) {

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
                'id' => 'line_count',
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

        $fields['cart_line_count'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-cart_line_count', 'zcpri_validate_condition_cart_line_count', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_line_count')) {

    function zcpri_validate_condition_cart_line_count($rule, $args) {
        $rule_line_count = 0;
        if ($rule['line_count'] != '') {
            $rule_line_count = $rule['line_count'];
        }

        $line_count = 0;
        foreach (WC()->cart->get_cart_item_quantities() as $qty) {
            $line_count++;
        }

        return WooPricely_Validation_Util::validate_value($rule['compare'], $line_count, $rule_line_count, 'no');
    }

}
<?php

add_filter('zcpri/get-condition-type-group-cart', 'zcpri_get_condition_type_total_weight', 10, 2);
if (!function_exists('zcpri_get_condition_type_total_weight')) {

    function zcpri_get_condition_type_total_weight($list, $args) {
        $weight_text = str_replace('[0]', get_option('woocommerce_weight_unit'), esc_html__('Cart Total Weight ([0])', 'zcpri-woopricely'));
        $list['cart_total_weight'] = $weight_text;
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_total_weight_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_total_weight_fields')) {

    function zcpri_get_condition_type_total_weight_fields($fields, $args) {

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
                'id' => 'total_weight',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.0',
                'placeholder' => esc_html__('0.0', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '37%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );

        $fields['cart_total_weight'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-cart_total_weight', 'zcpri_validate_condition_cart_total_weight', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_total_weight')) {

    function zcpri_validate_condition_cart_total_weight($rule, $args) {
        $rule_total_weight = 0;
        if ($rule['total_weight'] != '') {
            $rule_total_weight = $rule['total_weight'];
        }

        $total_weight = WC()->cart->get_cart_contents_weight();

        return WooPricely_Validation_Util::validate_value($rule['compare'], $total_weight, $rule_total_weight, 'no');
    }

}
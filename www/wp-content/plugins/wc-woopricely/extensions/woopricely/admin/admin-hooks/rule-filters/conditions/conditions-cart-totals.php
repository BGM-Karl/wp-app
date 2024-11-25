<?php

add_filter('zcpri/get-condition-type-group-cart', 'zcpri_get_condition_type_totals', 10, 2);
if (!function_exists('zcpri_get_condition_type_totals')) {

    function zcpri_get_condition_type_totals($list, $args) {
        $list['cart_total_inc_tax'] = esc_html__('Totals Including Tax','zcpri-woopricely');
        $list['cart_total_exc_tax'] = esc_html__('Totals Excluding Tax','zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_totals_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_totals_fields')) {

    function zcpri_get_condition_type_totals_fields($fields, $args) {

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
                'id' => 'total_inc_tax',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '37%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );

        $fields['cart_total_inc_tax'] = $flds;

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
                'id' => 'total_exc_tax',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '37%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );

        $fields['cart_total_exc_tax'] = $flds;
        return $fields;
    }

}



add_filter('zcpri/validate-condition-cart_total_inc_tax', 'zcpri_validate_condition_cart_total', 10, 3);
add_filter('zcpri/validate-condition-cart_total_exc_tax', 'zcpri_validate_condition_cart_total', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_total')) {

    function zcpri_validate_condition_cart_total($rule, $args) {


        $rule_total = 0;
        if (isset($rule['total_inc_tax'])) {
            $rule_total = (float) $rule['total_inc_tax'];
        }
        if (isset($rule['total_exc_tax'])) {
            $rule_total = (float) $rule['total_exc_tax'];
        }

        $cart_totals = 0;
        if (isset($rule['total_inc_tax'])) {
            $cart_totals = WC()->cart->get_total(false);
        }
        if (isset($rule['total_exc_tax'])) {
            $cart_totals = WC()->cart->get_total_ex_tax();
        }
        return WooPricely_Validation_Util::validate_value($rule['compare'], $cart_totals, $rule_total, 'no');
    }

}
<?php

add_filter('zcpri/get-condition-type-group-cart', 'zcpri_get_condition_type_subtotal', 10, 2);
if (!function_exists('zcpri_get_condition_type_subtotal')) {

    function zcpri_get_condition_type_subtotal($list, $args) {
        $list['cart_subtotal_inc_tax'] = esc_html__('Subtotals Including Tax', 'zcpri-woopricely');
        $list['cart_subtotal_exc_tax'] = esc_html__('Subtotals Excluding Tax', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_subtotals_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_subtotals_fields')) {

    function zcpri_get_condition_type_subtotals_fields($fields, $args) {

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
                'id' => 'subtotal_inc_tax',
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

        $fields['cart_subtotal_inc_tax'] = $flds;

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
                'id' => 'subtotal_exc_tax',
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

        $fields['cart_subtotal_exc_tax'] = $flds;
        return $fields;
    }

}


add_filter('zcpri/validate-condition-cart_subtotal_inc_tax', 'zcpri_validate_condition_cart_subtotal', 10, 3);
add_filter('zcpri/validate-condition-cart_subtotal_exc_tax', 'zcpri_validate_condition_cart_subtotal', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_subtotal')) {

    function zcpri_validate_condition_cart_subtotal($rule, $args) {
        $rule_subtotal = 0;
        if (isset($rule['subtotal_inc_tax'])) {
            $rule_subtotal = (float) $rule['subtotal_inc_tax'];
        }
        if (isset($rule['subtotal_exc_tax'])) {
            $rule_subtotal = (float) $rule['subtotal_exc_tax'];
        }

        $cart_subtotals = 0;

        if (isset($rule['subtotal_exc_tax'])) {
            $cart_subtotals = WooPricely_Cart_Totals::get_subtotals(false, WooPricely_Cart_Totals::get_totals_id_by_module_id($args['section']));
        }
        if (isset($rule['subtotal_inc_tax'])) {
            $cart_subtotals = WooPricely_Cart_Totals::get_subtotals(true, WooPricely_Cart_Totals::get_totals_id_by_module_id($args['section']));
        }
       
        return WooPricely_Validation_Util::validate_value($rule['compare'], $cart_subtotals, $rule_subtotal, 'no');
    }

}

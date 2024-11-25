<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_shipping_cost', 10, 2);
if (!function_exists('zcpri_get_condition_type_shipping_cost')) {

    function zcpri_get_condition_type_shipping_cost($list, $args) {
        $list['shipping_cost'] = esc_html__('Shipping Cost', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_shipping_cost_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_shipping_cost_fields')) {

    function zcpri_get_condition_type_shipping_cost_fields($fields, $args) {

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
                'id' => 'shipping_cost',
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
            )
        );

        $fields['shipping_cost'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-shipping_cost', 'zcpri_validate_condition_shipping_cost', 10, 3);
if (!function_exists('zcpri_validate_condition_shipping_cost')) {

    function zcpri_validate_condition_shipping_cost($rule, $args) {
        if ($rule['shipping_cost'] == '') {
            return false;
        }
        
        $shipping_cost = WooPricelyUtil::get_chosen_shipping_method_cost();
      
        return WooPricely_Validation_Util::validate_value($rule['compare'], $shipping_cost, $rule['shipping_cost'], 'no');
    }

}

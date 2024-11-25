<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_shipping_state', 10, 2);
if (!function_exists('zcpri_get_condition_type_shipping_state')) {

    function zcpri_get_condition_type_shipping_state($list, $args) {
        $list['shipping_state'] = esc_html__('Shipping State', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_shipping_state_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_shipping_state_fields')) {

    function zcpri_get_condition_type_shipping_state_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'shipping_states',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'minimum_input_length' => 2,
                'minimum_results_forsearch' => 10,
                'placeholder' => esc_html__('Shipping States...', 'zcpri-woopricely'),
                'ajax_data' => 'wc:states',
                'width' => '100%',
                'box_width' => '56%',
            )
        );

        $fields['shipping_state'] = $flds;
        return $fields;
    }

}


add_filter('zcpri/validate-condition-shipping_state', 'zcpri_validate_condition_shipping_state', 10, 3);
if (!function_exists('zcpri_validate_condition_shipping_state')) {

    function zcpri_validate_condition_shipping_state($rule, $args) {

        if (!is_array($rule['shipping_states'])) {
            return false;
        }

        $shipping_country = WC()->customer->get_shipping_country(false);
        $shipping_state = $shipping_country . ':' . WC()->customer->get_shipping_state(false);
        return WooPricely_Validation_Util::validate_value_list($shipping_state, $rule['shipping_states'], $rule['compare']);
    }

}
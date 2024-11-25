<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_billing_postcode', 10, 2);
if (!function_exists('zcpri_get_condition_type_billing_postcode')) {

    function zcpri_get_condition_type_billing_postcode($list, $args) {
        $list['billing_postcode'] = esc_html__('Billing Postcode', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_billing_postcode_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_billing_postcode_fields')) {

    function zcpri_get_condition_type_billing_postcode_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'match' => esc_html__('Match', 'zcpri-woopricely'),
                    'not_match' => esc_html__('Not match', 'zcpri-woopricely'),
                ),
                 'width' => '98%',
                'box_width' => '22%',
            ),
            array(
                'id' => 'billing_postcode',
                'type' => 'textbox',
                'input_type' => 'text',
                'default' => '',
                'placeholder' => esc_html__('e.g 1815, 870*, [1870 - 9999], DSE, LDS', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '59%',
            ),
        );

        $fields['billing_postcode'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-billing_postcode', 'zcpri_validate_condition_billing_postcode', 10, 3);
if (!function_exists('zcpri_validate_condition_billing_postcode')) {

    function zcpri_validate_condition_billing_postcode($rule, $args) {
        if ($rule['billing_postcode'] == '') {
            return false;
        }

        $billing_postcode = WC()->customer->get_billing_postcode(false);
        return WooPricely_Validation_Util::validate_match_value($rule['compare'], $billing_postcode, $rule['billing_postcode']);
    }

}

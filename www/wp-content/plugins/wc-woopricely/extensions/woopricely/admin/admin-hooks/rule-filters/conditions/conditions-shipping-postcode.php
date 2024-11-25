<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_shipping_postcode', 10, 2);
if (!function_exists('zcpri_get_condition_type_shipping_postcode')) {

    function zcpri_get_condition_type_shipping_postcode($list, $args) {
        $list['shipping_postcode'] = esc_html__('Shipping Postcode', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_shipping_postcode_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_shipping_postcode_fields')) {

    function zcpri_get_condition_type_shipping_postcode_fields($fields, $args) {

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
                'id' => 'shipping_postcode',
                'type' => 'textbox',
                'input_type' => 'text',
                'default' => '',
                'placeholder' => esc_html__('e.g 1815, 870*, [1870 - 9999], DSE, LDS', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '59%',
            ),
        );

        $fields['shipping_postcode'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-shipping_postcode', 'zcpri_validate_condition_shipping_postcode', 10, 3);
if (!function_exists('zcpri_validate_condition_shipping_postcode')) {

    function zcpri_validate_condition_shipping_postcode($rule, $args) {
        if ($rule['shipping_postcode'] == '') {
            return false;
        }
        $shipping_postcode = WC()->customer->get_shipping_postcode(false);
        return WooPricely_Validation_Util::validate_match_value($rule['compare'], $shipping_postcode, $rule['shipping_postcode']);
    }

}
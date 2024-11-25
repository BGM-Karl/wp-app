<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_payment_method', 10, 2);
if (!function_exists('zcpri_get_condition_type_payment_method')) {

    function zcpri_get_condition_type_payment_method($list, $args) {
        $list['payment_method'] = esc_html__('Payment Method', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_payment_method_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_payment_method_fields')) {

    function zcpri_get_condition_type_payment_method_fields($fields, $args) {

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
                'id' => 'payment_methods',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => esc_html__('Payment methods...', 'zcpri-woopricely'),
                'data' => 'wc:payment_methods',
                'width' => '100%',
                'box_width' => '56%',
            )
        );

        $fields['payment_method'] = $flds;
        return $fields;
    }

}


add_filter('zcpri/validate-condition-payment_method', 'zcpri_validate_condition_payment_method', 10, 3);
if (!function_exists('zcpri_validate_condition_payment_method')) {

    function zcpri_validate_condition_payment_method($rule, $args) {
        if (!is_array($rule['payment_methods'])) {
            return false;
        }

        $chosen_gateway = WC()->session->chosen_payment_method;
        return WooPricely_Validation_Util::validate_value_list($chosen_gateway, $rule['payment_methods'], $rule['compare']);
    }

}





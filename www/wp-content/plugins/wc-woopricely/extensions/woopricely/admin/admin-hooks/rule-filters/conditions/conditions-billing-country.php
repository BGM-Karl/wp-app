<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_billing_country', 10, 2);
if (!function_exists('zcpri_get_condition_type_billing_country')) {

    function zcpri_get_condition_type_billing_country($list, $args) {
        $list['billing_country'] = esc_html__('Billing Country', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_billing_country_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_billing_country_fields')) {

    function zcpri_get_condition_type_billing_country_fields($fields, $args) {

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
                'id' => 'billing_countries',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'minimum_input_length' => 2,
                'minimum_results_forsearch' => 10,
                'placeholder' => esc_html__('Billing Countries...', 'zcpri-woopricely'),
                'ajax_data' => 'wc:countries',
                'width' => '100%',
                'box_width' => '56%',
            )
        );

        $fields['billing_country'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-billing_country', 'zcpri_validate_condition_billing_country', 10, 3);
if (!function_exists('zcpri_validate_condition_billing_country')) {

    function zcpri_validate_condition_billing_country($rule, $args) {
        if (!is_array($rule['billing_countries'])) {
            return false;
        }
        $billing_country = WC()->customer->get_billing_country(false);
        return WooPricely_Validation_Util::validate_value_list($billing_country, $rule['billing_countries'], $rule['compare']);
    }

}

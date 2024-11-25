<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_shipping_rate', 10, 2);
if (!function_exists('zcpri_get_condition_type_shipping_rate')) {

    function zcpri_get_condition_type_shipping_rate($list, $args) {
        $list['shipping_rate'] = esc_html__('Shipping Rate', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_shipping_rate_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_shipping_rate_fields')) {

    function zcpri_get_condition_type_shipping_rate_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__( 'Any in the list', 'zcpri-woopricely' ),
                    'in_all_list' => esc_html__( 'All in the list', 'zcpri-woopricely' ),
                    'in_list_only' => esc_html__( 'Only in the list', 'zcpri-woopricely' ),
                    'in_all_list_only' => esc_html__( 'Only all in the list', 'zcpri-woopricely' ),
                    'none' => esc_html__( 'None in the list', 'zcpri-woopricely' ),
                ),
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'shipping_rates',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => esc_html__('Shipping rates...', 'zcpri-woopricely'),
                'data' => 'wc:zones_shipping',
                'width' => '100%',
                'box_width' => '56%',
            )
        );

        $fields['shipping_rate'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-shipping_rate', 'zcpri_validate_condition_shipping_rate', 10, 3);
if (!function_exists('zcpri_validate_condition_shipping_rate')) {

    function zcpri_validate_condition_shipping_rate($rule, $args) {
        if (!is_array($rule['shipping_rates'])) {
            return false;
        }
        $chosen_rates = WooPricelyUtil::get_chosen_shipping_rates();
        if (!count( $chosen_rates)) {
            return false;
        }
        
        return WooPricely_Validation_Util::validate_list_list( $chosen_rates, $rule['shipping_rates'], $rule['compare'] );
    }

}




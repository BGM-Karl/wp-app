<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_shipping_method', 10, 2);
if (!function_exists('zcpri_get_condition_type_shipping_method')) {

    function zcpri_get_condition_type_shipping_method($list, $args) {
        $list['shipping_method'] = esc_html__('Shipping Method', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_shipping_method_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_shipping_method_fields')) {

    function zcpri_get_condition_type_shipping_method_fields($fields, $args) {

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
                'id' => 'shipping_methods',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => esc_html__('Shipping methods...', 'zcpri-woopricely'),
                'data' => 'wc:shipping_methods',
                'width' => '100%',
                'box_width' => '56%',
            )
        );

        $fields['shipping_method'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-shipping_method', 'zcpri_validate_condition_shipping_method', 10, 3);
if (!function_exists('zcpri_validate_condition_shipping_method')) {

    function zcpri_validate_condition_shipping_method($rule, $args) {
        if (!is_array($rule['shipping_methods'])) {
            return false;
        }
        $chosen_methods = WooPricelyUtil::get_chosen_shipping_methods();
        if (!count($chosen_methods)) {
            return false;
        }
        
        return WooPricely_Validation_Util::validate_list_list( $chosen_methods, $rule['shipping_methods'], $rule['compare'] );
    }

}
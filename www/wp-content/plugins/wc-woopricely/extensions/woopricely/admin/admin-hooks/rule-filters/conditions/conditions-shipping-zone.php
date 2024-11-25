<?php

add_filter('zcpri/get-condition-type-group-billing_shipping', 'zcpri_get_condition_type_shipping_zone', 10, 2);
if (!function_exists('zcpri_get_condition_type_shipping_zone')) {

    function zcpri_get_condition_type_shipping_zone($list, $args) {
        $list['shipping_zone'] = esc_html__('Shipping Zone', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_shipping_zone_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_shipping_zone_fields')) {

    function zcpri_get_condition_type_shipping_zone_fields($fields, $args) {

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
                'id' => 'shipping_zones',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => esc_html__('Shipping zones...', 'zcpri-woopricely'),
                'data' => 'wc:shipping_zones',
                'width' => '100%',
                'box_width' => '56%',
            )
        );

        $fields['shipping_zone'] = $flds;
        return $fields;
    }

}


add_filter('zcpri/validate-condition-shipping_zone', 'zcpri_validate_condition_shipping_zone', 10, 3);
if (!function_exists('zcpri_validate_condition_shipping_zone')) {

    function zcpri_validate_condition_shipping_zone($rule, $args) {
        if (!is_array($rule['shipping_zones'])) {
            return false;
        }

        $zone_ids = WooPricelyUtil::get_chosen_shipping_zones();
        if (!count($zone_ids)) {
            return false;
        }
        
        return WooPricely_Validation_Util::validate_list_list( $zone_ids, $rule['shipping_zones'], $rule['compare'] );
    }

}



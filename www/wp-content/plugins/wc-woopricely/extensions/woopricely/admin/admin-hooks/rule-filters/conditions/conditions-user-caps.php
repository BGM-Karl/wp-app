<?php

add_filter('zcpri/get-condition-type-group-customer', 'zcpri_get_condition_type_user_caps', 10, 2);
if (!function_exists('zcpri_get_condition_type_user_caps')) {

    function zcpri_get_condition_type_user_caps($list, $args) {
        
        $list['user_caps'] =esc_html__('User Capabilities', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_user_caps_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_user_caps_fields')) {

    function zcpri_get_condition_type_user_caps_fields($fields, $args) {

        $fields['user_caps'] = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in the list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in the list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all in the list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'user_caps',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Roles...',
                'allow_clear' => true,
                'data' => 'wp_caps',
                'minimum_input_length' => 1,
                'placeholder' => 'Search capabilities...',
                'data' => array(
                    'source' => 'wp_caps',
                    'ajax' => true,
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}

add_filter('zcpri/validate-condition-user_caps', 'zcpri_validate_condition_user_caps', 10, 3);
if (!function_exists('zcpri_validate_condition_user_caps')) {

    function zcpri_validate_condition_user_caps($rule, $args) {

        if (!is_array($rule['user_caps'])) {
            return false;
        }

        $user_caps =array();
        foreach (wp_get_current_user()->allcaps as $key => $user_cap) {
            if($user_cap==true){
                $user_caps[]=$key;
            }
        }
        return WooPricely_Validation_Util::validate_list_list($user_caps, $rule['user_caps'], $rule['compare']);
    }

}
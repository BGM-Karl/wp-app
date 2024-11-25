<?php

add_filter('zcpri/get-condition-type-group-customer', 'zcpri_get_condition_type_user_is_logged_in', 10, 2);
if (!function_exists('zcpri_get_condition_type_user_is_logged_in')) {

    function zcpri_get_condition_type_user_is_logged_in($list, $args) {

        $list['user_is_logged_in'] = esc_html__('User Is Logged In', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_user_is_logged_in_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_user_is_logged_in_fields')) {

    function zcpri_get_condition_type_user_is_logged_in_fields($fields, $args) {

        $fields['user_is_logged_in'] = array(
            array(
                'id' => 'is_logged_in',
                'type' => 'select2',
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                'width' => '100%',
                'box_width' => '81%',
            )
        );
        return $fields;
    }

}


add_filter('zcpri/validate-condition-user_is_logged_in', 'zcpri_validate_condition_user_is_logged_in', 10, 3);
if (!function_exists('zcpri_validate_condition_user_is_logged_in')) {

    function zcpri_validate_condition_user_is_logged_in($rule, $args) {
        $is_logged_in = is_user_logged_in();
        return WooPricely_Validation_Util::validate_yes_no($is_logged_in, $rule['is_logged_in']);
    }

}


<?php

add_filter('zcpri/get-condition-type-group-customer', 'zcpri_get_condition_type_user_roles', 10, 2);
if (!function_exists('zcpri_get_condition_type_user_roles')) {

    function zcpri_get_condition_type_user_roles($list, $args) {
        $list['user_roles'] = esc_html__('User Roles', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_user_roles_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_user_roles_fields')) {

    function zcpri_get_condition_type_user_roles_fields($fields, $args) {

        $fields['user_roles'] = array(
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
                'id' => 'user_roles',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Roles...',
                'allow_clear' => true,
                'data' => 'roles',
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}

add_filter('zcpri/validate-condition-user_roles', 'zcpri_validate_condition_user_roles', 10, 3);
if (!function_exists('zcpri_validate_condition_user_roles')) {

    function zcpri_validate_condition_user_roles($rule, $args) {

        if (!is_array($rule['user_roles'])) {
            return false;
        }

        $user_roles = wp_get_current_user()->roles;
        return WooPricely_Validation_Util::validate_list_list($user_roles, $rule['user_roles'], $rule['compare']);
    }

}
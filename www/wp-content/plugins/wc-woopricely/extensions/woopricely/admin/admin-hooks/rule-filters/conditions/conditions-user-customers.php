<?php

add_filter('zcpri/get-condition-type-group-customer', 'zcpri_get_condition_type_customer_users', 10, 2);
if (!function_exists('zcpri_get_condition_type_customer_users')) {

    function zcpri_get_condition_type_customer_users($list, $args) {

        $list['user_customers'] = esc_html__('Customers', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_user_customers_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_user_customers_fields')) {

    function zcpri_get_condition_type_user_customers_fields($fields, $args) {

        $fields['user_customers'] = array(
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
                'id' => 'user_emails',
                'type' => 'select2',
                'multiple' => true,
                'minimum_input_length' => 2,
                'placeholder' => 'Search users...',
                'allow_clear' => true,
                'minimum_results_forsearch' => 10,
                'data' => array(
                    'source' => 'users',
                    'ajax' => true,
                    'value_col' => 'email',
                    'show_value' => true,
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}

add_filter('zcpri/validate-condition-user_customers', 'zcpri_validate_condition_user_customers', 10, 3);
if (!function_exists('zcpri_validate_condition_user_customers')) {

    function zcpri_validate_condition_user_customers($rule, $args) {

        if (!is_array($rule['user_emails'])) {
            return false;
        }


        $customer_email = wp_get_current_user()->user_email;
        if ($customer_email == '') {
            return false;
        }
        return WooPricely_Validation_Util::validate_value_list($customer_email, $rule['user_emails'], $rule['compare']);
    }

}
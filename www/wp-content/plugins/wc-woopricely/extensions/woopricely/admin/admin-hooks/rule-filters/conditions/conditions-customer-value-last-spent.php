<?php

add_filter('zcpri/get-condition-type-group-customer_value', 'zcpri_get_condition_type_customer_value_last_spent', 10, 2);
if (!function_exists('zcpri_get_condition_type_customer_value_last_spent')) {

    function zcpri_get_condition_type_customer_value_last_spent($list, $args) {
        $currency = get_woocommerce_currency_symbol(get_woocommerce_currency());
        $total_text = str_replace('[0]', $currency, esc_html__('Last Order Amount ([0])', 'zcpri-woopricely'));
        $list['customer_value_last_spent'] = $total_text;
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_customer_value_last_spent_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_customer_value_last_spent_fields')) {

    function zcpri_get_condition_type_customer_value_last_spent_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => '>=',
                'options' => array(
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                ),
                'width' => '99%',
                'box_width' => '45%',
            ),
            array(
                'id' => 'last_spent',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '36%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );

        $fields['customer_value_last_spent'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-customer_value_last_spent', 'zcpri_validate_condition_customer_value_last_spent', 10, 3);
if (!function_exists('zcpri_validate_condition_customer_value_last_spent')) {

    function zcpri_validate_condition_customer_value_last_spent($rule, $args) {

        $last_spent = WooPricelyUtil::get_customer_last_amount_spent(get_current_user_id());

        return WooPricely_Validation_Util::validate_value($rule['compare'], $last_spent, $rule['last_spent'], 'no');
    }

}

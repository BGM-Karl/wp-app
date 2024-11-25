<?php

add_filter('zcpri/get-condition-type-group-customer_value', 'zcpri_get_condition_type_customer_value_last_order_date', 10, 2);
if (!function_exists('zcpri_get_condition_type_customer_value_last_order_date')) {

    function zcpri_get_condition_type_customer_value_last_order_date($list, $args) {
        $list['customer_value_last_order_date'] = esc_html__('Last Order Date', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_customer_value_last_order_date_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_customer_value_last_order_date_fields')) {

    function zcpri_get_condition_type_customer_value_last_order_date_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'date_compare',
                'type' => 'select2',
                'default' => 'after',
                'options' => array(
                    '<=' => esc_html__('Earlier than', 'zcpri-woopricely'),
                    '>=' => esc_html__('Within the past', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '29%',
            ),
            array(
                'id' => 'date_type',
                'type' => 'select2',
                'default' => 'days',
                'options' => array(
                    'current' => esc_html__('Current', 'zcpri-woopricely'),
                    'hours' => esc_html__('Hours', 'zcpri-woopricely'),
                    'days' => esc_html__('Days', 'zcpri-woopricely'),
                    'weeks' => esc_html__('Weeks', 'zcpri-woopricely'),
                    'months' => esc_html__('Months', 'zcpri-woopricely'),
                    'years' => esc_html__('Years', 'zcpri-woopricely'),
                ),
                'fold_id' => 'date_type',
                'width' => '98%',
                'box_width' => '20%',
            ),
            array(
                'id' => 'current',
                'type' => 'select2',
                'default' => 'day',
                'options' => array(
                    'day' => esc_html__('Day', 'zcpri-woopricely'),
                    'week' => esc_html__('Week', 'zcpri-woopricely'),
                    'month' => esc_html__('Month', 'zcpri-woopricely'),
                    'year' => esc_html__('Year', 'zcpri-woopricely'),
                ),
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'current',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '32%',
            ),
            array(
                'id' => 'date_offset',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '1',
                'placeholder' => esc_html__('0', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '32%',
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'current',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
        );

        $fields['customer_value_last_order_date'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-customer_value_last_order_date', 'zcpri_validate_condition_customer_value_last_order_date', 10, 3);
if (!function_exists('zcpri_validate_condition_customer_value_last_order_date')) {

    function zcpri_validate_condition_customer_value_last_order_date($rule, $args) {

        $last_order = wc_get_customer_last_order(get_current_user_id());
        if ($last_order == false) {
            return false;
        }
        $from_date = WooPricelyUtil::get_date_from_rule_value($rule);
        $last_order_date = $last_order->get_date_paid(false)->format('Y-m-d H:i:s');

        return WooPricely_Validation_Util::validate_date($rule['date_compare'],$last_order_date ,  $from_date, 'Y-m-d H:i:s', 'Y-m-d H:i:s');
    }

}
<?php

add_filter('zcpri/get-condition-type-group-customer_value', 'zcpri_get_condition_type_customer_value_orders_count', 10, 2);
if (!function_exists('zcpri_get_condition_type_customer_value_orders_count')) {

    function zcpri_get_condition_type_customer_value_orders_count($list, $args) {
        $list['customer_value_orders_count'] = esc_html__('Number Of Orders', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_customer_value_orders_count_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_customer_value_orders_count_fields')) {

    function zcpri_get_condition_type_customer_value_orders_count_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'date_type',
                'type' => 'select2',
                'default' => 'all_time',
                'options' => array(
                    'all_time' => esc_html__('All time', 'zcpri-woopricely'),
                    'current' => esc_html__('Current', 'zcpri-woopricely'),
                    'hours' => esc_html__('Hours', 'zcpri-woopricely'),
                    'days' => esc_html__('Days', 'zcpri-woopricely'),
                    'weeks' => esc_html__('Weeks', 'zcpri-woopricely'),
                    'months' => esc_html__('Months', 'zcpri-woopricely'),
                    'years' => esc_html__('Years', 'zcpri-woopricely'),
                ),
                'fold_id' => 'date_type',
                'width' => '98%',
                'box_width' => '17%',
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
                    'value' => array('current'),
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '98%',
                'box_width' => '15%',
            ),
            array(
                'id' => 'date_offset',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '1',
                'placeholder' => esc_html__('0', 'zcpri-woopricely'),
                'width' => '98%',
                'box_width' => '15%',
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => array('hours', 'days', 'weeks', 'months', 'years'),
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
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
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '98%',
                'box_width' => '32%',
            ),
            array(
                'id' => 'all_time_compare',
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
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '99%',
                'box_width' => '47%',
            ),
            array(
                'id' => 'orders_count',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '1',
                'placeholder' => esc_html__('0', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '17%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
        );

        $fields['customer_value_orders_count'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-customer_value_orders_count', 'zcpri_validate_condition_customer_value_orders_count', 10, 3);
if (!function_exists('zcpri_validate_condition_customer_value_orders_count')) {

    function zcpri_validate_condition_customer_value_orders_count($rule, $args) {


        $compare = $rule['all_time_compare'];
        if ($rule['date_type'] != 'all_time' && $rule['date_type'] != '') {
            $compare = $rule['compare'];
        }

        $from_date = WooPricelyUtil::get_date_from_rule_value($rule);

        $orders_count = WooPricelyUtil::get_customer_orders_count(get_current_user_id(), $from_date);

        return WooPricely_Validation_Util::validate_value($compare, $orders_count, $rule['orders_count'], 'no');
    }

}

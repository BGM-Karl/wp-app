<?php

add_filter('zcpri/get-condition-type-group-date_time', 'zcpri_get_condition_type_calendar_date_time', 10, 2);
if (!function_exists('zcpri_get_condition_type_calendar_date_time')) {

    function zcpri_get_condition_type_calendar_date_time($list, $args) {

        $list['calendar_date_time'] = esc_html__('Date & Time', 'zcpri-woopricely');
        return $list;
    }

}



add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_calendar_date_time_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_calendar_date_time_fields')) {

    function zcpri_get_condition_type_calendar_date_time_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'date_type',
                'type' => 'select2',
                'default' => 'from',
                'options' => array(
                    'from' => esc_html__('From', 'zcpri-woopricely'),
                    'to' => esc_html__('To', 'zcpri-woopricely'),
                    'between' => esc_html__('Between', 'zcpri-woopricely'),
                ),
                'fold_id' => 'date_type',
                'width' => '98%',
                'box_width' => '23%',
            ),
            array(
                'id' => 'from_date_time',
                'type' => 'datetime',
                'default' => '',
                'placeholder' => esc_html__('yy-mm-dd 00:00:00', 'zcpri-woopricely'),
                'date_format' => 'yy-mm-dd',
                'number_of_months' => 1,
                'change_month' => true,
                'change_year' => true,
                'first_day' => 0,
                'time_format' => 'HH:mm:ss',
                'one_line' => true,
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'between',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'width' => '98%',
                'box_width' => '29%',
            ),
            array(
                'id' => 'to_date_time',
                'type' => 'datetime',
                'default' => '',
                'placeholder' => esc_html__('yy-mm-dd 00:00:00', 'zcpri-woopricely'),
                'date_format' => 'yy-mm-dd',
                'number_of_months' => 1,
                'change_month' => true,
                'change_year' => true,
                'first_day' => 0,
                'time_format' => 'HH:mm:ss',
                'one_line' => true,
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'between',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'width' => '100%',
                'box_width' => '29%',
            ),
            array(
                'id' => 'date_time',
                'type' => 'datetime',
                'default' => '',
                'placeholder' => esc_html__('yy-mm-dd 00:00:00', 'zcpri-woopricely'),
                'date_format' => 'yy-mm-dd',
                'number_of_months' => 1,
                'change_month' => true,
                'change_year' => true,
                'first_day' => 0,
                'time_format' => 'HH:mm:ss',
                'one_line' => true,
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'between',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'width' => '100%',
                'box_width' => '58%',
            ),
        );

        $fields['calendar_date_time'] = $flds;
        return $fields;
    }

}


add_filter('zcpri/validate-condition-calendar_date_time', 'zcpri_validate_condition_calendar_date_time', 10, 3);
if (!function_exists('zcpri_validate_condition_calendar_date_time')) {

    function zcpri_validate_condition_calendar_date_time($rule, $args) {


        if ($rule['date_type'] == 'between') {
            if ($rule['from_date_time'] == '' || $rule['to_date_time'] == '') {
                return false;
            }
            $current_date_time = WooPricelyUtil::get_current_date(true);

            $from_is_valid = WooPricely_Validation_Util::validate_date('>=', $current_date_time, $rule['from_date_time'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');
            $to_is_valid = WooPricely_Validation_Util::validate_date('<=', $current_date_time, $rule['to_date_time'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');

            $is_valid = ($from_is_valid == true && $to_is_valid == true);

            if ($is_valid == true) {
                WooPricely_CountDown::set_datetime($rule['to_date_time']);
            }

            return $is_valid;
        } else {
            if ($rule['date_time'] == '') {
                return false;
            }
            $current_date_time = WooPricelyUtil::get_current_date(true);
            $valid_type = '>=';
            if ($rule['date_type'] == 'to') {
                $valid_type = '<=';
            }
            $is_valid = WooPricely_Validation_Util::validate_date($valid_type, $current_date_time, $rule['date_time'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');


            if ($is_valid == true && $rule['date_type'] == 'to') {
                WooPricely_CountDown::set_datetime($rule['date_time']);
            }

            return $is_valid;
        }
    }

}

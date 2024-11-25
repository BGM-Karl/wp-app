<?php

add_filter('zcpri/get-condition-type-group-date_time', 'zcpri_get_condition_type_calendar_time', 10, 2);
if (!function_exists('zcpri_get_condition_type_calendar_time')) {

    function zcpri_get_condition_type_calendar_time($list, $args) {
        $list['calendar_time'] = esc_html__('Time', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_calendar_time_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_calendar_time_fields')) {

    function zcpri_get_condition_type_calendar_time_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'time_type',
                'type' => 'select2',
                'default' => 'from',
                'options' => array(
                    'from' => esc_html__('From', 'zcpri-woopricely'),
                    'to' => esc_html__('To', 'zcpri-woopricely'),
                    'between' => esc_html__('Between', 'zcpri-woopricely'),
                ),
                'fold_id' => 'time_type',
                'width' => '98%',
                'box_width' => '23%',
            ),
            array(
                'id' => 'from_time',
                'type' => 'time',
                'default' => '',
                'placeholder' => esc_html__('00:00:00', 'zcpri-woopricely'),
                'time_format' => 'HH:mm:ss',
                'one_line' => true,
                'fold' => array(
                    'target' => 'time_type',
                    'attribute' => 'value',
                    'value' => 'between',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'width' => '98%',
                'box_width' => '29%',
            ),
            array(
                'id' => 'to_time',
                'type' => 'time',
                'default' => '',
                'placeholder' => esc_html__('00:00:00', 'zcpri-woopricely'),
                'time_format' => 'HH:mm:ss',
                'one_line' => true,
                'fold' => array(
                    'target' => 'time_type',
                    'attribute' => 'value',
                    'value' => 'between',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'width' => '100%',
                'box_width' => '29%',
            ),
            array(
                'id' => 'time',
                'type' => 'time',
                'default' => '',
                'placeholder' => esc_html__('00:00:00', 'zcpri-woopricely'),
                'time_format' => 'HH:mm:ss',
                'one_line' => true,
                'fold' => array(
                    'target' => 'time_type',
                    'attribute' => 'value',
                    'value' => 'between',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'width' => '100%',
                'box_width' => '58%',
            ),
        );

        $fields['calendar_time'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-calendar_time', 'zcpri_validate_condition_calendar_time', 10, 3);
if (!function_exists('zcpri_validate_condition_calendar_time')) {

    function zcpri_validate_condition_calendar_time($rule, $args) {


        if ($rule['time_type'] == 'between') {
            if ($rule['from_time'] == '' || $rule['to_time'] == '') {
                return false;
            }
            $today = WooPricelyUtil::get_current_date(false) . ' ';
            $current_date_time = WooPricelyUtil::get_current_date(true);


            $from_is_valid = WooPricely_Validation_Util::validate_date('>=', $current_date_time, $today . $rule['from_time'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');
            $to_is_valid = WooPricely_Validation_Util::validate_date('<=', $current_date_time, $today . $rule['to_time'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');

            $is_valid = ($from_is_valid == true && $to_is_valid == true);

            if ($is_valid == true) {
                WooPricely_CountDown::set_datetime($today . $rule['to_time']);
            }

            return $is_valid;
        } else {
            if ($rule['time'] == '') {
                return false;
            }
            $today = WooPricelyUtil::get_current_date(false) . ' ';
            $current_date_time = WooPricelyUtil::get_current_date(true);
            $valid_type = '>=';
            if ($rule['time_type'] == 'to') {
                $valid_type = '<=';
            }
            $is_valid = WooPricely_Validation_Util::validate_date($valid_type, $current_date_time, $today . $rule['time'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');

            if ($is_valid == true && $rule['time_type'] == 'to') {
                WooPricely_CountDown::set_datetime($today . $rule['time']);
            }

            return $is_valid;
        }
    }

}
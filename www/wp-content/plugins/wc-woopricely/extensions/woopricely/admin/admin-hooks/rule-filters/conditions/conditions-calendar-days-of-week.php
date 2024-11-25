<?php

add_filter('zcpri/get-condition-type-group-date_time', 'zcpri_get_condition_type_calendar_days_of_week', 10, 2);
if (!function_exists('zcpri_get_condition_type_calendar_days_of_week')) {

    function zcpri_get_condition_type_calendar_days_of_week($list, $args) {
        $list['calendar_days_of_week'] = esc_html__('Days Of Week', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_calendar_days_of_week_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_calendar_days_of_week_fields')) {

    function zcpri_get_condition_type_calendar_days_of_week_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '25%'
            ),
            array(
                'id' => 'days',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Days of week...',
                'allow_clear' => true,
                'options' => array(
                    '0' => esc_html__('Monday', 'zcpri-woopricely'),
                    '1' => esc_html__('Tuesday', 'zcpri-woopricely'),
                    '2' => esc_html__('Wednesday', 'zcpri-woopricely'),
                    '3' => esc_html__('Thursday', 'zcpri-woopricely'),
                    '4' => esc_html__('Friday', 'zcpri-woopricely'),
                    '5' => esc_html__('Saturday', 'zcpri-woopricely'),
                    '6' => esc_html__('Sunday', 'zcpri-woopricely'),
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );


        $fields['calendar_days_of_week'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-calendar_days_of_week', 'zcpri_validate_condition_calendar_days_of_week', 10, 3);
if (!function_exists('zcpri_validate_condition_calendar_days_of_week')) {

    function zcpri_validate_condition_calendar_days_of_week($rule, $args) {
        if (!is_array($rule['days'])) {
            return false;
        }

        $range = WooPricelyUtil::get_date_from_week_days($rule['compare'], $rule['days']);
        if ($range == '') {
            return false;
        }
        $current_date_time = WooPricelyUtil::get_current_date(true);

        $from_is_valid = WooPricely_Validation_Util::validate_date('>=', $current_date_time, $range['from'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');
        $to_is_valid = WooPricely_Validation_Util::validate_date('<=', $current_date_time, $range['to'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');

        $is_valid = ($from_is_valid == true && $to_is_valid == true);

        if ($is_valid == true) {
            WooPricely_CountDown::set_datetime($range['to']);
        }

        return $is_valid;
    }

}
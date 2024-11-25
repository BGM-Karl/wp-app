<?php

add_filter('zcpri/get-condition-type-group-date_time', 'zcpri_get_condition_type_calendar_months_of_year', 10, 2);
if (!function_exists('zcpri_get_condition_type_calendar_months_of_year')) {

    function zcpri_get_condition_type_calendar_months_of_year($list, $args) {
        $list['calendar_months_of_year'] = esc_html__('Months Of Year', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_calendar_months_of_year_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_calendar_months_of_year_fields')) {

    function zcpri_get_condition_type_calendar_months_of_year_fields($fields, $args) {

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
                'box_width' => '25%',
            ),
            array(
                'id' => 'months',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Months...',
                'allow_clear' => true,
                'options' => array(
                    '1' => esc_html__('January', 'zcpri-woopricely'),
                    '2' => esc_html__('February', 'zcpri-woopricely'),
                    '3' => esc_html__('March', 'zcpri-woopricely'),
                    '4' => esc_html__('April', 'zcpri-woopricely'),
                    '5' => esc_html__('May', 'zcpri-woopricely'),
                    '6' => esc_html__('June', 'zcpri-woopricely'),
                    '7' => esc_html__('July', 'zcpri-woopricely'),
                    '8' => esc_html__('August', 'zcpri-woopricely'),
                    '9' => esc_html__('September', 'zcpri-woopricely'),
                    '10' => esc_html__('October', 'zcpri-woopricely'),
                    '11' => esc_html__('November', 'zcpri-woopricely'),
                    '12' => esc_html__('December', 'zcpri-woopricely'),
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );


        $fields['calendar_months_of_year'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-calendar_months_of_year', 'zcpri_validate_condition_calendar_months_of_year', 10, 3);
if (!function_exists('zcpri_validate_condition_calendar_months_of_year')) {

    function zcpri_validate_condition_calendar_months_of_year($rule, $args) {

        if (!is_array($rule['months'])) {
            return false;
        }

        $date_range = WooPricelyUtil::get_date_from_year_months($rule['compare'], $rule['months']);
        if ($date_range == '') {
            return false;
        }
        $current_date_time = WooPricelyUtil::get_current_date(true);

        $from_is_valid = WooPricely_Validation_Util::validate_date('>=', $current_date_time, $date_range['from'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');
        $to_is_valid = WooPricely_Validation_Util::validate_date('<=', $current_date_time, $date_range['to'], 'Y-m-d H:i:s', 'Y-m-d H:i:s');

        $is_valid = ($from_is_valid == true && $to_is_valid == true);

        if ($is_valid == true) {
            WooPricely_CountDown::set_datetime($date_range['to']);
        }
        return $is_valid;
    }

}
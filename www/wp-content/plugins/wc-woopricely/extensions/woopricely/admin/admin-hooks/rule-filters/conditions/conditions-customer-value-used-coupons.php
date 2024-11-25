<?php

add_filter('zcpri/get-condition-type-group-customer_value', 'zcpri_get_condition_type_customer_value_used_coupons', 10, 2);
if (!function_exists('zcpri_get_condition_type_customer_value_used_coupons')) {

    function zcpri_get_condition_type_customer_value_used_coupons($list, $args) {
        $list['customer_value_used_coupons'] = esc_html__('Used Coupons', 'zcpri-woopricely');
         $list['customer_value_never_use_coupons'] = esc_html__('Never Use Coupons', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_customer_value_used_coupons_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_customer_value_used_coupons_fields')) {

    function zcpri_get_condition_type_customer_value_used_coupons_fields($fields, $args) {

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
                'id' => 'all_time_applied_coupons',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Coupons...',
                'data' => 'posts:shop_coupon',
               'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '64%',
            ),
             array(
                'id' => 'applied_coupons',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Coupons...',
                'data' => 'posts:shop_coupon',
               'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '49%',
            ),
        );

        $fields['customer_value_used_coupons'] = $flds;
        $fields['customer_value_never_use_coupons'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-customer_value_used_coupons', 'zcpri_validate_condition_customer_value_used_coupons', 10, 3);
if (!function_exists('zcpri_validate_condition_customer_value_used_coupons')) {

    function zcpri_validate_condition_customer_value_used_coupons($rule, $args) {


        $rule_applied_coupons = $rule['all_time_applied_coupons'];
        if ($rule['date_type'] != 'all_time' && $rule['date_type'] != '') {
            $rule_applied_coupons = $rule['applied_coupons'];
        }
        if(!is_array($rule_applied_coupons)){
            return false;
        }

        $from_date = WooPricelyUtil::get_date_from_rule_value($rule);

        $coupons = WooPricelyUtil::get_customer_coupon_used(get_current_user_id(), $from_date);
  
    
        return WooPricely_Validation_Util::validate_list_list($coupons, $rule_applied_coupons, 'in_list');
    }

}


add_filter('zcpri/validate-condition-customer_value_never_use_coupons', 'zcpri_validate_condition_customer_value_never_use_coupons', 10, 3);
if (!function_exists('zcpri_validate_condition_customer_value_never_use_coupons')) {

    function zcpri_validate_condition_customer_value_never_use_coupons($rule, $args) {


        $rule_applied_coupons = $rule['all_time_applied_coupons'];
        if ($rule['date_type'] != 'all_time' && $rule['date_type'] != '') {
            $rule_applied_coupons = $rule['applied_coupons'];
        }
        if(!is_array($rule_applied_coupons)){
            return false;
        }

        $from_date = WooPricelyUtil::get_date_from_rule_value($rule);

        $coupons = WooPricelyUtil::get_customer_coupon_used(get_current_user_id(), $from_date);
     
        return !(WooPricely_Validation_Util::validate_list_list($coupons, $rule_applied_coupons, 'in_list'));
    }

}
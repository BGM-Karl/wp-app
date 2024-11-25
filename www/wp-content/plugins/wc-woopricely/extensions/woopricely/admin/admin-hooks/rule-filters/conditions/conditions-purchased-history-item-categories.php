<?php

add_filter('zcpri/get-condition-type-group-purchased_history', 'zcpri_get_condition_type_purchased_categories', 10, 2);
if (!function_exists('zcpri_get_condition_type_purchased_categories')) {

    function zcpri_get_condition_type_purchased_categories($list, $args) {
        $list['purchased_categories'] = esc_html__('Bought Categories', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_purchased_categories_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_purchased_categories_fields')) {

    function zcpri_get_condition_type_purchased_categories_fields($fields, $args) {

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
                'box_width' => '16%',
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
                    'in_list' => esc_html__('Any in list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all in list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in list', 'zcpri-woopricely'),
                ),
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '98%',
                'box_width' => '22%',
            ),
            array(
                'id' => 'all_time_compare',
                'type' => 'select2',
                'default' => '>=',
                'options' => array(
                    'in_list' => esc_html__('Any in list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all in list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in list', 'zcpri-woopricely'),
                ),
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'all_time_category_ids',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => 'Product categories...',
                'data' => 'categories:product_cat',
                'width' => '100%',
                'box_width' => '40%',
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
            ),
            array(
                'id' => 'category_ids',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => 'Product categories...',
                'data' => 'categories:product_cat',
                'width' => '100%',
                'box_width' => '28%',
                'fold' => array(
                    'target' => 'date_type',
                    'attribute' => 'value',
                    'value' => 'all_time',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
            ),
        );

        $fields['purchased_categories'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-purchased_categories', 'zcpri_validate_condition_purchased_categories', 10, 3);
if (!function_exists('zcpri_validate_condition_purchased_categories')) {

    function zcpri_validate_condition_purchased_categories($rule, $args) {


        $compare = $rule['all_time_compare'];
        if ($rule['date_type'] != 'all_time' && $rule['date_type'] != '') {
            $compare = $rule['compare'];
        }
        $rule_category_ids = $rule['all_time_category_ids'];
        if ($rule['date_type'] != 'all_time' && $rule['date_type'] != '') {
            $rule_category_ids = $rule['category_ids'];
        }
        if ($rule_category_ids == '') {
            return false;
        }

        $from_date = WooPricelyUtil::get_date_from_rule_value($rule);

        $category_ids = WooPricelyUtil::get_purchase_history(get_current_user_id(), 'category_ids', $from_date, true, true);
        
        if (count($category_ids) == 0) {
            return false;
        }

        return WooPricely_Validation_Util::validate_list_list($category_ids, $rule_category_ids, $compare);

    }

}
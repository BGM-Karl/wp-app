<?php

add_filter('zcpri/get-condition-type-group-cart', 'zcpri_get_condition_type_coupons', 10, 2);
if (!function_exists('zcpri_get_condition_type_coupons')) {

    function zcpri_get_condition_type_coupons($list, $args) {
        $list['cart_coupons'] = esc_html__('Applied Coupons','zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_coupons_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_coupons_fields')) {

    function zcpri_get_condition_type_cart_coupons_fields($fields, $args) {

        
      
        $fields['cart_coupons'] = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'any' => esc_html__('Any list?', 'zcpri-woopricely'),
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in the list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in the list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all in the list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'fold_id' => 'coupons_compare',
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'is_any',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                'fold' => array(
                    'target' => 'coupons_compare',
                    'attribute' => 'value',
                    'value' => 'any',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                    
                ),
                'width' => '100%',
                'box_width' => '56%',
            ),
            array(
                'id' => 'applied_coupons',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Coupons...',
                'data' => 'posts:shop_coupon',
                'fold' => array(
                    'target' => 'coupons_compare',
                    'attribute' => 'value',
                    'value' => 'any',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}


add_filter('zcpri/validate-condition-cart_coupons', 'zcpri_validate_condition_cart_coupons', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_coupons')) {

    function zcpri_validate_condition_cart_coupons($rule, $args) {
        $applied_coupons = WooPricelyUtil::get_applied_coupons_ids();

        if ($rule['compare'] == 'any') {
            
            return WooPricely_Validation_Util::validate_list_empty($applied_coupons, $rule['is_any']);
        } else {
            
            if (!is_array($rule['applied_coupons'])) {
                return false;
            }

            return WooPricely_Validation_Util::validate_list_list($applied_coupons, $rule['applied_coupons'], $rule['compare']);
        }
    }

}
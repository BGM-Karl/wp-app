<?php

add_filter('zcpri/get-condition-type-group-purchased_history_value', 'zcpri_get_condition_type_purchased_subtotal_exc_tax_categories', 10, 2);
if (!function_exists('zcpri_get_condition_type_purchased_subtotal_exc_tax_categories')) {

    function zcpri_get_condition_type_purchased_subtotal_exc_tax_categories($list, $args) {
        $list['purchased_subtotal_exc_tax_categories'] = esc_html__('Bought Categories Value', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_purchased_subtotal_exc_tax_categories_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_purchased_subtotal_exc_tax_categories_fields')) {

    function zcpri_get_condition_type_purchased_subtotal_exc_tax_categories_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'category_ids',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => 'Product categories...',
                'data' => 'categories:product_cat',
                'width' => '98%',
                'box_width' => '35%',
            ),
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => '>',
                'options' => array(
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '31%',
            ),
            array(
                'id' => 'subtotal_exc_tax',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '15%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );

        $fields['purchased_subtotal_exc_tax_categories'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-purchased_subtotal_exc_tax_categories', 'zcpri_validate_condition_purchased_subtotal_exc_tax_categories', 10, 3);
if (!function_exists('zcpri_validate_condition_purchased_subtotal_exc_tax_categories')) {

    function zcpri_validate_condition_purchased_subtotal_exc_tax_categories($rule, $args) {

        if (!is_array($rule['category_ids'])) {
            return false;
        }

        $subtotal = WooPricelyUtil::get_purchase_history_subtotal(get_current_user_id(), 'category_ids', $rule['category_ids'], '', true, true);

        return WooPricely_Validation_Util::validate_value($rule['compare'], $subtotal, $rule['subtotal_exc_tax'], 'no');
    }

}
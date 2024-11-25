<?php


add_filter('zcpri/get-condition-type-group-purchased_history_value', 'zcpri_get_condition_type_purchased_subtotal_exc_tax_product', 10, 2);
if (!function_exists('zcpri_get_condition_type_purchased_subtotal_exc_tax_product')) {

    function zcpri_get_condition_type_purchased_subtotal_exc_tax_product($list, $args) {
        $list['purchased_subtotal_exc_tax_product'] = esc_html__('Bought Products Value', 'zcpri-woopricely');

        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_purchased_subtotal_exc_tax_product_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_purchased_subtotal_exc_tax_product_fields')) {

    function zcpri_get_condition_type_purchased_subtotal_exc_tax_product_fields($fields, $args) {

        $flds = array(
            array(
                'id' => 'product_ids',
                'type' => 'select2',
                'multiple' => true,
                'minimum_input_length' => 2,
                'placeholder' => 'Search products...',
                'allow_clear' => true,
                'minimum_results_forsearch' => 10,
                'data' => array(
                    'source' => 'wc:products',
                    'ajax' => true,
                    'value_col' => 'id',
                    'value_col_pre' => '#',
                    'show_value' => true,
                ),
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

        $fields['purchased_subtotal_exc_tax_product'] = $flds;
        return $fields;
    }

}

add_filter('zcpri/validate-condition-purchased_subtotal_exc_tax_product', 'zcpri_validate_condition_purchased_subtotal_exc_tax_product', 10, 3);
if (!function_exists('zcpri_validate_condition_purchased_subtotal_exc_tax_product')) {

    function zcpri_validate_condition_purchased_subtotal_exc_tax_product($rule, $args) {

        if (!is_array($rule['product_ids'])) {
            return false;
        }

        $subtotal = WooPricelyUtil::get_purchase_history_subtotal(get_current_user_id(), 'product_ids', $rule['product_ids'], '', true, true);

        return WooPricely_Validation_Util::validate_value($rule['compare'], $subtotal, $rule['subtotal_exc_tax'], 'no');
    }

}
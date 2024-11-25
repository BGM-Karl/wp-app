<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_weight', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_weight')) {

    function zcpri_get_product_rule_type_weight($list, $args) {
        $weight_text = str_replace('[0]', get_option('woocommerce_weight_unit'), esc_html__('Product Weight ([0])', 'zcpri-woopricely'));
        $list['weight'] = $weight_text;
        return $list;
    }

}



add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_product_weight_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_product_weight_fields')) {

    function zcpri_get_product_rule_type_product_weight_fields($fields, $args) {

        $fld = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => '>=',
                'options' => array(
                    'empty' => esc_html__('Empty', 'zcpri-woopricely'),
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                ),
                'fold_id' => 'weight_compare',
                'width' => '99%',
                'box_width' => '44%',
            ),
            array(
                'id' => 'weight',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '37%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
                'fold' => array(
                    'target' => 'weight_compare',
                    'attribute' => 'value',
                    'value' => 'empty',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
            ),
            array(
                'id' => 'yes_no',
                'type' => 'select2',
                'default' => '>=',
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                'fold' => array(
                    'target' => 'weight_compare',
                    'attribute' => 'value',
                    'value' => 'empty',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '37%',
            ),
        );


        $fields['weight'] = $fld;
        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-weight', 'zcpri_validate_product_filter_weight', 10, 3);
if (!function_exists('zcpri_validate_product_filter_weight')) {

    function zcpri_validate_product_filter_weight($product, $rule, $args) {

        $yes_no = 'no';
        $rule_value = '';
        if (isset($rule['yes_no'])) {
            $yes_no = $rule['yes_no'];
        }
        if (isset($rule['weight'])) {
            $rule_value = $rule['weight'];
        }




        $weight = wc_get_product($product['id'])->get_weight(false);
        if ($weight != '') {
            $weight = (float) $weight;
        }

        return WooPricely_Validation_Util::validate_value($rule['compare'], $weight, $rule_value, $yes_no);
    }

}
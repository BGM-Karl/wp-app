<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_stock_quantity', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_stock_quantity')) {

    function zcpri_get_product_rule_type_stock_quantity($list, $args) {
        $list['stock_quantity'] = esc_html__('Product Stock Quantity', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_product_stock_quantity_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_product_stock_quantity_fields')) {

    function zcpri_get_product_rule_type_product_stock_quantity_fields($fields, $args) {

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
                'fold_id' => 'stock_compare',
                'width' => '99%',
                'box_width' => '44%',
            ),
            array(
                'id' => 'stock_qty',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0',
                'placeholder' => esc_html__('0', 'zcpri-woopricely'),
                'width' => '100%',
                'box_width' => '37%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
                'fold' => array(
                    'target' => 'stock_compare',
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
                    'target' => 'stock_compare',
                    'attribute' => 'value',
                    'value' => 'empty',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '37%',
            ),
        );


        $fields['stock_quantity'] = $fld;
        return $fields;
    }

}

add_filter('zcpri/validate-product-filter-stock_quantity', 'zcpri_validate_product_filter_stock_quantity', 10, 3);
if (!function_exists('zcpri_validate_product_filter_stock_quantity')) {

    function zcpri_validate_product_filter_stock_quantity($product, $rule, $args) {
        $yes_no = 'no';
        $rule_value = '';
        if (isset($rule['yes_no'])) {
            $yes_no = $rule['yes_no'];
        }
        if (isset($rule['stock_qty'])) {
            $rule_value = $rule['stock_qty'];
        }


        $stock_quantity = wc_get_product($product['id'])->get_stock_quantity(false);
        return WooPricely_Validation_Util::validate_value($rule['compare'], $stock_quantity, $rule_value, $yes_no);
    }

}
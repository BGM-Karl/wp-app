<?php

add_filter('zcpri/get-product-rule-type-group-product_prices', 'zcpri_get_product_rule_type_product_prices', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_prices')) {

    function zcpri_get_product_rule_type_product_prices($list, $args) {
        $currency = get_woocommerce_currency_symbol(get_woocommerce_currency());
        $list['regular_price'] = str_replace('[0]', $currency, esc_html__('Product Regular Price ([0])', 'zcpri-woopricely'));
        $list['sale_price'] = str_replace('[0]', $currency, esc_html__('Product Sales Price ([0])', 'zcpri-woopricely'));
        $list['price'] = str_replace('[0]', $currency, esc_html__('Product Price ([0])', 'zcpri-woopricely'));
        return $list;
    }

}

add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_product_prices_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_product_prices_fields')) {

    function zcpri_get_product_rule_type_product_prices_fields($fields, $args) {

        $compare = array(
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
            'fold_id' => 'regular_price_compare',
            'width' => '99%',
            'box_width' => '44%',
        );
        $fld = array();

        $fld[] = $compare;


        $fld[] = array(
            'id' => 'regular_price',
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
                'target' => 'regular_price_compare',
                'attribute' => 'value',
                'value' => 'empty',
                'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
            ),
        );

        $fld[] = array(
            'id' => 'yes_no',
            'type' => 'select2',
            'default' => '>=',
            'options' => array(
                'no' => esc_html__('No', 'zcpri-woopricely'),
                'yes' => esc_html__('Yes', 'zcpri-woopricely'),
            ),
            'fold' => array(
                'target' => 'regular_price_compare',
                'attribute' => 'value',
                'value' => 'empty',
                'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                'clear' => false,
            ),
            'width' => '100%',
            'box_width' => '37%',
        );
        $fields['regular_price'] = $fld;


        $compare['fold_id'] = 'sale_price_compare';
        $fld = array();
        $fld[] = $compare;

        $fld[] = array(
            'id' => 'sale_price',
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
                'target' => 'sale_price_compare',
                'attribute' => 'value',
                'value' => 'empty',
                'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                'clear' => true,
            ),
        );

        $fld[] = array(
            'id' => 'yes_no',
            'type' => 'select2',
            'default' => '>=',
            'options' => array(
                'no' => esc_html__('No', 'zcpri-woopricely'),
                'yes' => esc_html__('Yes', 'zcpri-woopricely'),
            ),
            'fold' => array(
                'target' => 'sale_price_compare',
                'attribute' => 'value',
                'value' => 'empty',
                'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                'clear' => false,
            ),
            'width' => '100%',
            'box_width' => '37%',
        );
        $fields['sale_price'] = $fld;


        $compare['fold_id'] = 'price_compare';
        $fld = array();
        $fld[] = $compare;

        $fld[] = array(
            'id' => 'price',
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
                'target' => 'price_compare',
                'attribute' => 'value',
                'value' => 'empty',
                'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                'clear' => true,
            ),
        );

        $fld[] = array(
            'id' => 'yes_no',
            'type' => 'select2',
            'default' => '>=',
            'options' => array(
                'no' => esc_html__('No', 'zcpri-woopricely'),
                'yes' => esc_html__('Yes', 'zcpri-woopricely'),
            ),
            'fold' => array(
                'target' => 'price_compare',
                'attribute' => 'value',
                'value' => 'empty',
                'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                'clear' => false,
            ),
            'width' => '100%',
            'box_width' => '37%',
        );
        $fields['price'] = $fld;


        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-regular_price', 'zcpri_validate_product_filter_prices', 10, 3);
add_filter('zcpri/validate-product-filter-sale_price', 'zcpri_validate_product_filter_prices', 10, 3);
add_filter('zcpri/validate-product-filter-price', 'zcpri_validate_product_filter_prices', 10, 3);
if (!function_exists('zcpri_validate_product_filter_prices')) {

    function zcpri_validate_product_filter_prices($product, $rule, $args) {

        $yes_no = 'no';
        $rule_value = '';
        if (isset($rule['yes_no'])) {
            $yes_no = $rule['yes_no'];
        }
        if (isset($rule['regular_price'])) {
            $rule_value = $rule['regular_price'];
        }

        if (isset($rule['sale_price'])) {
            $rule_value = $rule['sale_price'];
        }
        if (isset($rule['price'])) {
            $rule_value = $rule['price'];
        }


        $price = '';
        if (isset($rule['regular_price'])) {
            $price = wc_get_product($product['id'])->get_regular_price(false);
        }
        if (isset($rule['sale_price'])) {
            $price = wc_get_product($product['id'])->get_sale_price(false);
        }
        if (isset($rule['price'])) {
            $price = wc_get_product($product['id'])->get_price(false);
        }

        return WooPricely_Validation_Util::validate_value($rule['compare'], $price, $rule_value, $yes_no);
    }

}
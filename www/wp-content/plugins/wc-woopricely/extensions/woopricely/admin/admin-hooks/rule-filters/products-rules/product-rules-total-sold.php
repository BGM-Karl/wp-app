<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_sale_total', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_sale_total')) {

    function zcpri_get_product_rule_type_product_sale_total($list, $args) {
        $list['total_sold'] = esc_html__('Product Total Sold', 'zcpri-woopricely');
        return $list;
    }

}



add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_product_total_sold_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_product_total_sold_fields')) {

    function zcpri_get_product_rule_type_product_total_sold_fields($fields, $args) {

        $fld = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => '>=',
                'options' => array(
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                ),
                'width' => '99%',
                'box_width' => '44%',
            ),
            array(
                'id' => 'total_sold',
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
            ),
        );


        $fields['total_sold'] = $fld;
        return $fields;
    }

}


add_filter('zcpri/validate-product-filter-total_sold', 'zcpri_validate_product_filter_total_sold', 10, 3);
if (!function_exists('zcpri_validate_product_filter_total_sold')) {

    function zcpri_validate_product_filter_total_sold($product, $rule, $args) {
        $total_sales = wc_get_product($product['id'])->get_total_sales(false);
        if ($total_sales == '') {
            $total_sales = 0;
        }
        return WooPricely_Validation_Util::validate_value($rule['compare'], $total_sales, $rule['total_sold'], 'no');
    }

}
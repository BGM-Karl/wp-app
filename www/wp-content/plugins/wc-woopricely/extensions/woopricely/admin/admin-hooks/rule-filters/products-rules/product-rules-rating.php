<?php

add_filter('zcpri/get-product-rule-type-group-product_properties', 'zcpri_get_product_rule_type_product_rating', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_product_rating')) {

    function zcpri_get_product_rule_type_product_rating($list, $args) {
        $list['average_rating'] = esc_html__('Product Average Rating', 'zcpri-woopricely');
        $list['rating_count'] = esc_html__('Product Rating Count', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_product_average_rating_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_product_average_rating_fields')) {

    function zcpri_get_product_rule_type_product_average_rating_fields($fields, $args) {

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
                'width' => '190px',
            ),
            array(
                'id' => 'total_sold',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0.00',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '173px',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
            ),
        );


        $fields['average_rating'] = $fld;
        return $fields;
    }

}

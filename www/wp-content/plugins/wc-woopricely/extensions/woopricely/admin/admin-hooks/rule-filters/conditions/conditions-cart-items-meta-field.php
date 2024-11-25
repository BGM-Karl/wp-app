<?php

add_filter('zcpri/get-condition-type-group-cart_items', 'zcpri_get_condition_type_cart_items_meta', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_meta')) {

    function zcpri_get_condition_type_cart_items_meta($list, $args) {
        $list['cart_items_meta'] = esc_html__('Product Meta Field In Cart', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_meta_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_meta_fields')) {

    function zcpri_get_condition_type_cart_items_meta_fields($fields, $args) {
        $fld = array(
            array(
                'id' => 'meta_key',
                'type' => 'textbox',
                'input_type' => 'text',
                'default' => '',
                'placeholder' => esc_html__('Meta field key', 'zcpri-woopricely'),
                'width' => '98%',
                'box_width' => '33%',
            ),
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'empty',
                'options' => array(
                    'empty' => esc_html__('Empty', 'zcpri-woopricely'),
                    'contains' => esc_html__('Contains', 'zcpri-woopricely'),
                    'not_contains' => esc_html__('Not contains', 'zcpri-woopricely'),
                    'begins' => esc_html__('Begins with', 'zcpri-woopricely'),
                    'ends' => esc_html__('Ends with', 'zcpri-woopricely'),
                    '>=' => esc_html__('More than or equal to', 'zcpri-woopricely'),
                    '>' => esc_html__('More than', 'zcpri-woopricely'),
                    '<=' => esc_html__('Less than or equal to', 'zcpri-woopricely'),
                    '<' => esc_html__('Less than', 'zcpri-woopricely'),
                    '==' => esc_html__('Equal to', 'zcpri-woopricely'),
                    '!=' => esc_html__('Not equal to', 'zcpri-woopricely'),
                    'checked' => esc_html__('Checked', 'zcpri-woopricely'),
                ),
                'fold_id' => 'meta_field_compare',
                'width' => '98%',
                'box_width' => '31%',
            ),
            array(
                'id' => 'meta_value',
                'type' => 'textbox',
                'input_type' => 'text',
                'default' => '',
                'placeholder' => esc_html__('Value', 'zcpri-woopricely'),
                'fold' => array(
                    'target' => 'meta_field_compare',
                    'attribute' => 'value',
                    'value' => array('contains', 'not_contains', 'begins', 'ends', '>=', '>', '<=', '<', '==', '!='),
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '17%',
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
                    'target' => 'meta_field_compare',
                    'attribute' => 'value',
                    'value' => array('empty', 'checked'),
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '17%',
            ),
        );


        $fields['cart_items_meta'] = $fld;
        return $fields;
    }

}


add_filter('zcpri/validate-condition-cart_items_meta', 'zcpri_validate_condition_cart_items_meta', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_meta')) {

    function zcpri_validate_condition_cart_items_meta($rule, $args) {
        $yes_no = 'no';
        $rule_value = '';
        if (isset($rule['yes_no'])) {
            $yes_no = $rule['yes_no'];
        }
        if (isset($rule['meta_value'])) {
            $rule_value = $rule['meta_value'];
        }

        $found = false;
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (isset($product['id'])) {


                $prod = wc_get_product($product['id']);
                $meta_value = get_post_meta($product['id'], $rule['meta_key'], true);
                $fnd = WooPricely_Validation_Util::validate_value($rule['compare'], $meta_value, $rule_value, $yes_no);
                if ($fnd == true) {
                    $found = $fnd;
                }
            }
        }

        return $found;
    }

}
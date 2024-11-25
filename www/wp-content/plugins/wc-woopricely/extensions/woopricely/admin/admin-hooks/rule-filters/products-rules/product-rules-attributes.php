<?php

add_filter('zcpri/get-product-rule-type-group-products', 'zcpri_get_product_rule_type_attributes', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_attributes')) {

    function zcpri_get_product_rule_type_attributes($list, $args) {
        $list['attributes'] = esc_html__('Product Attributes', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_attributes_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_attributes_fields')) {

    function zcpri_get_product_rule_type_attributes_fields($fields, $args) {

        $fields['attributes'] = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'any' => esc_html__('Any list?', 'zcpri-woopricely'),
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in the list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in the list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'fold_id' => 'attr_compare',
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
                    'target' => 'attr_compare',
                    'attribute' => 'value',
                    'value' => 'any',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                 'width' => '100%',
                'box_width' => '56%',
            ),
            array(
                'id' => 'attribute_ids',
                'type' => 'select2',
                'multiple' => true,
                'minimum_input_length' => 1,
                'placeholder' => 'Search attributes...',
                'allow_clear' => true,
                'minimum_results_forsearch' => 10,
                'ajax_data' => 'wc:attributes',
                'fold' => array(
                    'target' => 'attr_compare',
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



add_filter('zcpri/validate-product-filter-attributes', 'zcpri_validate_product_filter_attributes', 10, 3);
if (!function_exists('zcpri_validate_product_filter_attributes')) {

    function zcpri_validate_product_filter_attributes($product, $rule, $args) {


        $attrs = array();
        $db_attrs = wc_get_product($product['id'])->get_attributes();

        foreach ($db_attrs as $db_attr) {
            foreach ($db_attr->get_options() as $attr_option) {
                $attrs[] = $attr_option;
            }
        }


        if ($rule['compare'] == 'any') {
            return WooPricely_Validation_Util::validate_list_empty($attrs, $rule['is_any']);
        } else {
            if (!is_array($rule['attribute_ids'])) {
                return false;
            }
            return WooPricely_Validation_Util::validate_list_list($attrs, $rule['attribute_ids'], $rule['compare']);
        }
    }

}
<?php

add_filter('zcpri/get-product-rule-type-group-products', 'zcpri_get_product_rule_type_categories', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_categories')) {

    function zcpri_get_product_rule_type_categories($list, $args) {
        $list['categories'] = esc_html__('Product Categories', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_categories_fields', 10, 2);

if (!function_exists('zcpri_get_product_rule_type_categories_fields')) {

    function zcpri_get_product_rule_type_categories_fields($fields, $args) {

        $fields['categories'] = array(
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
                'fold_id' => 'compare',
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'is_any',
                'type' => 'select2',
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                'fold' => array(
                    'target' => 'compare',
                    'attribute' => 'value',
                    'value' => 'any',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '56%',
            ),
            array(
                'id' => 'category_ids',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Product categories...',
                'data' => 'categories:product_cat',
                'fold' => array(
                    'target' => 'compare',
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


add_filter('zcpri/validate-product-filter-categories', 'zcpri_validate_product_filter_categories', 10, 3);
if (!function_exists('zcpri_validate_product_filter_categories')) {

    function zcpri_validate_product_filter_categories($product, $rule, $args) {
        if ($rule['compare'] == 'any') {
            return WooPricely_Validation_Util::validate_list_empty($product['categories'], $rule['is_any']);
        } else {
            if (!is_array($rule['category_ids'])) {
                return false;
            }
            return WooPricely_Validation_Util::validate_list_list($product['categories'], $rule['category_ids'], $rule['compare']);
        }
    }

}








add_filter('zcpri/get-products-categories', 'zcpri_get_products_categories', 10, 3);
if (!function_exists('zcpri_get_products_categories')) {

    function zcpri_get_products_categories($result, $rule, $qty) {

        if (!is_array($rule['category_ids'])) {
            return $result;
        }


        $args = array(
            'category' => array($rule['category_ids']),
            'orderby' => 'name',
        );
        if ($rule['compare'] != 'none') {
            return WooPricely::get_products_from_database($result, $args, $qty, false);
        } else {
            return WooPricely::get_products_from_database($result, $args, $qty, true);
        }
    }

}
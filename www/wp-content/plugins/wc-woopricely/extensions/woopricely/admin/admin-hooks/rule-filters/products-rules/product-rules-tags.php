<?php

add_filter('zcpri/get-product-rule-type-group-products', 'zcpri_get_product_rule_type_tags', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_tags')) {

    function zcpri_get_product_rule_type_tags($list, $args) {
        $list['tags'] = esc_html__('Product Tags', 'zcpri-woopricely');
        return $list;
    }

}


add_filter('zcpri/get-product-rule-type-fields', 'zcpri_get_product_rule_type_tags_fields', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_tags_fields')) {

    function zcpri_get_product_rule_type_tags_fields($fields, $args) {

        $fields['tags'] = array(
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
                'fold_id' => 'tag_compare',
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
                    'target' => 'tag_compare',
                    'attribute' => 'value',
                    'value' => 'any',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
                'width' => '100%',
                'box_width' => '56%',
            ),
            array(
                'id' => 'tag_ids',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Product tags...',
                'data' => 'categories:product_tag',
                'fold' => array(
                    'target' => 'tag_compare',
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



add_filter('zcpri/validate-product-filter-tags', 'zcpri_validate_product_filter_tags', 10, 3);
if (!function_exists('zcpri_validate_product_filter_tags')) {

    function zcpri_validate_product_filter_tags($product, $rule, $args) {

        if ($rule['compare'] == 'any') {
            return WooPricely_Validation_Util::validate_list_empty($product['tags'], $rule['is_any']);
        } else {
            if (!is_array($rule['tag_ids'])) {
                return false;
            }

            return WooPricely_Validation_Util::validate_list_list($product['tags'], $rule['tag_ids'], $rule['compare']);
        }

    }

}


add_filter('zcpri/get-products-tags', 'zcpri_get_products_tags', 10, 3);
if (!function_exists('zcpri_get_products_tags')) {

    function zcpri_get_products_tags($result, $rule, $qty) {

        if (!is_array($rule['tag_ids'])) {
            return $result;
        }


        $args = array(
            'tag' => array($rule['tag_ids']),
            'orderby' => 'name',
        );
        if ($rule['compare'] != 'none') {
            return WooPricely::get_products_from_database($result, $args, $qty, false);
        } else {
            return WooPricely::get_products_from_database($result, $args, $qty, true);
        }
    }

}
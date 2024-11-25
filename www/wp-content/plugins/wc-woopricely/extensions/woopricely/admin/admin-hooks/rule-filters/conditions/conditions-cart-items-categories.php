<?php

add_filter('zcpri/get-condition-type-group-cart_items', 'zcpri_get_condition_type_cart_items_categories', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_categories')) {

    function zcpri_get_condition_type_cart_items_categories($list, $args) {

        $list['cart_items_categories'] = esc_html__('Categories In Cart', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_categories_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_categories_fields')) {

    function zcpri_get_condition_type_cart_items_categories_fields($fields, $args) {

        $fields['cart_items_categories'] = array(
            array(
                'id' => 'compare',
                'type' => 'select2',
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__('Any in the list', 'zcpri-woopricely'),
                    'in_all_list' => esc_html__('All in the list', 'zcpri-woopricely'),
                    'in_list_only' => esc_html__('Only in the list', 'zcpri-woopricely'),
                    'in_all_list_only' => esc_html__('Only all in the list', 'zcpri-woopricely'),
                    'none' => esc_html__('None in the list', 'zcpri-woopricely'),
                ),
                'width' => '98%',
                'box_width' => '25%',
            ),
            array(
                'id' => 'category_ids',
                'type' => 'select2',
                'multiple' => true,
                'allow_clear' => true,
                'placeholder' => 'Product categories...',
                'data' => 'categories:product_cat',
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}

add_filter('zcpri/validate-condition-cart_items_categories', 'zcpri_validate_condition_cart_items_categories', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_categories')) {

    function zcpri_validate_condition_cart_items_categories($rule, $args) {
        $category_ids = array();
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (isset($product['categories'])) {
                foreach ($product['categories'] as $category_id) {
                    $category_ids[] = $category_id;
                }
            }
        }
        if (!is_array($rule['category_ids'])) {
            return false;
        }
        if (count($category_ids) == 0) {
            return false;
        }

        return WooPricely_Validation_Util::validate_list_list($category_ids, $rule['category_ids'], $rule['compare']);
    }

}

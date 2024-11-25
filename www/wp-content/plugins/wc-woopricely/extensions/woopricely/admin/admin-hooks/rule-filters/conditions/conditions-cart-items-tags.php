<?php

add_filter('zcpri/get-condition-type-group-cart_items', 'zcpri_get_condition_type_cart_items_tags', 10, 2);
if (!function_exists('zcpri_get_condition_type_cart_items_tags')) {

    function zcpri_get_condition_type_cart_items_tags($list, $args) {
        $list['cart_items_tags'] = esc_html__('Tags In Cart', 'zcpri-woopricely');
        return $list;
    }

}

add_filter('zcpri/get-condition-type-fields', 'zcpri_get_condition_type_cart_items_tags_fields', 10, 2);

if (!function_exists('zcpri_get_condition_type_cart_items_tags_fields')) {

    function zcpri_get_condition_type_cart_items_tags_fields($fields, $args) {

        $fields['cart_items_tags'] = array(
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
                'id' => 'tag_ids',
                'type' => 'select2',
                'multiple' => true,
                'placeholder' => 'Product tags...',
                'allow_clear' => true,
                'data' => 'categories:product_tag',
                'width' => '100%',
                'box_width' => '56%',
            )
        );
        return $fields;
    }

}


add_filter('zcpri/validate-condition-cart_items_tags', 'zcpri_validate_condition_cart_items_tags', 10, 3);
if (!function_exists('zcpri_validate_condition_cart_items_tags')) {

    function zcpri_validate_condition_cart_items_tags($rule, $args) {
        $tag_ids = array();
        foreach (WooPricely::get_products_from_cart() as $product) {
            if (isset($product['tags'])) {
                foreach ($product['tags'] as $tag_id) {
                    $tag_ids[] = $tag_id;
                }
            }
        }
        if (!is_array($rule['tag_ids'])) {
            return false;
        }
        if (count($tag_ids) == 0) {
            return false;
        }

        return WooPricely_Validation_Util::validate_list_list($tag_ids, $rule['tag_ids'], $rule['compare']);
    }

}
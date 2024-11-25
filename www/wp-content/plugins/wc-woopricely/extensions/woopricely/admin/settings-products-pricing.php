<?php

add_filter('reon/get-option-page-' . $option_name . '-sections', 'dpd_get_config_products_price_section', 20);

function dpd_get_config_products_price_section($in_sections) {
    $in_sections[] = array(
        'title' => esc_html__('Products Pricing', 'zcpri-woopricely'),
        'id' => 'product_price',
    );
    return $in_sections;
}

add_filter('get-option-page-' . $option_name . 'section-product_price-fields', 'zc_get_dpd_config_sections_product_price');

function zc_get_dpd_config_sections_product_price($in_fields) {
    $in_fields[] = array(
        'id' => 'module_title',
        'type' => 'paneltitle',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Product Pricing Rules', 'zcpri-woopricely'),
        'desc' => esc_html__('Create unlimited number product pricing rules', 'zcpri-woopricely'),
    );
   
    $in_fields[] = array(
        'id' => 'products_pricing',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 7,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'max_discount_type',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Discount Limit Per Product', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls discount pricing limit per product', 'zcpri-woopricely'),
                        'default' => 'before_add_to_cart',
                        'options' => array(
                            'no' => esc_html__('No limit', 'zcpri-woopricely'),
                            'amount' => esc_html__('Discount amount', 'zcpri-woopricely'),
                            'per' => esc_html__('Percentage Discount', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                        'fold_id' => 'max_discount_type',
                    ),
                    array(
                        'id' => 'max_discount_amount',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 2,
                        'column_title' => esc_html__('Limit', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls discount limit amount', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '1',
                        ),
                        'fold' => array(
                            'target' => 'max_discount_type',
                            'attribute' => 'value',
                            'value' => 'no',
                            'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                        ),
                    ),
                    array(
                        'id' => 'mode',
                        'type' => 'select2',
                        'column_size' => 3,
                        'column_title' => esc_html__('Rules Apply Mode Per Product', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls pricing rules apply mode', 'zcpri-woopricely'),
                        'default' => 'yes',
                        'options' => array(
                            'all' => esc_html__('Apply all valid rules', 'zcpri-woopricely'),
                            'bigger' => esc_html__('Apply rules with bigger price per product', 'zcpri-woopricely'),
                            'smaller' => esc_html__('Apply rules with smaller price per product', 'zcpri-woopricely'),
                            'first' => esc_html__('Apply first valid rule per product', 'zcpri-woopricely'),
                            'last' => esc_html__('Apply last valid rule per product', 'zcpri-woopricely'),
                            'no' => esc_html__('Do not apply any rule', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                    ),
                ),
            ),
        ),
    );

     
    $in_fields[] = array(
        'id' => 'products_pricing_rules',
        'type' => 'repeater',
        'full_width' => true,
        'center_head' => true,
        'white_repeater' => false,
        'repeater_size' => 'small',
        'accordions' => true,
        'buttons_sep' => false,
        'delete_button' => true,
        'clone_button' => true,        
        'width' => '100%',
        'auto_expand' => array(
            'new_section' => true,
            'cloned_section' => true,
        ),
        'sortable' => array(
            'enabled' => true,
        ),
        'template_adder' => array(
            'position' => 'right',
            'show_list' => false,
            'button_text' => esc_html__('Add Pricing Rule', 'zcpri-woopricely'),
        ),
    );


    return $in_fields;
}



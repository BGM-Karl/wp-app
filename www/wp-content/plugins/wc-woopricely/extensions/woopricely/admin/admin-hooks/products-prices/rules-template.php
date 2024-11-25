<?php

add_filter('reon/get-repeater-field-products_pricing_rules-templates', 'zcpri_get_products_pricing_rules_template', 10, 2);

function zcpri_get_products_pricing_rules_template($in_templates, $args) {

    if ($args['screen'] == 'option-page' && $args['option_name'] == 'zc_pri') {
        $in_templates[] = array(
            'id' => 'price_rule',
            'head' => array(
                'title' => '',
                'defaut_title' => esc_html__('Product Pricing', 'zcpri-woopricely'),
                'title_field' => 'admin_note',
                'subtitle_field' => 'price_mode',
            )
        );
    }

    return $in_templates;
}

add_filter('roen/get-repeater-template-products_pricing_rules-price_rule-fields', 'zcpri_get_products_price_rule_template_fields', 10, 2);

function zcpri_get_products_price_rule_template_fields($in_fields, $args) {
    
    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'autoid',
        'autoid' => 'woopricely',
    );
    
    $in_fields[] = array(
        'id' => 'rule_opt',
        'type' => 'panel',
        'full_width' => true,
        'center_head' => true,
        'white_panel' => true,
        'panel_size' => 'smaller',
        'width' => '100%',
        'merge_fields' => false,
        'last' => true,        
        'fields' => array(
            array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 5,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'price_mode',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Mode', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls the products pricing mode, you can choose either Regular Price Adjustment, Sale Price Adjustment or Regular / Sale Price Adjustment', 'zcpri-woopricely'),
                        'default' => 'before_add_to_cart',
                        'options' => array(
                            'sale_price' => esc_html__('Sale Price Adjusment', 'zcpri-woopricely'),
                            'regular_price' => esc_html__('Regular Price Adjusment', 'zcpri-woopricely'),
                            'regular_sale_price' => esc_html__('Regular / Sale Price Adjusment', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                        'fold_id' => 'price_mode',
                    ),
                    array(
                        'id' => 'admin_note',
                        'type' => 'textbox',
                        'tooltip' => esc_html__('Adds a private note for reference purposes', 'zcpri-woopricely'),
                        'column_size' => 2,
                        'column_title' => esc_html__('Admin Note', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'clear_sale_price',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Clear Sale Price', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Clears sale prices on applied products', 'zcpri-woopricely'),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__('No', 'zcpri-woopricely'),
                            'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'price_mode',
                            'attribute' => 'value',
                            'value' => 'regular_price',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                            'empty' => 'no',
                        ),
                    ),
                ),
            ),
            array(
                'id' => 'regular_adj',
                'type' => 'columns-field',
                'columns' => 5,
                'fold' => array(
                    'target' => 'price_mode',
                    'attribute' => 'value',
                    'value' => 'sale_price',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'fields' => array(
                    array(
                        'id' => 'adjustment',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Regular Price Adjustment', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls regular pricing adjustment method on applied products', 'zcpri-woopricely'),
                        'options' => array(
                            'fixed_price' => esc_html__('Fixed price', 'zcpri-woopricely'),
                            'fixed_discount' => esc_html__('Fixed discount amount', 'zcpri-woopricely'),
                            'fixed_fee' => esc_html__('Fixed fee amount', 'zcpri-woopricely'),
                            'per_discount' => esc_html__('Percentage discount', 'zcpri-woopricely'),
                            'per_fee' => esc_html__('Percentage fee', 'zcpri-woopricely'),
                        ),
                        'default' => 'fixed_discount',
                        'width' => '100%',
                        'fold_id' => 'reg_adj',
                    ),
                    array(
                        'id' => 'base_on',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls how to calculate the product prices, calculations can be based on product regular price, sale price or previously calculated prices', 'zcpri-woopricely'),
                        'options' => array(
                            'product' => array(
                                'label' => esc_html__('Source Prices', 'zcpri-woopricely'),
                                'options' => array(
                                    'reg_price' => esc_html__('Source regular price', 'zcpri-woopricely'),
                                    'sale_price' => esc_html__('Source sale price', 'zcpri-woopricely'),
                                ),
                            ),
                            'calc' => array(
                                'label' => esc_html__('Computed Prices', 'zcpri-woopricely'),
                                'options' => array(
                                    'calc_reg_price' => esc_html__('Computed regular price', 'zcpri-woopricely'),
                                    'calc_sale_price' => esc_html__('Computed sale price', 'zcpri-woopricely'),
                                ),
                            ),
                        ),
                        'default' => 'reg_price',
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'reg_adj',
                            'attribute' => 'value',
                            'value' => 'fixed_price',
                            'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                            'empty' => 'reg_price',
                        ),
                    ),
                    array(
                        'id' => 'amount',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'column_title' => esc_html__('Amount', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls the amount to apply based on the Regular Price Adjustment method', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '0.01',
                        ),
                    ),
                ),
            ),
            array(
                'id' => 'sale_adj',
                'type' => 'columns-field',
                'columns' => 5,
                'fold' => array(
                    'target' => 'price_mode',
                    'attribute' => 'value',
                    'value' => 'regular_price',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'fields' => array(
                    array(
                        'id' => 'adjustment',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Sale Price Adjustment', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls sale pricing adjustment method on applied products', 'zcpri-woopricely'),
                        'options' => array(
                            'fixed_price' => esc_html__('Fixed price', 'zcpri-woopricely'),
                            'fixed_discount' => esc_html__('Fixed discount amount', 'zcpri-woopricely'),
                            'fixed_fee' => esc_html__('Fixed fee amount', 'zcpri-woopricely'),
                            'per_discount' => esc_html__('Percentage discount', 'zcpri-woopricely'),
                            'per_fee' => esc_html__('Percentage fee', 'zcpri-woopricely'),
                        ),
                        'default' => 'reg_price',
                        'width' => '100%',
                        'fold_id' => 'sale_adj',
                    ),
                    array(
                        'id' => 'base_on',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls how to calculate the product prices, calculations can be based on product regular price, sale price or previously calculated prices', 'zcpri-woopricely'),
                        'options' => array(
                            'product' => array(
                                'label' => esc_html__('Source Prices', 'zcpri-woopricely'),
                                'options' => array(
                                    'reg_price' => esc_html__('Source regular price', 'zcpri-woopricely'),
                                    'sale_price' => esc_html__('Source sale price', 'zcpri-woopricely'),
                                ),
                            ),
                            'calc' => array(
                                'label' => esc_html__('Computed Prices', 'zcpri-woopricely'),
                                'options' => array(
                                    'calc_reg_price' => esc_html__('Computed regular price', 'zcpri-woopricely'),
                                    'calc_sale_price' => esc_html__('Computed sale price', 'zcpri-woopricely'),
                                ),
                            ),
                        ),
                        'default' => 'reg_price',
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'sale_adj',
                            'attribute' => 'value',
                            'value' => 'fixed_price',
                            'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                            'empty' => 'reg_price',
                        ),
                    ),
                    array(
                        'id' => 'amount',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'column_title' => esc_html__('Amount', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls the amount to apply based on the Sale Price Adjustment method', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '0.01',
                        ),
                    ),
                ),
            ),
            array(
                'id' => 'schedule_sale',
                'type' => 'columns-field',
                'columns' => 4,
                'fold' => array(
                    'target' => 'price_mode',
                    'attribute' => 'value',
                    'value' => 'regular_price',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'fields' => array(
                    array(
                        'id' => 'enable',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Schedule Sale Price', 'zcpri-woopricely'),
                        'tooltip' => esc_html__("Controls product sale schedule dates, work like WooCommerce schedule sale dates, enabling this option allows you to set the 'From' and 'To' date", 'zcpri-woopricely'),
                        'options' => array(
                            'no' => esc_html__('No', 'zcpri-woopricely'),
                            'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                        ),
                        'default' => 'no',
                        'width' => '100%',
                        'fold_id' => 'schedule_price',
                    ),
                    array(
                        'id' => 'from',
                        'type' => 'date',
                        'column_size' => 1,
                        'column_title' => esc_html__('From', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls product sale schedule from date', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => 'YYYY-MM-DD',
                        'date_format' => 'yy-mm-dd',
                        'number_of_months' => 1,
                        'show_button_panel' => false,
                        'change_month' => true,
                        'change_year' => true,
                        'show_week' => true,

                        'show_other_months' => true,
                        'select_other_months' => true,

                        'width' => '100%',
                        'fold' => array(
                            'target' => 'schedule_price',
                            'attribute' => 'value',
                            'value' => 'yes',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                        ),
                    ),
                    array(
                        'id' => 'to',
                        'type' => 'date',
                        'column_size' => 1,
                        'column_title' => esc_html__('To', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls product sale schedule to date', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => 'YYYY-MM-DD',
                        'date_format' => 'yy-mm-dd',
                        'number_of_months' => 1,
                        'show_button_panel' => false,
                        'change_month' => true,
                        'change_year' => true,
                        'show_week' => true,

                        'show_other_months' => true,
                        'select_other_months' => true,

                        'width' => '100%',
                        'fold' => array(
                            'target' => 'schedule_price',
                            'attribute' => 'value',
                            'value' => 'yes',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                        ),
                    ),
                ),
            ),
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 2,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'message',
                        'type' => 'textbox',
                        'column_size' => 2,
                        'column_title' => esc_html__('Promo Message', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls the promotional message on single product page', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                ),
            ),
            array(
                'id' => 'products',
                'type' => 'simple-repeater',
                'filter_id' => 'shop_price_products',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__('Product Filters', 'zcpri-woopricely'),
                'desc' => esc_html__('List of product filters, empty filters will include all products', 'zcpri-woopricely'),
                'white_repeater' => false,
                'repeater_size' => 'smaller',
                'buttons_sep' => false,
                'buttons_box_width' => '65px',
                'width' => '100%',
                'sortable' => array(
                    'enabled' => true,
                ),
                'template_adder' => array(
                    'position' => 'right', //left, right
                    'show_list' => false,
                    'button_text' => esc_html__('Add Filter', 'zcpri-woopricely'),
                ),
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'condidions',
        'type' => 'panel',
        'full_width' => true,
        'center_head' => true,
        'white_panel' => true,
        'panel_size' => 'smaller',
        'width' => '100%',
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'conditions',
                'type' => 'simple-repeater',
                'filter_id' => 'shop_price_conditions',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__('Conditions', 'zcpri-woopricely'),
                'desc' => esc_html__('List of conditions in which this rule should apply, empty conditions will apply in all cases', 'zcpri-woopricely'),
                'white_repeater' => false,
                'repeater_size' => 'smaller',
                'buttons_sep' => false,
                'buttons_box_width' => '65px',
                'width' => '100%',
                'sortable' => array(
                    'enabled' => true,
                ),
                'template_adder' => array(
                    'position' => 'right', //left, right
                    'show_list' => false,
                    'button_text' => esc_html__('Add Condition', 'zcpri-woopricely'),
                ),
            ),
        ),
    );

    return $in_fields;
}

add_filter('roen/get-repeater-template-products_pricing_rules-price_rule-head-fields', 'zcpri_get_products_price_rule_template_head_fields', 10, 2);

function zcpri_get_products_price_rule_template_head_fields($in_fields, $args) {
    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'group-field',
        'position' => 'right',
        'width' => '100%',
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'apply_mode',
                'type' => 'select2',
                'default' => 'with_others',
                'options' => array(
                    'with_others' => esc_html__('Apply this and other rules (per product)', 'zcpri-woopricely'),
                    'only_this' => esc_html__('Apply only this rule (per product)', 'zcpri-woopricely'),
                    'if_others' => esc_html__('Apply if other rules are valid (per product)', 'zcpri-woopricely'),
                    'if_no_others' => esc_html__('Apply if no other valid rules (per product)', 'zcpri-woopricely'),
                ),
                'width' => '290px',
            ),
            array(
                'id' => 'enable',
                'type' => 'select2',
                'default' => 'yes',
                'options' => array(
                    'yes' => esc_html__('Enable', 'zcpri-woopricely'),
                    'no' => esc_html__('Disable', 'zcpri-woopricely'),
                ),
                'width' => '95px',
            ),
        ),
    );

    return $in_fields;
}

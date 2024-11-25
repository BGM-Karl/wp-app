<?php

add_filter('reon/get-repeater-field-checkout_fees_rules-templates', 'zcpri_get_checkout_fee_rules_template', 10, 2);

function zcpri_get_checkout_fee_rules_template($in_templates, $args) {

    if ($args['screen'] == 'option-page' && $args['option_name'] == 'zc_pri') {
        $in_templates[] = array(
            'id' => 'fee_rule',
            'head' => array(
                'title' => '',
                'defaut_title' => esc_html__('Checkout Fee', 'zcpri-woopricely'),
                'title_field' => 'title',
                'subtitle_field' => 'admin_note',
            )
        );
    }

    return $in_templates;
}

add_filter('roen/get-repeater-template-checkout_fees_rules-fee_rule-fields', 'zcpri_get_checkout_fee_rule_template_fields', 10, 2);

function zcpri_get_checkout_fee_rule_template_fields($in_fields, $args) {
   
    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'autoid',
        'autoid' => 'woopricely',
    );

    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'panel',
        'full_width' => true,
        'center_head' => true,
        'white_panel' => true,
        'panel_size' => 'smaller',
        'width' => '100%',
        'last' => true,
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 4,
                'merge_fields' => false,
                'fields' => array(                    
                    array(
                        'id' => 'title',
                        'type' => 'textbox',
                        'tooltip' => esc_html__('Controls fee title on cart and checkout pages', 'zcpri-woopricely'),
                        'column_size' => 2,
                        'column_title' => esc_html__('Title', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'admin_note',
                        'type' => 'textbox',
                        'tooltip' => esc_html__('Adds a private note for reference purposes', 'zcpri-woopricely'),
                        'column_size' => 1,
                        'column_title' => esc_html__('Admin Note', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'send_to_group',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Send Fee To Groups', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Allows you to add the calculated fee to a group', 'zcpri-woopricely'),
                        'default' => 'yes',
                        'options' => array(
                            'no' => esc_html__('No', 'zcpri-woopricely'),
                            'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                        'fold_id' => 'send_to_group'
                    ),
                ),
            ),
            array(
                'id' => 'group',
                'type' => 'columns-field',
                'columns' => 2,
                'fold' => array(
                    'target' => 'send_to_group',
                    'attribute' => 'value',
                    'value' => 'yes',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'fields' => array(
                    array(
                        'id' => 'group_id',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Fee Group', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Allows to specify which fee group to send the calculated fee to', 'zcpri-woopricely'),
                        'ajax_data' => 'dpd:fee_groups',
                        'default' => '10280000',
                        'placeholder' => esc_html__('Select group', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'inc_method',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Include Method', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls how the calculated fee should be added to the group', 'zcpri-woopricely'),
                        'default' => 'increment',
                        'options' => array(
                            'increment' => esc_html__('Add amount to group', 'zcpri-woopricely'),
                            'decrement' => esc_html__('Subtract amount from group', 'zcpri-woopricely'),
                            'override' => esc_html__('Set group amount', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                    ),
                ),
            ),
            array(
                'id' => 'single',
                'type' => 'columns-field',
                'columns' => 5,
                'fold' => array(
                    'target' => 'send_to_group',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'fields' => array(
                    array(
                        'id' => 'desc',
                        'type' => 'textbox',
                        'column_size' => 2,
                        'column_title' => esc_html__('Description', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls fee description on cart and checkout pages', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'min',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'column_title' => esc_html__('Minimum', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls fee minimum value', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('0 minimum', 'zcpri-woopricely'),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '0.01',
                        ),
                    ),
                    array(
                        'id' => 'max',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'column_title' => esc_html__('Maximum', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls fee maximum value', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('No maximum', 'zcpri-woopricely'),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '0.01',
                        ),
                    ),
                    array(
                        'id' => 'taxable',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Taxable', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls fee tax class', 'zcpri-woopricely'),
                        'default' => '--1',
                        'options' => array(
                            '--1' => esc_html__('Not Taxable', 'zcpri-woopricely'),
                            '' => esc_html__('Standard', 'zcpri-woopricely'),
                        ),
                        'data' => 'wc:tax_classes',
                        'width' => '100%',
                    ),
                ),
            ),
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'fold' => array(
                    'target' => 'send_to_group',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => true,
                ),
                'fields' => array(
                    array(
                        'id' => 'notification',
                        'type' => 'textbox',
                        'column_size' => 1,
                        'column_title' => esc_html__('Cart/Checkout Notification', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls the notification message on cart and checkout pages', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                        'width' => '100%',
                    ),
                )
            ),
            array(
                'id' => 'fee',
                'type' => 'columns-field',
                'columns' => 3,
                'fields' => array(
                    array(
                        'id' => 'fee_type',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Fee Type', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls fee amount type', 'zcpri-woopricely'),
                        'options' => array(
                            'cart' => array(
                                'label' => 'Cart Fee',
                                'options' => array(
                                    'fixed_fee' => esc_html__('Fixed fee', 'zcpri-woopricely'),
                                    'per_fee' => esc_html__('Percentage fee', 'zcpri-woopricely'),
                                ),
                            ),
                            'products' => array(
                                'label' => 'Products Fee',
                                'options' => array(
                                    'fixed_item_fee' => esc_html__('Fix fee per line item', 'zcpri-woopricely'),
                                    'fixed_unit_fee' => esc_html__('Fix fee per item unit', 'zcpri-woopricely'),
                                    'per_item_fee' => esc_html__('Percentage fee per item', 'zcpri-woopricely'),
                                ),
                            ),
                        ),
                        'default' => 'fixed_fee',
                        'width' => '100%',
                        'fold_id' => 'fee_type',
                    ),
                    array(
                        'id' => 'cart_base_on',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls how to calculate the fee amount', 'zcpri-woopricely'),
                        'options' => array(
                            'subtotal' => esc_html__('Subtotal including tax', 'zcpri-woopricely'),
                            'subtotal_ex_tax' => esc_html__('Subtotal excluding tax', 'zcpri-woopricely'),
                        ),
                        'default' => 'subtotal',
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'fee_type',
                            'attribute' => 'value',
                            'value' => 'per_fee',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                            'empty' => 'subtotal',
                        ),
                    ),
                    array(
                        'id' => 'item_base_on',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls how to calculate the fee amount', 'zcpri-woopricely'),
                        'options' => array(
                            'cart_price' => esc_html__('Cart item price', 'zcpri-woopricely'),
                            'product' => array(
                                'label' => 'Source Prices',
                                'options' => array(
                                    'reg_price' => esc_html__('Source regular price', 'zcpri-woopricely'),
                                    'sale_price' => esc_html__('Source sale price', 'zcpri-woopricely'),
                                ),
                            ),
                            'calc' => array(
                                'label' => 'Computed Prices',
                                'options' => array(
                                    'calc_reg_price' => esc_html__('Computed regular price', 'zcpri-woopricely'),
                                    'calc_sale_price' => esc_html__('Computed sale price', 'zcpri-woopricely'),
                                ),
                            ),
                        ),
                        'default' => 'cart_price',
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'fee_type',
                            'attribute' => 'value',
                            'value' => 'per_item_fee',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                            'empty' => 'cart_price',
                        ),
                    ),
                    array(
                        'id' => 'amount',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'column_title' => esc_html__('Amount', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls the amount to apply based on the Fee Type method', 'zcpri-woopricely'),
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
                'id' => 'products',
                'type' => 'simple-repeater',
                'filter_id' => 'fee_products',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__('Product Filters', 'zcpri-woopricely'),
                'desc' => esc_html__('List of product filters, empty filters will include all products', 'zcpri-woopricely'),
                'white_repeater' => false,
                'repeater_size' => 'smaller',
                'buttons_sep' => false,
                'buttons_box_width' => '65px',
                'width' => '100%',
                'fold' => array(
                    'target' => 'fee_type',
                    'attribute' => 'value',
                    'value' => array('fixed_item_fee', 'fixed_unit_fee', 'per_item_fee'),
                    'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                ),
                'sortable' => array(
                    'enabled' => true,
                ),
                'template_adder' => array(
                    'position' => 'right', //left, right
                    'show_list' => false,
                    'button_text' => esc_html__('Add Filter', 'zcpri-woopricely'),
                ),
            ),
        )
    );

    $in_fields[] = array(
        'id' => 'any_id',
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
                'filter_id' => 'fee_conditions',
                'type' => 'simple-repeater',
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

add_filter('roen/get-repeater-template-checkout_fees_rules-fee_rule-head-fields', 'zcpri_get_checkout_fee_rule_template_head_fields', 10, 2);

function zcpri_get_checkout_fee_rule_template_head_fields($in_fields, $args) {
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
                    'with_others' => esc_html__('Apply this and other rules', 'zcpri-woopricely'),
                    'only_this' => esc_html__('Apply only this rule', 'zcpri-woopricely'),
                    'if_others' => esc_html__('Apply if other rules are valid', 'zcpri-woopricely'),
                    'if_no_others' => esc_html__('Apply if no other valid rules', 'zcpri-woopricely'),
                ),
                'width' => '210px',
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

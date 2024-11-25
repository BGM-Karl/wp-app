<?php

add_filter('reon/get-simple-repeater-field-checkout_price_products_in_group-templates', 'zcpri_get_checkout_price_products_group_template', 10, 2);

function zcpri_get_checkout_price_products_group_template($in_templates, $args) {

    if ($args['screen'] == 'option-page' && $args['option_name'] == 'zc_pri') {
        $in_templates[] = array(
            'id' => 'group',
        );
    }

    return $in_templates;
}

add_filter('roen/get-simple-repeater-template-checkout_price_products_in_group-group-fields', 'zcpri_get_checkout_price_products_group_template_fields', 10, 2);

function zcpri_get_checkout_price_products_group_template_fields($in_fields, $args) {

    $in_fields[] = array(
        'id' => 'qty',
        'type' => 'textbox',
        'input_type' => 'number',
        'default' => '',
        'placeholder' => esc_html__('Quantity', 'zcpri-woopricely'),
        'width' => '93%',
        'box_width' => '9%',
        'attributes' => array(
            'min' => '0',
            'step' => '1',
        ),
    );

    $rule_args = array(
        'section' => 'checkout_prices',
        'panel' => 'prodects_in_group',
    );

    $in_fields[] = array(
        'id' => 'rule_type',
        'type' => 'select2',
        'default' => 'no',
        'options' => zcpri_get_product_rule_list($rule_args),
        'width' => '97%',
        'box_width' => '28%',
        'dyn_switcher_id' => 'product_rule_type',
        'dyn_switcher_exclude' => 'is_req',
        'dyn_switcher_width'=>'62%'
    );


    foreach (zcpri_get_product_rule_fields($rule_args) as $fld) {
        $in_fields[] = $fld;
    }





    return $in_fields;
}

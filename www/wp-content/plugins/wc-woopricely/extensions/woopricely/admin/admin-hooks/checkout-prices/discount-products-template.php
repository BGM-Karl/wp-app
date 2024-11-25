<?php
add_filter('reon/get-simple-repeater-field-checkout_price_discount_products-templates', 'zcpri_get_checkout_price_discount_products_template', 10, 2);

function zcpri_get_checkout_price_discount_products_template($in_templates, $args) {

    if ($args['screen'] == 'option-page' && $args['option_name'] == 'zc_pri') {
        $in_templates[] = array(
            'id' => 'product',
        );
    }

    return $in_templates;
}

add_filter('roen/get-simple-repeater-template-checkout_price_discount_products-product-fields', 'zcpri_get_checkout_price_discount_products_template_fields', 10, 2);

function zcpri_get_checkout_price_discount_products_template_fields($in_fields, $args) {

 $rule_args = array(
        'section' => 'checkout_prices',
        'panel' => 'discount_prodects',
    );
 
    $in_fields[] = array(
        'id' => 'rule_type',
        'type' => 'select2',
        'default' => 'no',
        'options' => zcpri_get_product_rule_list($rule_args),
        'width' => '97%',
        'box_width' => '28%',
        'dyn_switcher_id' => 'product_rule_type',        
    );


    foreach (zcpri_get_product_rule_fields($rule_args) as $fld) {
        $in_fields[] = $fld;
    }


    return $in_fields;
}


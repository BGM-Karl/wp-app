<?php

require_once (dirname(__FILE__) . '/product-rules-specific.php');
require_once (dirname(__FILE__) . '/product-rules-categories.php');
require_once (dirname(__FILE__) . '/product-rules-tags.php');
require_once (dirname(__FILE__) . '/product-rules-attributes.php');
require_once (dirname(__FILE__) . '/product-rules-variation.php');

require_once (dirname(__FILE__) . '/product-rules-types.php');
require_once (dirname(__FILE__) . '/product-rules-is-virtual.php');
require_once (dirname(__FILE__) . '/product-rules-is-downloadable.php');
require_once (dirname(__FILE__) . '/product-rules-is-featured.php');

require_once (dirname(__FILE__) . '/product-rules-prices.php');
require_once (dirname(__FILE__) . '/product-rules-total-sold.php');
require_once (dirname(__FILE__) . '/product-rules-on-sale.php');
require_once (dirname(__FILE__) . '/product-rules-stock-status.php');
require_once (dirname(__FILE__) . '/product-rules-stock-quantity.php');
require_once (dirname(__FILE__) . '/product-rules-weight.php');
require_once (dirname(__FILE__) . '/product-rules-shipping-class.php');
require_once (dirname(__FILE__) . '/product-rules-meta-field.php');

add_filter('zcpri/get-product-rule-type-groups', 'zcpri_get_product_rule_type_groups', 10, 2);
if (!function_exists('zcpri_get_product_rule_type_groups')) {

    function zcpri_get_product_rule_type_groups($groups, $args) {
        $groups['products'] = array(
            'label' => esc_html__('Products', 'zcpri-woopricely')
        );
        $groups['product_prices'] = array(
            'label' => esc_html__('Product Prices', 'zcpri-woopricely')
        );
        $groups['product_properties'] = array(
            'label' => esc_html__('Product Properties', 'zcpri-woopricely')
        );
        return $groups;
    }

}
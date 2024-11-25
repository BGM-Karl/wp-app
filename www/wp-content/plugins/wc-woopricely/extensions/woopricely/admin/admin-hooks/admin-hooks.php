<?php

require_once 'checkout-prices/rules-template.php';
require_once 'checkout-prices/quantity-ranges-template.php';
require_once 'checkout-prices/discount-products-template.php';
require_once 'checkout-prices/products-group-template.php';
require_once 'checkout-prices/products-template.php';
require_once 'checkout-prices/conditions-template.php';

require_once 'products-prices/rules-template.php';
require_once 'products-prices/products-template.php';
require_once 'products-prices/conditions-template.php';

require_once 'checkout-dicscounts/rules-template.php';
require_once 'checkout-dicscounts/products-template.php';
require_once 'checkout-dicscounts/conditions-template.php';

require_once 'checkout-fees/rules-template.php';
require_once 'checkout-fees/products-template.php';
require_once 'checkout-fees/conditions-template.php';

require_once (dirname(__FILE__) . '/rule-filters/products-rules/product-rules.php');
require_once (dirname(__FILE__) . '/rule-filters/conditions/conditions.php');


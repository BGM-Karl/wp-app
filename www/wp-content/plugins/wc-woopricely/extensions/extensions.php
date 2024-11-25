<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

//WCWooPricely
if ( !class_exists( 'WCWooPricely_Extension' ) ) {
    include_once ('woopricely/woopricely-extension.php');
    new WCWooPricely_Extension();
}
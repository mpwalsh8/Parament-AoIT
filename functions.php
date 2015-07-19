<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

?>

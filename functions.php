<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 
function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter('woocommerce_output_related_products_args', 'aoit_related_products_args');
  function aoit_related_products_args( $args ) {
	$args['posts_per_page'] = 6; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


/** 
 * Manipulate default state and countries
 * 
 * As always, code goes in your theme functions.php file
 */
add_filter( 'default_checkout_country', 'aoit_change_default_checkout_country' );
add_filter( 'default_checkout_state', 'aoit_change_default_checkout_state' );

function aoit_change_default_checkout_country() {
  return 'US'; // country code
}

function aoit_change_default_checkout_state() {
  return 'NC'; // state code
}

/**
 * aoit_wp_footer()
 *
 * Use jQuery to "tweak" the containers WooCommerce uses so they take
 * take on the Parament Theme CSS.  Some minor CSS tweaks are needed to
 * keep the sidebar in the proper place and have the page look correct.
 */
function aoit_wp_footer()
{
?>
<!--  Add CSS classes to WooCommerce products -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        if ($("body").hasClass("woocommerce-page")) {
            $("[id=main]").addClass("hentry entry-content");
            $("[id=main]").css("margin-top", "10px");
            $("[id=main]").css("width", "640px");
        }
    }) ;
</script>
    
<?php
}

//add_action('wp_footer', 'aoit_wp_footer') ;

//  Code to export meta fields as separate columns.
//  @see:  https://gist.github.com/tamarazuk/46e66064a40c4a611397
require('woocommerce-csv-export-separate-item-meta.php');
?>

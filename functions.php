<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
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

add_action('wp_footer', 'aoit_wp_footer') ;
?>

<?php
// Add / remove code
function custom_code() {
    // Stylesheets
    // Add
    wp_enqueue_script('jquery');
    wp_enqueue_style('custom-css', get_template_directory_uri() . '/css/style.css');
    wp_enqueue_style('tooltipster-css', get_template_directory_uri() . '/css/tooltipster.css');
    // Remove
    wp_dequeue_style('contact-form-7');
    wp_deregister_style('contact-form-7');
    wp_dequeue_style('jquery-ui-css');
    wp_deregister_style('jquery-ui-css');
    wp_dequeue_style('wcj-timepicker-css');
    wp_deregister_style('wcj-timepicker-css');
    wp_dequeue_style('wc-memberships-frontend');
    wp_deregister_style('wc-memberships-frontend');
    wp_dequeue_style('select2');
    wp_deregister_style('select2');
    wp_dequeue_style('wcs-view-subscription');
    wp_deregister_style('wcs-view-subscription');
    wp_dequeue_style('wcs-checkout');
    wp_deregister_style('wcs-checkout');
    wp_dequeue_style('stripe_apple_pay');
    wp_deregister_style('stripe_apple_pay');
    /* wp_dequeue_style('one_page_checkout');
     * wp_deregister_style('one_page_checkout');
     * wp_dequeue_style('prettyphoto-pop');
     * wp_deregister_style('prettyphoto-pop');*/

    // Scripts
    // Add
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js');
    wp_enqueue_script('account-js', get_template_directory_uri() . '/js/account.js');
    wp_enqueue_script('validate-js', get_template_directory_uri() . '/js/jquery.validate.min.js');
    wp_enqueue_script('additional-methods-js', get_template_directory_uri() . '/js/additional-methods.min.js');
    wp_enqueue_script('masked-input-js', get_template_directory_uri() . '/js/jquery.mask.min.js');
    wp_enqueue_script('tooltipster-js', get_template_directory_uri() . '/js/jquery.tooltipster.min.js');
    // Remove
    wp_dequeue_script('jquery-ui-datepicker');
    wp_dequeue_script('wcj-datepicker');
    wp_dequeue_script('wcj-weekpicker');
    wp_dequeue_script('jquery-ui-timepicker');
    wp_dequeue_script('wcj-timepicker');
    wp_dequeue_script('wc-geolocation');
    wp_dequeue_script('select2');
}
add_action('wp_enqueue_scripts','custom_code', 100);


// Add / remove WooCommerce code
function remove_woocommerce_code() {
    // Remove generator (meta tag)
    remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator'));

    // Make sure WC exists to prevent fatal errors
    if ( function_exists( 'is_woocommerce' ) ) {
        // Styles
        wp_dequeue_style('woocommerce_frontend_styles');
        wp_deregister_style('woocommerce_frontend_styles');
        wp_dequeue_style('woocommerce_fancybox_styles');
        wp_deregister_style('woocommerce_fancybox_styles');
        wp_dequeue_style('woocommerce_chosen_styles');
        wp_deregister_style('woocommerce_chosen_styles');
        wp_dequeue_style('woocommerce_prettyPhoto_css');
        wp_deregister_style('woocommerce_prettyPhoto_css');

        // Scripts
        if (!is_woocommerce() && !is_cart() && !is_checkout()) {
            wp_dequeue_script('wc_price_slider');
            wp_dequeue_script('wc-single-product');
            wp_dequeue_script('wc-add-to-cart');
            wp_dequeue_script('wc-cart-fragments');
            wp_dequeue_script('wc-checkout');
            wp_dequeue_script('wc-add-to-cart-variation');
            wp_dequeue_script('wc-single-product');
            wp_dequeue_script('wc-cart');
            wp_dequeue_script('wc-chosen');
            wp_dequeue_script('woocommerce');
            wp_dequeue_script('prettyPhoto');
            wp_dequeue_script('prettyPhoto-init');
            wp_dequeue_script('jquery-blockui');
            wp_dequeue_script('jquery-placeholder');
            wp_dequeue_script('fancybox');
            wp_dequeue_script('jqueryui');
        }
    }
}
add_action('wp_enqueue_scripts', 'remove_woocommerce_code', 99);
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
?>

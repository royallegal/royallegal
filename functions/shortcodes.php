<?php
// Newsletter Widget
// [sidebar-newsletter] Shortcode
add_shortcode( 'sidebar-newsletter', 'sidebar_newsletter_shortcode' );
function sidebar_newsletter_shortcode( $atts ) {
    ob_start();
    get_template_part("snippets/newsletter/newsletter");
    $myvariable = ob_get_clean();
    return $myvariable;
}


// Center Widget
function display_center_widgets() {
    ob_start();
    if (is_active_sidebar('center_widgets')) {
        dynamic_sidebar('center_widgets');
        return ob_get_clean();
    }
    else {
        return '';
    }
}
add_shortcode('center_widgets', 'display_center_widgets');
?>

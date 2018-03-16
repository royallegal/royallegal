<?php
add_filter('widget_text', 'do_shortcode');

/* Custom Widgets */
function custom_widgets() {
    register_sidebar(array(
        'name' => __('Sidebar Widgets', 'royallegal'),
        'id' => 'sidebar',
        'description' => __('Add widgets here to appear in Footer Section.', 'royallegal'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Top Widgets', 'royallegal'),
        'id' => 'top_widgets',
        'description' => __('Add widgets here to appear in top section.', 'royallegal'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Bottom Widgets', 'royallegal'),
        'id' => 'bottom_widgets',
        'description' => __('Add widgets here to appear in bottom section.', 'royallegal'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Center Widgets', 'royallegal'),
        'id' => 'center_widgets',
        'description' => __('Add widgets here to appear in center section.', 'royallegal'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'custom_widgets');
?>

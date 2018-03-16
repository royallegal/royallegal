<?php
// ---- IMPORTS ---- //
require_once( __DIR__ . '/functions/account.php');
require_once( __DIR__ . '/functions/blog.php');
require_once( __DIR__ . '/functions/contact.php');
require_once( __DIR__ . '/functions/export.php');
require_once( __DIR__ . '/functions/files.php');
require_once( __DIR__ . '/functions/payment.php');
require_once( __DIR__ . '/functions/shortcodes.php');
require_once( __DIR__ . '/functions/widgets.php');
require_once( __DIR__ . '/functions/woocommerce.php');


// ---- SETUP ---- //
// HTML
add_action('after_setup_theme', 'royallegal_setup');
if (!function_exists('royallegal_setup')) {
    function royallegal_setup() {
        register_nav_menus(array(
            'Header' => __('Header Menu', 'royallegal'),
            'Navigation' => __('Footer Navigation', 'royallegal'),
        ));
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));
        add_image_size( 'page-banner', 1920, 180, true );
    }
}


// ---- COOKIES ---- //
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH ) setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);


// ---- ADMIN ---- //
add_action('set_current_user', 'royallegal_hide_admin_bar');
function royallegal_hide_admin_bar() {
    if (!current_user_can('edit_posts')) {
        show_admin_bar(false);
    }
}

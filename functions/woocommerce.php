<?php
// Declare Support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


// ---- CART ---- //
// Automatically add item to cart on visit
add_action('template_redirect', 'add_product_to_cart');
function add_product_to_cart() {
    if (!current_user_can('edit_posts')) {
        $referer = rtrim(wp_get_referer(), '/');
        $product = end(explode("/", $referer));

        /* if ($product == "webinar") {
         *     $product_id = 554;
         * }
         * elseif ($product == "cart") {
         *     $product_id = '';
         * }
         * else {
         *     $product_id = 552;
         * }*/

        if ($product == "cart") {
            $product_id = "";
        }
        else {
            $product_id = 554;
        }

        $found = false;
        //check if product already in cart
        if (sizeof(WC()->cart->get_cart()) > 0) {
	    foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
	        $_product = $values['data'];
	        if ($_product->id == $product_id)
		    $found = true;
	    }
	    // if product not found, add it
	    if (!$found)
	        WC()->cart->add_to_cart($product_id);
        } else {
	    // if no products in cart, add it
	    WC()->cart->add_to_cart($product_id);
        }
    }
}


// ---- ACCOUNTS ---- //
// Custom Post Type "practiceareas"
function create_post_type() {
    $labels_Gallery = array(
        'name' => 'Practice Areas',
        'singular_name' => 'Practice Areas',
        'add_new' => 'Add Practice Areas',
        'add_new_item' => 'Add New Practice Areas',
        'edit_item' => 'Edit Practice Areas',
        'new_item' => 'New Practice Areas',
        'all_items' => 'All Practice Areas',
        'view_item' => 'View Practice Areas',
        'search_items' => 'Search Practice Areas',
        'not_found' => 'No Practice Areas found',
        'not_found_in_trash' => 'No Practice Areas found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Practice Areas',
    );
    $argsGalleries = array(
        'label' => __('Practice Areas', 'text_domain'),
        'description' => __('Practice Areas information pages', 'text_domain'),
        'labels' => $labels_Gallery,
        'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'comments'),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'rewrite' => array('slug' => 'practiceareas', 'with_front' => true),
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('practiceareas', $argsGalleries);
}
add_action('init', 'create_post_type');

function create_taxonomies() {
    register_taxonomy('practiceareas_category', 'practiceareas', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Type of pactice areas'),
            'menu_name' => __('Add Type of pactice areas'),
            'singular_name' => __('Type of Gallary'),
            'add_new' => __('Add Type of pactice areas'),
            'add_new_item' => __('Add Type of pactice areas item'),
            'new_item' => __('New Type of pactice areas'),
            'search_items' => __('Search Type of Gallary'),
        ),
    ));
}
add_filter('manage_taxonomies_for_gallery_columns', 'gallery_type_columns');

function gallery_type_columns($taxonomies) {
    $taxonomies[] = 'galleries';
    return $taxonomies;
}
add_action('init', 'create_taxonomies');

// Disable automatic feeds
remove_action( 'do_feed_rdf', 'do_feed_rdf', 10, 1 );
remove_action( 'do_feed_rss', 'do_feed_rss', 10, 1 );
remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1 );
remove_action( 'do_feed_atom', 'do_feed_atom', 10, 1 );

// Remove automatic links to feeds
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// Create custom feed from template
function create_custom_feed() {
    load_template( TEMPLATEPATH . '/feed-rss2.php');
}

// Replace default feed rewrite rules
function customise_feed_rules($rules) {
    // Remove all feed related rules
    $filtered_rules = array_filter($rules, function($rule) {
        return !preg_match("/feed/i", $rule);
    });
    // Add the rule(s) for your custom feed(s)
    $new_rules = array(
        'feed\.xml$' => 'index.php?feed=custom_feed'
    );
    return $new_rules + $filtered_rules;
}

// Add the custom feed and update rewrite rules
function add_custom_feed() {
    global $wp_rewrite;
    add_action('do_feed_custom_feed', 'create_custom_feed', 10, 1);
    add_filter('rewrite_rules_array','customise_feed_rules');
    $wp_rewrite->flush_rules();
}

add_action('init', 'add_custom_feed');
?>

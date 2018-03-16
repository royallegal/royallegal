<?PHP
$pages   = array('dashboard','profile','finance','property','business', 'webinar');
$account = new Royal_Accounts($pages);


// Creates HTML pages
add_action('init', [$account,'endpoints']);

// WordPress helper functions
add_filter('query_vars', [$account,'query_vars']);
add_action('init', [$account,'flush_rewrite_rules']);

// Orders menu items
add_filter ('woocommerce_account_menu_items', [$account,'account_order']);

// Populate endpoint content
add_action('woocommerce_account_profile_endpoint','profile_custom_endpoint_content', 10, 1);
add_action('woocommerce_account_finance_endpoint','finance_custom_endpoint_content', 10, 1);
add_action('woocommerce_account_property_endpoint','property_custom_endpoint_content', 10, 1);
add_action('woocommerce_account_business_endpoint','business_custom_endpoint_content', 10, 1);
add_action('woocommerce_account_webinar_endpoint','webinar_custom_endpoint_content', 10, 1);


// Helper functions
function profile_custom_endpoint_content() {
    include(get_template_directory() . '/woocommerce/myaccount/form/profile.php');
}
function finance_custom_endpoint_content() {
    include(get_template_directory() . '/woocommerce/myaccount/form/finance.php');
}
function property_custom_endpoint_content() {
    include(get_template_directory() . '/woocommerce/myaccount/form/property.php');
}
function business_custom_endpoint_content() {
    include(get_template_directory() . '/woocommerce/myaccount/form/business.php');
}
function webinar_custom_endpoint_content() {
    include(get_template_directory() . '/woocommerce/myaccount/form/webinar.php');
}


class Royal_Accounts {
    function __construct($pages) {
        $this->pages = $pages;
    }

    public function endpoints() {
        foreach($this->pages as $key=>$page) {
            add_rewrite_endpoint($page, EP_ROOT | EP_PAGES);
        }
    }

    public function query_vars($vars) {
        foreach($this->pages as $key=>$page) {
            $vars[] = $page;
        }
        return $vars;
    }

    public function flush_rewrite_rules() {
        flush_rewrite_rules();
    }

    public function account_order() {
        $order = array();
        foreach($this->pages as $key=>$page) {
            $title = ucwords($page);
            $order[$page] = __($title,'woocommerce');
        }
        return $order;
    }
}
?>

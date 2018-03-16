<?php
require 'functions.php';
global $wpdb;
$location = "/my-account/property";
$header   = "Location: " . "https://" . $_SERVER['HTTP_HOST'] . $location;

$properties = $wpdb -> get_results("SELECT * FROM royal_properties WHERE user='{$user}'");

$businesses = $wpdb -> get_results("SELECT * FROM royal_businesses WHERE user='{$user}'");
$profiles = $wpdb -> get_results("SELECT * FROM royal_profiles WHERE user='{$user}'");

$setup = empty($properties);


// ---- VIEWS ---- //
include(locate_template('woocommerce/myaccount/form/property/index.php'));
include(locate_template('woocommerce/myaccount/form/property/property-form.php'));


// ---- DATA ---- //
if (isset($_POST['add_properties'])) {
    $accountDB->add_properties();
    header($header);
}
if (isset($_REQUEST['delete_properties'])) {
    $id = $_REQUEST['data-id'];
    $table ="royal_properties";
    $accountDB->delete_row($id,$table);
    header($header);
}
if (isset($_REQUEST['update_properties'])) {
    $id = $_REQUEST['data-id'];
    $accountDB->update_properties($id);
    header($header);
}
?>


<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
 $(document).ready(function() {
     // SQL Data Object
     var properties = <?php echo json_encode($properties, JSON_HEX_TAG); ?>;
     accounts({properties});
 });
</script>

<?php
require 'functions.php';
global $wpdb;


$location = "/my-account/finance";
$header   = "Location: " . "https://" . $_SERVER['HTTP_HOST'] . $location;

$assets      = $wpdb->get_results("SELECT * FROM royal_assets WHERE user = '{$user}'");
$investments = $wpdb->get_results("SELECT * FROM royal_investments WHERE user = '{$user}'");
$retirement  = $wpdb->get_results("SELECT * FROM royal_retirement WHERE user = '{$user}'");


$profiles    = $wpdb->get_results("SELECT * FROM royal_profiles WHERE user = '{$user}'");

// ---- DATA ---- //
if (isset($_POST['add_assets'])) {
    $accountDB->add_assets();
    header($header);
}
if (isset($_REQUEST['update_assets'])) {
    $id = $_REQUEST['data-id'];
    $accountDB->update_assets($id);
    header($header);
}
if (isset($_REQUEST['delete_assets'])) {
    $id = $_REQUEST['data-id'];
    $table ="royal_assets";
    $accountDB->delete_row($id,$table);
    header($header);
}

// Investments
if (isset($_POST['add_investments'])) {
    $accountDB->add_investments();
    header($header);
}
if (isset($_REQUEST['update_investments'])) {
    $id = $_REQUEST['data-id'];
    $accountDB->update_investments($id);
    header($header);
}
if (isset($_REQUEST['delete_investments'])) {
    $id = $_REQUEST['data-id'];
    $table ="royal_investments";
    $accountDB->delete_row($id,$table);
    header($header);
}

// Retirement
if (isset($_POST['add_retirement'])) {
    $accountDB->add_retirement();
    header($header);
}
if (isset($_REQUEST['update_retirement'])) {
    $id = $_REQUEST['data-id'];
    $accountDB->update_retirement($id);
    header($header);
}
if (isset($_REQUEST['delete_retirement'])) {
    $id = $_REQUEST['data-id'];
    $table ="royal_retirement";
    $accountDB->delete_row($id,$table);
    header($header);
}


// ---- VIEWS ---- //
$templates = ['index','assets-form','investments-form','retirement-form'];
foreach ($templates as $key=>$name) {
    include(locate_template('woocommerce/myaccount/form/finance/'.$name.'.php'));
}
?>


<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
 $(document).ready(function() {
     // SQL Data Object
     var assets      = <?php echo json_encode($assets, JSON_HEX_TAG); ?>;
     var investments = <?php echo json_encode($investments, JSON_HEX_TAG); ?>;
     var retirement  = <?php echo json_encode($retirement, JSON_HEX_TAG); ?>;
     var tables      = {assets,investments,retirement};
     accounts(tables);

     var setup = <?php echo json_encode($setup, JSON_HEX_TAG); ?>;
 });
</script>

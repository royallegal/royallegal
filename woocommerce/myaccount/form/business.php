<?php
require 'functions.php';
global $wpdb;
$location = "/my-account/business";
$header   = "Location: " . "https://" . $_SERVER['HTTP_HOST'] . $location;

$businesses = $wpdb -> get_results("SELECT * FROM royal_businesses WHERE user = '{$user}'");

$setup = empty($businesses);


// ---- VIEWS ---- //
include(locate_template('woocommerce/myaccount/form/business/index.php'));
include(locate_template('woocommerce/myaccount/form/business/business-form.php'));


// ---- DATA ---- //
if (isset($_POST['add_businesses'])) {
    $accountDB->add_businesses();
    header($header);
}
if (isset($_REQUEST['update_businesses'])) {
    $id = $_REQUEST['data-id'];
    $accountDB->update_businesses($id);
    header($header);
}
if (isset($_REQUEST['delete_businesses'])) {
    $id = $_REQUEST['data-id'];
    $table = "royal_businesses";
    $accountDB->delete_row($id,$table);
    header($header);
}
?>


<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
 $(document).ready(function() {
     // SQL Data Object
     var businesses = <?php echo json_encode($businesses, JSON_HEX_TAG); ?>;
     accounts({businesses});
 });
</script>

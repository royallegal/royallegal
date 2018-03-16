<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $wpdb;
$names = ['users','profiles','goals','estate','assets','investments','retirement','properties','businesses'];

$tables = array();
foreach($names as $key=>$name) {
    $source;
    // Iterates through the names array to create unique table names
    ($name == 'users') ? $source = 'mattsharplaw_users' : $source = 'royal_'.$name;
    // Creates an array of SQL objects
    $tables[$name] = $wpdb -> get_results("SELECT * from ".$source);
}

function get_name($key) {
    return ucfirst(str_replace('$get_','',$key));
}
?>


<!-- JAVASCRIPT  -->
<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
 var data = <?php echo json_encode($accounts, JSON_HEX_TAG); ?>;
 console.log(data);
</script>


<!---- ADMIN ---->
<?php if (current_user_can('edit_posts')) {
    include(locate_template('woocommerce/myaccount/dashboard/admin_notifications.php'));
?>
    <!-- Exports  -->
    <div class="export form section">
        <?php include(locate_template('woocommerce/myaccount/dashboard/exports.php')); ?>
    </div>
<?php }



/* ---- CUSTOMERS ---- */
else { 
    include(locate_template('woocommerce/myaccount/dashboard/user_notifications.php'));
} ?>

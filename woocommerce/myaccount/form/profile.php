<?php
// ---- WORDPRESS ---- //
global $wpdb;
$current_user = wp_get_current_user();
$wp_id = $current_user->ID;
$meta  = get_user_meta($wp_id);


// ---- DATABASE ---- //
require 'functions.php';
// Web Info
$location = "/my-account/profile";
$header   = "Location: " . "https://" . $_SERVER['HTTP_HOST'] . $location;

// Tables
$profiles = $wpdb -> get_results("SELECT * FROM royal_profiles WHERE user = '{$user}'");
$goals    = $wpdb -> get_results("SELECT * FROM royal_goals WHERE user = '{$user}'");
$estate   = $wpdb -> get_results("SELECT * FROM royal_estate WHERE user = '{$user}'");
$clients  = $wpdb -> get_results("SELECT * FROM royal_clients WHERE user = '{$user}'");
// Conditional views (see profiles folder)
$setup = empty($profiles);

$post = (object) [
    'relationship' => $_POST['relationship'],
    'occupation'   => $_POST['occupation'],
    'first_name'   => $_POST['first_name'],
    'last_name'    => $_POST['last_name'],
    'gender'       => $_POST['gender'],
    'dob_day'      => $_POST['dob_day'],
    'dob_month'    => $_POST['dob_month'],
    'dob_year'     => $_POST['dob_year'],
    'birthday'     => $profile->birthday,
    'age'        => (date('Y') - date('Y',strtotime($birthday))),
    'protection'   => $goals[0]->protection,
    'investment'   => $goals[0]->investment,
];


// ---- METHODS ---- //
// ADD
// Profile
if (isset($_POST['add_profiles'])) {
    $accountDB->add_profiles();
    if ($post->relationship == 'Owner') {
        // WordPress
        if (empty($meta)) {
            add_user_meta($wp_id, 'first_name', $post->first_name);
            add_user_meta($wp_id, 'last_name', $post->last_name);
        }
        if (!empty($meta)) {
            update_user_meta($wp_id, 'first_name', $post->first_name);
            update_user_meta($wp_id, 'last_name', $post->last_name);
        }
    }
    header($header);
}

// Goals
if (isset($_POST['update_goals'])) {
    $accountDB->add_goals();
    header($header);
}
// Estate
if ( isset($_POST['update_estate'])) {
    $accountDB->add_estate();
    header($header);
}

// UPDATE
// Profile
if (isset($_POST['update_profiles'])) {
    $id = $_POST['data-id'];
    $accountDB->update_profiles($id);
    if ($post->relationship == 'Owner') {
        // WordPress
        if (empty($meta)) {
            add_user_meta($wp_id, 'first_name', $post->first_name);
            add_user_meta($wp_id, 'last_name', $post->last_name);
        }
        if (!empty($meta)) {
            update_user_meta($wp_id, 'first_name', $post->first_name);
            update_user_meta($wp_id, 'last_name', $post->last_name);
        }
    }
    header($header);
}

// DELETE
// Profile
if (isset($_REQUEST['delete_profiles'])) {
    $id = $_REQUEST['data-id'];
    $table = "royal_profiles";
    $accountDB->delete_row($id,$table);
    header($header);
}


// ---- HELPERS ---- //
function get_check($string, $word) {
    if (strpos(strtolower($string),strtolower($word)) !== false){
        return 'checked';
    }
}


// ---- VIEWS ---- //
$templates = ['index','profile-form','goals-form','estate-form'];
foreach($templates as $key=>$name) {
    include(locate_template('woocommerce/myaccount/form/profile/'.$name.'.php'));
}
?>


<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
 $(document).ready(function(){
     // SQL Data Object
     var profiles = <?php echo json_encode($profiles, JSON_HEX_TAG); ?>;
     var goals    = <?php echo json_encode($goals, JSON_HEX_TAG); ?>;
     var estate   = <?php echo json_encode($estate, JSON_HEX_TAG); ?>;
     var clients  = <?php echo json_encode($clients, JSON_HEX_TAG); ?>;
     var tables   = {profiles,goals,estate,clients};
     accounts(tables);
 });
</script>

<?php
global $wpdb;
$current_user = wp_get_current_user()->user_login;

// Creates a list of complete / incomplete tables
foreach ($tables as $key=>$table) {
    $completed[$key] = 'incomplete';
    foreach ($table as $data) {
        if (!empty($data) && $data->user == $current_user) {
            $completed[$key] = 'complete';
        }
    }
}
?>


<!-- Notifications  -->
<div class="notifications form section">
    <div class="notification account-setup">
        <strong>Setup Your Account</strong>
        <p>Please fill out your client profile so we can better advise you.</p>
        <ul>
            <?php foreach ($completed as $table=>$status) {
                if ($table != 'users') {
                    // Generate URLs
                    if ($table == 'profiles' || $table == 'goals' || $table == 'estate') { $url = 'profile'; }
                    if ($table == 'assets' || $table == 'investments' || $table == 'retirement') { $url = 'finance'; }
                    if ($table == 'properties') { $url = 'property'; }
                    if ($table == 'businesses') { $url = 'business'; }

                    // Generate Icons
                    if ($status == 'incomplete') {
                        $icon = 'fa-square-o';
                    }
                    if ($status == 'complete') {
                        $icon = 'fa-check-square-o';
                    }

                    // Create Notification
                    echo '<li class='.$status.'><a href="/my-account/'.$url.'"><i class="fa fa-fw '.$icon.'"></i>'.ucwords($table).'</a></li>';
                }
            }?>
        </ul>
    </div>
</div>

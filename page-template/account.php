<?php
/* Template Name: Account */
get_header();

// WordPress
$wp_user  = wp_get_current_user();
$wp_first = $wp_user->user_firstname;
$wp_last  = $wp_user->user_lastname;
$user     = $current_user->user_login;

// Accounts
$profiles    = $wpdb -> get_results("SELECT * FROM royal_profiles WHERE user='{$wp_user->user_login}' AND relationship='Owner'");
$businesses  = $wpdb -> get_results("SELECT * FROM royal_businesses WHERE user='{$wp_user->user_login}'");
$properties  = $wpdb -> get_results("SELECT * FROM royal_properties WHERE user='{$wp_user->user_login}'");
$clients     = $wpdb -> get_results("SELECT * FROM royal_clients WHERE user='{$wp_user->user_login}'");

// Vars
$registered = substr($wp_user->user_registered, 0, 4);
$rls_first = $profiles[0]->first_name;
$rls_last  = $profiles[0]->last_name;
$user_status = (object) [
    'wp'=>false,
    'rls'=>false,
    'first'=>false,
    'last'=>false,
];

if (!empty($wp_first) && !empty($wp_last)) {
    $user_status->wp = true;
}
if (!empty($rls_first) && !empty($rls_last)) {
    $user_status->rls = true;
}
if ($wp_first == $rls_first) {
    $user_status->first = true;
}
if ($wp_last == $rls_last) {
    $user_status->last = true;
}
?>


<?php if (is_user_logged_in()) { ?>
    <div class="account banner">
        <div class="container">
            <?php
            if (($user_status->wp) && ($user_status->rls) &&
                ($user_status->first) && ($user_status->last)) { ?>
                <div class="user section">
                    <div class="circle">
                        <?php echo "<p>".$wp_first[0].''.$wp_last[0]."</p>"; ?>
                    </div>
                    <?php echo "<p class='heading'>".$wp_first."'s<br>Account</p>"; ?>
                </div>
            <?php } else { ?>
                <div class="property section">
                    <p class="title">Your Profile</p>
                    <p class="status">Owner</p>
                    <a href="/my-account/profile">
                        <p class="upsell">Add information</p>
                    </a>
                </div>
            <?php } ?>

            <div class="membership section">
                <p class="title">Membership Status</p>
                <p class="status">
                    <?php
                    $level = $clients[0]->membership;
                    if (!empty($level)) {
                        echo "Level ".$level;
                    }
                    else {
                        echo "Inactive";
                    }
                    ?>
                </p>
                <a href="/product/family-office">
                    <p class="upsell">Manage Subscription</p>
                </a>
            </div>

            <div class="property section">
                <p class="title">Your Properties</p>
                <p class="status">
                    <?php
                    $local = sizeof($properties);
                    if ($local == 1) {
                        echo $local." Location";
                    }
                    else {
                        echo $local." Locations";
                    }
                    ?>
                </p>
                <a href="/my-account/property"><p class="upsell">Manage properties</p></a>
            </div>

            <div class="investment section">
                <p class="title">Your Businesses</p>
                <p class="status">
                    <?php
                    $biz = sizeof($businesses);
                    if ($biz == 1) {
                        echo $biz." Company";
                    }
                    else {
                        echo $biz." Companies";
                    }
                    ?>
                </p>
                <a href="/my-account/business"><p class="upsell">Manage businesses</p></a>
            </div>

            <div class="lifespan section">
                <p class="title">Customer Since</p>
                <p class="status">
                    <?php echo $registered; ?>
                </p>
            </div>
        </div>
    </div>
<?php } ?>


<main class="account">
    <?php if (is_user_logged_in()) { ?>
        <sidebar class="account">
            <?php
            /**
             * My Account navigation.
             * @since 2.6.0
             */
            do_action( 'woocommerce_account_navigation' );
            ?>
        </sidebar>
    <?php } ?>

    <?php the_content(); ?>
</main>


<footer>
    <?php get_template_part('snippets/footer/copyright'); ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>

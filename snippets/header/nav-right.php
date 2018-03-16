<?php
// WordPress
$wp_user  = wp_get_current_user();
$wp_first = $wp_user->user_firstname;

// Accounts
$profiles  = $wpdb -> get_results("SELECT * FROM royal_profiles WHERE user='{$wp_user->user_login}' AND relationship='Owner'");
$rls_first = $profiles[0]->first_name;

$logout = esc_url(wc_logout_url(wc_get_page_permalink('myaccount')));
?>


<div class="item">
    <a href="<?= current_user_can('edit_posts') ? "/quick-cart" : "/cart"; ?>">
        <span class="baseline">
            <i class="fa fa-fw fa-shopping-cart"></i>
            <p>Cart</p>
        </span>
    </a>
</div>

<div class="login-status item">
    <?php if (is_user_logged_in()) { ?>
        <span class="baseline">
            <a href="/my-account">
                <span class="greeting baseline">
                    <i class="fa fa-fw fa-user"></i>
                    <?php if (!empty($wp_first) && !empty($rls_first)
                              && $wp_first == $rls_first) { ?>
                        <p>Hi <?php echo $wp_first ?></p>
                    <?php } else { ?>
                        <p>My Account</p>
                    <?php } ?>
                </span>
            </a>
            <p class="logout">
                <a href="<?php echo $logout;?>">(logout)</a>
            </p>
        </span>
    <?php } else { ?>
        <span class="greeting baseline">
	    <p><a href="/my-account">Log In</a></p>
        </span>
    <?php } ?>
</div>

<div class="cta item">
    <a href="/cart">
	<p>Consultation</p>
    </a>
</div>

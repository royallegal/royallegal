<?php
// WordPress
$wp_user  = wp_get_current_user();
$wp_first = $wp_user->user_firstname;
/* $wp_last  = $wp_user->user_lastname;*/

// Accounts
$profiles  = $wpdb -> get_results("SELECT * FROM royal_profiles WHERE user='{$wp_user->user_login}' AND relationship='Owner'");
$rls_first = $profiles[0]->first_name;
/* $rls_last  = $profiles[0]->last_name;*/

$logout = esc_url(wc_logout_url(wc_get_page_permalink('myaccount')));
?>


<div id="logo" class="item">
    <a href="/">
        <div class="logo"></div>
    </a>
</div>

<div class="item trigger">
    <a class="disabled">
        <span class="baseline">
            <p>Services</p>
            <i class="fa fa-fw fa-angle-down reverse"></i>
        </span>
    </a>
    <div class="vertical composite sub menu">
        <div class="section">
            <div class="header">Asset Protection</div>
            <a href="/product/traditional-llc">
		<div class="item">
                    <p>Traditional LLC</p>
		</div>
            </a>
            <a href="/product/series-llc">
		<div class="item">
                    <p>Series LLC</p>
		</div>
            </a>
            <a href="/product/ira-owned-llc">
		<div class="item">
                    <p>IRA Owned LLC</p>
		</div>
            </a>
            <a href="/product/ira-owned-trust">
		<div class="item">
                    <p>IRA Owned Trust</p>
		</div>
            </a>
            <a href="/product/limited-partnership">
		<div class="item">
                    <p>Limited Partnership</p>
                </div>
            </a>
        </div>
        <div class="section">
            <div class="header">Other Services</div>
            <a href="/product/property-transfer">
                <div class="item">
                    <p>Property Transfer</p>
                </div>
            </a>
            <a href="/product/estate-planning">
                <div class="item">
                    <p>Estate Planning</p>
                </div>
            </a>
            <a href="/product/family-office">
                <div class="item">
                    <p>Family Office</p>
                </div>
            </a>
            <a href="/product/hourly-consulting">
                <div class="item">
                    <p>Hourly Consulting</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- <div class="item">
     <a href="/product/webinar">
     <p>Webinar</p>
     </a>
     </div> -->

<div class="item">
    <a href="/blog">
        <p>Blog</p>
    </a>
</div>

<div class="item">
    <a href="/contact-us">
        <p>Contact Us</p>
    </a>
</div>

<div class="item">
    <a href="tel:5127573994">
        <span class="vcenter">
            <i class="fa fa-fw fa-phone"></i>
            <p>1.512.757.3994</p>
        </span>
    </a>
</div>

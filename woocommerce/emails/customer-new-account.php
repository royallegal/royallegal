<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>


<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>


<h2>Let's Get Started!</h2>
<p>The first step is to log in to <a href="https://royallegalsolutions.com/my-account/">your account</a>. We're going to need you to fill out some forms so we can complete the documentation process.</p>

<p>Here's your login information.</p>
<ul style="list-style: none;">
    <li>
        <strong>Username: </strong>
        <?php printf(__('%1$s', 'woocommerce'), esc_html($user_login));?>
    </li>
    <li>
        <strong>Password: </strong>
        <?php printf(__('%1$s', 'woocommerce'), esc_html($user_pass));?>
    </li>
</ul>

<p>Once you complete the data-entry portion of the process, we'll generate your files and store them in the <a href="">documents page</a>.</p>

<p><a href="https://royallegalsolutions.com/contact-us">Contact Us</a> | <a href="https://royallegalsolutions.com/my-account/settings">Manage Account</a> | <a href="https://royallegalsolutions.com/my-account/orders">View Orders</a>.</p>


<?php do_action( 'woocommerce_email_footer', $email );

<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>


<?php wc_print_notices(); ?>
<?php do_action( 'woocommerce_before_customer_login_form' ); ?>


<div class="flip">
    <div class="flipper">
        <!-- FRONT SIDE -->
        <div id="login" class="card front">
            <form method="post">
                <?php do_action( 'woocommerce_login_form_start' ); ?>
                <h3 class="tcenter">Login</h3>

                <!-- Username  -->
                <div class="row">
                    <h4>Username</h4>
	            <input type="text"
                           name="username"
                           value="<?php !empty($_POST['username']) 
                                  ? esc_attr($_POST['username']) 
                                  : '' ?>"/>        
                </div>

                <!-- Password  -->
                <div class="row">
                    <h4>Password</h4>
	            <input type="password" name="password"/>
                    <p class="baseline">
                        <input name="rememberme"
                               type="checkbox"
                               id="rememberme"
                               value="forever"/>
                        <label for="rememberme">
                            <?php _e('Remember me', 'woocommerce');?>
                        </label>
                    </p>
                </div>

                <!-- Spam Trap -->
	        <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;">
                    <label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label>
                    <input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off"/>
                </div>

                <?php do_action( 'woocommerce_login_form' ); ?>
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

                <!-- Buttons  -->
                <div class="row">
                    <input class="button"
                           type="submit"
                           name="login"
                           value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
                        <p class="password-reset"><?php _e( 'Lost your password?', 'woocommerce' ); ?></p>
                    </a>
                    <p data-id="register" data-action="rotate">Register</p>
                </div>

                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>
        </div>


        <!-- BACK SIDE -->
        <div id="register" class="blue card back">
            <form method="post" class="register">
	        <?php do_action( 'woocommerce_register_form_start' ); ?>
	        <h3 class="tcenter">Register</h3>

                <!-- Username -->
                <div class="row">
                    <h4>Email Address</h4>
	            <input type="text"
                           name="email"/>
                </div>

                <!-- Password -->
                <div class="row">
                    <h4>Password</h4>
	            <input type="text" name="password"/>
                </div>

	        <!-- Spam Trap -->
	        <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;">
                    <label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label>
                    <input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off"/>
                </div>

	        <?php do_action( 'woocommerce_register_form' ); ?>
	        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <!-- Buttons -->
                <div class="row">
 	            <input class="button"
                           type="submit"
                           name="register"
                           value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
                    <p data-id="login" data-action="rotate">Log In</p>
                </div>

	        <?php do_action( 'woocommerce_register_form_end' ); ?>
            </form>
        </div>
    </div>
</div>


<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

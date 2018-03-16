<?php if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>




















<!-- PAYMENT METHODS -->
<?php
$saved_methods = wc_get_customer_saved_methods_list(get_current_user_id());
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types();
do_action('woocommerce_before_account_payment_methods', $has_methods);?>


<div class="payments section">
    <h3>Payments</h3>
    <hr class="push-down"/>

    <?php if ($has_methods) :?>
        <table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
	    <thead>
	        <tr>
		    <?php foreach (wc_get_account_payment_methods_columns() as $column_id => $column_name) :?>
		        <th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr($column_id);?> payment-method-<?php echo esc_attr($column_id);?>"><span class="nobr"><?php echo esc_html($column_name);?></span></th>
		    <?php endforeach;?>
	        </tr>
	    </thead>
	    <?php foreach ($saved_methods as $type => $methods) :?>
	        <?php foreach ($methods as $method) :?>
		    <tr class="payment-method<?php echo ! empty($method['is_default'])? ' default-payment-method' : ''?>">
		        <?php foreach (wc_get_account_payment_methods_columns() as $column_id => $column_name) :?>
			    <td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr($column_id);?> payment-method-<?php echo esc_attr($column_id);?>" data-title="<?php echo esc_attr($column_name);?>">
    <?php
    if (has_action('woocommerce_account_payment_methods_column_' . $column_id)) {
        do_action('woocommerce_account_payment_methods_column_' . $column_id, $method);
    } elseif ('method' === $column_id) {
        if (! empty($method['method']['last4'])) {
	    /* translators: 1: credit card type 2: last 4 digits */
	    echo sprintf(__('%1$s ending in %2$s', 'woocommerce'), esc_html(wc_get_credit_card_type_label($method['method']['brand'])), esc_html($method['method']['last4']));
        } else {
	    echo esc_html(wc_get_credit_card_type_label($method['method']['brand']));
        }
    } elseif ('expires' === $column_id) {
        echo esc_html($method['expires']);
    } elseif ('actions' === $column_id) {
        foreach ($method['actions'] as $key => $action) {
	    echo '<a href="' . esc_url($action['url']) . '" class="button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>&nbsp;';
        }
    }
    ?>
			    </td>
		        <?php endforeach;?>
		    </tr>
	        <?php endforeach;?>
	    <?php endforeach;?>
        </table>

    <?php else :?>

        <p class="woocommerce-Message woocommerce-Message--info woocommerce-info"><?php esc_html_e('No saved methods found.', 'woocommerce');?></p>

    <?php endif;?>

    <?php do_action('woocommerce_after_account_payment_methods', $has_methods);?>

    <a class="button" href="<?php echo esc_url(wc_get_endpoint_url('add-payment-method'));?>"><?php esc_html_e('Add payment method', 'woocommerce');?></a>
</div>











<!-- ADDRESS -->
<div class="address section">
    <h3>Address Boojk</h3>
    <hr class="push-down"/>

    <?php
    $customer_id = get_current_user_id();
    if (! wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
        $get_addresses = apply_filters('woocommerce_my_account_get_addresses', array(
	    'billing' => __('Billing address', 'woocommerce'),
	    'shipping' => __('Shipping address', 'woocommerce'),
        ), $customer_id);
    } else {
        $get_addresses = apply_filters('woocommerce_my_account_get_addresses', array(
	    'billing' => __('Billing address', 'woocommerce'),
        ), $customer_id);
    }
    $oldcol = 1;
    $col    = 1;
    ?>

    <p>
        <?php echo apply_filters('woocommerce_my_account_my_address_description', __('The following addresses will be used on the checkout page by default.', 'woocommerce'));?>
    </p>

    <?php if (! wc_ship_to_billing_address_only() && wc_shipping_enabled()) :?>
        <div class="u-columns woocommerce-Addresses col2-set addresses">
    <?php endif;?>

    <?php foreach ($get_addresses as $name => $title) :?>

        <div class="u-column<?php echo (($col = $col * -1) < 0)? 1 : 2;?> col-<?php echo (($oldcol = $oldcol * -1) < 0)? 1 : 2;?> woocommerce-Address">
	    <header class="woocommerce-Address-title title">
	        <h3><?php echo $title;?></h3>
	        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name));?>" class="edit"><?php _e('Edit', 'woocommerce');?></a>
	    </header>
	    <address>
	        <?php
	        $address = apply_filters('woocommerce_my_account_my_address_formatted_address', array(
		    'first_name'  => get_user_meta($customer_id, $name . '_first_name', true),
		    'last_name'   => get_user_meta($customer_id, $name . '_last_name', true),
		    'company'     => get_user_meta($customer_id, $name . '_company', true),
		    'address_1'   => get_user_meta($customer_id, $name . '_address_1', true),
		    'address_2'   => get_user_meta($customer_id, $name . '_address_2', true),
		    'city'        => get_user_meta($customer_id, $name . '_city', true),
		    'state'       => get_user_meta($customer_id, $name . '_state', true),
		    'postcode'    => get_user_meta($customer_id, $name . '_postcode', true),
		    'country'     => get_user_meta($customer_id, $name . '_country', true),
	        ), $customer_id, $name);
	        $formatted_address = WC()->countries->get_formatted_address($address);
	        if (! $formatted_address) {
		    _e('You have not set up this type of address yet.', 'woocommerce');
	        } else {
		    echo $formatted_address;
	        }
	        ?>
	    </address>
        </div>

    <?php endforeach;?>

    <?php if (! wc_ship_to_billing_address_only() && wc_shipping_enabled()) :?>
        </div>
    <?php endif;?>

</div>

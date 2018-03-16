<?php
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 12
);
$purchases = new WP_Query($args);


function product_loop($type, $purchases) {
    $id    = get_current_user_id();
    $data  = get_userdata($id);
    $email = $data->user_email;

    $purchases->the_post();
    $product = get_product($purchases->post->ID);

    if (wc_customer_bought_product($email,$id,$product->id)){
        $id = $product->category_ids[0];
        $category = get_term_by('id', $id, 'product_cat', 'ARRAY_A');

        if ($type == 'subscriptions' && $category['name'] == 'Memberships') {
            return woocommerce_get_template_part('content', 'product');            
        }
        if ($type == 'purchases' && $category['name'] != 'Memberships') {
            return woocommerce_get_template_part('content', 'product');
        }
    }
}
?>


<?php if ($purchases->have_posts()) { ?>
    <div class="subscriptions form section">
        <h3>Subscriptions</h3>
        <hr/>
        <div class="gallery">
            <?php while ($purchases->have_posts()) {
                product_loop('subscriptions', $purchases);
            } ?>
        </div>
    </div>

    <div class="purchases form section">
        <h3>Your Purchases</h3>
        <hr/>
        <div class="gallery">
            <?php while ($purchases->have_posts()) {
                product_loop('purchases', $purchases);
            } ?>
        </div>
    </div>
<?php } ?>

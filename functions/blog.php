<?php
// Excerpt Formatting
function custom_wp_trim_excerpt($text) {
    $raw_excerpt = $text;
    if ( '' == $text ) {
        //Retrieve the post content. 
        $text = get_the_content('');
        
        //Delete all shortcode tags from the content. 
        $text = strip_shortcodes( $text );
        
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);
        
        $allowed_tags = 'p'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
        $text = strip_tags($text, $allowed_tags);
        
        $excerpt_word_count = 55; /*** MODIFY THIS. change the excerpt word count to any integer you like.***/
        $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
        
        $excerpt_end = '[...]'; /*** MODIFY THIS. change the excerpt endind to something else.***/
        $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
        
        $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
        } else {
            $text = implode(' ', $words);
        }
    }
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');


if ( ! function_exists( 'display_related_products' ) ) {
    function display_related_products($post_tag) { ?>
    <div class="related-products">
        <?php
        $args = array(
            'post_type' => 'product',
            'tag' => $post_tag, // Here is where is being filtered by the tag you want
            'orderby' => 'id',
            'order' => 'ASC'
        );
        $related_products = new WP_Query( $args );

        while ($related_products->have_posts()) : $related_products->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="related-product">
                <?php if(has_post_thumbnail()) :
                the_post_thumbnail( 'full', array('class'=>'related-product-img', 'alt'=>get_the_title()));
                endif; ?>
            </a>
        <?php endwhile; wp_reset_query(); ?>
    </div>
<?php } } ?>

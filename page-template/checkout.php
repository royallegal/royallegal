<?php
/* Template Name: Checkout */
get_header();
$current_user = wp_get_current_user();
?>


<main class="checkout">
    <?php the_content(); ?>
</main>

<footer>
    <?php get_template_part('snippets/footer/copyright'); ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>

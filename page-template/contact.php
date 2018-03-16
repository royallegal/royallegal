<?php
/* Template Name: Contact Us*/
get_header();
?>


<main>
    <div class="mask"></div>

    <?php
    /* Contact Us */
    if (is_page('contact-us')) {
        get_template_part('snippets/form/contact-us');
    }

    /* Basic Form */
    else {
        the_content();
    }
    ?>
</main>


<?php get_footer(); ?>

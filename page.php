<?php
/* Template Name: Default Template */
get_header();
 ?>


<main>
    <div class="content">
        <div class="top widgets">
            <?php  
                if (is_active_sidebar('top_widgets')) {
                    dynamic_sidebar('top_widgets');
                }
            ?>
        </div>

        <article>
       
            <?php the_content(); ?>
        </article>

        <div class="bottom widgets">
            <?php  
                if (is_active_sidebar('bottom_widgets')) {
                    dynamic_sidebar('bottom_widgets');
                }
            ?>
        </div>
    </div>
</main>
<?php get_footer();

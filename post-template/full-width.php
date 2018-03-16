<?php
/*
   Template Name: Full-Width
   Template Post Type: Post
 */
get_header();
?>


<main class="feed">
    <div class="sidebar_data sidebar_full">
        <?php
        if (is_active_sidebar('top_widgets')) {
            dynamic_sidebar('top_widgets');
        }
        ?>

        <div class="h2_data">
            <?php
            while ( have_posts() ) : the_post();
            echo '<h2>'.get_the_title().'</h2>';
            echo '<div class="blog-cnt-main">';
            echo '<div class="blog-cnt"><p>'.get_the_content().'</p></div>';
            echo '</div>';
            endwhile; // End of the loop.
            ?>
        </div>

        <?php
        
        if (is_active_sidebar('bottom_widgets')) :
        dynamic_sidebar('bottom_widgets');
        endif;
         
        ?>

        <div class="pagination">
            <ul>
                <li><?php previous_post_link( '%link', 'Previous'); ?></li>
                <li><?php next_post_link( '%link', 'Next'); ?></li>
            </ul>
        </div>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
        ?>

    </div>
</main>


<?php get_footer(); ?>

<?php
get_header();
?>


<main>
    <div class="content">
	<?php if (is_active_sidebar('top_widgets')) { ?>
	    <div class="top widgets">
		<?php dynamic_sidebar('top_widgets'); ?>
	    </div>
	<?php } ?>

        <?php while (have_posts()) {
            the_post();
            echo '<article>';
            echo '<h1 class="title">'.get_the_title().'</h1>';
             the_content();
	    echo '</article>';

            echo '<div class="spread pagination">';
            previous_post_link( '%link', 'Previous');
            next_post_link( '%link', 'Next');
            echo '</div>';
        } ?>

        <?php
        if (is_active_sidebar('bottom_widgets')) { ?>
	    <div class="bottom widgets">
		<?php dynamic_sidebar('bottom_widgets'); ?>
	    </div>
        <?php } ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
        ?>
    </div>

    <sidebar>
        <?php get_sidebar(); ?>
    </sidebar>
</main>

<?php get_footer(); ?>

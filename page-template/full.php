<?php
/* Template Name: Full */
get_header();
?>


<main class="full">
    <?php  
    if (is_active_sidebar('top_widgets')) { ?>
	<div class="top widgets">
            <?php dynamic_sidebar('top_widgets'); ?>
	</div>
    <?php } ?>

    <?php the_content(); ?>

    <?php  
    if (is_active_sidebar('bottom_widgets')) { ?>
	<div class="bottom widgets">
	    <?php dynamic_sidebar('bottom_widgets'); ?>
	</div>
    <?php }  ?>
</main>


<?php get_footer(); 

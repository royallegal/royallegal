<?php
/* Display all category */

get_header();
?>

<section>
	<div class="stick_nav" style="padding-top: 66px;">
		<div class="blogs">
			<div class="container">
				 
				<div class="blog_container">
					<div class="col-8">
						<?php 
						 
							if (is_active_sidebar('top_widgets')) :
								dynamic_sidebar('top_widgets');
							endif;
					 
						
						while (have_posts()) : the_post();
							echo '<div class="blog_data">';
							echo '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
							if (has_post_thumbnail()):
								$url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
								echo '<img src="'.$url[0].'" alt="img_small_1" draggable="false">';
							endif;
							echo apply_filters( 'the_excerpt', get_excerpt() );
							echo '</div>';
						endwhile; 
						
						the_posts_pagination( array(
							'mid_size'  => 2,
							'prev_text' => 'Previous',
							'next_text' => 'Next',
						) );
						
						?>
					</div>
					<div class="col-4">
						<div class="sidebar">
							<?php get_sidebar(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();

/* End display all category */
?>
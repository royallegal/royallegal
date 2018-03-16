<div class="feed">
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args  = array (
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
        'post_type'      => 'post'
    );
    $article = new WP_Query($args);
    $max_no_of_article = $article -> found_posts;
    $no_of_article = 0;
    ?>

    <?php while ($article-> have_posts()) { ?>
        <?php $article -> the_post(); ?>
        <article>
            <h2>
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                    <?php echo get_the_title(); ?>
                </a>
            </h2>
            <?php echo apply_filters( 'the_excerpt', get_excerpt() ); ?>
        </article>
        <?php $no_of_article++; ?>
    <?php } ?>

    <?php wp_reset_query(); ?>

    <?php if ($max_no_of_article > $no_of_article) {
        echo '<a href="'.get_permalink( get_option( 'page_for_posts' ) ).'">More</a>';
    } ?>
</div>


<script>
 var pageNumber = 1;
 var ppp = 3;

 $(".article").on("click", "#load_more_articles", function () {
     pageNumber++;
     var str = '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&action=more_article_ajax';

     $('#loader').show();

     $.ajax({
         type: "POST",
         dataType: "html",
         url: '<?php echo admin_url('admin-ajax.php'); ?>',
         data: str,
         success: function (data) {
             $('#load_more_articles').hide();
             $('.article #load_more_articles').hide();
             $(".disp-article").append(data);
         },
         error: function (jqXHR, textStatus, errorThrown) {
             $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
         }
     });
     return false;
 });
</script>

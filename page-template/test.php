<?php
/* Template Name: Blog */
get_header();

$args = array(
    'posts_per_page'=>-1,
    'orderby' => 'date',
    'order' => 'DESC',
);
$content = new WP_Query($args);
$posts = $content->posts;

$arr = array();
foreach ($posts as $i=>$post) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail')[0];
    $wp_cats = wp_get_post_categories($post->ID);
    $cats = array();
    foreach ($wp_cats as $category) {
        array_push($cats, $category->slug);
    }
    $wp_tags = wp_get_post_tags($post->ID);
    $tags = array();
    foreach ($wp_tags as $tag) {
        array_push($tags, $tag->slug);
    }
    $var = (object) [
        'slug'=>$post->post_name,
        'title'=>$post->post_title,
        'content'=>$post->post_content,
        'image'=>$image,
        'excerpt'=>$post->post_excerpt,
        'cats'=>$cats,
        'tags'=>$tags
    ];
    array_push($arr, $var);
}
?>


<main class="feed">
    <div class="content">
        <?php foreach ($arr as $article) {
            $title   = $article->title;
            $content = $article->content;
            $image   = $article->image;
            $excerpt = $article->excerpt;
            $excerpt = strip_shortcodes($excerpt);
            $excerpt = apply_filters('the_content', $excerpt);
            $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
            $cats    = $article->cats;
            $tags    = $article->tags;
        ?>
            <article data-cats="<?php echo implode(" ", $cats);?>"
                     data-tags="<?php echo implode(" ", $tags);?>">
                <?php if (!empty($image)) { ?>
                    <div class="featured image">
                        <div style="background-image: url('<?php echo $image;?>')"></div>
                        <i class="fa fa-play-circle"></i>
                    </div>
                <?php } ?>

                <div class="text">
                    <h2 class="title">
                        <a href="<?php echo $slug;?>"><?php echo $title;?></a>
                    </h2>
                    <div class="excerpt">
                        <?php echo $excerpt;?>
                    </div>
                    <a class="more" href="<?php echo $slug;?>">
                        Read More
                    </a>
                </div>
            </article>
        <?php } ?>
    </div>

    <sidebar>
        <?php get_sidebar(); ?>
    </sidebar>
</main>


<?php get_footer();

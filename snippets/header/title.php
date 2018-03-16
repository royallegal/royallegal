<div class="mask"></div>
<div class="title-group">
    <?php if (is_404()): ?>
        <h1 class="title">
            <?php echo '404'; ?>
        </h1>
        <h2 class="subtitle">
            <?php echo 'Page not found'; ?>
        </h2>


    <?php elseif (is_page() || is_singular()): ?>
        <h1 class="title"><?php echo get_the_title(); ?></h1>


    <?php elseif (is_category()): ?>
        <h1 class="title">
            <?php
            $category = $wp_query->get_queried_object();
            $cat_name = $category->name;
            echo '<p>' . $cat_name . '</p>';
            ?>
        </h1>

    <?php endif; ?>
</div>

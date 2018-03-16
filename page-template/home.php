<?php
/* Template Name: Home */
get_header();
?>


<div class="video-group">
    <div class="mask"></div>
    <!-- <iframe class="hidden video player" src="https://www.youtube.com/embed/4BTAaASt-gQ?rel=0?version=3&autoplay=1&controls=0&&showinfo=0&loop=10" frameborder="0"></iframe> -->
    <object id="ytplayer" class="hidden video player">
        <param name="movie" value="https://www.youtube.com/embed/4BTAaASt-gQ?rel=0?version=3&enablejsapi=1&autoplay=1&controls=0&&showinfo=0&loop=0">
        <param name="allowScriptAccess" value="always">
        <embed id="ytplayer" src="https://www.youtube.com/embed/4BTAaASt-gQ?rel=0?version=3&enablejsapi=1&autoplay=1&controls=0&&showinfo=0&loop=0" type="application/x-shockwave-flash" allowScriptAccess="always">
    </object>
</div>

<main>
    <article class="full">
        <div class="title-group">
            <h2>Credentials</h2>
        </div>

        <?php the_content(); ?>
    </article>
</main>


<?php get_footer(); ?>

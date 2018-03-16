     <div class="blue form banner newsletter">
        <button class="close">X</button>

        <div class="title-group">
            <?php if ($title) {
                echo '<h3 class=title>'.$title.'</h3>';
            } ?>
        </div>

        <?php echo do_shortcode('[yikes-mailchimp form="2"]'); ?>
    </div>
 
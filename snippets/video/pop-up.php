<?php
$video_type = 'vimeo';
?>

<?php if ($video_type) { ?>
    <div class="video pop-up">
        <span class="close_popup">X</span>

        <?php if ($video_type == 'vimeo'): ?>
        <iframe
            class="vimeo video"
            src="vimeo"
            frameborder="0"
            allowFullScreen>
        </iframe>

        <?php elseif ($video_type == 'youtube'): ?>
        <iframe
            class="youtube video"
            src="youtube"
            frameborder="0"
            allowFullScreen>
        </iframe>

        <?php endif ?>
    </div>
<?php } ?>

<?php
require 'functions.php';
global $wpdb;
$location = "/my-account/webinar";
$header   = "Location: " . "https://" . $_SERVER['HTTP_HOST'] . $location;
?>


<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
 $(document).ready(function() {
 });
</script>


<div class="section">
    <h3>Webinar</h3>
    <hr class="push-down"/>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/live_stream?channel=UC1NvwH8_lKTfRRn2Jo9ULzA" frameborder="0" allowfullscreen></iframe>
</div>

<div class="section" style="margin-top: 50px;">
    <div class="vcenter spread">
        <h3>Reference Material</h3>
        <a class="gray button" href="https://royallegalsolutions.com/wp-content/uploads/2017/08/Presentation-for-Real-Estate-Professionals-3-hour-2.pdf">Download PDF</a>
    </div>
    <hr class="push-down"/>
    <?php echo do_shortcode('[pdf-embedder url="https://royallegalsolutions.com/wp-content/uploads/2017/08/Presentation-for-Real-Estate-Professionals-3-hour-2.pdf" title="Presentation for Real Estate Professionals (3-hour)-2"]'); ?>
</div>

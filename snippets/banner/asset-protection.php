<div class="foot_image">
    
        <img src="<?php echo get_template_directory_uri(); ?>/images/foot_img.png"  alt="foot_img" draggable="false">
    
</div>
<div class="foot_form">
    <?php
     
        echo '<h3> footer_asset_protect_title </h3>';
    

    
        echo '<p> footer_asset_protect_subtitle </p>';
     
    ?>

    <div class="foot_link">
        <?php echo do_shortcode('[yikes-mailchimp form="1"]');
        //echo do_shortcode('[mailmunch-form id="469486"]');  ?>
    </div>

    <!-- <form>
         <div class="foot_link">
         <input type="text" placeholder="Email Address">
         <input type="submit" value="Get the Link">
         </div>
         </form> -->
</div>

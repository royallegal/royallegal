<div class="form tags section <?= $setup ? 'hidden' : '';?>"> 
    <div class="vcenter spread">
        <h3>Businesses</h3>
        <input class="small gray trigger button"
               type="button"
               name="businesses"
               data-action="form-trigger"
               value="Add Business"/>
    </div>

    <hr class="push-down"/>

    <div class="grid">
        <?php foreach($businesses as $key=>$business) { ?>
            <div class="tag">

                <!-- FRONT SIDE -->
                <div class="front">
                    <!-- Graphic -->
                    <div class="circle">
                        <p class="<?php echo strtolower($business->business).' '.strtolower($business->type) ?>">
                            <?php
                            $words = explode(' ', $business->type);
                            foreach($words as $word) {
                                echo $word[0];
                            }
                            ?>
                        </p>
                    </div>
                    <!-- Title -->
                    <div class="title-group">
                        <?php
                        echo '<h4>'.$business->business.'</h4>';
                        echo '<p class="description">$'.number_format($business->income).'</p>';
                        ?>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="back">
                    <!-- Edit -->
                    <input class="borderless ghost trigger button"
                           type="button"
                           name="businesses"
                           data-action="form-trigger"
                           data-id="<?php echo $business->id;?>"
                           value="Edit">
                    <!-- Delete -->
                    <p>
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                              method="POST"
                              name="delete">
                            <input type="hidden" name="data-id" value="<?php echo $business->id; ?>">
                            <input class="borderless ghost trigger button"
                                   type="submit"
                                   name="delete_businesses"
                                   data-action="form-trigger"
                                   data-id="<?php echo $business->id; ?>"
                                   value="Delete">
                        </form>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

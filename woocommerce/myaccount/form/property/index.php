<div class="form tags section  <?= empty($properties) ? 'hidden' : '';?>">
    <div class="vcenter spread">
        <h3>Properties</h3>
        <input class="small gray trigger button"
               type="button"
               name="properties"
               data-action="form-trigger"
               value="Add Property"/>
    </div>

    <hr class="push-down"/>

    <div class="grid">    	
        <?php foreach($properties as $key=>$property) { ?>
            <div class="tag">

                <!-- FRONT SIDE -->
                <div class="front">
                    <div class="tcenter title-group">
                        <?php
                        echo '<h4>'.$property->city.' ('.$property->purchase.')</h4>';
                        echo '<p class="description">$'.number_format($property->value).'</p>';
                        ?>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="back">
                    <!-- Edit -->
                    <input class="borderless ghost trigger button"
                           type="button"
                           name="properties"
                           data-action="form-trigger"
                           data-id="<?php echo $property->id;?>"
                           value="Edit">
                    <!-- Delete -->
                    <p>
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                              method="POST"
                              name="delete">
                            <input type="hidden" name="data-id" value="<?php echo $property->id; ?>">
                            <input class="borderless ghost trigger button"
                                   type="submit"
                                   name="delete_properties" data-action="form-trigger"
                                   data-id="<?php echo $property->id; ?>"
                                   value="Delete">
                        </form>
                    </p>
                </div>
            </div>
        <?php  }  ?>
    </div>
</div>

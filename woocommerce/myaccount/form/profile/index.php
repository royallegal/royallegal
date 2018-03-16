<div class="form tags section <?= $setup ? 'hidden' : ''; ?>">
    <div class="vcenter spread">
        <h3>Profiles</h3>
        <input class="small gray trigger button"
               type="button"
               name="profiles"
               data-action="form-trigger"
               value="Add Family"/>
    </div>

    <hr class="push-down"/>

    <div class="grid">
        <?php foreach($profiles as $key=>$profile) { ?>
            <div class="tag">

                <!-- FRONT SIDE -->
                <div class="front">
                    <!-- Graphic -->
                    <div class="circle">
                        <p class="<?php echo strtolower($profile->gender).' '.strtolower($profile->relationship) ?>">
                            <?php echo $profile->first_name[0].' '.$profile->last_name[0] ?>
                        </p>
                    </div>
                    <!-- Title -->
                    <div class="title-group">
                        <?php echo '<h4>'.$profile->first_name.' '.$profile->last_name.'</h4>';?>
                        <p class="description">
                            <?php if (empty($profile->relationship)) {
                                echo 'Add Relation';
                            } else {
                                echo $profile->relationship;
                            } ?>
                        </p>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="back">
                    <!-- Edit -->
                    <input class="borderless ghost trigger button"
                           type="submit"
                           name="profiles"
                           data-action="form-trigger"
                           data-id="<?php echo $profile->id;?>"
                           value="Edit">
                    <!-- Delete -->
                    <p>
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                              method="POST"
                              name="delete">
                            <input type="hidden" name="data-id" value="<?php echo $profile->id; ?>">
                            <input class="borderless ghost trigger button"
                                   type="submit"
                                   name="delete_profiles"
                                   data-action="form-trigger"
                                   data-id="<?php echo $profile->id; ?>"
                                   value="Delete">
                        </form>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<!-- OTHER SECTION -->
<div class="form tags section <?= $setup ? 'hidden' : ''; ?>">
    <div class="vcenter spread">
        <h3>Other Information</h3>
    </div>

    <hr class="push-down"/>

    <div class="grid">
        <div id="goals" class="tag">
            <div class="front">
                <div class="tcenter title-group">
                    <h4>Account Goals</h4>
                    <p class="status description">
                        <?= (empty($goals)) ? 'Incomplete' : 'Complete'; ?>
                    </p>
                </div>
            </div>
            <div class="back">
                <input class="borderless ghost trigger button"
                       type="button"
                       name="goals"
                       data-action="form-trigger"
                       data-id="<?php echo $goals[0]->id; ?>"
                       value="Edit">
                <!-- Delete -->
                <p>
                    <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                          method="POST"
                          name="delete">
                        <input type="hidden"
                               name="data-id"
                               value="<?php echo $goals[0]->id; ?>">
                        <input class="borderless ghost trigger button"
                               type="submit"
                               name="delete_goals"
                               data-action="form-trigger"
                               data-id="<?php echo $goals[0]->id; ?>"
                               value="Clear">
                    </form>
                </p>
            </div>
        </div>

        <div id="estate" class="tag">
            <div class="front">
                <div class="tcenter title-group">
                    <h4>Estate Planning</h4>
                    <p class="status description">
                        <?= (empty($estate)) ? 'Incomplete' : 'Complete'; ?>
                    </p>
                </div>
            </div>
            <div class="back">
                <input class="borderless ghost trigger button"
                       type="button"
                       name="estate"
                       data-action="form-trigger"
                       data-id="<?php echo $estate[0]->id;?>"
                       value="Edit">
                <!-- Delete -->
                <p>
                    <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                          method="POST"
                          name="delete">
                        <input type="hidden"
                               name="data-id"
                               value="<?php echo $estate[0]->id; ?>">
                        <input class="borderless ghost trigger button"
                               type="submit"
                               name="delete_estate"
                               data-id="<?php echo $estate[0]->id;?>"
                               value="Clear">
                    </form>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="form tags section">
    <div class="vcenter spread">
        <h3>Cash Assets</h3>
        <input class="small gray trigger button <?= empty($assets) ? 'hidden' : '';?>"
               type="button"
               name="assets"
               data-action="form-trigger"
               value="Add Asset"/>
    </div>

    <hr class="push-down"/>

    <div class="grid">
        <div class="instructions" <?= empty($assets) ? '' : 'hidden';?>>
            <p>Please complete the following schedule of your cash assets. This includes checking, savings, and money market accounts, certificates of deposit, and cash value in life insurance.</p>
            <input class="trigger button"
                   type="button"
                   name="assets"
                   data-action="form-trigger"
                   value="Add Asset"/>
        </div>

        <?php foreach($assets as $key=>$asset) { ?>
            <div class="tag">

                <!-- FRONT SIDE -->
                <div class="front">
                    <!-- Graphic -->
                    <div class="circle">
                        <p class="<?php echo strtolower($asset->type); ?>">
                            <?php echo $asset->type[0];?>
                        </p>
                    </div>
                    <!-- Title -->
                    <div class="title-group">
                        <?php
                        echo '<h4>'.$asset->type.'</h4>';
                        echo '<p class="description">$'.number_format($asset->balance).'</p>';
                        ?>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="back">
                    <!-- Edit -->
                    <input class="borderless ghost trigger button"
                           type="submit"
                           name="assets"
                           data-action="form-trigger"
                           data-id="<?php echo $asset->id; ?>"
                           value="Edit">
                    <!-- Delete -->
                    <p>
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                              method="POST"
                              name="delete">
                            <input type="hidden" name="data-id" value="<?php echo $asset->id; ?>">
                            <input class="borderless ghost trigger button"
                                   type="submit"
                                   name="delete_assets"
                                   data-action="form-trigger"
                                   data-id="<?php echo $asset->id; ?>"
                                   value="Delete">
                        </form>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<div class="form tags section">
    <div class="vcenter spread">
        <h3>Investment Portfolio</h3>
        <input class="small gray trigger button <?= empty($investments) ? 'hidden' : '';?>"
               type="button"
               name="investments"
               data-action="form-trigger"
               value="Add Investment"/>
    </div>

    <hr class="push-down"/>

    <div class="grid">
        <div class="instructions <?= empty($investments) ? '' : 'hidden';?>">
            <p>Please complete the following schedule of non-retirement account investments you own.</p>
            <input class="trigger button"
                   type="button"
                   name="investments"
                   data-action="form-trigger"
                   value="Add Investment"/>
        </div>

        <?php foreach($investments as $key=>$investment) { ?>
            <div class="tag">

                <!-- FRONT SIDE -->
                <div class="front">
                    <!-- Graphic -->
                    <div class="circle">
                        <p class="<?php echo strtolower($investment->owner); ?>">
                            <?php echo substr(($investment->owner),0,2) ?>
                        </p>
                    </div>
                    <!-- Title -->
                    <div class="title-group">
                        <?php
                        echo '<h4>'.ucfirst($investment->type).'</h4>';
                        echo '<p class="description">$'.number_format($investment->value).'</p>';
                        ?>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="back">
                    <!-- Edit -->
                    <input class="borderless ghost trigger button"
                           type="submit"
                           name="investments"
                           data-action="form-trigger"
                           data-id="<?php echo $investment->id; ?>"
                           value="Edit">
                    <!-- Delete -->
                    <p>
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                              method="POST"
                              name="delete">
                              <input type="hidden" name="data-id" value="<?php echo $investment->id; ?>">
                            <input class="borderless ghost trigger button"
                                   type="submit"
                                   name="delete_investments"
                                   data-action="form-trigger"
                                   data-id="<?php echo $investment->id; ?>"
                                   value="Delete">
                        </form>
                    </p>
                </div>
            </div>
        <?php  }  ?>
    </div>
</div>


<div class="form tags section">
    <div class="vcenter spread">
        <h3>Retirement Plans</h3>
        <input class="small gray trigger button <?= empty($retirement) ? 'hidden' : '';?>"
               type="button"
               name="retirement"
               data-action="form-trigger"
               value="Add Plan"/>
    </div>

    <hr class="push-down"/>

    <div class="grid">
        <div class="instructions <?= empty($retirement) ? '' : 'hidden';?>">
            <p>Please complete the following schedule of retirement accounts you own. This includes IRAs, 401(k)s, SEPs, SIMPLEs, or Defined Benefit Plans and Deferred Compensation Plans.</p>
            <input class="trigger button"
                   type="button"
                   name="retirement"
                   data-action="form-trigger"
                   value="Add Plan"/>
        </div>

        <?php foreach($retirement as $key=>$retirements) { ?>
            <div class="tag">

                <!-- FRONT SIDE -->
                <div class="front">
                    <!-- Grahpic -->
                    <div class="circle">
                        <p class="<?php echo strtolower($retirements->investment).' '.strtolower($retirements->participant) ?>">
                            <?php echo substr($retirements->participant,0,2); ?>
                        </p>
                    </div>
                    <!-- Title -->
                    <div class="title-group">
                        <?php
                        echo '<h4>'.$retirements->plan.'</h4>';
                        echo '<p class="description">$'.number_format($retirements->balance).'</p>';
                        ?>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="back">
                    <!-- Edit -->
                    <input class="borderless ghost trigger button"
                           type="submit"
                           name="retirement"
                           data-action="form-trigger"
                           data-id="<?php echo $retirements->id; ?>"
                           value="Edit">
                    <!-- Delete -->
                    <p>
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>"
                              method="POST"
                              name="delete">
                            <input type="hidden" name="data-id" value="<?php echo $retirements->id; ?>">
                            <input class="borderless ghost trigger button"
                                   type="submit"
                                   name="delete_retirement"
                                   data-action="form-trigger"
                                   data-id="<?php echo $retirements->id; ?>"
                                   value="Delete">
                        </form>
                    </p>
                </div>
            </div>
        <?php  }  ?>
    </div>
</div>

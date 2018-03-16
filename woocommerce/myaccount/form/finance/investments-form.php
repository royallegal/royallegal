<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      class="toggle hidden"
      name="investments">

    <div class="vcenter spread">
        <h3>Investment Details</h3>
        <div class="small gray trigger button" data-action="back">Go Back</div>
    </div>

    <hr class="push-down"/>

    <div id="owner" class="gray row">
        <h4>Owner</h4>
        <select class="select" name="owner">
            <option class="placeholder" selected> -- Select -- </option>
            <?php foreach ($profiles as $profile) { ?>
                <option class="option" value="<?php echo $profile->relationship; ?>">
                    <?php echo $profile->relationship; ?>
                </option>
            <?php } ?>
            <option class="option" value="trust">Trust</option>
        </select>
    </div>

    <div id="type" class="gray row">
        <h4>Investment Type</h4>
        <select class="select" name="type">
            <option class="placeholder" selected> -- Select -- </option>
            <option class="option" value="Stocks">Stocks</option>
            <option class="option" value="REIT">REIT</option>
            <option class="option" value="Oil & Gas">Oil & Gas</option>
            <option class="option" value="Life Insurance">Life Insurance</option>
            <option class="option" value="Notes">Notes</option>
        </select>
    </div>

    <div id="value" class="gray row">
        <h4>Current Value</h4>
        <input type="number" name="value"/>
    </div>

    <hr class="push-up"/>
    <input type="hidden" name="data-id"  value="">
    <input class="button" type="submit" name="" value="Save">
</form>

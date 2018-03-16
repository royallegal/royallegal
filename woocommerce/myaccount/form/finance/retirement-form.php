<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      class="toggle hidden"
      name="retirement">

    <div class="vcenter spread">
        <h3>Retirement Details</h3>
        <div class="small gray trigger button" data-action="back">Go Back</div>
    </div>

    <hr class="push-down"/>

    <div id="plan" class="gray row">
        <h4>Plan Type</h4>
        <select class="select" name="plan">
            <option class="placeholder" selected> -- Select -- </option>
            <option class="option" value="IRA">IRA</option>
            <option class="option" value="401(k)">401(k)</option>
            <option class="option" value="SEP">SEP</option>
            <option class="option" value="SIMPLE">SIMPLE</option>
            <option class="option" value="Defined Benefit / Deferred Comp">Defined Benefit / Deferred Comp</option>
            <option class="option" value="Other">Other</option>
        </select>
		
        <br>
        
        <div id="plan_txt" class="gray row">
            <h4>Other Plan Type</h4>
            <input type="text" name="plan_txt">
        </div>

        <div id="llc" class="gray row">
            <label for="llc">
                Does this plan own an LLC with checkbook control?
            </label>
            <input type="text" name="llc" placeholder="LLC Name"/>
        </div>
    </div>

    <div id="participant" class="gray row">
        <h4>Plan Participant</h4>
        <select class="select" name="participant">
            <option class="placeholder" selected> -- Select -- </option>
            <?php foreach($profiles as $profile) { ?>
                <option class="option" value="<?php echo $profile->relationship; ?>">
                    <?php echo $profile->relationship; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div id="balance" class="gray row">
        <h4>Current Account Balance</h4>
        <input type="number" name="balance"/>
    </div>

    <div id="investment" class="gray row">
        <h4>Investment Type</h4>
        <select class="select" name="investment">
            <option class="placeholder" selected> -- Select -- </option>
            <option value="Stocks">Stocks</option>
            <option value="Mutual Funds">Mutual Funds</option>
            <option value="Notes">Notes</option>
            <option value="Real Estate">Real Estate</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div id="max_contribution" class="gray row">
        <h4>Max Annual Contribution?</h4>
        <div class="baseline">
            <input type="radio" name="max_contribution" value="Yes">
            <label for="max_contribution">Yes</label>
        </div>
        <div class="baseline">
            <input type="radio" name="max_contribution" value="No">
            <label for="max_contribution">No</label>
        </div>
    </div>

    <div id="satisfaction" class="gray row">
        <h4>Satisfied with Performance?</h4>
        <div class="baseline">
            <input type="radio" name="satisfaction" value="Yes">
            <label for="satisfaction">Yes</label>
        </div>
        <div class="baseline">
            <input type="radio" name="satisfaction" value="No">
            <label for="satisfaction">No</label>
        </div>
    </div>

    <hr class="push-up"/>
    <input type="hidden" name="data-id" value="<?php echo $retirement->id; ?>">
    <input class="button" type="submit" name="" value="Save">
</form>

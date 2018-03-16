<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      class="toggle hidden"
      name="assets">

    <div class="vcenter spread section">
        <h3>Asset Details</h3>
        <div class="small gray trigger button" data-action="back">Go Back</div>
    </div>

    <hr class="push-down"/>

    <div id="type" class="gray row">
        <h4>Asset Type</h4>
        <select class="select" name="type">
            <option class="placeholder" selected> -- Select -- </option>
            <option class="option" value="Checking">Checking</option>
            <option class="option" value="Savings">Savings</option>
            <option class="option" value="Money Market">Money Market</option>
            <option class="option" value="Certificate of Deposit">Certificate of Deposit</option>
            <option class="option" value="Life Insurance Cash Value">Life Insurance Cash Value</option>
            <option class="option" value="Other">Other</option>
        </select>
        <div class="hidden row">
            <h4>Other Asset</h4>
            <input type="text" name="type_txt">
        </div>
    </div>
    
    <div id="balance" class="gray row">
        <h4>Current Account Balance</h4>
        <input type="number" name="balance"/>
    </div>

    <hr class="push-up"/>
    <input type="hidden" name="data-id"  value="">
    <input class="button" type="submit" name="" value="Save">
</form>

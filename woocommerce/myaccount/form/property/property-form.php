<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      name="properties"
      class="toggle <?= $setup ? '' : 'hidden'; ?>">

    <div class="vcenter spread">
        <h3>Property Details</h3>
        <div class="small gray trigger button <?= $setup ? 'hidden' : ''; ?>"
             data-action="back">
            Go Back
        </div>
    </div>

    <hr class="push-down"/>

    <div id="owner" class="gray row">
        <h4>Property Owner</h4>
        <select class="select" name="owner">
            <option class="placeholder" selected> -- Select -- </option>
            <?php
            foreach ($profiles as $profile) {
                $individual = $profile->first_name;
                echo '<option class="option" value="'.$individual.'">'.$individual.'</option>';
            }
            foreach ($businesses as $business) {
                $entity = $business->business;
                echo '<option class="option" value="'.$entity.'">'.$entity.'</option>';
            }
            ?>
        </select>
    </div>

    <!-- <div id="type">
         <input type="hidden" name="type" value=""/>
         </div> -->

    <div id="purchase" class="gray row">
        <h4>Purchase Year</h4>
        <input type="text" name="purchase"/>
    </div>

    <div id="equity" class="gray row">
        <h4>Equity</h4>
        <input type="number" name="equity" min="0" max="100" placeholder="1"/>
    </div>    

    <div id="address" class="gray row">
        <h4>Location</h4>
        <input class="ship-address"
               name="address"
               placeholder="Street Address"
               autocomplete="shipping street-address">
        <div class="location triple-column">
            <input class="ship-address"
                   name="city"
                   placeholder="City"
                   autocomplete="shipping locality">
            <input class="ship-address"
                   name="state"
                   placeholder="State"
                   autocomplete="shipping region">
            <input class="ship-address"
                   name="zip"
                   placeholder="Zip"
                   autocomplete="shipping postal-code">
        </div>
    </div>

    <div id="value" class="gray row">
        <h4>Fair Market Value</h4>
        <input type="number" name="value"/>
    </div>

    <div id="mortgage" class="gray row">
        <h4>Mortgage Balance</h4>
        <input type="number" name="mortgage"/>
    </div>

    <div id="income" class="gray row">
        <h4>Annual Net Rental Income</h4>
        <input type="number" name="income"/>
    </div>

    <div id="dispose" class="gray row">
        <h4>Looking to Dispose?</h4>
        <div class="baseline">
            <input type="radio" name="dispose" value="Y"/>
            <label for="dispose">Yes</label>
        </div>
        <div class="baseline">
            <input type="radio" name="dispose" value="N"/>
            <label for="dispose">No</label>
        </div>
    </div>

    <hr class="push-up"/>

    <input type="hidden" name="data-id" value="">
    <input class="button" type="submit" name="add_properties" value="Save">
</form>

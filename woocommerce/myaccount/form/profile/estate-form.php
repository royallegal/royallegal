<?php
$living_trust      = $estate[0]->living_trust;
$insurance         = $estate[0]->insurance;
$hsa               = $estate[0]->hsa;
$minor_investments = $estate[0]->minor_investments;
$referrals         = $estate[0]->referrals;
$other       = $estate[0]->other;
?>


<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      name="estate"
      class="toggle hidden">

    <div class="vcenter spread">
        <h3>Estate Planning</h3>
        <div class="small gray trigger button" data-action="back">Go Back</div>
    </div>

    <hr class="push-down"/>

    <div id="insurance" class="gray row">
        <h4>Health Insurance</h4>
        <select class="select" name="insurance">
            <option class="placeholder"
                    <?= ($insurance == "") ? 'selected' : '';?>>
                -- Covered By --
            </option>
            <?php
            $insurance_options = array('Employer','Myself','Medicare','Other');
            foreach ($insurance_options as $key=>$option) {
                $selected = '';
                if ($insurance == $option) { $selected = 'selected'; }

                echo '<option class="option" value="'.$option.'" '.$selected.'>'.$option.'</option>';
            } ?>
        </select>
    </div>

    <div id="living_trust" class="gray row">
        <h4>Do you have a living trust?</h4>
        <div class="baseline">
            <input type="radio" name="living_trust" value="Y">
            <label for="yes">Yes</label>
        </div>
        <div class="baseline">
            <input type="radio" name="living_trust" value="N">
            <label for="no">No</label>
        </div>
    </div>

    <div id="hsa" class="gray row">
        <h4>Do you have a health savings account (HSA)?</h4>
        <div class="baseline">
            <input type="radio" name="hsa" value="Y">
            <label for="yes">Yes</label>
        </div>
        <div class="baseline">
            <input type="radio" name="hsa" value="N">
            <label for="no">No</label>
        </div>
        <div class="baseline">
            <input type="radio" name="hsa" value="Self">
            <label for="self">Self Only</label>
        </div>
        <div class="baseline">
            <input type="radio" name="hsa" value="Family">
            <label for="family">Family Coverage</label>
        </div>
    </div>

    <div id="minor_investments" class="gray row">
        <h4>Do you have investment accounts in the name of your minor children?</h4>
        <div class="baseline">
            <input type="radio" name="minor_investments" value="Y">
            <label for="yes">Yes</label>
        </div>
        <div class="baseline">
            <input type="radio" name="minor_investments" value="N">
            <label for="no">No</label>
        </div>
    </div>

    <div id="referrals" class="gray row">
        <h4>Referrals</h4>
        <p>Would you like an introduction to any of the following professionals?</p>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="referrals[]" value="CPA">
            <label for="cpa">CPA</label>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="referrals[]" value="Bookkeeper">
            <label for="bookkeeper">Bookkeeper</label>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="referrals[]" value="Self-Directed Custodian">
            <label for="self-directed-custodian">Self-Directed Custodian</label>
        </div>
    </div>

    <div id="other" class="gray row">
        <h4>Other</h4>
        <p>Let us know if you have any other relevant information not covered above.</p>
        <textarea placeholder="Description" name="other"></textarea>
    </div>

    <hr class="push-up"/>
    <input class="button" type="submit" name="add_estate" value="Save">
</form>

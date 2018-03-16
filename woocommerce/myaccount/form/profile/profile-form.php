<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      class="toggle <?= $setup ? '' : 'hidden'; ?>"
      name="profiles">

    <div class="vcenter spread">
        <h3>User Information</h3>
        <div class="small gray trigger button <?= $setup ? 'hidden' : '';?>"
             data-action="back">
            Go Back
        </div>
    </div>

    <hr class="push-down"/>

    <div id="relationship" class="gray row">
        <h4>Relationship</h4>
        <?php if ($setup) { ?>
            <select class="disabled" name="relationship">
                <option value="Owner" selected>Owner</option>
            </select>
        <?php } else { ?>
            <select name="relationship">
                <option class="placeholder" selected>-- Select --</option>
                <option value="Owner">Owner</option>
                <option value="Spouse">Spouse</option>
                <option value="Child">Child</option>
                <option value="Other">Other</option>
            </select>
        <?php } ?>
    </div>

    <div id="full_name" class="gray row">
        <h4>Name</h4>
        <div class="double column">
            <input type="text"
                   name="first_name"
                   placeholder="First"/>
            <input type="text"
                   name="last_name"
                   placeholder="Last">
        </div>
    </div>

    <div id="birthday" class="gray row">
        <h4>Date of Birth</h4>
        <div class="triple column">
            <input type="number"
                   name="dob_day"
                   placeholder="Day (dd)"
                   min="0"
                   max="31"
                   maxlength='2'/>
            <input type="number"
                   name="dob_month"
                   placeholder="Month (mm)"
                   min="0"
                   max="12"
                   maxlength='2'/>
            <input type="number"
                   name="dob_year"
                   placeholder="Year (yyyy)"
                   min="0"
                   minlength="4"
                   maxlength='4'/>
        </div>
    </div>

    <div id="gender" class="gray row">
        <h4>Gender</h4>
        <div class="baseline">
            <input type="radio" name="gender" value="Male">
            <label for="male">Male</label>
        </div>
        <div class="baseline">
            <input type="radio" name="gender" value="Female">
            <label for="female">Female</label>
        </div>
    </div>

    <div id="occupation" class="gray row">
        <h4>Occupation</h4>
        <input type="text" name="occupation" placeholder="Occupation"/>
    </div>

    <div id="description" class="gray row">
        <h4>Description</h4>
        <input type="text"
               name="description"
               placeholder="Please provide any other relevant information?"/>
    </div>

    <hr class="push-up"/>
    <input type="hidden" name="data-id" value="">
    <input class="button" type="submit" name="add_profiles" value="Save">
</form>

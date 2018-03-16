<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      name="businesses"
      class="toggle <?= $setup ? '' : 'hidden'; ?>">

    <div class="vcenter spread">
        <h3>Business Details</h3>
        <div class="small gray trigger button <?= $setup ? 'hidden' : ''; ?>"
             data-action="back">
            Go Back
        </div>
    </div>

    <hr class="push-down"/>

    <div id="business" class="gray row">
        <h4>Name</h4>
        <input type="text" name="business" placeholder="e.g. 'Company Name'"/>
    </div>

    <div id="type" class="gray row">
        <h4>Entity Type</h4>
        <select class="select" name="type">
            <option class="placeholder" selected> -- Select -- </option>
            <option class="option" value="Sole Proprietor">Sole Proprietor</option>
            <option class="option" value="S-Corporation">S-Corporation</option>
            <option class="option" value="C-Corporation">C-Corporation</option>
            <option class="option" value="Partnership">Partnership</option>
            <option class="option" value="LLC">LLC</option>
        </select>
    </div>

    <div id="equity" class="gray row">
        <h4>Equity (%)</h4>
        <input type="number" name="equity" min="0" max="100" placeholder="1"/>
    </div>

    <div id="industry" class="gray row">
        <h4>Industry</h4>
        <input type="text" name="industry" placeholder="e.g. 'Retail'"/>
    </div>

    <div id="employees" class="gray row">
        <h4>Employees</h4>
        <input type="number" name="employees"/>
    </div>

    <div id="income" class="gray row">
        <h4>Annual Net Income</h4>
        <input type="number" name="income"/>
    </div>

    <div id="goal" class="gray row">
        <h4>Looking to Expand or Dispose?</h4>
        <div class="baseline">
            <input type="radio" name="goal" value="Expand">
            <label for="expand">Expand</label>
        </div>
        <div class="baseline">
            <input type="radio" name="goal" value="Dispose">
            <label for="dispose">Dispose</label>
        </div>
    </div>

    <hr class="push-up"/>
    <input type="hidden" name="data-id" value="">
    <input class="button" type="submit" name="add_businesses" value="Save">
</form>

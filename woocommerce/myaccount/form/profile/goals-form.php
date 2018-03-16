<?php
$protection = $goals[0]->protection;
$investment = $goals[0]->investment;
?>


<form action="<?= $_SERVER['REQUEST_URI'] ?>"
      method="POST"
      name="goals"
      class="toggle hidden">

    <div class="vcenter spread">
        <h3>My Goals</h3>
        <div class="small gray trigger button" data-action="back">Go Back</div>
    </div>

    <hr class="push-down"/>

    <div id="protection" class="gray row">
        <h4>Custom Protection</h4>
        <p>Please identify which of the following areas you currently use or plan on using in the future:</p>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="protection[]" value="Asset Protection">
            <div class="wrap">
                <label for="asset-protection">Asset Protection</label>
                <p class="description">Create or review a company to ensure protection and anonymity.</p>
            </div>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="protection[]" value="Estate Planning">
            <div class="wrap">
                <label for="estate-planning">Estate Planning</label>
                <p class="description">Pass your wealth to future generations.</p>
            </div>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="protection[]" value="Retirement Investing">
            <div class="wrap">
                <label for="retirement-investing">Retirement Investing</label>
                <p class="description">Develop strategies to funnel savings into alternative investment.</p>
            </div>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="protection[]" value="Passive Investing">
            <div class="wrap">
                <label for="passive-investing">Passive Investing</label>
                <p class="description">Allocate funds into real estate and/or other ventures.</p>
            </div>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="protection[]" value="Unlimited Advice">
            <div class="wrap">
                <label for="unlimited-advice">Unlimited Advice</label>
                <p class="description">Get as much legal and tax advice whenever you want.</p>
            </div>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="protection[]" value="Tax Writeoffs">
            <div class="wrap">
                <label for="tax-writeoffs">Tax Writeoffs</label>
                <p class="description">Maximize your year-end tax savings.</p>
            </div>
        </div>
        <textarea placeholder="Add a custom goal" name="protection_txt"></textarea>
    </div>

    <div id="investment" class="gray row">
        <h4>Investment Goals</h4>
        <p>Check any of the following real estate investment you are interested in:</p>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="investment[]" value="Rentals">
            <label for="rentals">Rentals</label>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="investment[]" value="Fix-n-Flips">
            <label for="fix-n-flips">Fix-n-Flips</label>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="investment[]" value="Wholesale">
            <label for="wholesale">Wholesale</label>
        </div>
        <div class="baseline">
            <input class="check-group" type="checkbox" name="investment[]" value="Syndication">
            <label for="syndication">Syndication</label>
        </div>
        <div class="baseline">
            <label for="notes">Other?</label>
            <input class="check-group" type="text" name="investment_txt" value="">
        </div>
    </div>

    <hr class="push-up"/>
    <input type="hidden" name="data-id" value="">
    <input class="button" type="submit" name="add_goals" value="Save">
</form>

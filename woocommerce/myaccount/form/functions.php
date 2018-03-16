<?php
global $wpdb;
$current_user = wp_get_current_user();
$user         = $current_user->user_login;

// ---- SESSION ---- //
$session_options = array(
    "session_id" => "form"
);
session_start($session_options);
$accountDB = new AccountDB;


class AccountDB {
    private $wpdb;

    // Accounts Group
    // Notifications
    /* public $notification_recipient, $notification_subject, $notification_previous_contact, $notification_next_contact, $notification_history;*/

    // Household Group
    // Profiles
    public $profile_relationship, $profile_first_name, $profile_last_name, $profile_gender, $profile_occupation, $profile_description, $profile_dob_year, $profile_dob_month, $profile_dob_day, $profile_dob, $profile_birthday;
    // Goals
    public $goal_protection, $goal_protection_txt, $goal_investment, $goal_investment_txt;
    // Estate
    public $estate_insurance, $estate_living_trust, $estate_hsa, $estate_minor_investments, $estate_referrals, $estate_other;

    // Finances Group
    // Assets
    public $asset_type, $asset_type_txt, $asset_balance;
    // Investments
    public $investment_owner, $investment_type, $investment_value;
    // Retirement
    public $retirement_plan, $retirement_plan_txt, $retirement_llc, $retirement_participant, $retirement_balance, $retirement_investment, $retirement_max_contribution, $retirement_satisfaction;

    // Businesses
    public $business_name, $business_type, $business_equity, $business_industry, $business_employees, $business_income, $business_goal;

    // Properties
    public $property_owner, $property_type, $property_purchase, $property_equity, $property_address, $property_city, $property_state, $property_zip, $property_value, $property_mortgage, $property_income, $property_dispose;


    public function __construct() {
        global $wpdb, $current_user;
        get_currentuserinfo();
        $this->db = $wpdb;
        $this->current_user = $current_user;

        // Notifications
        /* $this->notifications                 = "royal_notifications";
         * $this->notification_recipient        = $_POST['recipient'];
         * $this->notification_subject          = $_POST['subject'];
         * $this->notification_previous_contact = $_POST['previous_contact'];
         * $this->notification_next_contact     = $_POST['next_contact'];
         * $this->notification_history          = $_POST['history'];*/

        // Profiles
        $this->profiles             = "royal_profiles";
        $this->profile_relationship = $_POST['relationship'];
        $this->profile_first_name   = $_POST['first_name'];
        $this->profile_last_name    = $_POST['last_name'];
        $this->profile_gender       = $_POST['gender'];
        $this->profile_occupation   = $_POST['occupation'];
        $this->profile_description  = $_POST['description'];
        $this->profile_day          = empty($_POST['dob_day']) ? "" : $_POST['dob_day']."=";
        $this->profile_month        = empty($_POST['dob_month']) ? "" : $_POST['dob_month']."-";
        $this->profile_year         = $_POST['dob_year'];
        $this->profile_dob          = $this->profile_year."".$this->profile_month."".$this->profile_day;

        // Goals
        $this->goals               = "royal_goals";
        $this->goal_protection     = $_POST['protection'];
        $this->goal_protection_txt = $_POST['protection_txt'];
        $this->goal_investment     = $_POST['investment'];
        $this->goal_investment_txt = $_POST['investment_txt'];

        // Estate
        $this->estate                   = "royal_estate";
        $this->estate_insurance         = $_POST['insurance'];
        $this->estate_living_trust      = $_POST['living_trust'];
        $this->estate_hsa               = $_POST['hsa'];
        $this->estate_minor_investments = $_POST['minor_investments'];
        $this->estate_referrals         = $_POST['referrals'];
        $this->estate_other             = $_POST['other'];

        // Assets
        $this->assets          = "royal_assets";
        $this->asset_type      = $_POST['type'];
        $this->asset_type_txt  = $_POST['type_txt'];
        $this->asset_balance   = $_POST['balance'];

        // Investments
        $this->investments      = "royal_investments";
        $this->investment_owner = $_POST['owner'];
        $this->investment_type  = $_POST['type'];
        $this->investment_value = $_POST['value'];

        // Retirement
        $this->retirement                  = "royal_retirement";
        $this->retirement_plan             = $_POST['plan'];
        $this->retirement_plan_txt         = $_POST['plan_txt'];
        $this->retirement_llc              = $_POST['llc'];
        $this->retirement_participant      = $_POST['participant'];
        $this->retirement_balance          = $_POST['balance'];
        $this->retirement_investment       = $_POST['investment'];
        $this->retirement_max_contribution = $_POST['max_contribution'];
        $this->retirement_satisfaction     = $_POST['satisfaction'];

        // Businesses
        $this->businesses         = "royal_businesses";
        $this->business_name      = $_POST['business'];
        $this->business_type      = $_POST['type'];
        $this->business_equity    = $_POST['equity'];
        $this->business_industry  = $_POST['industry'];
        $this->business_employees = $_POST['employees'];
        $this->business_income    = $_POST['income'];
        $this->business_goal      = $_POST['goal'];

        // Properties
        $this->properties        = "royal_properties";
        $this->property_owner    = $_POST['owner'];
        $this->property_type     = $_POST['type'];
        $this->property_purchase = $_POST['purchase'];
        $this->property_equity   = $_POST['equity'];
        $this->property_address  = $_POST['address'];
        $this->property_city     = $_POST['city'];
        $this->property_state    = $_POST['state'];
        $this->property_zip      = $_POST['zip'];
        $this->property_value    = $_POST['value'];
        $this->property_mortgage = $_POST['mortgage'];
        $this->property_income   = $_POST['income'];
        $this->property_dispose  = $_POST['dispose'];
    }


    // ---- FUNCTIONS ---- //
    // Common delete query based on row_id and table name
    function delete_row($id,$table) {
        $this->db->query(
            $this->db->prepare(
                "DELETE FROM $table
                         WHERE id = %d AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }

    function add_profiles() {
        $birthday = "";
        if (!empty($this->profile_dob)) {
            $birthday = date('Y-m-d', strtotime($this->profile_dob));
        }
        $this->db->insert($this->profiles, array(
            'id'           => "",
            'user'         => $this->current_user->user_login,
            'first_name'   => $this->profile_first_name,
            'last_name'    => $this->profile_last_name,
            'birthday'     => $birthday,
            'gender'       => $this->profile_gender,
            'occupation'   => $this->profile_occupation,
            'relationship' => $this->profile_relationship,
            'description'  => $this->profile_description,
        ),array(
            '%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        update_clients();
    }

    function update_profiles($id) {
        $birthday = "";
        if (!empty($this->profile_dob)) {
            $birthday = date('Y-m-d', strtotime($this->profile_dob));
        }
        $this->db->query(
            $this->db->prepare(
                "UPDATE $this->profiles
                     SET first_name = '$this->profile_first_name',
                     last_name      = '$this->profile_last_name',
                     birthday       = '$birthday',
                     gender         = '$this->profile_gender',
                     occupation     = '$this->profile_occupation',
                     relationship   = '$this->profile_relationship',
                     description    = '$this->profile_description'
                    WHERE id = %d AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }

    function add_goals() {
        $hasGoals  = $this->db->get_var("SELECT COUNT(*) FROM $this->goals WHERE user='{$this->current_user->user_login}'");
        $protection_arr = implode(',', $this->goal_protection);
        $investment_arr = implode(',', $this->goal_investment);

        // Add
        if ($hasGoals == 0) {
            $this->db->insert($this->goals, array(
                'id'             => "",
                'user'           => $this->current_user->user_login,
                'protection'     => $protection_arr,
                'protection_txt' => $this->goal_protection_txt,
                'investment'     => $investment_arr,
                'investment_txt' => $this->goal_investment_txt
            ),array(
                '%s', '%s','%s','%s','%s','%s')
            );
        }
        // Update
        else {
            $this->db->query(
                "UPDATE $this->goals
                SET protection     = '$protection_arr',
                    protection_txt = '$this->goal_protection_txt',
                    investment     = '$investment_arr',
                    investment_txt = '$this->goal_investment_txt'
                WHERE user         = '{$this->current_user->user_login}'"
            );
        }
        update_clients();
    }

    function add_estate(){
        $estate_count = $this->db->get_var("SELECT COUNT(*) FROM $this->estate WHERE user='{$this->current_user->user_login}'");
        $referral = implode(',',$this->estate_referrals);

        if ($estate_count == 0) {
            $this->db->insert($this->estate, array(
                'id'                => "",
                'user'              => $this->current_user->user_login,
                'insurance'         => $this->estate_insurance,
                'living_trust'      => $this->estate_living_trust,
                'hsa'               => $this->estate_hsa,
                'minor_investments' => $this->estate_minor_investments,
                'referrals'         => $referral,
                'other'             => $this->estate_other
            ),array(
                '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
            );
        }

        else {
            $this->db->query(
                "UPDATE $this->estate
                SET insurance         = '$this->estate_insurance',
                    living_trust      = '$this->estate_living_trust',
                    hsa               = '$this->estate_hsa',
                    minor_investments = '$this->estate_minor_investments',
                    referrals         = '$referral',
                    other                 = '$this->estate_other'
                WHERE user            = '{$this->current_user->user_login}'"
            );
        }
        update_clients();
    }

    function add_assets() {
        $this->db->insert($this->assets, array(
            'id'       => "",
            'user'     => $this->current_user->user_login,
            'type'     => $this->asset_type,
            'type_txt' => $this->asset_type_txt,
            'balance'  => $this->asset_balance
        ),array(
            '%s', '%s', '%s', '%s', '%s')
        );
        update_clients();
    }

    function update_assets($id) {
        $this->db->query(
            $this->db->prepare(
                "UPDATE $this->assets
                     SET type = '$this->asset_type',
                     type_txt = '$this->asset_type_txt',
                     balance  = '$this->asset_balance'
                 WHERE id = '{$id}' AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }

    function add_investments() {
        $this->db->insert($this->investments, array(
            'id'    => "",
            'user'  => $this->current_user->user_login,
            'owner' => $this->investment_owner,
            'type'  => $this->investment_type,
            'value' => $this->investment_value
        ),array(
            '%s', '%s', '%s', '%s', '%s')
        );
        update_clients();
    }

    function update_investments($id) {
        $this->db->query(
            $this->db->prepare(
                "UPDATE $this->investments
                     SET owner = '$this->investment_owner',
                     type      = '$this->investment_type',
                     value     = '$this->investment_value'
                 WHERE id = %d AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }

    function add_retirement() {
        $this->db->insert($this->retirement, array(
            'id'               => "",
            'user'             => $this->current_user->user_login,
            'plan'             => $this->retirement_plan,
            'plan_txt'         => $this->retirement_plan_txt,
            'llc'              => $this->retirement_llc,
            'participant'      => $this->retirement_participant,
            'balance'          => $this->retirement_balance,
            'investment'       => $this->retirement_investment,
            'max_contribution' => $this->retirement_max_contribution,
            'satisfaction'     => $this->retirement_satisfaction
        ),array(
            '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')
        );
        update_clients();
    }

    function update_retirement($id) {
        $this->db->query(
            $this->db->prepare(
                "UPDATE $this->retirement
                     SET plan         = '$this->retirement_plan',
                     plan_txt         = '$this->retirement_plan_txt',
                     llc              = '$this->retirement_llc',
                     participant      = '$this->retirement_participant',
                     balance          = '$this->retirement_balance',
                     investment       = '$this->retirement_investment',
                     max_contribution = '$this->retirement_max_contribution',
                     satisfaction     = '$this->retirement_satisfaction'
                 WHERE id = %d AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }

    function add_properties() {
        $this->db->insert($this->properties, array(
            'id'       => "",
            'user'     => $this->current_user->user_login,
            'owner'    => $this->property_owner,
            'type'     => $this->property_type,
            'purchase' => $this->property_purchase,
            'equity'   => $this->property_equity,
            'address'  => $this->property_address,
            'city'     => $this->property_city,
            'state'    => $this->property_state,
            'zip'      => $this->property_zip,
            'value'    => $this->property_value,
            'mortgage' => $this->property_mortgage,
            'income'   => $this->property_income,
            'dispose'  => $this->property_dispose
        ),array(
            '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')
        );
        update_clients();
    }

    function update_properties($id) {
        $this->db->query(
            $this->db->prepare(
                "UPDATE $this->properties
                     SET owner = '$this->property_owner',
                     type      = '$this->property_type',
                     purchase  = '$this->property_purchase',
                     equity    = '$this->property_equity',
                     address   = '$this->property_address',
                     city      = '$this->property_city',
                     state     = '$this->property_state',
                     zip       = '$this->property_zip',
                     value     = '$this->property_value',
                     mortgage  = '$this->property_mortgage',
                     income    = '$this->property_income',
                     dispose   = '$this->property_dispose'
                   WHERE id = %d AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }

    function add_businesses() {
        $this->db->insert($this->businesses, array(
            'id'        => "",
            'user'      => $this->current_user->user_login,
            'business'  => $this->business_name,
            'type'      => $this->business_type,
            'equity'    => $this->business_equity,
            'industry'  => $this->business_industry,
            'employees' => $this->business_employees,
            'income'    => $this->business_income,
            'goal'      => $this->business_goal
        ),array(
            '%s','%s','%s','%s','%s','%s','%s','%s','%s')
        );
        update_clients();
    }

    function update_businesses($id) {
        $this->db->query(
            $this->db->prepare(
                "UPDATE $this->businesses
                     SET business   = '$this->business_name',
                     type           = '$this->business_type',
                     equity         = '$this->business_equity',
                     industry       = '$this->business_industry',
                     employees      = '$this->business_employees',
                     income         = '$this->business_income',
                     goal           = '$this->business_goal'
                   WHERE id = %d AND user = '{$this->current_user->user_login}'",
                $id
            )
        );
        update_clients();
    }
}




function update_clients() {
    global $wpdb;
    $user = wp_get_current_user()->user_login;

    // Tables
    $profile = get_profile();
    $goals       = $wpdb->get_results("SELECT * FROM royal_goals WHERE user='{$user}'");
    $estate      = $wpdb->get_results("SELECT * FROM royal_estate WHERE user='{$user}'");
    $assets      = $wpdb->get_results("SELECT * FROM royal_assets WHERE user='{$user}'");
    $investments = $wpdb->get_results("SELECT * FROM royal_investments WHERE user='{$user}'");
    $retirement  = $wpdb->get_results("SELECT * FROM royal_retirement WHERE user='{$user}'");
    $properties  = $wpdb->get_results("SELECT * FROM royal_properties WHERE user='{$user}'");
    $businesses  = $wpdb->get_results("SELECT * FROM royal_businesses WHERE user='{$user}'");
    $clients     = $wpdb->get_results("SELECT * FROM royal_clients WHERE user='{$user}'");


    // Profiles
    $profiles    = $wpdb->get_results("SELECT * FROM royal_profiles WHERE user='{$user}'");
    $client_profiles = "";
    foreach ($profiles as $profile) {
        // Row 1 == First Last (Age - Gender)
        if ($profile->birthday != "0000-00-00") {
            $age = (date('Y') - date('Y',strtotime($profile->birthday)));
            if (!empty($profile->gender)) {
                $dash = " - ";
            } else { $dash = ""; }
        } else { $age = ""; $dash = ""; }
        $row1 = $profile->first_name." ".$profile->last_name." (".$age."".$dash."".$profile->gender.")";

        // Row 2 == Relationship | Occupation
        if (!empty($profile->relationship) && !empty($profile->occupation)) {
            $bar = " | ";
        } else { $bar = ""; }
        $row2 = $profile->relationship."".$bar."".$profile->occupation;

        // Row 3 == Description
        $row3 = $profile->description;

        // Separate rows with linebreaks
        $profile_data  = $row1."\r\n".$row2."\r\n".$row3."\r\n \r\n";

        // Add data to existing client profile
        $client_profiles = $client_profiles ."".$profile_data;
    }
    $client_profiles = (empty($client_profiles)) ? "" : "---- PROFILES ----\r\n".$client_profiles;


    // Goals
    $protection = (!empty($goals[0]->protection)) ? "Protection: ".$goals[0]->protection."\r\n" : "";
    $investment = (!empty($goals[0]->investment)) ? "Investment: ".$goals[0]->investment."\r\n" : "";
    if (!empty($protection) || !empty($investment)) {
        $client_goals = "---- GOALS ----\r\n".$protection."".$investment."\r\n \r\n";
    }


    // Estate
    $insurance = (!empty($estate[0]->insurance)) ? "Health insurance provided by ".$estate[0]->insurance."\r\n" : "";
    $trust = ($estate[0]->living_trust == "Y") ? "Has a living trust\r\n" : "";
    $hsa = (!empty($estate[0]->hsa)) ? "Health Savings Account: ".$estate[0]->hsa."\r\n" : "";
    $minors = ($estate[0]->minor_investments == "Y") ? "Has investment accounts under the name(s) of their minor children\r\n" : "";
    $referrals = (!empty($estate[0]->referral)) ? "Wants referrals for: ".$estate[0]->referrals."\r\n" : "";
    $other = (!empty($estate[0]->other)) ? "Other information: ".$estate[0]->other."\r\n" : "";

    if (!empty($insurance) || !empty($trust) || !empty($hsa) || !empty($minors)
        || !empty($referrals) || !empty($other)) {
        $client_estate = "---- ESTATE PLANNING ----\r\n".$insurance."".$trust."".$hsa."".$minors."".$referrals."".$other."\r\n \r\n";
    }


    // Assets
    $client_assets = "";
    foreach ($assets as $asset) {
        $type    = $asset->type;
        $balance = '$'.number_format($asset->balance);
        $asset_data    = $type."\r\n".$balance."\r\n \r\n";
        $client_assets = $client_assets ."".$asset_data;
    }
    $client_assets = !empty($client_assets) ? "\r\n---- ASSETS ----\r\n".$client_assets : '';


    // Investments
    $client_investments = "";
    foreach ($investments as $investment) {
        $owner = !empty($investment->owner) ? "Managed by ".$investment->owner."\r\n" : "";
        $type  = $investment->type."\r\n";
        $value = !empty($investment->value) ? "$".number_format($investment->value)."\r\n" : "";
        $investment_data  = $owner."".$type."".$value."\r\n";
        $client_investments = $client_investments ."".$investment_data;
    }
    $client_investments = !empty($client_investments) ? "\r\n---- INVESTMENTS ----\r\n".$client_investments : '';


    // Retirement
    $client_retirement = "";
    foreach ($retirement as $retire) {
        // Row 1 == Plan (Plan Text)
        $plan = $retire->plan;
        $plan_txt = $retire->plan_txt;
        if (!empty($plan) && !empty($plan_txt)) { $dash = " - "; } else { $dash = ""; }
        $row1 = $plan."".$dash."".$plan_txt."\r\n";

        $llc = !empty($retire->llc) ? "Checkbook Control: ".$retire->llc."\r\n" : "";
        $participant = !empty($retire->participant) ? "Plan Participant: ".$retire->participant."\r\n" : "";
        $max = ($retire->max_contribution == "Yes") ? "Maxes annual contribution\r\n" : "";
        $satisfy = ($retire->max_satisfaction == "No") ? "Not satisfied with performance\r\n" : "";
        $investment = !empty($retire->investment) ? $retire->investment : "";
        $balance = !empty($retire->balance) ? "$".number_format($retire->balance) : "";
        if (!empty($investment) || !empty($balance)) {
            if (!empty($investment) && !empty($balance)) {
                $investment_balance = "Has invested ".$balance." in ".$investment."\r\n";
            } else {
                $investment_balance = "Investment: ".$balance."".$investment."\r\n";
            }
        }
        $retirement_data = $row1."".$llc."".$participant."".$max."".$satisfy."".$investment_balance."\r\n";
        $client_retirement = $client_retirement ."".$retirement_data;
    }
    $client_retirement = !empty($client_retirement) ? "\r\n---- RETIREMENT PLANS ----\r\n".$client_retirement : '';


    // Properties
    $client_properties = "";
    foreach ($properties as $property) {
        // Row 1 == Owner - Type
        $owner = !empty($property->owner) ? $property->owner : "";
        $type = !empty($property->type) ? $property->type : "";
        if (!empty($owner) && !empty($type)) {
            $dash = " - ";
        } else { $dash = ""; }
        $row1 = "Owned by ".$owner."".$dash."".$type."\r\n";

        $purchase = !empty($property->purchase) ? "Purchased in ".$property->purchase."\r\n" : "";
        $equity = !empty($property->equity) ? "Equity: ".$property->equity."%\r\n" : "";
        $value = !empty($property->value) ? "Value: $".number_format($property->value)."\r\n" : "";
        $mortgage = !empty($property->mortgage) ? "Mortgage: $".number_format($property->mortgage)."\r\n" : "";
        $income = !empty($property->income) ? "Rental Income: $".number_format($property->income)."\r\n" : "";

        $address1 = $property->address."\r\n";
        $city = !empty($property->city) ? $property->city.", " : "";
        $state = !empty($property->state) ? $property->state.", " : "";
        $address2 = $city."".$state."".$property->zip."\r\n";
        $dispose = ($property->dispose == "Y") ? "Looking to Dispose\r\n" : "";

        $property_data = $row1."".$purchase."".$equity."".$value."".$mortgage."".$income."".$address1."".$address2."".$dispose."\r\n";
        $client_properties = $client_properties ."".$property_data;
    }
    $client_properties = !empty($client_properties) ? "\r\n---- PROPERTIES ----\r\n".$client_properties : '';


    // Businesses
    $client_businesses = "";
    foreach ($businesses as $business) {
        $name = !empty($business->business) ? $business->business."\r\n" : "";
        $type = !empty($business->type) ? $business->type."\r\n" : "";
        $equity = !empty($business->equity) ? "Equity: ".$business->equity."%\r\n" : "";
        $industry = !empty($business->industry) ? "Industry: ".$business->industry."\r\n" : "";
        $employees = !empty($business->employees) ? "Employees: ".$business->employees."\r\n" : "";
        $income = !empty($business->income) ? "Annual Revenue: $".number_format($business->income)."\r\n" : "";
        $goal = !empty($business->goal) ? "Wants to ".$business->goal."\r\n" : "";
        
        $business_data = $name."".$type."".$equity."".$industry."".$employees."".$income."".$goal."\r\n";
        $client_businesses = $client_businesses ."".$business_data;
    }
    $client_businesses = !empty($client_businesses) ? "\r\n---- BUSINESSES ----\r\n".$client_businesses : '';


    $client_data = $client_profiles."".$client_goals."".$client_estate."".$client_assets."".$client_investments."".$client_retirement."".$client_properties."".$client_businesses;

    // Update WordPress
    $wpdb->update('royal_clients', array(
        'activity'=>date('Y-m-d H:i:s'),
        'profile'=>$client_data
    ), array('user'=>$user));

    // Update Insightly
    require 'insightly.php';
    $crm    = new Insightly();
    $email  = wp_get_current_user()->user_email;
    $crm_id = $crm->getContacts(array("email"=>$email))[0]->CONTACT_ID;
    $field  = (object) [
        "CUSTOM_FIELD_ID"=>"CONTACT_FIELD_4",
        "FIELD_VALUE"=>$client_data
    ];
    $crm->updateCustomFields($crm_id, $field);
}

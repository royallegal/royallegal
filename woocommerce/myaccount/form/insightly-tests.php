<?php
/**
 * Test all API library funtions
 * 
 * @param int $top (Number of results in some requests)
 * @throws Exception
 */
public function test($top=null){
    echo "Test API .....\n";
    echo "Testing authentication\n";
    $passed = 0;
    $failed = 0;
    $currencies = $this->getCurrencies();
    if(count($currencies) > 0){
        echo "Authentication passed...\n";
        $passed += 1;
    }
    else{
        $failed += 1;
    }
    // Test getUsers()
    try{
        $users = $this->getUsers();
        $user = $users[0];
        $user_id = $user->USER_ID;
        echo "PASS: getUsers(), found " . count($users) . " users.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        $user = null;
        $users = null;
        $user_id = null;
        echo "FAIL: getUsers()\n";
        $failed += 1;
    }
    // Test getContacts()
    try{
        $contacts = $this->getContacts(array("orderby" => "DATE_UPDATED_UTC desc",
                                             "top" => $top));
        $contact = $contacts[0];
        echo "PASS: getContacts(), found " . count($contacts) . " contacts.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getContacts()\n";
        $failed += 1;
    }
    if($contact != null){
        $contact_id = $contact->CONTACT_ID;
        try{
            $emails = $this->getContactEmails($contact_id);
            echo "PASS: getContactEmails(), found " . count($emails) . " emails.\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: getContactEmails()\n";
            $failed += 1;
        }
        try{
            $notes = $this->getContactNotes($contact_id);
            echo "PASS: getContactNotes(), found " . count($notes) . " notes.\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: getContactNotes()\n";
            $failed += 1;
        }
        try{
            $tasks = $this->getContactTasks($contact_id);
            echo "PASS: getContactTasks(), found " . count($tasks) . " tasks.\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: getContactTasks()\n";
            $failed += 1;
        }
    }
    // Test addContact()
    try{
        $contact = (object)array("SALUTATION" => "Mr",
                                 "FIRST_NAME" => "Testy",
                                 "LAST_NAME" => "McTesterson");
        $contact = $this->addContact($contact);
        echo "PASS: addContact()\n";
        $passed += 1;
        // Test deleteContact()
        try{
            $this->deleteContact($contact->CONTACT_ID);
            echo "PASS: deleteContact()\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: deleteContact()\n";
            $failed += 1;
        }
    }
    catch(Exception $ex){
        $contact = null;
        echo "FAIL: addContact()\n";
        $failed += 1;
    }
    try{
        $countries = $this->getCountries();
        echo "PASS: getCountries(), found " . count($countries) . " countries.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getCountries()\n";
        $failed += 1;
    }
    try{
        $currencies = $this->getCurrencies();
        echo "PASS: getCurrencies(), found " . count($currencies) . " currencies\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getCurrencies()\n";
        $failed += 1;
    }
    try{
        $customfields = $this->getCustomFields();
        echo "PASS: getCustomFields(), found " . count($customfields) . " custom fields.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getCustomFields()\n";
        $failed += 1;
    }
    // Test getEmails()
    try{
        $emails = $this->getEmails(array("top" => $top));
        echo "PASS: getEmails(), found " . count($emails) . " emails.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getEmails()\n";
        $failed += 1;
    }
    // Test getEvents()
    try{
        $events = $this->getEvents(array("top" => $top));
        echo "PASS: getEvents(), found " . count($events) . " events.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getEvents()\n";
        $failed += 1;
    }
    // Test addEvent()
    try{
        $event = (object)array("TITLE" => "Test Event",
                               "LOCATION" => "Somewhere",
                               "DETAILS" => "Details",
                               "START_DATE_UTC" => "2014-07-12 12:00:00",
                               "END_DATE_UTC" => "2014-07-12 13:00:00",
                               "OWNER_USER_ID" => $user_id,
                               "ALL_DAY" => false,
                               "PUBLICLY_VISIBLE" => true);
        $event = $this->addEvent($event);
        echo "PASS: addEvent()\n";
        $passed += 1;
        // Test deleteEvent()
        try{
            $this->deleteEvent($event->EVENT_ID);
            echo "PASS: deleteEvent()\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: deleteEvent()\n";
            $failed += 1;
        }
    }
    catch(Exception $ex){
        $event = null;
        echo "FAIL: addEvent\n";
        $failed += 1;
    }
    // Test getFileCategories()
    try{
        $categories = $this->getFileCategories();
        echo "PASS: getFileCategories(), found " . count($categories) . " categories\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getFileCategories()\n";
        $failed += 1;
    }
    // Test addFileCategory()
    try{
        $category = new stdClass();
        $category->CATEGORY_NAME = "Test Category";
        $category->ACTIVITY = true;
        $category->BACKGROUND_COLOR = "000000";
        $category = $this->addFileCategory($category);
        echo "PASS: addFileCategory()\n";
        $passed += 1;
        // Test deleteFileCategory()
        try{
            $this->deleteFileCategory($category->CATEGORY_ID);
            echo "PASS: deleteFileCategory()\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: deleteFileCategory()\n";
            $failed += 1;
        }
    }
    catch(Exception $ex){
        $category = null;
        echo "FAIL: addFileCategory()\n";
        $failed += 1;
    }
    // Test getNotes()
    try{
        $notes = $this->getNotes(array());
        echo "PASS: getNotes(), found " . count($notes) . " notes.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getNotes\n";
        $failed += 1;
    }
    // Test getOpportunities()
    try{
        $opportunities = $this->getOpportunities(array("orderby" => "DATE_UPDATED_UTC desc",
                                                       "top" => $top));
        echo "PASS: getOpportunities(), found " . count($opportunities) . " opportunities.\n";
        $passed += 1;
        if(!empty($opportunities)){
            $opportunity = $opportunities[0];
            $opportunity_id = $opportunity->OPPORTUNITY_ID;
            // Test getOpportunityEmails()
            try{
                $emails = $this->getOpportunityEmails($opportunity_id);
                echo "PASS: getOpportunityEmails(), found " . count($emails) . " emails.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOpportunityEmails()\n";
                $failed += 1;
            }
            // Test getOpportunityNotes()
            try{
                $notes = $this->getOpportunityNotes($opportunity_id);
                echo "PASS: getOpportunityNotes(), found " . count($notes) . " notes.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOpportunityNotes()\n";
                $failed += 1;
            }
            // Test getOpportunityTasks()
            try{
                $tasks = $this->getOpportunityTasks($opportunity_id);
                echo "PASS: getOpportunityTasks(), found " . count($tasks) . " tasks.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOpportunityTasks()\n";
                $failed += 1;
            }
            // Test getOpportunityStateHistory()
            try{
                $states = $this->getOpportunityStateHistory($opportunity_id);
                echo "PASS: getOpportunityStateHistory(), found " . count($states) . " states in history.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOpportunityStateHistory()\n";
                $failed += 1;
            }
        }
    }
    catch(Exception $ex){
        echo "FAIL: getOpportunities()\n";
        $failed += 1;
    }
    // Test getOpportunityCategories()
    try{
        $categories = $this->getOpportunityCategories();
        echo "PASS: getOpportunityCategories(), found " . count($categories) . "categories.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getOpportunityCategories()\n";
        $failed += 1;
    }
    // Test addOpportunityCategory()
    try{
        $category = new stdClass();
        $category->CATEGORY_NAME="Test Category";
        $category->ACTIVE = true;
        $category->BACKGROUND_COLOR = "000000";
        $category = $this->addOpportunityCategory($category);
        echo "PASS: getOpportunityCategory()\n";
        $passed += 1;
        // Test deleteOpportunityCategory
        try{
            $this->deleteOpportunityCategory($category->CATEGORY_ID);
            echo "PASS: deleteOpportunityCategory()\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: deleteOpportunityCategory()\n";
            $failed += 1;
        }
    }
    catch(Exception $ex){
        echo "FAIL: addOpportunityCategory()\n";
        $failed += 1;
    }
    // Test getOpportunityStateReasons()
    try{
        $reasons = $this->getOpportunityStateReasons();
        echo "PASS: getOpportunityStateReasons(), found " . count($reasons) . " reasons.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getOpportunityStateReasons()\n";
        $failed += 1;
    }
    // Test getOrganizations()
    try{
        $organizations = $this->getOrganizations(array("top" => $top,
                                                       "orderby" => "DATE_UPDATED_UTC desc"));
        echo "PASS: getOrganizations(), found " . count($organizations) . " organizations.\n";
        $passed += 1;
        if(!empty($organizations)){
            $organization = $organizations[0];
            $organization_id = $organization->ORGANISATION_ID;
            // Test getOrganizationEmails()
            try{
                $emails = $this->getOrganizationEmails($organization_id);
                echo "PASS: getOrganizationEmails(), found " . count($emails) . " emails.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOrganizationEmails()\n";
                $failed += 1;
            }
            // Test getOrganizationNotes()
            try{
                $notes = $this->getOrganizationNotes($organization_id);
                echo "PASS: getOrganizationNotes(), found " . count($notes) . " notes.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOrganizationNotes()\n";
                $failed += 1;
            }
            // Test getOrganizationTasks()
            try{
                $tasks = $this->getOrganizationTasks($organization_id);
                echo "PASS: getOrganizationTasks(), found " . count($tasks) . " tasks.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getOrganizationTasks()\n";
                $failed += 1;
            }
        }
    }
    catch(Exception $ex){
        echo "FAIL: getOgranizations()\n";
        $failed += 1;
    }
    // Test addOrganization()
    try{
        $organization = new stdClass();
        $organization->ORGANISATION_NAME = "Foo Corp";
        $organization->BACKGROUND = "Details";
        $organization = $this->addOrganization($organization);
        echo "PASS: addOrganization()\n";
        $passed += 1;
        // Test deleteOrganization()
        try{
            $this->deleteOrganization($organization->ORGANISATION_ID);
            echo "PASS: deleteOrganization()\n";
            $passed += 1;
        }
        catch(Exception $ex){
            echo "FAIL: deleteOrganization()\n";
            $failed += 1;
        }
    }
    catch(Exception $ex){
        echo "FAIL: addOrganization()\n";
        $failed += 1;
    }
    // Test getPipelines()
    try{
        $pipelines = $this->getPipelines();
        echo "PASS: getPipelines(), found " . count($pipelines) . " pipelines\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getPilelines()\n";
        $failed += 1;
    }
    // Test getProjects()
    try{
        $projects = $this->getProjects(array("top" => $top,
                                             "orderby" => "DATE_UPDATED_UTC desc"));
        echo "PASS: getProjects(), found " . count($projects) . " projects.\n";
        $passed += 1;
        if(!empty($projects)){
            $project = $projects[0];
            $project_id = $project->PROJECT_ID;
            // Test getProjectEmails()
            try{
                $emails = $this->getProjectEmails($project_id);
                echo "PASS: getProjectEmails(), found " . count($emails) . " emails.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getProjectEmails()\n";
                $failed += 1;
            }
            // Test getProjectNotes()
            try{
                $notes = $this->getProjectNotes($project_id);
                echo "PASS: getProjectNotes(), found " . count($notes) . " notes.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getProjectNotes()\n";
                $failed += 1;
            }
            // Test getProjectTasks()
            try{
                $tasks = $this->getProjectTasks($project_id);
                echo "PASS: getProjectTasks(), found " . count($tasks) . " tasks.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getProjectTasks()\n";
                $failed += 1;
            }
        }
    }
    catch(Exception $ex){
        echo "FAIL: getProjects()\n";
        $failed += 1;
    }
    // Test getProjectCategories()
    try{
        $categories = $this->getProjectCategories();
        echo "PASS: getProjectCategories(), found " . count($categories) . " categories.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getProjectCategories()\n";
        $failed += 1;
    }
    // Test getRelationships
    try{
        $relationships = $this->getRelationships();
        echo "PASS: getRelationships(), found " . count($relationships) . " relationships.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getRelationships()\n";
        $failed += 1;
    }
    // Test getTasks()
    try{
        $tasks = $this->getTasks(array("top" => $top,
                                       "orderby" => "DUE_DATE desc"));
        echo "PASS: getTasks(), found " . count($tasks) . " tasks.\n";
        $passed += 1;
    }
    catch(Exception $ex){
        echo "FAIL: getTasks()\n";
        $failed += 1;
    }
    // Test getTeams()
    try{
        $teams = $this->getTeams();
        echo "PASS: getTeams(), found " . count($teams) . " teams.\n";
        $passed += 1;
        if(!empty($teams)){
            $team = $teams[0];
            $team_id = $team->TEAM_ID;
            // Test getTeamMembers()
            try{
                $team_members = $this->getTeamMembers($team_id);
                echo "PASS: getTeamMembers(), found " . count($team_members) . " team members.\n";
                $passed += 1;
            }
            catch(Exception $ex){
                echo "FAIL: getTeamMembers()\n";
                $failed += 1;
            }
        }
    }
    catch(Exception $ex){
        echo "FAIL: getTeams()\n";
        $failed += 1;
    }
    if($failed > 0){
        throw new Exception($failed . " tests failed!");
    }
}
?>

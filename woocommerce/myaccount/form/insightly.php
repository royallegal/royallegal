<?php
class Insightly {
    private $apikey;
    public  $v;

    public function __construct() {
        $this->apikey = '64a00447-52a4-44ef-9955-c7cc8d78d406';
        $this->v = 'v2.2'; // API Version
    }

    public function addAddress($id, $address_id, $address) {
        $url_path = "/".$this->v."/Contacts/".$id."/Addresses";
        $request = null;
        if (isset($address) && $address > 0) {
            $address["ADDRESS_ID"] = $address_id;
            $request = $this->PUT($url_path);
        }
        else {            
            $request = $this->POST($url_path);
        }
        return $request->body($address)->asJSON();
    }


    /* ---- CONTACTS ---- */
    /* POST */
    /* New Contact (auto-generates ID) */
    public function addContact($contact) {
        $url_path = "/".$this->v."/Contacts";
        $request = null;
        if (isset($contact->CONTACT_ID) && $contact->CONTACT_ID > 0) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($contact)->asJSON();
    }

    public function updateCustomFields($id, $data) {
        $url_path = "/v2.2/Contacts/".$id."/CustomFields";
        return $this->PUT($url_path)->body($data)->asJSON();
    }

    /* DELETE */
    /* By ID */
    public function deleteContact($id) {
        $this->DELETE("/".$this->v."/Contacts/$id")->asString();
        return true;
    }

    /* GET */
    /* All Contacts */
    public function getContacts($options = null) {
        $email = isset($options["email"]) ? $options["email"] : null;
        $tag = isset($options["tag"]) ? $options["tag"] : null;
        $ids = isset($options["ids"]) ? $options["ids"] : null;
        $request = $this->GET("/v2.1/Contacts");
        // handle standard OData options
        $this->buildODataQuery($request, $options);
        // handle other options
        if ($email != null) {
            $request->queryParam("email", $email);
        }
        if ($tag != null) {
            $request->queryParam("tag", $tag);
        }
        if ($ids != null) {
            $s = "";
            foreach($ids as $key => $value) {
                if ($key > 0) {
                    $s = $s . ",";
                }
                $s = $s . $value;
            }
            $request->queryParam("ids", $s);
        }
        return $request->asJSON();
    }

    /* By ID */
    public function getContact($id) {
        return $this->GET("/".$this->v."/Contacts/" . $id)->asJSON();
    }

    /* By Contact Info */
    public function getContactEmails($contact_id) {
        return $this->GET("/".$this->v."/Contacts/$contact_id/Emails")->asJSON();
    }
    public function getContactNotes($contact_id) {
        return $this->GET("/".$this->v."/Contacts/$contact_id/Notes")->asJSON();
    }
    public function getContactTasks($contact_id) {
        return $this->GET("/".$this->v."/Contacts/$contact_id/Tasks")->asJSON();
    }

    public function getCountries() {
        return $this->GET("/".$this->v."/Countries")->asJSON();
    }
    public function getCurrencies() {
        return $this->GET("/".$this->v."/Currencies")->asJSON();
    }

    /* CUSTOM FIELDS */
    public function getCustomFields() {
        return $this->GET("/v2.2/CustomFields")->asJSON();
    }
    public function getCustomFieldGroups($id) {
        return $this->GET("/v2.2/CustomFields/$id")->asJSON();
    }

    public function getEmails($options = null) {
        $request = $this->GET("/v2.1/Emails");
        $this->buildODataQuery($request, $options);
        return $request->asJSON();
    }
    public function getEmail($id) {
        return $this->GET("/v2.1/Emails/$id")->asJSON();
    }
    public function deleteEmail($id) {
        $this->DELETE("/v2.1/Emails/$id")->asString();
        return true;
    }
    public function getEmailComments($email_id) {
        $this->GET("/v2.1/Emails/$email_id/Comments")->asJSON();
    }
    public function addCommentToEmail($email_id, $body, $owner_user_id) {
        $data = new stdClass();
        $data->BODY = $body;
        $data->OWNER_USER_ID = $owner_user_id;
        return $this->POST("/v2.1/Emails/")->body($data)->asJSON();
    }

    public function getEvents($options = null) {
        $request = $this->GET("/v2.1/Events");
        $this->buildODataQuery($request, $options);
        return $request->asJSON();
    }
    public function getEvent($id) {
        return $this->GET("/v2.1/Events/$id")->asJSON();
    }
    public function addEvent($event) {
        if ($event == "sample") {
            $return = $this->getEvents(array("top" => 1));
            return $return[0];
        }
        $url_path = "/v2.1/Events";
        if (isset($event->EVENT_ID) && ($event->EVENT_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($event)->asJSON();
    }
    public function deleteEvent($id) {
        $this->DELETE("/v2.1/Events/$id")->asString();
        return true;
    }

    public function getFileCategories() {
        return $this->GET("/v2.1/FileCategories")->asJSON();
    }
    public function getFileCategory($id) {
        return $this->GET("/v2.1/FileCategories/$id")->asJSON();
    }
    public function addFileCategory($category) {
        if ($category == "sample") {
            $return = $this->getFileCategories();
            return $return[0];
        }
        $url_path = "/v2.1/FileCategories";
        if (isset($category->CATEGORY_ID)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($category)->asJSON();
    }
    public function deleteFileCategory($id) {
        $this->DELETE("/v2.1/FileCategories/$id")->asString();
        return true;
    }

    public function getNotes($options = null) {
        $request = $this->GET("/v2.1/Notes");
        $this->buildODataQuery($request, $options);
        return $request->asJSON();
    }
    public function getNote($id) {
        return $request = $this->GET("/v2.1/Notes/$id")->asJSON();
    }
    public function addNote($note) {
        if ($note == "sample") {
            $return = $this->getNotes(array("top" => 1));
            return $return[0];
        }
        $url_path = "/v2.1/Notes";
        if (isset($note->NOTE_ID) && ($note->NOTE_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($note)->asJSON();
    }
    public function getNoteComments($note_id) {
        return $this->GET("/v2.1/Notes/$note_id/Comments")->asJSON();
    }
    public function addNoteComment($note_id, $comment) {
        if ($comment == "sample") {
            $comment = new stdClass();
            $comment->COMMENT_ID = 0;
            $comment->BODY = "This is a comment.";
            $comment->OWNER_USER_ID = 1;
            $comment->DATE_CREATED_UTC = "2014-07-15 16:40:00";
            $comment->DATE_UPDATED_UTC = "2014-07-15 16:40:00";
            return $comment;
        }
        return $this->POST("/v2.1/$note_id/Comments")->body($comment)->asJSON();
    }
    public function deleteNote($id) {
        $this->DELETE("/v2.1/Notes/$id")->asString();
        return true;
    }

    public function getOpportunities($options = null) {
        $request = $this->GET("/v2.1/Opportunities");
        $this->buildODataQuery($request, $options);
        return $request->asJSON();
    }
    public function getOpportunity($id) {
        return $this->GET("/v2.1/Opportunities/" . $id)->asJSON();
    }
    public function addOpportunity($opportunity) {
        if ($opportunity == "sample") {
            $return = $this->getOpportunities(array("top" => 1));
            return $return[0];
        }
        $url_path = "/v2.1/Opportunities";
        if (isset($opportunity->OPPORTUNITY_ID) && ($opportunity->OPPORTUNITY_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($opportunity)->asJSON();
    }
    public function deleteOpportunity($id) {
        $this->DELETE("/v2.1/Opportunities/$id")->asString();
        return true;
    }
    public function getOpportunityEmails($opportunity_id) {
        return $this->GET("/v2.1/Opportunities/$opportunity_id/Emails")->asJSON();
    }
    public function getOpportunityNotes($opportunity_id) {
        return $this->GET("/v2.1/Opportunities/$opportunity_id/Notes")->asJSON();
    }
    public function getOpportunityStateHistory($opportunity_id) {
        return $this->GET("/v2.1/Opportunities/$opportunity_id/StateHistory")->asJSON();
    }
    public function getOpportunityTasks($opportunity_id) {
        return $this->GET("/v2.1/Opportunities/$opportunity_id/Tasks")->asJSON();
    }
    public function getOpportunityCategories() {
        return $this->GET("/v2.1/OpportunityCategories")->asJSON();
    }
    public function getOpportunityCategory($id) {
        return $this->GET("/v2.1/OpportunityCategories/$id")->asJSON();
    }
    public function addOpportunityCategory($category) {
        if ($category == "sample") {
            $return = $this->getOpportunityCategories();
            return $return[0];
        }
        $url_path = "/v2.1/OpportunityCategories";
        if (isset($category->CATEGORY_ID) && ($category->CATEGORY_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($category)->asJSON();
    }
    public function deleteOpportunityCategory($id) {
        $this->DELETE("/v2.1/OpportunityCategories/$id")->asString();
        return true;
    }
    public function getOpportunityStateReasons() {
        return $this->GET("/v2.1/OpportunityStateReasons")->asJSON();
    }

    public function getOrganizations($options = null) {
        $request = $this->GET("/v2.1/Organisations");
        $this->buildODataQuery($request, $options);
        return $request->asJSON();
    }
    public function getOrganization($id) {
        return $this->GET("/v2.1/Organisations/$id")->asJSON();
    }
    public function addOrganization($organization) {
        if ($organization == "sample") {
            $return = $this->getOrganizations(array("top" => 1));
            return $return[0];
        }
        $url_path = "/v2.1/Organisations";
        if (isset($organization->ORGANISATION_ID) && ($organization->ORGANISATION_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($organization)->asJSON();
    }
    public function deleteOrganization($id) {
        $this->DELETE("/v2.1/Organisations/$id")->asString();
        return true;
    }
    public function getOrganizationEmails($organization_id) {
        return $this->GET("/v2.1/Organisations/$organization_id/Emails")->asJSON();
    }
    public function getOrganizationNotes($organization_id) {
        return $this->GET("/v2.1/Organisations/$organization_id/Notes")->asJSON();
    }
    public function getOrganizationTasks($organization_id) {
        return $this->GET("/v2.1/Organisations/$organization_id/Tasks")->asJSON();
    }

    public function getPipelines() {
        return $this->GET("/v2.1/Pipelines")->asJSON();
    }
    public function getPipeline($id) {
        return $this->GET("/v2.1/Pipelines/$id")->asJSON();
    }
    public function getPipelineStages() {
        return $this->GET("/v2.1/PipelineStages")->asJSON();
    }
    public function getPipelineStage($id) {
        return $this->GET("/v2.1/PipelineStages/$id")->asJSON();
    }

    public function getProjectCategories() {
        return $this->GET("/v2.1/ProjectCategories")->asJSON();
    }
    public function getProjectCategory($id) {
        return $this->GET("/v2.1/ProjectCategories/$id")->asJSON();
    }
    public function addProjectCategory($category) {
        if ($category == "sample") {
            $return = $this->getProjectCategoriest();
            return $return[0];
        }
        $url_path = "/v2.1ProjectCategories";
        if (isset($category->CATEGORY_ID) && ($category->CATEGORY_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($category)->asJSON();
    }
    public function deleteProjectCategory($id) {
        $this->DELETE("/v2.1/ProjectCategories/$id")->asString();
        return true;
    }

    public function getProjects($options = null) {
        $tag = isset($options["tag"]) ? $options["tag"] : null;
        $ids = isset($options["ids"]) ? $options["ids"] : null;
  	
        $request = $this->GET("/v2.1/Projects");
        // handle standard OData options
        $this->buildODataQuery($request, $options);
        // handle other options
        if ($tag != null) {
            $request->queryParam("tag", $tag);
        }
        if ($ids != null) {
            $s = "";
            foreach($ids as $key => $value) {
                if ($key > 0) {
                    $s = $s . ",";
                }
                $s = $s . $value;
            }
            $request->queryParam("ids", $s);
        }
        return $request->asJSON();
    }
    public function getProject($id) {
        return $this->GET("/v2.1/Projects/$id")->asJSON();
    }
    public function addProject($project) {
        if ($project == "sample") {
            $return = $this->getProjects();
            return $return[0];
        }
        $url_path = "/v2.2/Projects";
        if (isset($project->PROJECT_ID) && ($project->PROJECT_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($project)->asJSON();
    }
    public function deleteProject($id) {
        $this->DELETE("/v2.1/Projects/$id")->asString();
        return true;
    }

    public function getProjectEmails($project_id) {
        return $this->GET("/v2.1/Projects/$project_id/Emails")->asJSON();
    }
    public function getProjectNotes($project_id) {
        return $this->GET("/v2.1/Projects/$project_id/Notes")->asJSON();
    }
    public function getProjectTasks($project_id) {
        return $this->GET("/v2.1/Projects/$project_id/Tasks")->asJSON();
    }
    public function getRelationships() {
        return $this->GET("/v2.1/Relationships")->asJSON();
    }
    public function getTags($id) {
        return $this->GET("/v2.1/Tags/$id")->asJSON();
    }
    public function getTasks($options = null) {
        $request = $this->GET("/v2.1/Tasks");
        $this->buildODataQuery($request, $options);
        if (isset($options["ids"])) {
            $ids = "";
            foreach($options["ids"] as $id) {
                $ids .= $id . ",";
            }
            $request.queryParam("ids", $ids);
        }
        return $request->asJSON();
    }
    public function getTask($id) {
        return $this->GET("/v2.1/Tasks/$id")->asJSON();
    }
    public function addTask($task) {
        if ($task == "sample") {
            $return = $this->getTasks(array("top" => 1));
            return $return[0];
        }
        $url_path = "/v2.1/Tasks";
        if (isset($task->TASK_ID) && ($task->TASK_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($task)->asJSON();
    }
    public function deleteTask($id) {
        $this->DELETE("/v2.1/Tasks/$id")->asString();
        return true;
    }
    public function getTaskComments($task_id) {
        return $this->GET("/v2.1/Tasks/$task_id/Comments")->asJSON();
    }
    public function addTaskComment($task_id, $comment) {
        return $this->POST("/v2.1/Tasks/$task_id/Comments")->body($comment)->asJSON();
    }
    public function getTeams($options = null) {
        $request = $this->GET("/v2.1/Teams");
        $this->buildODataQuery($request, $options);
        return $request->asJSON();
    }
    public function getTeam($id) {
        return $this->GET("/v2.1/Teams/$id")->asJSON();
    }
    public function addTeam($team) {
        if ($team == "sample") {
            $return = $this->getTeams(array("top" => 1));
            return $return[0];
        }
        $url_path = "/v2.1/Teams";
        if (isset($team->TEAM_ID) && ($team->TEAM_ID > 0)) {
            $request = $this->PUT($url_path);
        }
        else{
            $request = $this->POST($url_path);
        }
        return $request->body($team)->asJSON();
    }
    public function deleteTeam($id) {
        $this->DELETE("/v2.1/Teams/$id")->asString();
        return true;
    }
    public function getTeamMembers($team_id) {
        return $this->POST("/v2.1/TeamMembers/teamid=$team_id")->asJSON();
    }
    public function getTeamMember($id) {
        return $this->POST("/v2.1/TeamMembers/$id")->asJSON();
    }
    public function addTeamMember($team_member) {
        if ($team_member == "sample") {
            $team_member = new stdClass();
            $team_member->PERMISSION_ID = 1;
            $team_member->TEAM_ID = 1;
            $team_member->MEMBER_USER_ID = 1;
            $team_member->MEMBER_TEAM_ID = 1;
            return $team_member;
        }
        return $this->POST("/v2.1/TeamMembers")->body($team_member)->asJSON();
    }
    public function updateTeamMember($team_member) {
        return $this->PUT("/v2.1/TeamMembers")->body($team_member)->asJSON();
    }
    public function deleteTeamMember($id) {
        $this->DELETE("/v2.1/TeamMembers/$id")->asString();
        return true;
    }
    public function getUsers() {
        return $this->GET("/v2.1/Users")->asJSON();
    }
    public function getUser($id) {
        return $this->GET("/v2.1/Users/" . $id)->asJSON();
    }
    /**
     * Add OData query filters to a request
     * 
     * Accepted options:
     * 	- top
     * 	- skip
     * 	- orderby
     * 	- an array of filters 
     * 
     * @param InsightlyRequest $request
     * @param array $options
     * @return InsightlyRequest
     * @link http://www.odata.org/documentation/odata-version-2-0/uri-conventions/
     */
    private function buildODataQuery($request, $options) {
  	$top = isset($options["top"]) ? $options["top"] : null;
  	$skip = isset($options["skip"]) ? $options["skip"] : null;
  	$orderby = isset($options["orderby"]) ? $options["orderby"] : null;
  	$filters = isset($options["filters"]) ? $options["filters"] : null;
        if ($top != null) {
            $request->queryParam('$top', $top);
        }
        if ($skip != null) {
            $request->queryParam('$skip', $skip);
        }
        if ($orderby != null) {
            $request->queryParam('$orderby', $orderby);
        }
        if ($filters != null) {
            foreach($filters as $filter) {
                $filterValue = str_replace(array('=', '>', '<'),
                                           array(' eq ', ' gt ', ' lt '),
                                           $filter);
                $request->queryParam('$filter', $filterValue);
            }
        }
        return $request;
    }

    // ---- HELPER METHODS ---- //
    // Create GET request
    private function GET($url_path) {
        return new InsightlyRequest("GET", $this->apikey, $url_path);
    }
    // Create PUT request
    private function PUT($url_path) {
        return new InsightlyRequest("PUT", $this->apikey, $url_path);
    }
    // Create POST request
    private function POST($url_path) {
        return new InsightlyRequest("POST", $this->apikey, $url_path);
    }
    // Create DELETE request
    private function DELETE($url_path) {
        return new InsightlyRequest("DELETE", $this->apikey, $url_path);
    }
}


/* API Requests class
 * Helper class for executing REST requests to the Insightly API.
 * 
 * Usage:
 *  - Instanciate: $request = new InsightlyRequest('GET', $apikey, 'create.../)
 *  - Execute: $request->toString();
 *  - Or implicitly execute: $request->asJSON(); */
class InsightlyRequest {
    const URL_BASE = 'https://api.insight.ly';
    /* @var resource */
    private $curl;
    /* @var string */
    private $url_path;
    /* @var array */
    private $headers;
    /* @var array */
    private $querystrings;
    /* @var string */
    private $body;

    /* Request initialisation */
    function __construct($method, $apikey, $url_path) {
        $this->curl = curl_init();
        $this->url_path = $url_path;
        $this->headers = array("Authorization: Basic " . base64_encode($apikey . ":"));
        $this->querystrings = array();
        $this->body = null;
        switch($method) {
            case "GET": // default
                break;
            case "DELETE":
                $this->method("DELETE");
                break;
            case "POST":
                $this->method("POST");
                break;
            case "PUT":
                $this->method("PUT");
                break;
            default: throw new Exception('Invalid HTTP method: ' . $method);
        }
        // Have curl return the response, rather than echoing it
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    /* Get executed request response */
    public function asString() {
        // This may be useful for debugging
        curl_setopt($this->curl, CURLOPT_VERBOSE, true);
        $url =  InsightlyRequest::URL_BASE . $this->url_path . $this->buildQueryString();
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        $response = curl_exec($this->curl);

        // Debugging
        /* echo '<pre>';
         * print_r($response);
         * echo '</pre>';*/

        $errno = curl_errno($this->curl);
        if ($errno != 0) {
            throw new Exception("HTTP Error (" . $errno . "): " . curl_error($this->curl));
        }
        $status_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        if (!($status_code == 200 || $status_code == 201 || $status_code == 202 || $status_code == 401)) {
            throw new Exception("Bad HTTP status code: " . $status_code);
        }
        return $response;
    }

    /* Return decoded JSON response */
    public function asJSON() {
        $data = json_decode($this->asString());
        $errno = json_last_error();
        if ($errno != JSON_ERROR_NONE) {
            throw new Exception("Error encountered decoding JSON: " . json_last_error_msg());
        }
        return $data;
    }

    /* Add data to the current request */
    public function body($obj) {
        $data = json_encode($obj);
        $errno = json_last_error();
        if ($errno != JSON_ERROR_NONE) {
            throw new Exception("Error encountered encoding JSON: " . json_last_error_message());
        }
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $this->headers[] = "Content-Type: application/json";

        return $this;
    }

    /* Set request method */
    private function method($method) {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        return $this;
    }

    /* Add query parameter to the current request */
    public function queryParam($name, $value) {
        // build the query string for this name/value pair
        $querystring = http_build_query(array($name => $value));
        // append it to the list of query strings
        $this->querystrings[] = $querystring;
        return $this;
    }

    /* Build query string for the current request */
    private function buildQueryString() {
        if (count($this->querystrings) == 0) {
            return "";
        }
        else{
            $querystring = "?";
            foreach($this->querystrings as $index => $value) {
                if ($index > 0) {
                    $querystring .= "&";
                }
                $querystring .= $value;
            }
            return $querystring;
        }
    }
}

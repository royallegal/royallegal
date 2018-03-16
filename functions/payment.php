<?php
add_action('woocommerce_thankyou', 'sync_purchase');
function sync_purchase($order_id) {
    global $wpdb;
    include $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/royallegal/woocommerce/myaccount/form/insightly.php';

    // Collect order data
    $order      = wc_get_order($order_id);
    $order_meta = get_post_meta($order_id);
    $data = array(
        "First"    => $order_meta['_billing_first_name'][0],
        "Last"     => $order_meta['_billing_last_name'][0],
        "Company"  => $order_meta['_billing_company'][0],
        "Address1" => $order_meta['_billing_address_1'][0],
        "Address2" => $order_meta['_billing_address_2'][0],
        "City"     => $order_meta['_billing_city'][0],
        "State"    => $order_meta['_billing_state'][0],
        "Zip"	   => $order_meta['_billing_postcode'][0],
        "Country"  => $order_meta['_billing_country'][0],
        "Email"    => $order_meta['_billing_email'][0],
        "Phone"    => $order_meta['_billing_phone'][0],
    );

    // Find user account by order email
    $wp_user    = get_user_by("email", $data["Email"])->user_login;    
    $rls_user   = $wpdb->get_results("SELECT * FROM royal_clients WHERE user='$wp_user'");

    // Generate API data
    $status     = status();
    $purchases  = purchases($rls_user, $order);
    $membership = membership($rls_user, $order);
    $profile    = $rls_user->profile;
    $date       = date('Y-m-d H:i:s');

    // ---- RLS ACCOUNTS ---- //
    // New User
    if (empty($rls_user)) {
        $wpdb->insert('royal_clients', array(
            'id'         => '',
            'user'       => $wp_user,
            'activity'   => date('Y-m-d H:i:s'),
            'status'     => $status->FIELD_VALUE,
            'purchases'  => $purchases->FIELD_VALUE,
            'membership' => $membership->FIELD_VALUE,
            'profile'    => ''
        ));
    }

    // Existing User
    else {
        $wpdb->update('royal_clients', array(
            'activity'   => date('Y-m-d H:i:s'),
            'status'     => $status->FIELD_VALUE,
            'purchases'  => $purchases->FIELD_VALUE,
            'membership' => $membership->FIELD_VALUE,
            'profile'    => ($profile ? $profile : '')
        ), array('user'  => $wp_user));
    }


    // ---- INSIGHTLY ---- //
    $crm = new Insightly();
    $crm_id   = $crm->getContacts(array("email"=>$data["Email"]))[0]->CONTACT_ID;
    $crm_user = $crm->getContact($crm_id);

    // Existing Users
    if (is_object($crm_user)) {
        // Update custom fields
        $custom_fields = array($status, $purchases, $membership, $rls["clients"]);
        foreach ($custom_fields as $field) {
            if (!empty($field)) {
                $crm->updateCustomFields($crm_id, $field);
            }
        }
    }

    // New Users
    else {
        // Creates Insightly user
        create_client($crm, $data, $status, $purchases, $membership);

        // Updates $crm_id based on new Insightly user ID
        $crm_id   = $crm->getContacts(array("email"=>$data["Email"]))[0]->CONTACT_ID;
        $crm_user = $crm->getContact($crm_id);
    }

    // Update the projects for that user
    update_projects($crm, $crm_id, $order, $data);
}


// ---- METHODS ---- //
// Contact
// Creates a new contact
function create_client($crm, $data, $status, $purchases, $membership) {
    $info = (object) [
        "FIRST_NAME"=>$data["First"],
        "LAST_NAME"=>$data["Last"],
        "CUSTOMFIELDS"=>array(
            0=>$status,
            1=>$purchases,
            2=>$membership
        ),
        "CONTACTINFOS"=>array(
            0=> (object) [
                "TYPE"   => "EMAIL",
 	        "LABEL"  => "WORK",
 	        "DETAIL" => $data["Email"]
            ],                    
            1=> (object) [
                "TYPE"   => "PHONE",
 	        "LABEL"  => "WORK",
 	        "DETAIL" => $data["Phone"]
            ],                    
        ),
        "ADDRESSES"=>array(
            0=>address($data)
        ),
    ];
    $crm->addContact($info);
}


// Projects
// Creates projects for each item purchased
function update_projects($crm, $crm_id, $order, $data) {
    $projects = array();
    $items = $order->get_items();
    foreach ($items as $i=>$item) {
  	$name = $item['name'];
  	$quantity = $item['quantity'];
  	$x = 0;
  	while($x < $quantity) {
            array_push($projects, $name);
  	    $x++;
  	}
    }

    foreach ($projects as $project) {
        $pipelines = $crm->getPipelines();
        $pipeline_id = "";
        foreach ($pipelines as $pipeline) {
            if ($pipeline->PIPELINE_NAME == $project) {
                $pipeline_id = $pipeline->PIPELINE_ID;
            }
        }

        $stages = $crm->getPipelineStages();
        $stage_id = "";
        foreach ($stages as $stage) {
            if ($stage->PIPELINE_ID == $pipeline_id) {
                $stage_id = $stage->STAGE_ID;
            }
        }

        $new_project = (object) [
            "PROJECT_NAME"=>$project." for ".$data["First"]." ".$data["Last"],
            "STATUS"=>"Not Started",
            "RESPONSIBLE_USER_ID"=>606969,
            "PIPELINE_ID"=>intval($pipeline_id),
            "STAGE_ID"=>intval($stage_id),
            "LINKS"=>array(
                0=>(object) [
                    "CONTACT_ID"=>$crm_id
                ]
            )
        ];
        $crm->addProject($new_project);
    }
}


// Address
//  - returns @array
//  - see $address
function address($data) {
    $street	= $data['Address1'].', '.$data['Address2'];
    $city	= $data['City'];
    $state	= $data['State'];
    $zip	= $data['Zip'];
    $address = (object) [
 	"ADDRESS_ID"   => "",
 	"ADDRESS_TYPE" => "OTHER",
 	"STREET"       => $street, 
 	"CITY"	       => $city,
 	"STATE"	       => $state,
 	"POSTCODE"     => $zip,
 	"COUNTRY"      => ""
    ];
    return $address;
}


// Contact Info
//  - returns @array (email, phone, phone, phone...)
//  - see $email
function contact_info($crm, $crm_id, $crm_user, $data) {
    $contact = phone($crm_user, $data);
    $email = (object) [
  	"TYPE"		  => "EMAIL",
  	"LABEL"		  => "WORK",
  	"DETAIL"	  => email($crm, $crm_id, $data)["Contact"]
    ];
    array_unshift($contact, $email);
    return $contact;
}


// Email
// returns @array (contact, note)
function email($crm, $crm_id, $data) {
    $contact = $crm->getContact($crm_id)->CONTACTINFOS;
    $match = 0;
    $email = array(
  	"Contact"=>"",
  	"Note"=>""
    );
    foreach ($contact as $info) {
  	if ($info->TYPE == "EMAIL" && !empty($info->DETAIL)) {
  	    // Leave contact email as-is
  	    $email["Contact"] = $info->DETAIL;
  	    // Add a note if new email doesn't match existing email
  	    if ($info->DETAIL != $data["Email"]) {
  		$match = 1;
  	    }
  	}
    }
    // Adds new email if none exists
    if ($match == 0) {
  	$email["Contact"] = $data["Email"];
    }
    // Check notes to see if new email has already been added
    else {
  	$notes = $crm->getContactNotes($crm_id);
  	$match = 0;
  	foreach ($notes as $note) {
  	    if ($note->TITLE == "Email" && $note->BODY == $data['Email']) {
  		$match = 1;
  	    }
  	}
  	// Add new note
  	if ($match == 0) {
  	    $email["Note"] = $data["Email"];
  	}
    }
    return $email;
}


// Phone
//  - returns @array (phone, phone, phone...)
//  - see $number
function phone($crm_user, $data) {
    $contact  = $crm_user->CONTACTINFOS;
    $phone = array();
    $labels   = array("WORK", "HOME", "MOBILE", "OTHER", "ASSISTANT", "FAX");
    $match = 0;
    foreach ($contact as $info) {
  	if ($info->TYPE == "PHONE") {
  	    // Flag pre-existing number(s)
  	    if ($info->DETAIL == $data["Phone"]) { $match = 1; }
  	    // Save existing numbers
  	    array_push($phone, $info);
  	    // Remove existing labels
  	    $used = array_search($info->LABEL, $labels);
  	    if ($used !== FALSE) {
  		unset($labels[$used]);
  	    }
  	}
    }
    
    // Add a new number to phone array
    if ($match == 0) {
  	$number = (object) [
  	    "TYPE"	      => "PHONE",
  	    "LABEL"	      => reset($labels),
  	    "DETAIL"	      => $data["Phone"]
  	];
  	array_push($phone, $number);
    }
    return $phone;
}


// Status
//  - returns @string ('client')
//  - see $status
function status() {
    $env = is_wpe() ? "Client" : "Test";  // Production vs Staging
    $status = (object) [
  	"CUSTOM_FIELD_ID"=>"CONTACT_FIELD_1",
  	"FIELD_VALUE"=>$env
    ];
    return $status;
}


// Purchases
//  - returns @string ('item1, item2, item3...')
function purchases($rls_user, $order) {
    if ($order) {
  	$history = $rls_user[0]->purchases; // Gets purchase purchases from royal_clients
  	$items = $order->get_items();
  	foreach ($items as $i=>$item) {
  	    $name = $item['name'];
  	    $quantity = $item['quantity'];
            
  	    // A list of product names (comma delimited)
  	    $x = 0;
  	    while($x < $quantity) {
  		$history = empty($history) ? $name : ($history.', '.$name);
  		$x++;
  	    }
  	}
    }
    $purchases = (object) [
  	"CUSTOM_FIELD_ID"=>"CONTACT_FIELD_2",
  	"FIELD_VALUE"=>$history
    ];

    return $purchases;
}


// Membership
// returns @number (3)
function membership($rls_user, $order) {
    if ($order) {
        $level = $rls_user[0]->membership;
  	$items = $order->get_items();
  	foreach ($items as $i=>$item) {
  	    $name = $item['name'];
  	    // Membership Level => 1 / 2 / 3
  	    if (class_exists('WC_Subscriptions_Product')
  		&& WC_Subscriptions_Product::is_subscription($item->get_product())) {
  		$level = substr($name, -1);
  	    }
  	}
    }
    $membership = (object) [
  	"CUSTOM_FIELD_ID"=>"CONTACT_FIELD_3",
  	"FIELD_VALUE"=>$level
    ];
    return $membership;
}
?>

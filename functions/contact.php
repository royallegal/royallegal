<?php
add_action('wp_ajax_nopriv_contact_us_form', 'contact_us_form_submit');
add_action('wp_ajax_contact_us_form', 'contact_us_form_submit');
function contact_us_form_submit(){
    // ---- POST DATA ---- //
    $first = $_POST['first'];
    $last  = $_POST['last'];
    $phone = $_POST['phone'];
    $email = strtolower($_POST['email']);
    $msg   = strtolower($_POST['msg']);

    // Validate Form Fields
    $post = array($first, $last, $phone, $email, $msg);
    foreach ($post as $key=>$data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        if ($key == 0 || $key == 1) {  // First & Last Name
            $data = ucwords($data);
        }
        if ($key == 2) {               // Phone
            $data = preg_replace('/[^0-9]/', '', $data);
        }
        if ($key == 3) {               // Email
            $data = strtolower($data);
        }
    }


    // ---- INSIGHTLY ---- //
    include $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/royallegal/woocommerce/myaccount/form/insightly.php';
    $crm    = new Insightly();
    $crm_id = $crm->getContacts(array("email"=>$email))[0]->CONTACT_ID;
    $crm_user = $crm->getContact($crm_id);

    // Existing Users
    if (is_object($crm_user)) {
        $task = (object) [
            "TITLE"=>"Contact ".$first." ".$last,
            "PUBLICLY_VISIBLE"=>true,
            "COMPLETED"=>false,
            "STATUS"=>"Not Started",
            "RESPONSIBLE_USER_ID"=>606969,
            "OWNER_USER_ID"=>606969,
            "TASKLINKS"=>array(
                0=>(object) [
                    "TASK_LINK_ID"=>$crm_id,
                    "CONTACT_ID"=>$crm_id
                ]
            )
        ];
        $crm->addTask($task);
    }

    // New Users
    else {
        // Adds contact form data to Insightly
        $env = is_wpe() ? "Prospect" : "Test"; // Production vs stating env
        $info = (object) [
            "FIRST_NAME"=>$first, // First
            "LAST_NAME"=>$last, // Last
            "CUSTOMFIELDS"=>array(
                0=>(object) [
                    "CUSTOM_FIELD_ID"=>"CONTACT_FIELD_1",
                    "FIELD_VALUE"=>$env
                ]
            ),
            "CONTACTINFOS"=>array(
                0=>(object) [
                    "TYPE"=>"EMAIL",
                    "LABEL"=>"WORK",
                    "DETAIL"=>$email
                ],
                1=>(object) [
                    "TYPE"=>"PHONE",
                    "LABEL"=>"WORK",
                    "DETAIL"=>$phone
                ]
            )
        ];
        $crm->addContact($info);

        // Update Insightly contact ID for the newly created user
        $crm_id = $crm->getContacts(array("email"=>$email))[0]->CONTACT_ID;

        // Enroll in MailChimp
    }

    // Add Note
    $note = (object) [
        "TITLE"=>"Contact Form",
        "BODY"=>$msg,
        "LINK_SUBJECT_ID"=>$crm_id,
        "LINK_SUBJECT_TYPE"=>"CONTACT",
        "NOTELINKS"=>array(
            0=>(object) [
                "CONTACT_ID"=>$crm_id
            ]
        )
    ];
    $crm->addNote($note);
    /* add_contact_note($crm_id, $post);*/


    // ---- EMAIL ---- //
    // Admin Email
    $contact1 = "scott@royallegalsolutions.com";
    $contact2 = "mark.swedberg@gmail.com";
    $contacts = $contact1.", ".$contact2;
    $subject  = "New Contact <Royal Legal Solutions>";
    $headers  = '';
    $headers .= 'From: '.$first.' '.$last.' <'.$email.'>'."\r\n";
    $headers .= "Reply-To: ".$email."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = '<h3>New Contact Request</h3><ul><li><strong>Name: </strong>'.$first.' '.$last.'</li><li><strong>Phone: </strong>'.$phone.'</li><li><strong>Email: </strong>'.$email.'</li></ul><br/><strong>Message</strong><p>'.$msg.'</p>';

    @mail($contacts, $subject, $body, $headers);

    // User Email
    $subject1  = "Thanks for Contacting Royal Legal Solutions";
    $headers1  = '';
    $headers1 .= "From: Royal Legal Solutions <".$contact1."> \r\n";
    $headers1 .= "Reply-To: ".$contact1."\r\n";
    $headers1 .= "MIME-Version: 1.0\r\n";
    $headers1 .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = '<h3>Thanks for contacting us!</h3><p>We have received your email and will get in touch with you soon.</p>';

    @mail($email, $subject1, $body, $headers1);

    // Close Connection
    die();
}


function add_contact_note($crm_id, $post) {
    $note = (object) [
        "TITLE"=>"Contact Form",
        "BODY"=>$post[4],
        "LINK_SUBJECT_ID"=>$crm_id,
        "LINK_SUBJECT_TYPE"=>"CONTACT",
        "NOTELINKS"=>array(
            0=>(object) [
                "CONTACT_ID"=>$crm_id
            ]
        )
    ];
    $crm->addNote($note);
}
?>

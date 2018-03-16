<?php
$validation = array(
    'relationship' => array(
	'name' => 'Relationship',
	'type' => 'fixed',
	'options' => array(
	    'Owner', 
	    'Spouse', 
	    'Child', 
	    'Other'
	),
    ),
    'first_name' => array(
	'name' => 'First Name',
	'type' => 'string',
	'options' => array(
	    'format' => VALIDATE_NAME,
	    'min_length' => '1',
	),
    ),
    'last_name' => array(
	'name' => 'Last Name',
	'type' => 'string',
	'options' => array(
	    'format' => VALIDATE_NAME,
	    'min_length' => '1',
	),
    ),
    'birthday' => array(
	'name' => 'Birthday',
	'type' => 'date',
	'options' => array(
	    'format' => '%Y-%m-%d',
	),
    ),
    'gender' => array(
	'name' => 'Gender',
	'type' => 'fixed',
	'options' => array(
	    'male',
	    'female',
	),
    ),
    'occupation' => array(
	'name' => 'Occupation',
	'type' => 'string',
	'options' => array(
	    'format' => VALIDATE_ALPHA,
	    'min_length' => '1',
	),
    ),
    'description' => array(
	'name' => 'Description',
	'type' => 'string',
	'options' => array(
	    'format' => VALIDATE_ALPHA,
	    'min_length' => '1',
	),
    ),
);

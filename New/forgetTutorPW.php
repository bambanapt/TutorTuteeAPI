<?php

//importing required script
require_once 'dbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    if(!empty($_POST['email'])){
        //getting values
        $email = $_POST['email'];

    	//creating db operation object
        $db = new dbOperation();

        //adding user to datsabase
        $result = $db->forgetTutorPW($email);
        
        //making the respone accordingly
        if ($result == EMAIL_SENT) {
            $response['error'] = false;
            $response['message'] = 'Password reset email sent successfully.';
        } elseif ($result == EAMIL_NOT_FOUND) {
            $response['error'] = true;
            $response['message'] = 'Email not found.';
        } 
    } else {
        $response['error'] = true;
        $response['message'] = 'Required parameters are missing.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

echo json_encode($response);


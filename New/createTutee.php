<?php
/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 04/02/17
 * Time: 7:51 PM
 */

//importing required script
require_once 'dbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('username', 'email', 'password'))) {
        
        //getting values
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $image = $_POST['image'];

        //creating db operation object
        $db = new dbOperation();

        //adding user to database
        $result = $db->createTutee($username, $email, $password, $image);

        //making the respone accordingly
        if ($result == USER_CREATED) {
            $response['error'] = false;
            $response['message'] = 'Tutee user created successfully.';
        } elseif ($result == USERNAME_ALREADY_EXIST) {
            $response['error'] = true;
            $response['message'] = 'Username already exist.';
        } elseif ($result == EMAIL_ALREADY_EXIST) {
            $response['error'] = true;
            $response['message'] = 'Email already exist.';  
        } elseif ($result == USER_NOT_CREATED) {
            $response['error'] = true;
            $response['message'] = 'Some error occurred.';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Required parameters are missing.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

//function to validate the required parameter in request
function verifyRequiredParams($required_fields) {

    //Getting the request parameters
    $request_params = $_REQUEST;

    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {

            //returning true;
            return true;
        }
    }
    return false;
}

echo json_encode($response);

?>
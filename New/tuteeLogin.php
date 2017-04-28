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

	if (!verifyRequiredParams(array('email', 'password'))) {

		//getting values
		$email = $_POST['email'];
        $password = $_POST['password'];

        //creating db operation object
        $db = new dbOperation();

         //getting user details from database
        $result = $db->tuteeLogin($email, $password);
        
        //making the respone accordingly
        if ($result['constant'] == USER_FOUND) {
            $response['error'] = false;
            $response['message'] = 'Tutee user login successfully.';
            $response['result'] = $result['data'];
        } elseif ($result['constant'] == USER_NOT_FOUND) {
            $response['error'] = true;
            $response['message'] = 'This email is not registered.';
        } elseif ($result['constant'] == INCORRECT_PW) {
            $response['error'] = true;
            $response['message'] = 'Incorrect Password';  
        } elseif ($result['constant'] == INACTIVATE_USER) {
            $response['error'] = true;
            $response['message'] = 'This email is not activated.';  
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
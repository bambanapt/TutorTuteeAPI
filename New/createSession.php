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
    if (!verifyRequiredParams(array('tutor_ID', 'date', 'start_time', 'finish_time', 'duration', 'subject', 'location'))) {

    	//getting values
        $tutor_ID = $_POST['tutor_ID'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $finish_time = $_POST['finish_time'];
        $duration = $_POST['duration'];
        $subject = $_POST['subject'];
        $location = $_POST['location'];

        //creating db operation object
        $db = new dbOperation();

         //adding session to database
        $result = $db->createSession($tutor_ID, $date, $start_time, $finish_time, $duration, $subject, $location);

        //making the respone accordingly
        if ($result['constant'] == SESSION_CREATED) {
            $response['error'] = false;
            $response['message'] = 'Session created successfully.';
            $response['result'] = $result['data'];
        } elseif ($result['constant'] == SESSION_EXISTED) {
            $response['error'] = true;
            $response['message'] = 'Tutor already created a session for this period.';
        } elseif ($result['constant'] == SESSION_NOT_CREATED) {
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
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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if(!empty($_GET['id'])) {

		//getting values
		$id = $_GET['id'];

		//creating db operation object
        $db = new dbOperation();

        //getting sessions from database
        $result = $db->getTutorAvailableSessions($id);

        // echo json_encode($result);
        if($result == null){
            $response['error'] = true;
            $response['message'] = 'No session found.';
        } else {
            $response['error'] = false;
            $response['message'] = 'Get sessions successfully.';
            $response['result'] = $result;
        }
    } else {
    	$response['error'] = true;
        $response['message'] = 'Required parameter is missing.';
        
    }
} else {
	$response['error'] = true;
    $response['message'] = 'Invalid request';
}

echo json_encode($response);

?>
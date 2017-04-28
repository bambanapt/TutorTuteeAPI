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

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    parse_str(file_get_contents("php://input"), $request_vars);
	if(!empty($request_vars['id'])) {
		//getting values
		$id = $request_vars['id'];

		//creating db operation object
    	$db = new dbOperation();
    
    	//getting sessions from database
    	$result = $db->deleteSession($id);
 
    	//making the respone accordingly
        if ($result == SESSION_DELETED) {
            $response['error'] = false;
            $response['message'] = 'Session is deleted successfully.';
        } elseif ($result == SESSION_NOT_EXIST) {
        	$response['error'] = true;
            $response['message'] = 'No session found.';
        } elseif ($result == SESSION_NOT_AVAILABLE) {
        	$response['error'] = true;
            $response['message'] = 'Session is already booked and cannot be delete.';
        } else {
        	$response['error'] = true;
            $response['message'] = 'Some error occured. Session cannot be deleted.';
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
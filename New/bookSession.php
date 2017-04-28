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

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"),$post_vars);
	if(!empty($post_vars['session_ID']) && !empty($post_vars['tutee_ID'])) {
		//getting values
		$session_ID = $post_vars['session_ID'];
        $tutee_ID = $post_vars['tutee_ID'];

		//creating db operation object
    	$db = new dbOperation();
    
    	//getting sessions from database
    	$result = $db->bookSession($session_ID, $tutee_ID);
    
    	//making the respone accordingly
        if ($result['constant'] == SESSION_BOOKED) {
            $response['error'] = false;
            $response['message'] = 'Session created successfully.';
            $response['result'] = $result['data'];
        } elseif ($result['constant'] == SESSION_NOT_AVAILABLE) {
            $response['error'] = true;
            $response['message'] = 'This session is already booked.';
        } elseif ($result['constant'] == SESSION_NOT_BOOKED) {
            $response['error'] = true;
            $response['message'] = 'Some error occurred.';
        } elseif($result['constant'] == SESSION_NOT_FOUND){
            $response['error'] = false;
            $response['message'] = 'No session found.';
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
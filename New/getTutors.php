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

	//creating db operation object
    	$db = new dbOperation();

	if (!empty($_GET['sort']) && !empty($_GET['search']) && !empty($_GET['value'])) {
    	$sort = $_GET['sort'];
    	$search = $_GET['search'];
    	$value = $_GET['value'];

    	//getting sessions from database
    	$result = $db->sortAndSearchTutors($sort,$search,$value);
    	// echo '===============sort&search===================';
    	// echo json_encode($result);

    } elseif(!empty($_GET['sort'])) {
    	$sort = $_GET['sort'];

    	//getting sessions from database
    	$result = $db->sortTutors($sort);
    	// echo '===============sort===================';
    	// echo json_encode($result);

    } elseif(!empty($_GET['search']) && !empty($_GET['value'])) {
    	$search = $_GET['search'];
    	$value = $_GET['value'];

    	//getting sessions from database
    	$result = $db->searchTutors($search,$value);
    	// echo '===============search===================';
    	// echo json_encode($result);

    } else {
    	//getting sessions from database
    	$result = $db->getTutors();
    	// echo '===============normal case===================';
    	// echo json_encode($result);
    } 
	
	if($result == null){
        $response['error'] = true;
        $response['message'] = 'No tutor found.';
    } else {
        $response['error'] = false;
        $response['message'] = 'Get tutors successfully.';
        $response['result'] = $result;
    }

} else {
	$response['error'] = true;
    $response['message'] = 'Invalid request';
}

echo json_encode($response);

?>
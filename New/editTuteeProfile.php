<?php

require_once 'dbOperation.php';
$db = new dbOperation();

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	parse_str(file_get_contents("php://input"),$post_vars);
	if(!empty($post_vars['id'])) {
		//getting values
		$id = $post_vars['id'];
        $password = $post_vars['password'];
        $image = $post_vars['image'];

		//creating db operation object
        $db = new dbOperation();

        //update user
        $result = $db->editTuteeProfile($id,$password,$image);

        //making the respone accordingly
        if ($result['constant'] == USER_UPDATED) {
            $response['error'] = false;
            $response['message'] = 'Tutee user updated successfully.';
            $response['result'] = $result['data'];
        } elseif ($result['constant'] == USER_NOT_UPDATED) {
            $response['error'] = true;
            $response['message'] = 'Some error occurred.';
        } elseif ($result['constant'] == USER_NOT_FOUND) {
        	$response['error'] = true;
            $response['message'] = 'No account found.';
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

?>
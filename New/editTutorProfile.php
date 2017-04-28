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
        $description = $post_vars['description'];
        $gender = $post_vars['gender'];
        $age = $post_vars['age'];
        $image = $post_vars['image']; 
        $subject = $post_vars['subject'];
        $hourly_rate = $post_vars['hourly_rate'];
        $location = $post_vars['location'];

        // $faculty = $post_vars['faculty'];
        // $university = $post_vars['university'];
        // $certificate = $post_vars['certificate'];
        // $transcript = $post_vars['transcript'];
        $phone = $post_vars['phone'];
        $lineID = $post_vars['lineID'];
        $account_name = $post_vars['account_name'];
        $account_no = $post_vars['account_no'];
        $bank_name = $post_vars['bank_name'];

		//creating db operation object
        $db = new dbOperation();

        //update user
        $result = $db->editTutorProfile($id,$password,$description,$gender,$age,$image,$subject,$hourly_rate,$location,$phone,$lineID,$account_name,$account_no,$bank_name);

        //making the respone accordingly
        if ($result['constant'] == USER_UPDATED) {
            $response['error'] = false;
            $response['message'] = 'Tutor user updated successfully.';
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
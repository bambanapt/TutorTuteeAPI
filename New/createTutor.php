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
    if (!verifyRequiredParams(array('tutor_Fname', 'tutor_Lname', 'email', 'password','description','gender','age', 'subject', 'hourly_rate', 'location', 'faculty', 'university', 'phone', 'account_name', 'account_no', 'bank_name'))) {

        //getting values
        $tutor_Fname = $_POST['tutor_Fname'];
        $tutor_Lname = $_POST['tutor_Lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $description = $_POST['description'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $image = $_POST['image']; 
        $subject = $_POST['subject'];
        $hourly_rate = $_POST['hourly_rate'];
        $location = $_POST['location'];
        $faculty = $_POST['faculty'];
        $university = $_POST['university'];
        $certificate = $_POST['certificate'];
        $transcript = $_POST['transcript'];
        $phone = $_POST['phone'];
        $lineID = $_POST['lineID'];
        $account_name = $_POST['account_name'];
        $account_no = $_POST['account_no'];
        $bank_name = $_POST['bank_name'];

        //creating db operation object
        $db = new dbOperation();

        //adding user to datsabase
        $result = $db->createTutor($tutor_Fname, $tutor_Lname, $email, $password, $description,$gender,$age,$image,$subject,$hourly_rate,$location,$faculty,$university,$certificate,$transcript,$phone,$lineID,$account_name,$account_no,$bank_name);

        //making the respone accordingly
        if ($result == USER_CREATED) {
            $response['error'] = false;
            $response['message'] = 'Tutor user created successfully.';
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
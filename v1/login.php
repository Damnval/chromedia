<?php

session_start();
// Connect to database
include("connection.php");

$db = new dbObj();
$connection = $db->getConnstring();
 
$request_method=$_SERVER["REQUEST_METHOD"];

/**
 * Will identify what http request is send
 * 
 * @param string $request_method
 */
switch($request_method)
{
  case 'POST':
    login();
    break;
break;
  default:
    // Invalid Request Method
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

/**
 * Api that will check user credentials
 *
 * @return json
 */
function login()
{
  global $connection;

	$username = stripslashes($_REQUEST['username']);
	//escapes special characters in a string
	$username = mysqli_real_escape_string($connection, $username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($connection,$password);
	//Checking is user existing in the database or not
	$query = "SELECT * FROM `users` WHERE username='$username'
		and password='".md5($password)."'";
	$result = mysqli_query($connection,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	$user_data = mysqli_fetch_assoc($result);

    if($rows==1){
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_data['id'];
        $response=array(
            'status' => 200,
            'status_message' =>'Successfully Login.'
        );
    } else {
        $response=array(
            'status' => 500,
            'status_message' =>'Invalid Credentials.'
        );
    }

  header('Content-Type: application/json');
  echo json_encode($response);

}



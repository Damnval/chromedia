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
  case 'GET':
    // Retrive Todo
    if(!empty($_GET["id"])) {
      $id=intval($_GET["id"]);
      get_task($id);
    }
    else {
      get_tasks();
    }
    break;
  case 'POST':
    // Insert Todo
    insert_task();
    break;
  case 'PUT':
    // Update Todo
    $id=intval($_GET["id"]);
    update_task($id);
    break;
  case 'DELETE':
    // Delete Todo
    $id=intval($_GET["id"]);
    delete_task($id);
break;
  default:
    // Invalid Request Method
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

/**
 * Api that will get all tasks
 *
 * @return json
 */
function get_tasks()
{
  global $connection;

  $array = array();  
  $query = "SELECT * FROM tasks WHERE user_id=". $_SESSION['user_id'] ."";  
  $result = mysqli_query($connection, $query);  
  while($row = mysqli_fetch_assoc($result))  
  {  
      $array[] = $row;  
  }  
  
  header('Content-Type: application/json');
  echo json_encode($array);
}

/**
 * Api that will get all specific tasks
 *
 * @return json
 */
function get_task($id=0)
{
	global $connection;
	$query="SELECT * FROM tasks";

	if($id != 0) {
		$query.=" WHERE id=".$id." LIMIT 1";
	}

	$response=array();
	$result=mysqli_query($connection, $query);

	while($row=mysqli_fetch_assoc($result)) {
		$response[]=$row;
	}
  
	header('Content-Type: application/json');
	echo json_encode($response);
}

/**
 * Api that will insert a tasks
 *
 * @return json
 */
function insert_task()
{
  global $connection;
  $data =($_REQUEST);

  $query = "INSERT INTO tasks (";
  $query .= implode(",", array_keys($data)) . ') VALUES (';  
  $query .= "'" . implode("','", array_values($data)) . "')";
  
  if(mysqli_query($connection, $query))
  {
    $response=array(
      'status' => 200,
      'status_message' =>'Task Added Successfully.'
    );
  }
  else
  {
    $response=array(
      'status' => 500,
      'status_message' =>'Task Addition Failed.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

/**
 * Api that will update a tasks
 *
 * @return json
 */
function update_task($id)
{
  global $connection;
  // $data = [];
  // $data =($_REQUEST);

  $put_data = file_get_contents("php://input");

  parse_str($put_data, $post_vars);

  // $post_vars = json_decode(file_get_contents("php://input"),true);
  $task=$post_vars["task"];
  $query="UPDATE tasks SET task='".$task."' WHERE id=".$id;
  
  if(mysqli_query($connection, $query))
  {
    $response=array(
      'status' => 200,
      'status_message' =>'Task Updated Successfully.'
    );
  }
  else
  {
    $response=array(
      'status' => 500,
      'status_message' =>'Task Updation Failed.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

/**
 * Api that will delete a tasks
 *
 * @return json
 */
function delete_task($id)
{
	global $connection;
	$query="DELETE FROM tasks WHERE id=".$id;
	if(mysqli_query($connection, $query))
	{
		$response=array(
			'status' => 200,
			'status_message' =>'Task Deleted Successfully.'
		);
	}
	else
	{
		$response=array(
			'status' => 500,
			'status_message' =>'Task Deletion Failed.'
		);
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}

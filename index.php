<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="style.css" />
</head>

<body>
<?php
require('database.php');
$data = new Databases;  
session_start();
// If form submitted, insert values into the database.
if (isset($_POST['username'])){
  // removes backslashes
	$username = stripslashes($_REQUEST['username']);
  //escapes special characters in a string
	$username = mysqli_real_escape_string($data->con,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($data->con,$password);
	//Checking is user existing in the database or not
  $query = "SELECT * FROM `users` WHERE username='$username'
              and password='".md5($password)."'";
	$result = mysqli_query($data->con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	$user_data = mysqli_fetch_assoc($result);
  if($rows==1){
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $user_data['id'];
      // Redirect user to todo.php
    header("Location: todo.php");
    }else{
	echo "<div class='form'>
	<h3>Username/password is incorrect.</h3>
	<br/>Click here to <a href='/chromedia/'>Login</a></div>";
	}
    }else{
?>
<div class="form">
    <h1>Log In</h1>
    <form action="" method="post" name="login">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <input name="submit" type="submit" value="Login" />
    </form>
</div>

<?php } ?>

</body>
</html>
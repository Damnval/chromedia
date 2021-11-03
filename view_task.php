<?php
  include 'database.php';  
  $data = new Databases; 
  //include auth.php file on all secure pages
  include("auth.php"); 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>
<body>

	<div class="col-md-3"></div>
	<div class="col-md-6">
		<h3 class="text-primary">
    	<?php

      if($_GET['id']){

        $where = [
          'id' => $_GET["id"],
          'user_id' => $_SESSION['user_id']  
        ];

        $single_data = $data->select_where("tasks", $where);  
        if(!count($single_data)){
          $message = "Huli ka balbon! Walang magic2 dito. peace :)";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
        foreach($single_data as $post)  
        {  
      ?>  
          <label>View Task</label>  
          <input class="form-control" type="text" placeholder="<?php echo $post["task"]; ?>" readonly>
      <?php  
        }  

      }
      ?>
    </h3>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
<?php  
 //todo.php  
 include 'database.php';  
//include auth.php file on all secure pages
include("auth.php");
 $data = new Databases;  

 if(isset($_POST["submit"]))  
 {  
    $insert_data = [
        'task' => mysqli_real_escape_string($data->con, $_POST['task']),
        'user_id' => $_SESSION['user_id'] 
    ];  

    if($data->insert('tasks', $insert_data))  
    {  
      header("location:todo.php"); 
    }       
 }  

 if(isset($_POST["edit"]))  
 {  
    $update_data =[ 
      'task' =>  mysqli_real_escape_string($data->con, $_POST['task']),  
    ];  
        
    $where_condition = [ 
      'id' => $_POST["id"]  
    ]; 

    if($data->update("tasks", $update_data, $where_condition))  
    {  
      header("location:todo.php"); 
    }  
 }  

 if(isset($_GET["delete"]))  
 {  
    $where = [ 
      'id' => $_GET["task_id"]  
    ];

    if($data->delete("tasks", $where)) {  
        header("location:todo.php");  
    }  
 }  

 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
          <title>Val Montesclaros Coding Exam</title>  
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <style>
        a{
          color:#0067ab;
          text-decoration:none;
        }
        a:hover{
          text-decoration:underline;
        }
      </style>
      <body>  
           <br /><br />  
    
           <div class="container" style="width:700px;">  
               <h3>Hello <?php echo $_SESSION['username']; ?></h3>
               <a href="logout.php">Logout</a>
               <br />  
               <form method="post">  
                    <?php  
                      if(isset($_GET["edit"]))  
                      {  
                        if(isset($_GET["id"]))  
                        {  
                          $where = [
                            'id' => $_GET["id"]  
                          ];
                      
                          $single_data = $data->select_where("tasks", $where);  
                          foreach($single_data as $post)  
                          {  
                    ?>  
                      <label>Task</label>  
                      <input type="text" name="task" value="<?php echo $post["task"]; ?>" class="form-control" />  
                      <br />  
                      <input type="hidden" name="id" value="<?php echo $post["id"]; ?>" />  
                      <input type="submit" name="edit" class="btn btn-info" value="Edit" />  
                    <?php  
                            }  
                          }  
                        }  
                     else {  
                     ?>  
                      <label>Todo Task</label>  
                      <input type="text" name="task" class="form-control" />  
                      <br />  
                      <input type="submit" name="submit" class="btn btn-info" value="Submit" />  
                     <?php  
                     }  
                     ?>  
                </form>  
                <br />  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                            <td width="55%">Task</td>  
                            <td width="15%">Edit</td>  
                            <td width="15%">Delete</td>  
                            <td width="15%">View</td> 
                          </tr>  
                          <?php  

                          $where = [
                            'user_id' => $_SESSION['user_id']  
                          ];

                          $task_data = $data->select_where("tasks", $where);  
                          foreach($task_data as $task)  
                          {  
                          ?>  
                          <tr>  
                            <td><?php echo $task["task"]; ?></td>  
                            <td><a href="todo.php?edit=1&id=<?php echo $task["id"]; ?>">Edit</a></td>  
                            <td><a href="#" id="<?php echo $task["id"]; ?>" class="delete">Delete</a></td> 
                            <td><a href="view_task.php?id=<?php echo $task["id"]; ?> ">View</a></td>   
                          </tr>  
                         <?php  
                         }  
                         ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
    $('.delete').click(function(){  
          var task_id = $(this).attr("id");  
          if(confirm("Are you sure you want to delete this Task?"))  
          {  
              window.location = "todo.php?delete=1&task_id="+task_id+"";  
          }  
          else  
          {  
              return false;  
          }  
    });  
 });  
 </script>  
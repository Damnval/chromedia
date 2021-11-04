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
              <input type="text" name="task" class="form-control" required/>  
              <br />  
              <input type="submit" name="submit" class="btn btn-info" value="Submit" />  
              <?php  
              }  
              ?>  
        </form>  
        <br />  
        <div class="table-responsive">  
          <table class="table table-bordered" id="tbDetails">  
            <tr>  
              <td width="55%">Task</td>  
              <td width="15%">Edit</td>  
              <td width="15%">Delete</td>  
              <td width="15%">View</td> 
            </tr>  
            <tbody id="todo-list">
  
            </tbody>
          </table>  
        </div>  
      </div>  
    </body>  
 </html>  

 <script>  

 $(document).ready(function(){  

    $('#todo-list').on('click', '.delete', function(data){
      if(confirm("Are you sure you want to delete this Task?"))  
      {  
        var task_id = data.target.id
       
        $.ajax({
            url: 'http://localhost/chromedia/v1/tasks/' + task_id,
            type: 'DELETE',
            success: function(result) {
              alert(result.status_message)
            }
        });
        $(this).closest('tr').remove()

      }  
      else  
      {  
        return false;  
      }  
    })

    $.ajax({
      type: "GET",
      url: "http://localhost/chromedia/v1/tasks",
      dataType: "json",
      success: function (result, status, xhr) {

        $.each(result, function (index, obj) { 
          var row = '<tr><td> ' + obj.task + ' </td> ' +
          ' + <td><a href="todo.php?edit=1&id=' + obj.id + '">Edit</a></td> ' +
          ' + <td><a href="#" id="' + obj.id + '" class="delete">Delete</a></td> ' +
          ' + <td><a href="view_task.php?id=' + obj.id + '">View</a></td>  </tr>';
          $("#todo-list").append(row);
        }); 

      },
      error: function (xhr, status, error) {
        alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
      }
    });

 });  
 </script>  
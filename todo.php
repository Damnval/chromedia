<?php  
//todo.php
//include auth.php file on all secure pages
include("auth.php");
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
          <label>Todo Task</label>  
          <input type="text" name="task" id="task" class="form-control" required/>  
          <br />  
          <input type="button" id="submit_task" name="submit" class="btn btn-info" value="Submit" />  
          <input type="hidden" id="edit_task" name="edit" class="btn btn-info edit_task" value="Edit" /> 
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

  var selectedTaskId = 0;
  /**
   * HTTP that will save new task
   */
  $('#submit_task').on('click', function() {

		var task = $('#task').val();
			$.ajax({
				url: "http://localhost/chromedia/v1/tasks/",
				type: "POST",
				data: {
					task: task,
					user_id: <?php echo $_SESSION['user_id']; ?>,			
				},
				success: function(result){
          alert(result.status_message)
          window.location.href = "http://localhost/chromedia/todo.php";
				}
			});
	});

  /**
   * pre-set the selected task id and the task value what to changed
   */
  $('#tbDetails').on('click', '.edit', function (e) {

    selectedTaskId = e.target.id;
    var task = $(this).parent().parent().children(':nth-child(1)').text().trim();
    // set the task to the selected task
    $('input[name=task]').val(task);
    // show edit task button
    $('#edit_task').removeAttr("type").attr("type", "button");
    // show submit task button on creating new tasks
    $('#submit_task').removeAttr("type").attr("type", "hidden");
  });

  /**
   * HTTP that will delete task
   */
  $(".edit_task").click(function(){
    var task = $('#task').val();

    $.ajax({
        url: 'http://localhost/chromedia/v1/tasks/' + selectedTaskId,
        type: 'PUT',
        data: {
					task: task,
					user_id: <?php echo $_SESSION['user_id']; ?>,			
				},
        success: function(result) {
          window.location.href = "http://localhost/chromedia/todo.php";
        }
    });
  });

  /**
   * HTTP that will delete task
   */
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

  /**
   * HTTP that will get all tasks
   */
  $.ajax({
    type: "GET",
    url: "http://localhost/chromedia/v1/tasks",
    dataType: "json",
    success: function (result, status, xhr) {

      $.each(result, function (index, obj) { 
        var row = '<tr><td> ' + obj.task + ' </td> ' +
        ' + <td><a href="#" id="' + obj.id + '" class="edit">Edit</a></td> ' +
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
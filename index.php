<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
</head>

<body>
  <div class="container">
    <div class="col-md-3"></div>
    <div class="col-md-6">

    <div class="form">
      <h1>Log In</h1>
      <form action="" name="login" id="loginForm">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" class="form-control" id="username" placeholder="username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="password">
        </div>
        <button type="button" id="login" class="btn btn-primary">Submit</button>
      </form>
    </div>

    </div>
  <div class="col-md-3"></div>
</div>

<script>

  $(document).ready(function(){  

    $('#login').on('click', function() {

       /**
       * HTTP that will get specific tasks
       */
      $.ajax({
        type: "POST",
        url: "http://localhost/chromedia/v1/login/",
        data: {
          username: $("input[name=username]").val(),
          password: $("input[name=password]").val(),			
        },
        dataType: "json",
        success: function (result, status, xhr) {
          console.log(result)
          if(result.status == 200){
            window.location.href = "http://localhost/chromedia/todo.php";
          } else {
            document.getElementById("loginForm").reset();
            alert(result.status_message)
          }
          
        },
        error: function (xhr, status, error) {
          alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
        }
      });

    });

    });  
    
</script>

<?php  
  include("layout/footer.php");
?>

<?php
  include("layout/header.php"); 
?>

<body>
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<h3 class="text-primary">
      <label>View Task</label>  
      <input class="form-control" type="text" name="task" id="task" readonly>
    </h3>
	</div>

<script>

  $(document).ready(function(){  

    var task_id = <?php echo $_GET["id"]; ?>;
      /**
       * HTTP that will get specific tasks
       */
      $.ajax({
        type: "GET",
        url: "http://localhost/chromedia/v1/tasks/" + task_id,
        dataType: "json",
        success: function (result, status, xhr) {

           $('input[name=task]').val((result[0].task));
        },
        error: function (xhr, status, error) {
          alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
        }
      });

    });  
</script>

<?php
  include("layout/footer.php"); 
?>

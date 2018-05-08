<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

	<style>

		.box {
		position:relative;
		width: auto;
		height: auto;
		
		background: rgba(0, 0, 0, .1);
		border-radius: 3px;
		border: 1px solid black;
		}
		
		#user {
		float: right;
		
	
			}

	</style>

      <script type = "text/javascript">
var movie = "<?php  $movie = $_GET['title']; echo $movie; ?>";  
var user = "<?php  session_start(); $user= $_SESSION['user']; echo $user; ?>";    
         $(document).ready(function() {
        
           $.ajax({
                type: "GET",
                url: "forum.php",
		data: "title=" + movie,

                success: function(data)//should be data
        { var pd = JSON.parse(data);
	
        
	$("#header").html( movie + ' Reviews');
	$.each(pd, function(){
	$("#fill").append('<div class = "box" >' +  this.user + ': <br> <br>' + this.comment + '<br>' + '</div> <br>');
		});
	$("#user").append('You are logged in as: ' +user);
        }, // success

                 }); // ajax
  


 $("#A").click(function(){

var insert = $("#t").val(); 

   $.ajax({
                type: "GET",
                url: "forum.php",
                data: "desc=" + insert + "&title=" + movie,

                success: function(data)//should be data
        { var pd = JSON.parse(data);
 	 $("#t").val("");

        }, // success

                 }); // ajax
                
         }); // click
}); // document
    </script>
</head>
<body>
<div id = "user" > </div>
<div class="container">

  <h2 id= "header">Reviews</h2>
  <form>
	 <div class="form-group">
      <label for="pwd">Comments/Description:</label>
      <input type="text" class="form-control" id="t" placeholder="Write a review up to 100 characters" name="pwd">
    </div>
    <button type="button"  id = "A" class="btn btn-default"> Send</button>
  </form>
</div><br>

<div class="container2">

	<div class="container" id = "fill"></div>
</div>
</body>
</html>

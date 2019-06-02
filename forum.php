<?php

session_start();


$user = $_SESSION["user"]; // has user not zipcode
$movie = $_GET['title'];
//$movie= 'A Quiet Place';
$db = mysqli_connect ( 'localhost', 'root', 'root', 'example' );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }

    mysqli_select_db($db, 'example' );
$movie = mysqli_real_escape_string($db, $movie);
$s = "Select * from reviews where title = '$movie'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$new = array();
while($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
{
array_push($new, $r);
}

if(isset($_GET['desc']))
{
$comment = $_GET['desc'];
$comment = mysqli_real_escape_string($db, $comment);
$b = "INSERT INTO reviews VALUES('$user','$movie','$comment')";
$a = mysqli_query($db, $b) or die (mysqli_error($db));
}



echo json_encode($new); // i think??



?>

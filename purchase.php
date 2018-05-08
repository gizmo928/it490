<?php

$movie =  $_GET["title"];
$date = $_GET["date"];
$user = $_GET["user"];
$showtime = $_GET["showtime"];

($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
 mysqli_select_db($db, 'example' );

$s = "INSERT INTO purchases VALUES ('$user','$movie', '$showtime', '$date')";
( mysqli_query($db,$s) or die (mysqli_error($db)));







?>


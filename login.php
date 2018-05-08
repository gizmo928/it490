<?php
session_start();
error_reporting(-1);
ini_set('display_errors', true);

include ('client.php');
include('redirect.php');
$user = $_POST['username'];
$pass = $_POST['password'];
$response = connection($user,$pass);
if($response == false)
  {
    $message= "Login Unsuccessful. Please try again or Register";
    redirect($message, "main.html", 3);
  }
  else{
  $message = "Login Successful!";
  $_SESSION["user"] = $user;
  redirect($message, "main2.html", 3);
}
  
?>

<?php

error_reporting(-1);
ini_set('display_errors', true);

include ('client.php');
include('redirect.php');
$user = $_POST['user'];
$pass = $_POST['password'];
$response = connection($user,$pass);
if($response == false)
  {
    $message= "Login Unsuccessful. Please try again or Register";
    redirect($message, "login.html", 3);
  }
  else{
  echo "login succ!";
  $message = "Login Successful!";
  redirect($message, "main.html", 3);
}
  
?>

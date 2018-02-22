<?php

error_reporting(-1);
ini_set('display_errors', true);

include ('client.php');
$user = $_POST['user'];
$pass = $_POST['password'];
echo" user is $user, pass is $pass";
$response = connection($user,$pass);
if($response == false)
  {
    echo "Login Unsuccessful. Please try again or Register";
  }
  else

  echo "Login Successful!";

?>

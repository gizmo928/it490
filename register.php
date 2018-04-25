

<?php
/*


//include ('redirect.php');

error_reporting(-1);
ini_set('display_errors', false);
include ('client.php');
$firstname = $_POST['fName'];
$lastname  = $_POST['lName'];
$email = $_POST['email'];
$user = $_POST['user']; 
$password = $_POST['pass'];

$response = registration($email,$firstname,$lastname,$password, $user);

if($response != true)
  {
	 header("Refresh:2; url=main.html", true, 303);
//	redirect("registration failed !!", "main.html", 3);
  }
  else

  
{
echo "thank you for registering!!:)";
 header("Refresh:2; url=newtheatre.html", true, 303);
   // redirect("Thank you for registering!!!", "newtheatre.html", 3);
  }

*/


ini_set("display_errors", 1);
//ini_set("log_errors",1);
//ini_set("error_log", "/tmp/error.log");
//error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT);
//error_log("Hello, errors!");
include ('client.php');
$firstname = $_POST['fName'];
$lastname = $_POST['lName'];
$user  = $_POST['user'];
$email = $_POST['email'];
$password = $_POST['pass'];
$zipcode = $_POST['zipcode'];
$response = registration($email,$firstname,$lastname, $password, $user, $zipcode);
if($response != true)
  {
    echo "Registration Failed. Please try a different email";
    header( "Refresh:1; url=main.html", true, 303);
  }
  else
  {
    echo "Thank you for Registering!. Please Log in now.";
    header( "Refresh:1; url=main.html", true, 303);
  }

?> 


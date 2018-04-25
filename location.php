<?php
//ini_set("display_errors", 1);
//ini_set("log_errors",1);
//ini_set("error_log", "/tmp/error.log");
//error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT);
include ('client.php');

session_start();
/*
$db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }

    mysqli_select_db($db, 'example' );
$user = $_SESSION["user"]; // has user not zipcode

$s = "Select * from customer where user = '$user'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
$_SESSION["zipcode"] = $r['zipcode'];

*/

$user = $_SESSION["user"]; // has user not zipcode
$date  = date("Y-m-d"); // contains todays date
$date = "$date";
$_SESSION["date"] = $date; // adding date to session, not sure about this though.
$response = apicall($date, $user);
$response1 = getData($date, $user); 
echo json_encode($response1); // returns title & photo for main2.html when first logging in 
?>

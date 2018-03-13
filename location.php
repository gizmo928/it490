<?php
//ini_set("display_errors", 1);
//ini_set("log_errors",1);
//ini_set("error_log", "/tmp/error.log");
//error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT);
include ('client.php');
$zipcode = $_GET["uu"]; 
$date  = $_GET["u"];//date("Y-m-d"); 
$zipcode = "$zipcode";
$date = "$date";
$response = apicall($date, $zipcode);
$response1 = getData($date, $zipcode); 
echo json_encode($response1); 
?>

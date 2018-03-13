#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
function auth($u, $v) {
    ( $db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    echo "Successfully connected to MySQL<br><br>";
    mysqli_select_db($db, 'example' );
    $s = "select * from customer where user = '$u' and password = '$v'";
    //echo "The SQL statement is $s";
    ($t = mysqli_query ($db,$s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);
    if ($num == 0){
      return false;
    }else
    {

      return true;
    }
}


function registration($email,$firstname,$lastname,$password) {
    ( $db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    echo "Successfully connected to MySQL";
    mysqli_select_db($db, 'example' );
    $e = "SELECT * FROM customer WHERE email = '$email'";
    $t = mysqli_query($db, $e) or die(mysqli_error($db));
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $p = $r["email"];
    if($email == $p){
        echo "  Email has already been used";
	return false; 
    }else{
          mysqli_query($db,"INSERT INTO customer (email, firstname, lastname, password) VALUES ('$email', '$firstname', '$lastname', '$password')");
print "You have successfully registerd. Please return to login page";
 
    return true;
}
}


function store_data($date, $zipcode)
{

ini_set("allow_url_fopen",1);

 ($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
   
    mysqli_select_db($db, 'example' );
$url = "http://data.tmsapi.com/v1.1/movies/showings?startDate=$date&zip=$zipcode&api_key=54jmnjmpmgek7ydjy7984zxq";
$json = file_get_contents($url);
$m = json_decode($json, true);
$title = array();
$releaseDate= array();
$genre = array();
$photoURL = array();
$purchLink = array();
 
$s = "select * from movie where zipcode = '$zipcode' AND date_stored = '$date'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$num = mysqli_num_rows($t);
    if ($num == 0)
	{
     	 for($x = 0; $x < 5; $x++)
          {
 		$title[$x] = $m[$x]["title"];
         	$releaseDate[$x] = $m[$x]["releaseDate"];
         	$genre[$x] = $m[$x]["genres"][0];
         	$photoURL[$x] = "http://developer.tmsimg.com/"  . $m[$x]["preferredImage"]["uri"] . "?api_key=54jmnjmpmgek7ydjy7984zxq";
         	if(isset($m[$x]["showtimes"][0]["ticketURI"]))
	$purchLink[$x] =   $m[$x]["showtimes"][0]["ticketURI"];
	else $purchLink[$x] = "";
       	   }
	for($z = 0; $z <5 ; $z++)
	{
        	$t = $title[$z];
       		$p = $photoURL[$z];
        	$r = $releaseDate[$z];
        	$g = $genre[$z];
        	$pu = $purchLink[$z];
        	mysqli_query($db, "Insert into movie (title, photo, releaseDate, genre, link, date_stored, zipcode, url)  values('$t','$p' ,'$r', '$g', '$pu','$date','$zipcode','$url')");
        }
    }
}

function retrieveData($date, $zipcode){
($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    
    mysqli_select_db($db, 'example' );
$titles = array();
$releaseDates = array();
$genres = array();
$pics = array();
$purchLinks = array();
$s = "select * from movie where zipcode = '$zipcode' AND date_stored = '$date'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
          array_push($titles, $r["title"]);
          array_push($releaseDates, $r["releaseDate"]);
          array_push($genres, $r["genre"]);
          array_push($pics, $r["photo"]);
          array_push($purchLinks, $r["link"]);
        }
$result = array($titles, $pics, $releaseDates, $genres, $purchLinks);
return $result;
}

function requestProcessor($request)
  {
      echo "received request".PHP_EOL;
      var_dump($request);
      if(!isset($request['type']))
      {
        return "ERROR: unsupported message type";
      }
      switch ($request['type'])
      {
        case "login":
          return auth($request['user'],$request['password']);
        case "validate_session":
          return doValidate($request['sessionId']);
	case "register":
          return registration($request['email'],$request['firstname'],$request['lastname'],$request['password']);
	case "apicall":
	 return store_data($request['today'],$request['zipcode']);
	case "getData": 
	  return retrieveData($request['today'],$request['zipcode']);
      }
      return array("returnCode" => '0', 'message'=>"Server received request and processed");
    }
    $server = new rabbitMQServer("testRabbitMQ.ini","testServer");
    $server->process_requests('requestProcessor');
    exit();
?>



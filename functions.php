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



function movieRetrieve($title,$photo, $releaseDate, $genre, $purchLink) {
    ( $db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    echo "Successfully connected to MySQL<br><br>";
    mysqli_select_db($db, 'example' );
    $s = "Insert into movie (title, photo, releaseDate, genre, link)  values('$title','$photo' ,'$releaseDate', '$genre', '$purchLink')";
    
    ( mysqli_query ($db,$s)) or die(mysqli_error($db));
    
}

function purgeTable()
{
 	$db = mysqli_connect ('localhost','root','root','example');
	mysqli_select_db($db, 'example');
//	$s = "drop table movie";
//	(mysqli_query($db,$s)) or die mysqli_error($db));
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
      }
      return array("returnCode" => '0', 'message'=>"Server received request and processed");
    }
    //$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
    //$server->process_requests('requestProcessor');
    //exit();
?>



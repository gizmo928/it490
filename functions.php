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
    ($t = mysqli_query ($db,$s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);
    if ($num == 0){
      return false;
    }else
    {

      return true;
    }
}


function registration($email,$firstname,$lastname,$password, $user, $zipcode) {
    ( $db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    echo "Successfully connected to MySQL";
    mysqli_select_db($db, 'example' );
    $e = "SELECT * FROM customer WHERE email = '$email'"; // should be and user=
    $t = mysqli_query($db, $e) or die(mysqli_error($db));
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $p = $r["email"];
    
    if($email == $p){
        echo "  Email or User has already been used.  Please try registering again.";
	return false; 
    }
  
	else{
          mysqli_query($db,"INSERT INTO customer (email, firstname, lastname, password, user, zipcode) VALUES ('$email', '$firstname', '$lastname', '$password','$user', '$zipcode')");
print "Thankss";
 
    return true;
}
}


function store_data($date, $user)// this will be user not zipcode, get zip from mysql
{
ini_set("allow_url_fopen",1);

 ($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
   
    mysqli_select_db($db, 'example' );
//$date = "2018-04-26";
$s = "Select * from customer where user = '$user'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
$zipcode = $r['zipcode'];
$zipcode ="$zipcode";
//$_SESSION["zipcode"] = $zipcode;
$url = "http://data.tmsapi.com/v1.1/movies/showings?startDate=$date&zip=$zipcode&api_key=54jmnjmpmgek7ydjy7984zxq";
$json = file_get_contents($url);
$m = json_decode($json, true); // was $m
$title = array();
$releaseDate= array();
//$genre = array();
$photoURL = array();
$purchLink = array();
$desc= array();
$rating = array();
$runTime = array();
$hours = array();
$mins = array(); 
$s = "select * from movie where zipcode = '$zipcode' AND date_stored = '$date'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$num = mysqli_num_rows($t);
    if ($num == 0)
	{
	     	
	 for($x = 0; $x < count($m); $x++)
          {
 		$title[$x] = $m[$x]["title"];
		$title[$x] = mysqli_real_escape_string($db, $title[$x]);
		if(isset($m[$x]["releaseDate"]))
		{	
         	$releaseDate[$x] = $m[$x]["releaseDate"];
		$releaseDate[$x] = "'$releaseDate[$x]'";
		}
		else
		{$releaseDate[$x] = "NULL";}

		if(isset($m[$x]["genres"]))
		{
		   $someArray = $m[$x]["genres"];
                   foreach($someArray as $value)
                    {
		      mysqli_query($db, "Insert into movie_genre (title, genre) values ('$title[$x]', '$value')"); 
                    }
		}
		else
		{$value= "NULL"; // no purpose for genre output to html for now, just to get rid of errors
		 mysqli_query($db, "Insert into movie_genre (title, genre) values ('$title[$x]', $value)");	}

		$desc[$x]= $m[$x]["longDescription"];
		$desc[$x] = mysqli_real_escape_string($db,$desc[$x]);
		if(isset($m[$x]["ratings"][0]["code"])){
		$rating[$x] = $m[$x]["ratings"][0]["code"];
				$rating[$x] = "'$rating[$x]'";} // if rating is set then set it to rating, else set rating to null
		else { $rating[$x] = "NULL"; }
		$runTime[$x] = $m[$x]["runTime"];
		$hours[$x] = substr($runTime[$x], 2, 3);
		$mins[$x] = substr($runTime[$x], 5, 6);

  //       	$genre[$x] = $m[$x]["genres"][0];
         	$photoURL[$x] = "http://developer.tmsimg.com/"  . $m[$x]["preferredImage"]["uri"] . "?api_key=54jmnjmpmgek7ydjy7984zxq";

		 $STarray = $m[$x]["showtimes"];

		foreach($STarray as $key=>$val)
		{
		$id = $val["theatre"]["id"];
		$name = $val["theatre"]["name"];
		$name = mysqli_real_escape_string($db, $name);
		$time = $val["dateTime"];
		$time = substr($time,11, 5);
	if(isset($val["ticketURI"])){
		$link = $val["ticketURI"];
		$link= "'$link'";
		}
	else {$link = "NULL"; }
		mysqli_query($db, "Insert into theatres (theatre_id, theatre_name, zipcode) values ('$id', '$name', '$zipcode')");
		mysqli_query($db, "Insert into showtimes (theatre_id, theatre_name, title, date, time, link) values ('$id', '$name', '$title[$x]','$date','$time', $link)");

		}


         	if(isset($m[$x]["showtimes"][0]["ticketURI"]))
	$purchLink[$x] =   $m[$x]["showtimes"][0]["ticketURI"];
	else $purchLink[$x] = "";




// mysqli_query($db, "Insert into movie_info (title, photo, release_date, mpaa, hours, mins, description) values ('$title[$x]', '$photoURL[$x]', '$releaseDate[$x]','$rating[$x]', '$hours[$x]', '$mins[$x]',   '$desc[$x]')");
       	   }

	for($z = 0; $z < count($m) ; $z++)
	{
        	$t = $title[$z];
       		$p = $photoURL[$z];
        	$r = $releaseDate[$z];
		//$pu = $purchLink[$z];
        	mysqli_query($db, "Insert into movie (title, photo, date_stored, zipcode)  values('$t','$p','$date','$zipcode')") or die(mysqli_error($db));
	// maybe we can use the movie tables to check which queries went through i.e zipcode and date	

		mysqli_query($db, "Insert into movie_info (title, photo, release_date, mpaa, hours, mins, description) values ('$title[$z]', '$photoURL[$z]', $releaseDate[$z],$rating[$z], '$hours[$z]', '$mins[$z]', '$desc[$z]') ON DUPLICATE KEY UPDATE title=title") or die (mysqli_error($db));

        }
    }
}

function retrieveData($date, $user){
($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    
    mysqli_select_db($db, 'example' );

$s = "Select * from customer where user = '$user'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
$zipcode = $r['zipcode'];
$fname= $r['firstname'];
$a0 =array();
$s=" select distinct movie_info.title, movie_info.photo from movie_info join showtimes on movie_info.title = showtimes.title join theatres on showtimes.theatre_name = theatres.theatre_name where showtimes.date = '$date' and theatres.zipcode = '$zipcode'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
	 array_push($a0, array("title" => $r["title"], "photo" => $r["photo"]));
        }

//return $a0;
return array("info" => $a0, "firstname" => $fname, "zipcode" => $zipcode);
}

function stData($date, $zipcode, $movie)
{















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
          return registration($request['email'],$request['firstname'],$request['lastname'],$request['password'], $request['user'], $request['zipcode']);
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



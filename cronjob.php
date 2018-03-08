<?php
include ("newfunctions.php");

$zipArray = array();
$today = date("Y-m-d");
$today = "$today";

$db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) ;
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
   
    mysqli_select_db($db, 'example' );
   $s = "select distinct zipcode from movie";
   ($t = mysqli_query ($db,$s)) or die(mysqli_error($db));
$num = mysqli_num_rows($t);
while($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
{ $q = 0; array_push($zipArray, $r["zipcode"]); $q++;}

for($i = 0; $i < count($zipArray); $i++)
{
	$url = "http://data.tmsapi.com/v1.1/movies/showings?startDate=$today&zip=" . $zipArray[$i] . "&api_key=54jmnjmpmgek7ydjy7984zxq";
	$json = file_get_contents($url);
	$m = json_decode($json, true);
	$title = array();
	$releaseDate= array();
	$genre = array();
	$photoURL = array();
	$purchLink = array();
	for($x = 0; $x < 5; $x++)
        {
         $title[$x] = $m[$x]["title"];
         $releaseDate[$x] = $m[$x]["releaseDate"];
         $genre[$x] = $m[$x]["genres"][0];
         $photoURL[$x] = "http://developer.tmsimg.com/"  . $m[$x]["preferredImage"]["uri"] . "?api_key=54jmnjmpmgek7ydjy7984zxq";
         $purchLink[$x] =   $m[$x]["showtimes"][0]["ticketURI"];
		echo $genre[$x];
        }
	
	for($p = 0; $p < 5; $p++)
	{
        movieRetrieve($title[$p],$photoURL[$p],$releaseDate[$p],$genre[$p],$purchLink[$p],$today,$zipArray[$i]);
	}



}

?>


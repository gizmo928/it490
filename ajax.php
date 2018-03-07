<?php
include ("functions.php"); //for movieRetrieve function
ini_set("allow_url_fopen",1);
$ucopy = $_GET["u"];
$ucopy = "$ucopy";
$today = date("Y-m-d"); 
$today = "$today";
sleep(2);
$url = "http://data.tmsapi.com/v1.1/movies/showings?startDate=$today&zip=07011&api_key=54jmnjmpmgek7ydjy7984zxq"; 
//http://api.openweathermap.org/data/2.5/weather?zip=$ucopy,us&APPID=29d9e6c71d0cc7ebbe82ad3823d9ed9b
// http://data.tmsapi.com/v1.1/movies/showings?startDate=2018-02-24&zip=$ucopy&api_key=54jmnjmpmgek7ydjy7984zxq
$json = file_get_contents($url);
$m = json_decode($json, true);
//echo  $m[0]["genres"][0];
$title = array();
$releaseDate= array();
$genre = array();
$photoURL = array();
$purchLink = array();
for($x = 0; $x < 5; $x++)
	{
	 $title[$x] = $m[$x]["title"];
//	 echo $title[$x];
	 $releaseDate[$x] = $m[$x]["releaseDate"];
	 $genre[$x] = $m[$x]["genres"][0];
	 $photoURL[$x] = "http://developer.tmsimg.com/"  . $m[$x]["preferredImage"]["uri"] . "?api_key=54jmnjmpmgek7ydjy7984zxq";
	 $purchLink[$x] =   $m[$x]["showtimes"][0]["ticketURI"];

	}
for($i = 0; $i < 5; $i++)
{
//	movieRetrieve($title[$i],$photoURL[$i],$releaseDate[$i],$genre[$i],$purchLink[$i]);
}


//$fp = fopen ( $url , "r" ); 
//$contents = "";
//while ( $more = fread ( $fp, 1000  ) ) {
 //  $contents .=  $more ;
//}
  
//echo $contents ; 
?>

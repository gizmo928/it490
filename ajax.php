<?php

session_start();
include ("newfunctions.php"); //for movieRetrieve function
ini_set("allow_url_fopen",1);
$zipcode = $_GET["uu"];
$zipcode = "$zipcode";
$day = $_GET["u"];
$day = "$day";
$_SESSION['zip'] = $zipcode;
$today = date("Y-m-d"); 
$today = "$today";
//sleep(2);

if(zip_check($zipcode) == false || day_check($day) == false)
{
$url = "http://data.tmsapi.com/v1.1/movies/showings?startDate=$day&zip=$zipcode&api_key=54jmnjmpmgek7ydjy7984zxq";

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
//	if(isset($m[$x]["title"]))
	 $title[$x] = $m[$x]["title"];
	//else {$title[$x] = "hrllo";}

//	if(isset($m[$x]["releaseDate"]))
	$releaseDate[$x] = $m[$x]["releaseDate"];
//	else  {$releaseDate[$x] = "help me";}
	
//	if(isset($m[$x]["genres"]))	
	 $genre[$x] = $m[$x]["genres"][0];
//	else {$genre[$x] = "no genre";}

//	if(isset($m[$x]["preferredImage"]["uri"]))
	 $photoURL[$x] = "http://developer.tmsimg.com/"  . $m[$x]["preferredImage"]["uri"] . "?api_key=54jmnjmpmgek7ydjy7984zxq";
		
//	if(isset($m[$x]["showtimes"][0]["ticketURI"]))
	 $purchLink[$x] =   $m[$x]["showtimes"][0]["ticketURI"];
//	else {$purchLink[$x] = "no purch link lul";}
	}
for($i = 0; $i < 5; $i++)
{
	movieRetrieve($title[$i],$photoURL[$i],$releaseDate[$i],$genre[$i],$purchLink[$i],$day,$zipcode,$url);
}

}



 	$titles = array();
        $releaseDates = array();
        $genres = array();
        $pics = array();
        $purchLinks = array();
        $db = mysqli_connect('localhost','root','root','example');
        mysqli_select_db($db, 'example');
        $s = "select * from movie where zipcode ='$zipcode' ";
        $t = mysqli_query($db,$s) or die (mysqli_error($db));
        while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
          array_push($titles, $r["title"]);
          array_push($releaseDates, $r["releaseDate"]);
          array_push($genres, $r["genre"]);
          array_push($pics, $r["photo"]);
          array_push($purchLinks, $r["link"]);
        }

	$prod = array($titles,$pics, $releaseDates, $genres, $purchLinks);
echo json_encode($prod);

?>                                                                 




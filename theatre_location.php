<?php
session_start();
if(!isset($_SESSION["user"]))
{
        header("Refresh:1; url=main.html", true, 303);
}
$movie =  $_GET['title'];
$date = $_SESSION["date"];
$user = $_SESSION["user"];
$zipcode = $_SESSION["zipcode"];
($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    mysqli_select_db($db, 'example' );
//$s ="select * from customer where user = '$user'";
//$t = mysqli_query($db,$s) or die (mysqli_error($db));
//$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
//$zipcode = $r["zipcode"];

$a1 = array();
$movie = mysqli_real_escape_string($db,$movie);

$s = "select showtimes.theatre_name, showtimes.time, showtimes.link from theatres JOIN showtimes on theatres.theatre_name = showtimes.theatre_name where showtimes.title= '$movie' and showtimes.date = '$date' and theatres.zipcode = '$zipcode'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
         
          array_push($a1, $r);

        }

$b1 = array();
$c1 = array();
$e1 = array();//added for purchase links
$d1 = array();
$f1 = array();
for ($i =0; $i < (count($a1)); $i++)
{

//array_push($c1, $a1[$i]['time']);

if (!in_array($a1[$i]['theatre_name'], $b1) || $i == (count($a1) - 1))
	{
		if ( $i == (count($a1) - 1))
		{
	//	array_push($b1, $a1[$i]['theatre_name'], $c1);
		array_push($c1, $a1[$i]['time']);
		array_push($e1, $a1[$i]['link']);
		array_push($d1, array("theatre" => $a1[$i]['theatre_name'], "showtimes" => $c1, "link" => $e1));
		$c1 = array();
		$e1 = array();
		}

		else if(!empty($b1))
		{
		array_push($d1, array("theatre" => $a1[$i-1]['theatre_name'], "showtimes" => $c1, "link" => $e1));
                $c1 = array();
		$e1 = array();
		}

		 array_push($b1, $a1[$i]['theatre_name']);// had , c1

	}

array_push($c1, $a1[$i]['time']);
array_push($e1, $a1[$i]['link']);


}

$s = "select * from movie_info where title = '$movie'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
   
array_push($f1, $r);
//echo json_encode($f1);

echo json_encode(array("a" => $d1, "b" => $f1));


?>


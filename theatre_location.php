<?php

($db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }

    mysqli_select_db($db, 'example' );
$a1 = array();

$s = "select showtimes.theatre_name, showtimes.title, showtimes.time from theatres JOIN showtimes on theatres.theatre_name = showtimes.theatre_name where showtimes.title= 'Rampage' and showtimes.date = '2018-04-16' and theatres.zipcode = '07011'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
         
          array_push($a1, $r);

        }

$b1 = array();
$c1 = array();
$d1 = array();
for ($i =0; $i < (count($a1)); $i++)
{

//array_push($c1, $a1[$i]['time']);

if (!in_array($a1[$i]['theatre_name'], $b1) || $i == (count($a1) - 1))
	{
		if ( $i == (count($a1) - 1))
		{
	//	array_push($b1, $a1[$i]['theatre_name'], $c1);
		array_push($c1, $a1[$i]['time']);
		array_push($d1, array("theatre" => $a1[$i]['theatre_name'], "showtimes" => $c1));
		$c1 = array();
		}

		else if(!empty($b1))
		{
		array_push($d1, array("theatre" => $a1[$i-1]['theatre_name'], "showtimes" => $c1));
                $c1 = array();
		}

		 array_push($b1, $a1[$i]['theatre_name']);// had , c1

	}

array_push($c1, $a1[$i]['time']);

}

echo json_encode($d1);


?>


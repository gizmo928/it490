<?php

$db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) ;
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }

    mysqli_select_db($db, 'example' );

$s = "Select * from customer where user = 'myoldfriend'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
$zipcode = $r['zipcode'];
$a0 =array();
$s=" select distinct movie_info.title, movie_info.photo from movie_info join showtimes on movie_info.title = showtimes.title join theatres on showtimes.theatre_name = theatres.theatre_name where showtimes.date = '2018-04-24' and theatres.zipcode = '$zipcode'";
$t = mysqli_query($db,$s) or die (mysqli_error($db));
while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
         array_push($a0, array("title" => $r["title"], "photo" => $r["photo"]));
        }
$result = array($a0);
//return $result;
echo json_encode($result);
?>

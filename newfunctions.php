<?php

function movieRetrieve($title,$photo, $releaseDate, $genre, $purchLink, $date, $zip) {
    ( $db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }
    echo "Successfully connected to MySQL<br><br>";
    mysqli_select_db($db, 'example' );
    $s = "Insert into movie (title, photo, releaseDate, genre, link, date_stored, zipcode)  values('$title','$photo' ,'$releaseDate', '$genre', '$purchLink', '$date', '$zip')";

    ( mysqli_query ($db,$s)) or die(mysqli_error($db));

}










function zip_check($zipcode)
{
        ( $db = mysqli_connect ( 'localhost', 'root', 'root', 'example' ) );
    if (mysqli_connect_errno())
    {
      echo"Failed to connect to MYSQL<br><br> ". mysqli_connect_error();
      exit();
    }

    mysqli_select_db($db, 'example' );
    $s = "select * from movie where zipcode = '$zipcode'";
    ($t = mysqli_query ($db,$s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);
    if ($num == 0){
      return false;
    }else
    {
      return true;
    }
}

?>



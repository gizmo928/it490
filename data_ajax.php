<?php

$ucopy = $_GET["u"];
$ucopy = "$ucopy";

sleep(2);
$url = "http://data.tmsapi.com/v1.1/movies/showings?startDate=2018-02-25&zip=$ucopy&api_key=54jmnjmpmgek7ydjy7984zxq"; 

//http://api.openweathermap.org/data/2.5/weather?zip=$ucopy,us&APPID=29d9e6c71d0cc7ebbe82ad3823d9ed9b
// http://data.tmsapi.com/v1.1/movies/showings?startDate=2018-02-24&zip=$ucopy&api_key=54jmnjmpmgek7ydjy7984zxq



$fp = fopen ( $url , "r" ); 
$contents = "";

while ( $more = fread ( $fp, 1000  ) ) {
   $contents .=  $more ;
}
  
echo $contents ; 

?>

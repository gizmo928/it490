<?php
error_reporting(-1);
ini_set('display_errors', false);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function connection($user,$pass){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    if (isset($argv[1]))
    {
      $msg = $argv[1];
    }
    else
    {
      $msg = "test message";
    }



    $request = array();
    $request['type'] = "login";
    $request['user'] = $user;
    $request['password'] = $pass;
    $request['message'] = $msg;
    $response = $client->send_request($request);
    //$response = $client->publish($request);

    //echo "client received response: ".PHP_EOL;
   // print_r($response);
    return $response;
    echo "\n\n";

    echo $argv[0]." END".PHP_EOL;
}


function registration($email,$firstname,$lastname,$password){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    if (isset($argv[1]))
    {
      $msg = $argv[1];
    }
    else
    {
      $msg = "test message";
    }
    $request = array();
    $request['type'] = "register";
    $request['email'] = $email;
    $request['firstname'] = $firstname;
    $request['lastname'] = $lastname;
    $request['password'] = $password;
    $request['message'] = $msg;
    $response = $client->send_request($request);
    //$response = $client->publish($request);
    //echo "client received response: ".PHP_EOL;
    //print_r($response);
    return $response;
    echo "\n\n";
    echo $argv[0]." END".PHP_EOL;
}

function apicall($date,$zipcode){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    if (isset($argv[1]))
    {
      $msg = $argv[1];
    }
    $request = array();
    $request['type'] = "apicall";
    $request['today'] = $date;
    $request['zipcode'] = $zipcode;
    $response = $client->send_request($request);
    return $response;
    echo "\n\n";
    echo $argv[0]." END".PHP_EOL;
}


function getData($date,$zipcode){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    if (isset($argv[1]))
    {
      $msg = $argv[1];
    }
    $request = array();
    $request['type'] = "getData";
    $request['today'] = $date;
    $request['zipcode'] = $zipcode;
    $response1 = $client->send_request($request);
    return $response1;
    echo "\n\n";
    echo $argv[0]." END".PHP_EOL;
}
?>

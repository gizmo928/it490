<?php


if ($pass != $passr)
{
print "passwords dont match, please re-enter! <br>";
exit(0);
}

$mydb = new mysqli('localhost','root','root','example');

$user =  mysqli_real_escape_string($mydb, $_GET['user']);
$fname = mysqli_real_escape_string($mydb, $_GET['fname']);
$lname = mysqli_real_escape_string($mydb, $_GET['lname']);
$pass =  mysqli_real_escape_string($mydb, $_GET['passw']);
$passr = mysqli_real_escape_string($mydb, $_GET['passw-repeat']);
$email = mysqli_real_escape_string($mydb, $_GET['email']);


if ($mydb->errno != 0)
{
print "failed to connect to database!" . $mydb->error . PHP_EOL;
exit(0);
}
print "successfully connected to database" . PHP_EOL;


$query = "select * from customer where email = '$email'";
$response = $mydb->query($query);
//$t = mysqli_query($mydb, $query);

if($mydb->errno !=0)
{
echo "failed to execute query:".PHP_EOL;
echo "error: ". $mydb->error.PHP_EOL;
echo __FILE__ . ':' . __LINE__ . ":error:";
        exit(0);
        }
if(mysqli_num_rows($response) == 0)
{
   $s = "insert into customer values ('$user','$pass', '$fname', '$lname', '$email')";
    mysqli_query($mydb, $s) or die (mysqli_error($mydb));
}
else
print "There is already an account with that email. Please log in. <br>" ;
?>



<?php



$mydb = new mysqli('localhost','root','root','example');

$user = mysqli_real_escape_string ($mydb, $_GET['uname']);
$pass = mysqli_real_escape_string ($mydb, $_GET['passw']);

print "$user $pass";


if ($mydb->errno != 0)
{
print "failed to connect to database!" . $mydb->error . PHP_EOL;
exit(0);
}


$query = "select * from customer where user = '$user' and password = '$pass'";
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
	print "USER $user does not exist. Please Register.". PHP_EOL;
}
else
print "user authenticated! " .PHP_EOL;
?>




<?php
	session_destroy();
	setcookie(session_name(),'',time() - 7000 , '/');
	function redirect($message,$url)
	{
		 echo $message;
		 header( "refresh:2; url=$url");
	}
	redirect("Logging Out!","main.html");
?>


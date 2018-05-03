<?php

function redirect($message, $url, $delay)
{
	echo "$message";
	header("Refresh: $delay; url = $url");
	exit(0);



}
?>

<?php
	$host="127.0.0.1"; //replace with database hostname 
	$username="root"; //replace with database username 
	$password=""; //replace with database password 
	$db_name="laravel"; //replace with database name
	
	$sleep = 1;
	
	$con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect");
?>
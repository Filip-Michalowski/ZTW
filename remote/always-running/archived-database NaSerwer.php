<?php
	$host="mysql.hostinger.pl"; //replace with database hostname 
	$username="u835926318_ztw"; //replace with database username 
	$password="bober_k4wka"; //replace with database password 
	$db_name="u835926318_ztw"; //replace with database name 
	
	$sleep = 5;
	
	$con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
?>
<?php
	/*
	Nie poci¹gnie - php w wersji 5.2.17
	*/
	
	$host="mysql1.ph-hos.osemka.pl"; //replace with database hostname 
	$username="1433415663_f"; //replace with database username 
	$password="bober_k4wka"; //replace with database password 
	$db_name="1287983_ztwpiraci"; //replace with database name
	
	$sleep = 1;
	
	$con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect");
?>
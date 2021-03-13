<?php 
	//Create Database Connection
	$db = new mysqli('Localhost', 'myspring_phil', '@Phil12345!', 'myspring_mydb');

	//Check Connection
	if($db->connect_error){
		die("Database Error: ".$db->connect_error);
	}
?>
<?php 
	$server = 'localhost';
	$user = 'root';
	$pass = '';
	$database = 'bdTapCPIIA'; //Nombre de la base de datos

	$conn = mysqli_connect($server, $user, $pass, $database);

	// Check connection
	if (mysqli_connect_errno()){
		echo "Fallo al conectarse a MySQL: " . mysqli_connect_error();
	}
?>
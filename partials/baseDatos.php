<?php 
	$servidor = 'localhost';
	$usuario = 'root';
	$pass = '';
	$baseDatos = 'bd-tap-cpiia'; //Nombre de la base de datos

	$conn = mysqli_connect($servidor, $usuario, $pass, $baseDatos);

	// Check connection
	if (mysqli_connect_errno()){
		echo "Fallo al conectarse a MySQL: " . mysqli_connect_error();
	}
?>
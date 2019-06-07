<?php 
	if(!isset($_SESSION)) { session_start(); } 
	$_SESSION['SesionLoggedIn'] = False;
	$_SESSION['SesionNumColegiado'] = null;
	$_SESSION['SesionRol'] = null;
	$_SESSION['SesionNombre'] = null;
	session_unset();
	session_destroy();
	header('Location: /cpiia-tap');
?>
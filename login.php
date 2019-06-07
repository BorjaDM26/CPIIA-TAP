<?php 
	require 'partials/referencias.php';
	
	if(!isset($_SESSION)) { session_start(); } 

	if(isset($_SESSION['SesionNumColegiado'])){
		header('Location: /'.$inicio);
		exit();
	}

	if(!empty($_POST['NumColeg']) && !empty($_POST['pass'])){
		$NumColeg=$_REQUEST["NumColeg"];
	    $stmt = $conn->query("SELECT * FROM colegiado WHERE NumColegiado='".$NumColeg."'");
	    $results = $stmt->fetch_assoc();

	    if(count($results) > 0 && password_verify($_POST['pass'], $results['Pass'])){
			$_SESSION["SesionNumColegiado"] = $results['NumColegiado'];
			$_SESSION["SesionRol"] = $results['Rol'];
			$_SESSION["SesionNombre"] = $results['Nombre'].' '.$results['Apellidos'];
	        echo'<script type="text/javascript"> alert("Acceso correcto."); window.location.href="index.php"; </script>';
		} else {
	        echo'<script type="text/javascript"> alert("Error, la cuenta introducida no existe"); window.location.href="login.php"; </script>';
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<h1>Login</h1>
		<div class="contenidoCentro">
			<form class="sesion" action="login.php" method="post">
				<input type="text" id="NumColeg" name="NumColeg" placeholder="Introduce tu número de colegiado">
				<input type="password" id="pass" name="pass" placeholder="Introduce tu contraseña">
				<input class="btn btn-primary" type="submit" name="Enviar" value="Entrar">
			</form>
		</div>
	</body>
</html>
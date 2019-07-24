<?php 
	require_once 'partials/referencias.php';
	
	if(!isset($_SESSION)) { session_start(); } 

	if(isset($_SESSION['SesionNumColegiado'])){
		header('Location: /'.$index);
		exit();
	}

	if(!empty($_POST['NumColeg']) && !empty($_POST['pass'])){
		$numColeg = $_REQUEST["NumColeg"];
		$cryptedPass = hash('sha256', $_REQUEST["pass"]);
	    $stmt = $conn->query("SELECT Rol, Nombre, Apellidos, Pass FROM colegiado WHERE NumColegiado='".$numColeg."'");

	    if($stmt->num_rows == 1){
	    	$row = $stmt->fetch_assoc();
	    	$bdPass = $row['Pass'];

	    	if ($cryptedPass == $bdPass) {
	    		$_SESSION["SesionNumColegiado"] = $numColeg;
				$_SESSION["SesionRol"] = $row['Rol'];
				$_SESSION["SesionNombre"] = $row['Nombre'].' '.$row['Apellidos'];
		        echo'<script type="text/javascript"> alert("Acceso correcto."); window.location.href="index.php"; </script>';
	    	} else {
	    		echo'<script type="text/javascript"> alert("Error, la cuenta introducida no existe"); window.location.href="login.php"; </script>';
	    	}
		} else {
			echo'<script type="text/javascript"> alert("Error, la cuenta introducida no existe"); window.location.href="login.php"; </script>';
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Login</h1>
            </div>
			
			<form class="sesion" action="login.php" method="post">
				<input type="text" id="NumColeg" name="NumColeg" placeholder="Introduce tu número de colegiado" required="true">
				<input type="password" id="pass" name="pass" placeholder="Introduce tu contraseña" required="true">
				<input class="btn btn-primary" type="submit" name="Enviar" value="Entrar">
			</form>

    		<div class="push"></div>
    	</div>

		<?php require 'partials/footer.php' ?>	</body>
</html>
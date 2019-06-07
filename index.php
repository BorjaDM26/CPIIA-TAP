<?php if(!isset($_SESSION)) { session_start(); } ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Turno de Actuación Profesional del CPIIA</title>
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?> <br/>
		<div class="contenidoCentro text-center">


			<?php if(isset($_SESSION["SesionNombre"])): ?>
				<br>Welcome. <?= $_SESSION["SesionNombre"] ?>
				<br> You are successfully logged in. <br> 
				<?php
					echo "Pagina actual: ".$pgnActual;
					echo "<br>Pagina cortada: ".substr($pgnActual , 0 , 5);
				?>
			<?php else: ?>
				<h1>Por favor, <a href="login.php">inicia sesión</a></h1>
			<?php endif; ?>


		</div>
	</body>
</html>
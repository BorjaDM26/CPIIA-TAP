<?php if(!isset($_SESSION)) { session_start(); } ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Turno de Actuación Profesional del CPIIA</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido text-center">
			<?php if(isset($_SESSION["SesionNombre"])): ?>
				<br>Welcome. <?= $_SESSION["SesionNombre"] ?>
				<br> You are successfully logged in. <br> 
				<?php
					echo "Pagina actual: ".$curPage;
					echo "<br>Pagina cortada: ".substr($curPage , 0 , 5);
					echo "<br>".date("Y/m/d<br>", time());
				?>
			<?php else: ?>
				<h1>Por favor, <a href="login.php">inicia sesión</a></h1>
			<?php endif; ?>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
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
				<br> Welcome. <?= $_SESSION["SesionNombre"] ?>
				<br> You are successfully logged in. <br> 
				<?php
					echo "Pagina actual: ".$curPage;
					echo "<br>Pagina cortada: ".substr($curPage , 0 , 5);
					echo "<br>".date("d/m/Y<br>", time());
				?>
			<?php else: ?>
				<h2>Por favor, <a href="login.php">inicia sesión</a></h2>
			<?php endif; ?>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
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
			<br><br>
			<?php
				$pass = 'Hans';
				echo "Soy una prueba: '$pass' <br>";
				$passCryp = hash('sha256', $pass);
				echo $pass.'->'.$passCryp.'<br>';

				$pass2 = 'hans';
				$passCryp2 = hash('sha256', $pass2);
				echo $pass2.'->'.$passCryp2.'<br>';

				print_r($estadosInscripcion); 

				echo '<br> Array = [';
				foreach ($estadosInscripcion as $i => $value) {
				    echo $value.'<br>';
				}
				echo '];';
			?>

			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
<?php if(!isset($_SESSION)) { session_start(); } ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Turno de Actuación Profesional del CPIIA</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<h1 class="text-justified">Sistema de Gestión de Turnos de Actuación Profesional del CPIIA</h1>
			<p>La importancia creciente de la informática en prácticamente todos los sectores de la sociedad, su desarrollo científico y la evolución de la tecnología en el último cuarto del siglo XX, ha originado el que la sociedad española, y en concreto la andaluza, cuente en la actualidad con numerosos profesionales en este campo con titulación académica suficiente para el ejercicio profesional, habiéndose puesto de manifiesto por los mismos la necesidad de contar con una organización colegial en Andalucía que, por un lado, sirva de protección a los intereses generales de la sociedad y, por otro, sirva a los propios intereses profesionales mediante la asistencia y protección de sus miembros.</p>
			<p><a href="http://cpiiand.es/wordpress/">Nuestro colegio</a> se constituyó el 30 de Septiembre de 2008 con la celebración de una primera Asamblea General en Málaga y sus estatutos fueron aprobados en Asamblea General el 19 de Diciembre de 2012. En Enero del 2014 se elige el primer decano elegido democráticamente, D. Pedro Espina Martínez, que es sucedido en Febrero del 2018 por el decano Dr. D. David Santo Orcero.</p>
			<p>El sistema de gestión de turnos de actuación profesional (TAP) de este colegio le brinda las siguientes funciones:</p>

			<div class="row">
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title text-center">Turno de Actuación Profesional</h5>
							<p class="card-text">
								<ul>
									<li><a href="TAPSolicitarActuacion.php">Solicitar actuación profesional</a></li>
									<li><a href="TAPListaPublica.php">Consultar listas públicas</a></li>
									<li><a href="TAPTiposLista.php">Consultar tipos de lista</a></li>
								</ul>
							</p>
						</div>
					</div>
				</div>
				<?php if(isset($_SESSION["SesionRol"])): ?>
					<div class="col-sm-4">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title text-center">Colegiados</h5>
								<p class="card-text">
									<p>Consultar:</p>
									<ul>
										<li><a href="ColegMiPerfil.php">Información personal</a></li>
										<li><a href="ColegMisListas.php">Listas inscritas</a></li>
										<li><a href="ColegMisComisiones.php">Comisiones incluidas</a></li>
										<li><a href="ColegMisEspecializaciones.php">Especializaciones registradas</a></li>
										<li><a href="ColegMisProyectos.php">Proyectos asignados</a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
				<?php endif;
				if(isset($_SESSION['SesionRol']) && $_SESSION['SesionRol']=='Responsable'): ?>
					<div class="col-sm-4">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title text-center">Administración</h5>
								<p class="card-text">
									<ul>
										<li><a href="AdminColegiados.php">Colegiados</a></li>
										<li><a href="AdminListas.php">Listas</a></li>
										<li><a href="AdminTiposLista.php">Tipos de lista</a></li>
										<li><a href="AdminEspecializaciones.php">Especializaciones</a></li>
										<li><a href="AdminComisiones.php">Comisiones</a></li>
										<li><a href="AdminProyectos.php">Proyectos</a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
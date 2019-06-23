<?php require_once 'partials/referencias.php'; ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Menu Superior</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/funciones.js"></script>
	</head>

	<body>
		<nav id="menuSuperior" class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand offset-md-1" href="index.php">
				<img src="assets/images/LogoCPIIA.jpg" width="170px"/>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<div class="dropdown">
							<?php 
								if(substr ( $curPage , 0 , 3) == 'TAP'){
									echo "<a class=\"nav-link activada\" href=\"TAPSolicitarActuacion.php\"><i class=\"fas fa-home\"></i> TAP</a>";
								} else{
									echo "<a class=\"nav-link noActivada\" href=\"TAPSolicitarActuacion.php\"><i class=\"fas fa-home\"></i> TAP</a>";
								} 
							?>
							<div class="dropdown-content">
								<a class="dropdown-item" href="TAPSolicitarActuacion.php"> Solicitar Actuación</a>
								<a class="dropdown-item" href="TAPListaPublica.php"> Listas Públicas</a>
								<a class="dropdown-item" href="TAPTiposLista.php"> Tipos de Lista</a>
							</div>
						</div>
					</li>
					<?php if(isset($_SESSION['SesionRol'])): ?>
					<li class="nav-item">
						<div class="dropdown">
							<?php 
								if(substr ( $curPage , 0 , 5) == 'Coleg' && substr ( $curPage , 0 , 13) != 'ColegMiPerfil'){
									echo "<a class=\"nav-link activada\" href=\"ColegMisListas.php\"><i class=\"fas fa-users\"></i> Colegiados</a>";
								} else{
									echo "<a class=\"nav-link noActivada\" href=\"ColegMisListas.php\"><i class=\"fas fa-users\"></i> Colegiados</a>";
								} 
							?>
							<div class="dropdown-content">
								<a class="dropdown-item" href="ColegMisListas.php"> Mis Listas</a>
								<a class="dropdown-item" href="ColegMisEspecializaciones.php"> Mis Especializaciones</a>
								<a class="dropdown-item" href="ColegMisComisiones.php"> Mis Comisiones</a>
								<a class="dropdown-item" href="ColegMisProyectos.php"> Mis Proyectos</a>
							</div>
						</div>
					</li>
					<?php endif;
					if(isset($_SESSION['SesionRol']) && $_SESSION['SesionRol']=='Responsable'): ?>
						<li class="nav-item">
							<div class="dropdown">
								<?php 
								if(substr ( $curPage , 0 , 5) == 'Admin'){
									echo "<a class=\"nav-link activada\" href=\"AdminColegiadoLista.php\"><i class=\"fab fa-whmcs\"></i> Administración</a>";
								} else{
									echo "<a class=\"nav-link noActivada\" href=\"AdminColegiadoLista.php\"><i class=\"fab fa-whmcs\"></i> Administración</a>";
								} 
								?>
								<div class="dropdown-content">
									<a class="dropdown-item" href="AdminColegiadoLista.php"> Colegiados</a>
									<a class="dropdown-item" href="AdminListaLista.php"> Listas</a>
									<a class="dropdown-item" href="#"> Tipos de Lista</a>
									<a class="dropdown-item" href="AdminEspecializacionLista.php"> Especializaciones</a>
									<a class="dropdown-item" href="#"> Comisiones</a>
									<a class="dropdown-item" href="#"> Proyectos</a>
								</div>
							</div>
						</li>
					<?php endif; ?>
				</ul>
				<?php if(isset($_SESSION['SesionRol'])): ?>
					<?php 
						if($_SESSION['SesionRol']=='Responsable'){
							echo "<a class=\"nav-link offset-md-3 sesion noActivada\" href=\"#\"><i class=\"fas fa-bell\"></i></a>";
						} elseif($_SESSION['SesionRol']=='Colegiado'){
							echo "<a class=\"nav-link offset-md-5 sesion noActivada\" href=\"#\"><i class=\"fas fa-bell\"></i></a>";
						}

						if(substr ( $curPage , 0 , 13) == 'ColegMiPerfil'){
							echo '<a class="nav-link sesion activada" href="ColegMiPerfil.php"><i class="fas fa-user"></i>'.$_SESSION['SesionNombre'].'</a>';
						} else{
							echo "<a class=\"nav-link sesion noActivada\" href=\"ColegMiPerfil.php\"><i class=\"fas fa-user\"></i>".$_SESSION['SesionNombre']."</a>";
						}
					?>
					<a class="sesion noActivada" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
				<?php else: ?>
					<a class="noActivada sesion offset-md-8" href="login.php"><i class="fas fa-user">&nbsp; Iniciar sesión</i></a>
				<?php endif; ?>
			</div>
		</nav>
		<br/>
	</body>
</html>
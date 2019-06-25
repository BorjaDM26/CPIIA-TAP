<?php require_once 'partials/referencias.php'; ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Menu Superior</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/funciones.js"></script>
	</head>

	<body>
		<header>
			<nav id="menuSuperior" class="navbar navbar-expand-custom navbar-light">
				<a class="navbar-brand" href="index.php">
					<img src="assets/images/LogoCPIIA.jpg" height="50px"/>
					<!--<img src="assets/images/LogoCPIIA.png" height="45px"/>-->
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
					<span class="navbar-toggler-icon"></span>
				</button>
					<div class="collapse navbar-collapse row" id="navbarNav">
						<div class="left">
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
											echo "<a class=\"nav-link activada\" href=\"AdminColegiados.php\"><i class=\"fab fa-whmcs\"></i> Administración</a>";
										} else{
											echo "<a class=\"nav-link noActivada\" href=\"AdminColegiados.php\"><i class=\"fab fa-whmcs\"></i> Administración</a>";
										} 
										?>
										<div class="dropdown-content">
											<a class="dropdown-item" href="AdminColegiados.php"> Colegiados</a>
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
					</div>

					<div class="right">
						<?php if(isset($_SESSION['SesionRol'])): ?>
							<a class="sesion noActivada" href="procesarLogout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
							<?php 
								if(substr ( $curPage , 0 , 13) == 'ColegMiPerfil'){
									echo '<a class="nav-link sesion activada" href="ColegMiPerfil.php"><i class="fas fa-user"></i> '.$_SESSION['SesionNombre'].'</a>';
								} else{
									echo "<a class=\"nav-link sesion noActivada\" href=\"ColegMiPerfil.php\"><i class=\"fas fa-user\"></i> ".$_SESSION['SesionNombre']."</a>";
								}
							?>
						<?php else: ?>
							<a class="noActivada sesion " href="login.php"><i class="fas fa-user"></i> Iniciar sesión</a>
						<?php endif; ?>
					</div>
				</div>
			</nav>
		</header>
	</body>
</html>
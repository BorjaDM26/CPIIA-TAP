<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$consEspecColeg = "SELECT IdEspecializacion, Nombre
				FROM campoespecializacion
				WHERE IdEspecializacion NOT IN (SELECT IdEspecializacion FROM especializacioncolegiado WHERE NumColegiado=".$_REQUEST['numColegiado'].")
				ORDER BY IdEspecializacion";

	$stmtEspecColeg = $conn->query($consEspecColeg);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Asignar Especialización a Colegiado</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Asignar Especialización a Colegiado</h1>
            </div>

            <?php 
                $stmtColeg = $conn->query("SELECT NumColegiado, Nombre, Apellidos FROM colegiado WHERE NumColegiado='".$_REQUEST["numColegiado"]."'");
                $rowColeg = $stmtColeg->fetch_assoc();
            ?>

			<form id="formCrearSolicitud" method="POST" action="procesarAgregarEspecializacionAColegiado.php">
				<div class="form-row">
					<div class="form-group campoForm">
	                    <label for="numColegiado" class="etiqueta">Nº de colegiado </label>
	                    <input class="form-control customInput" type="text" id="numColegiado" name="numColegiado" readonly="true" <?php echo 'value="'.$rowColeg['NumColegiado'].'"'; ?> />
	                </div>
					<div class="form-group campoForm">
	                    <label for="nombre" class="etiqueta">Nombre </label>
	                    <input class="form-control customInput" type="text" id="nombre" name="nombre" readonly="true" <?php echo 'value="'.$rowColeg['Nombre'].'"'; ?> />
	                </div>
					<div class="form-group campoForm">
	                    <label for="apellidos" class="etiqueta">Apellidos </label>
	                    <input class="form-control customInput" type="text" id="apellidos" name="apellidos" readonly="true" <?php echo 'value="'.$rowColeg['Apellidos'].'"'; ?> />
	                </div>

	                <div class="form-group campoForm">
	                	<label for="espec" class="etiqueta">Campo de especialización * </label>
	                	<select class="form-control customInput" name="espec" id="espec">
	                		<?php 
	                			while ($rowEspecColeg = $stmtEspecColeg->fetch_assoc()){
	                				$especializacion = $rowEspecColeg['IdEspecializacion']." - ".$rowEspecColeg['Nombre'];
	            					echo "<option value=\"".$rowEspecColeg['IdEspecializacion']."\">".$especializacion."</option>";
	                			} 
	                		?>
						</select>
	                </div>
                </div>
                <div class="botonera">
				    <input type="submit" class="btn btn-success" value="Asignar Especialización" />
				    <button type="button" class="volver" onclick="location.href='AdminColegiadoModificar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>'">Cancelar</button>
				</div>
			</form>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
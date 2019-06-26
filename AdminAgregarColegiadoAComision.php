<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$consComis = "SELECT TL.Nombre TipoLista, CT.IdComision
				FROM inscripcion I, lista L, tipolista TL, colegiado C, comisiontap CT
				WHERE I.NumColegiado=C.NumColegiado AND I.IdLista=L.IdLista AND L.IdTipoLista=TL.IdTipoLista AND TL.IdComision=CT.IdComision AND C.NumColegiado=".$_REQUEST['numColegiado']." AND CT.IdComision NOT IN (SELECT IdComision FROM miembrocomision WHERE NumColegiado=".$_REQUEST['numColegiado'].")
				GROUP BY TL.Nombre ORDER BY CT.IdComision";

	$stmtComis = $conn->query($consComis);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Incluir Colegiado en una Comisión de TAP</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Incluir Colegiado en una Comisión de TAP</h1>
            </div>

            <?php 
                $stmtColeg = $conn->query("SELECT NumColegiado, Nombre, Apellidos FROM colegiado WHERE NumColegiado='".$_REQUEST["numColegiado"]."'");
                $rowColeg = $stmtColeg->fetch_assoc();
            ?>

			<form id="formCrearSolicitud" method="POST" action="procesarAgregarColegiadoAComision.php">
				<div class="form-row">
					<div class="form-group campoForm">
	                    <label for="numColegiado" class="etiqueta">Número de Colegiado </label>
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
	                	<label for="comision" class="etiqueta">Comisión * </label>
	                	<select class="form-control customInput" name="comision" id="comision">
	                		<?php 
	                			while ($rowComis = $stmtComis->fetch_assoc()){
	                				$comision = $rowComis['IdComision']." - ".$rowComis['TipoLista'];
	            					echo "<option value=\"".$rowComis['IdComision']."\">".$comision."</option>";
	                			} 
	                		?>
						</select>
	                </div>
                </div>
                <div class="botonera">
				    <input type="submit" class="btn btn-success" value="Incluir" />
				    <button type="button" class="volver" onclick="location.href='AdminColegiadoModificar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>'">Cancelar</button>
				</div>
			</form>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
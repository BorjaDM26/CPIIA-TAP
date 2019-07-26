<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$consEspecTipoLst = "SELECT IdEspecializacion, Nombre FROM campoespecializacion WHERE IdEspecializacion NOT IN (SELECT IdEspecializacion FROM especializacionlista WHERE IdTipoLista=".$_REQUEST['idTipoLista'].") ORDER BY IdEspecializacion";

	$stmtEspecTipoLst = $conn->query($consEspecTipoLst);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Requerir Especialización a Tipo de Lista</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Requerir Especialización a Tipo de Lista</h1>
            </div>

            <?php 
                $stmtTipoLst = $conn->query("SELECT IdTipoLista, Nombre FROM tipolista WHERE IdTipoLista='".$_REQUEST["idTipoLista"]."'");
                $rowTipoLst = $stmtTipoLst->fetch_assoc();
            ?>

			<form id="formCrearSolicitud" method="POST" action="procesarRequerirEspecializacionATipoLista.php">
				<div class="form-row">
					<div class="form-group campoForm">
	                    <label for="idTipoLista" class="etiqueta">Id. de tipo de lista </label>
	                    <input class="form-control customInput" type="text" id="idTipoLista" name="idTipoLista" readonly="true" <?php echo 'value="'.$rowTipoLst['IdTipoLista'].'"'; ?> />
	                </div>
					<div class="form-group campoForm">
	                    <label for="nombre" class="etiqueta">Nombre </label>
	                    <input class="form-control customInput" type="text" id="nombre" name="nombre" readonly="true" <?php echo 'value="'.$rowTipoLst['Nombre'].'"'; ?> />
	                </div>

	                <div class="form-group campoForm">
	                	<label for="espec" class="etiqueta">Campo de especialización * </label>
	                	<select class="form-control customInput" name="espec" id="espec">
	                		<?php 
	                			while ($rowEspecTipoLst = $stmtEspecTipoLst->fetch_assoc()){
	                				$especializacion = $rowEspecTipoLst['IdEspecializacion']." - ".$rowEspecTipoLst['Nombre'];
	            					echo "<option value=\"".$rowEspecTipoLst['IdEspecializacion']."\">".$especializacion."</option>";
	                			} 
	                		?>
						</select>
	                </div>
                </div>
                <div class="botonera">
				    <input type="submit" class="btn btn-success" value="Requerir Especialización" />
				    <button type="button" class="volver" onclick="location.href='AdminTipoListaModificar.php?idTipoLista=<?php echo $_REQUEST["idTipoLista"]; ?>'">Cancelar</button>
				</div>
			</form>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
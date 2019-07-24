<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$consRevision = "SELECT SE.EstadoVisado Estado, SE.DescripcionVisado Descripcion, C.NumColegiado IdRevisor, CONCAT(C.NumColegiado, ' - ', C.Nombre, ' ', C.Apellidos) Revisor FROM servicioactuacion SE, colegiado C WHERE SE.NumColegiadoRevisor=C.NumColegiado AND SE.NumColegiado=".$_REQUEST['encargado']." AND SE.IdSolicitudAct=".$_REQUEST['idProyecto'];

	$stmtRevision = $conn->query($consRevision);
	$rowRevision = $stmtRevision->fetch_assoc();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Actualizar Estado de Visado</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Actualizar Estado de Visado</h1>
            </div>

            <?php 
                $stmtEncargado = $conn->query("SELECT NumColegiado IdEncargado, CONCAT(NumColegiado, ' - ', Nombre, ' ', Apellidos) Encargado FROM colegiado WHERE NumColegiado='".$_REQUEST["encargado"]."'");
                $rowEncargado = $stmtEncargado->fetch_assoc();
            ?>

			<form id="formCrearSolicitud" method="POST" action="procesarActualizarEstadoRevision.php">
				<div class="form-row">
					<div class="form-group campoForm">
	                    <label for="idProyecto" class="etiqueta">Id. Proyecto </label>
	                    <input class="form-control customInput" type="text" id="idProyecto" name="idProyecto" readonly="true" <?php echo 'value="'.$_REQUEST['idProyecto'].'"'; ?> />
	                </div>
					<div class="form-group campoForm">
	                    <label for="encargado" class="etiqueta">Encargado </label>
	                    <select class="form-control customInput" name="encargado" id="encargado" readonly="true">
	                		<?php echo '<option value="'.$rowEncargado['IdEncargado'].'" selected>'.$rowEncargado['Encargado'].'</option>'; ?>
						</select>
	                </div>
					<div class="form-group campoForm">
	                    <label for="revisor" class="etiqueta">Revisor </label>
	                    <input class="form-control customInput" type="text" id="revisor" name="revisor" readonly="true" <?php echo 'value="'.$rowRevision['Revisor'].'"'; ?> />
	                </div>
	                <div class="form-group campoForm">
	                	<label for="estado" class="etiqueta">Estado del Visado </label>
	                	<select class="form-control customInput" name="estado" id="estado">
	                		<?php
                                foreach ($estadosVisado as $i => $value) {
                                    if($value == $rowRevision['Estado']){
                                        echo "<option value='$i' selected>$value</option>";
                                    } else {
                                        echo "<option value='$i'>$value</option>";
                                    }
                                }
                                echo '</select>';
                            ?>
						</select>
	                </div>
                    <div class="form-group campoForm">
                        <label for="descripcion" class="etiqueta">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="80" required="true" > <?php echo $rowRevision['Descripcion']; ?></textarea>
                    </div>
                </div>
                <div class="botonera">
				    <input type="submit" class="btn btn-success" value="Actualizar" />
				    <button type="button" class="volver" onclick="location.href='AdminProyectoModificar.php?<?php echo "idProyecto=".$_REQUEST["idProyecto"]; ?>'">Cancelar</button>
				</div>
			</form>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
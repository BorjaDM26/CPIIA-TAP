<?php 
	if(!isset($_SESSION)) { session_start(); } 

	if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
	    echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
	}

    require_once 'partials/referencias.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Modificar Colegiado</title>
	</head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Modificar Colegiado</h1>
            </div>
            
            <?php 
                $stmt = $conn->query("SELECT * FROM colegiado WHERE numColegiado='".$_REQUEST["numColegiado"]."'");
                $row = $stmt->fetch_assoc();
                echo "<p>Información del perfil del colegiado ".$row['Nombre']." ".$row['Apellidos'].".</p>";
            ?>

            <form id="formModificarColegiado" method="POST" action="procesarModificarColegiado.php?numColegiado=<?php echo $_REQUEST["numColegiado"] ?>">
                <div class="form-row">
                    <div class="form-group campoForm">
                        <label for="nuevoNumColegiado" class="etiqueta">Número de Colegiado </label>
                        <input class="form-control customInput" type="number" id="nuevoNumColegiado" name="nuevoNumColegiado" <?php echo 'value="'.$row['NumColegiado'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="nombre" class="etiqueta">Nombre </label>
                        <input class="form-control customInput" type="text" id="nombre" name="nombre" <?php echo 'value="'.$row['Nombre'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="apellidos" class="etiqueta">Apellidos </label>
                        <input class="form-control customInput" type="text" id="apellidos" name="apellidos" <?php echo 'value="'.$row['Apellidos'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="rol" class="etiqueta">Rol * </label>
                        <select class="form-control customInput" name="rol" id="rol"> 
                            <?php if ($row['Rol']=='Colegiado') {
                                echo '<option value="Colegiado" selected>Colegiado</option>';
                                echo '<option value="Responsable">Responsable</option>';
                            } else{
                                echo '<option value="Colegiado">Colegiado</option>';
                                echo '<option value="Responsable" selected>Responsable</option>';
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group campoForm">
                        <label for="domicilio" class="etiqueta">Domicilio Profesional </label>
                        <input class="form-control customInput" type="text" id="domicilio" name="domicilio" <?php echo 'value="'.$row['DomicilioProfesional'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="localidad" class="etiqueta">Localidad </label>
                        <input class="form-control customInput" type="text" id="localidad" name="localidad" <?php echo 'value="'.$row['Localidad'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="codigoPostal" class="etiqueta">Código Postal </label>
                        <input class="form-control customInput" type="text" id="codigoPostal" name="codigoPostal" <?php echo 'value="'.$row['CodigoPostal'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="provincia" class="etiqueta">Provincia </label>
                        <input class="form-control customInput" type="text" id="provincia" name="provincia" <?php echo 'value="'.$row['Provincia'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="telefonoProfesional" class="etiqueta">Teléfono Profesional </label>
                        <input class="form-control customInput" type="text" id="telefonoProfesional" name="telefonoProfesional" <?php echo 'value="'.$row['TelefonoProfesional'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="email" class="etiqueta">Correo Electrónico </label>
                        <input class="form-control customInput" type="text" id="email" name="email" <?php echo 'value="'.$row['CorreoElectronico'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="URL" class="etiqueta">Web Personal </label>
                        <input class="form-control customInput" type="text" id="URL" name="URL" <?php echo 'value="'.$row['URL'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="finInhabilitacion" class="etiqueta"> Fin de Inhabilitación </label>
                        <input class="form-control customInput" type="date" id="finInhabilitacion" name="finInhabilitacion" <?php echo 'value="'.$row['FinInhabilitacion'].'"'; ?> />
                    </div>
                </div>
                <div class="botonera row">
                    <input type="submit" class="btn btn-success" value="Modificar Colegiado" />
                    <button type="reset" <?php echo "onclick=\"location.href='AdminColegiadoModificar.php?numColegiado=".$_GET['numColegiado']."'\"" ?>>Reiniciar Formulario</button>
                    <button type="button" class="volver" onclick="location.href='AdminColegiados.php'">Cancelar</button>
                </div>
            </form>

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
    </body>
</html>
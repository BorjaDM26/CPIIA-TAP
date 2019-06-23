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
		<title>Consultar Colegiado</title>
	</head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <h1>Mi Perfil</h1>
            <?php 
                $stmt = $conn->query("SELECT * FROM colegiado WHERE numColegiado='".$_SESSION["SesionNumColegiado"]."'");
                $row = $stmt->fetch_assoc();
                echo "<p>Información del perfil del colegiado ".$row['Nombre']." ".$row['Apellidos'].".</p>";
            ?>

            <div class="form-row">
                <div class="form-group campoForm">
                    <label for="numColegiado" class="etiqueta">Número de Colegiado </label>
                    <input class="form-control customInput" type="text" id="numColegiado" name="numColegiado" readonly="true" <?php echo 'value="'.$row['NumColegiado'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="nombre" class="etiqueta">Nombre </label>
                    <input class="form-control customInput" type="text" id="nombre" name="nombre" readonly="true" <?php echo 'value="'.$row['Nombre'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="apellidos" class="etiqueta">Apellidos </label>
                    <input class="form-control customInput" type="text" id="apellidos" name="apellidos" readonly="true" <?php echo 'value="'.$row['Apellidos'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="rol" class="etiqueta">Rol </label>
                    <input class="form-control customInput" type="text" id="rol" name="rol" readonly="true" <?php echo 'value="'.$row['Rol'].'"'; ?> />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group campoForm">
                    <label for="domicilio" class="etiqueta">Domicilio Profesional </label>
                    <input class="form-control customInput" type="text" id="domicilio" name="domicilio" readonly="true" <?php echo 'value="'.$row['DomicilioProfesional'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="localidad" class="etiqueta">Localidad </label>
                    <input class="form-control customInput" type="text" id="localidad" name="localidad" readonly="true" <?php echo 'value="'.$row['Localidad'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="codigoPostal" class="etiqueta">Código Postal </label>
                    <input class="form-control customInput" type="text" id="codigoPostal" name="codigoPostal" readonly="true" <?php echo 'value="'.$row['CodigoPostal'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="provincia" class="etiqueta">Provincia </label>
                    <input class="form-control customInput" type="text" id="provincia" name="provincia" readonly="true" <?php echo 'value="'.$row['Provincia'].'"'; ?> />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group campoForm">
                    <label for="telefonoProfesional" class="etiqueta">Teléfono Profesional </label>
                    <input class="form-control customInput" type="text" id="telefonoProfesional" name="telefonoProfesional" readonly="true" <?php echo 'value="'.$row['TelefonoProfesional'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="email" class="etiqueta">Correo Electrónico </label>
                    <input class="form-control customInput" type="text" id="email" name="email" readonly="true" <?php echo 'value="'.$row['CorreoElectronico'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="URL" class="etiqueta">Web Personal </label>
                    <input class="form-control customInput" type="text" id="URL" name="URL" readonly="true" <?php echo 'value="'.$row['URL'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="finInhabilitacion" class="etiqueta"> Fin de Inhabilitación </label>
                    <input class="form-control customInput" type="text" id="finInhabilitacion" name="finInhabilitacion" disabled="true" <?php echo 'value="'.$row['FinInhabilitacion'].'"'; ?> />
                </div>
            </div>
            <button type="button" class="volver" onclick="location.href='index.php'">Volver</button>
        </div>

        <?php require 'partials/footer.php' ?>
    </body>
</html>
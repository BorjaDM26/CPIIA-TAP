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
		<title>Crear Colegiado</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Colegiados</h1>
            </div>

			<form id="formCrearColegiado" method="POST" action="procesarCrearColegiado.php">
				<div class="form-row">
                    <div class="form-group campoForm">
                    	<label for="numColegiado" class="etiqueta">Número de Colegiado * </label>
                        <input class="form-control customInput" type="number" id="numColegiado" name="numColegiado" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="nombre" class="etiqueta">Nombre * </label>
                        <input class="form-control customInput" type="text" id="nombre" name="nombre" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="apellidos" class="etiqueta">Apellidos * </label>
                        <input class="form-control customInput" type="text" id="apellidos" name="apellidos" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="rol" class="etiqueta">Rol * </label>
                        <select class="form-control customInput" name="rol" id="rol">    
							<option value="Colegiado">Colegiado</option>    
							<option value="Responsable">Responsable</option>     
						</select>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="domicilio" class="etiqueta">Domicilio Profesional * </label>
                        <input class="form-control customInput" type="text" id="domicilio" name="domicilio" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="localidad" class="etiqueta">Localidad * </label>
                        <input class="form-control customInput" type="text" id="localidad" name="localidad" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="codigoPostal" class="etiqueta">Código Postal * </label>
                        <input class="form-control customInput" type="text" id="codigoPostal" name="codigoPostal" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                        <label for="provincia" class="etiqueta">Provincia * </label>
                        <input class="form-control customInput" type="text" id="provincia" name="provincia" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="telefonoProfesional" class="etiqueta">Teléfono Profesional * </label>
                        <input class="form-control customInput" type="text" id="telefonoProfesional" name="telefonoProfesional" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="email" class="etiqueta">Correo Electrónico * </label>
                        <input class="form-control customInput" type="text" id="email" name="email" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                        <label for="URL" class="etiqueta">Web Personal </label>
                        <input class="form-control customInput" type="text" id="URL" name="URL"/>
                    </div>
				</div>
                <div class="botonera row">
    			    <input type="submit" class="btn btn-success" value="Crear Colegiado" />
            		<input type="reset" value="Reiniciar Formulario"/>
    			    <button type="button" class="volver" onclick="location.href='AdminColegiados.php'">Cancelar</button>
                </div>
			</form>
		</div>
	</body>
</html>
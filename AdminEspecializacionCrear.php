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
		<title>Crear Especialización</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Crear Especialización</h1>
            </div>

			<form id="formCrearLista" method="POST" action="procesarCrearEspecializacion.php">
				<div class="form-row">
                    <div class="form-group campoForm">
                    	<label for="nombre" class="etiqueta">Nombre * </label>
                        <input class="form-control customInput" type="text" id="nombre" name="nombre" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                        <label for="descripcion" class="etiqueta">Descripción * </label>
                        <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="94" required="true"></textarea>
                    </div>
				</div>
                <div class="botonera">
    			    <input type="submit" class="btn btn-success" value="Crear Especialización" />
            		<input type="reset" value="Reiniciar Formulario"/>
    			    <button type="button" class="volver" onclick="location.href='AdminEspecializaciones.php'">Cancelar</button>
                </div>
			</form>
            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
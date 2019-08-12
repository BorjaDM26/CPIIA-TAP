<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$stmtTipoLst = $conn->query("SELECT * FROM tipolista;");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Solicitud de Actuación</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Solicitud de Actuación</h1>
            </div>
			
			<p>El Colegio Profesional de Ingenieros en Informática de Andalucía (CPIIA) pone a disposición de ciudadanos y entidades la cualificación y experiencia de sus colegiados para ejercer como Ingenieros Informáticos en todas las provincias andaluzas (Almería, Cádiz, Córdoba, Huelva, Jaén, Granada, Málaga y Sevilla), ya sea en proceso judicial o extrajudicial.</p>

			<form id="formCrearSolicitud" method="POST" action="procesarCrearSolicitud.php">
				<div class="form-row">
	                <div class="form-group campoForm">
	                	<label for="nombre" class="etiqueta">Nombre del solicitante * </label>
	                    <input class="form-control customInput" type="text" id="nombre" name="nombre" required="true"/>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="email" class="etiqueta">Correo electrónico * </label>
	                    <input class="form-control customInput" type="text" id="email" name="email" required="true"/>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="telefono" class="etiqueta">Teléfono de contacto * </label>
	                    <input class="form-control customInput" type="text" id="telefono" name="telefono" required="true"/>
	                </div>

	                <div class="form-group campoForm">
	                	<label for="tipoLst" class="etiqueta">Tipo de solicitud </label>
	                	<select class="form-control customInput" name="tipoLst" id="tipoLst">
	                		<?php 
	                			while ($filaTipoLst = $stmtTipoLst->fetch_assoc()){
	            					echo "<option value=\"".$filaTipoLst['IdTipoLista']."\">".$filaTipoLst['Nombre']."</option>";
	                			} 
	                		?>
						</select>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="provincia" class="etiqueta">Provincia </label>
	                	<select class="form-control customInput" name="provincia" id="provincia">
	                		<option value="ALM">Almería</option>
	                		<option value="CAD">Cádiz</option>
	                		<option value="COR">Córdoba</option>
	                		<option value="GRA">Granada</option>
	                		<option value="HUE">Huelva</option>
	                		<option value="JAE">Jaén</option>
	                		<option value="MAL">Málaga</option>
	                		<option value="SEV">Sevilla</option>
						</select>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="visado" class="etiqueta">Visado </label>
	                    <select class="form-control customInput" name="visado" id="visado">    
							<option value="0" selected>No</option>    
							<option value="1">Si</option>     
						</select>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="descripcion" class="etiqueta">Descripción de lo solicitado * </label>
	                    <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="94" required="true"></textarea>
	                </div>
                </div>
                <div class="botonera">
				    <input type="submit" value="Enviar solicitud"/>
	        		<input type="reset" value="Reiniciar Formulario"/>
				    <button type="button" class="volver" onclick="location.href='index.php'">Volver</button>
				</div>
			</form>

			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
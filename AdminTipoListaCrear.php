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
		<title>Crear Tipo de Lista</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Crear Tipo de Lista</h1>
            </div>

			<form id="formCrearLista" method="POST" action="procesarCrearTipoLista.php">
				<div class="form-row">
                    <div class="form-group campoForm">
                    	<label for="nombre" class="etiqueta">Nombre * </label>
                        <input class="form-control customInput" type="text" id="nombre" name="nombre" required="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="comision" class="etiqueta">Comisión *</label>
                        <select class="form-control customInput" name="comision" id="comision" required="true">
                            <?php 
                                $stmtComision = $conn->query("SELECT C.IdComision FROM comisiontap C WHERE C.IdComision NOT IN (SELECT TL.IdComision FROM tipolista TL);");

                                while ($rowComision = $stmtComision->fetch_assoc()){
                                    echo "<option value=\"".$rowComision['IdComision']."\">Comisión ".$rowComision['IdComision']."</option>";
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group campoForm">
                        <label for="iniciovacaciones" class="etiqueta">Inicio vacacional </label>
                        <input class="form-control customInput" type="date" id="iniciovacaciones" name="iniciovacaciones"/>
                    </div>
                    <div class="form-group campoForm">
                        <label for="finvacaciones" class="etiqueta">Fin vacacional </label>
                        <input class="form-control customInput" type="date" id="finvacaciones" name="finvacaciones"/>
                    </div>
                    <div class="form-group campoForm">
                        <label for="descripcion" class="etiqueta">Descripción * </label>
                        <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="94" required="true"></textarea>
                    </div>
				</div>
                <div class="botonera">
    			    <input type="submit" class="btn btn-success" value="Crear Tipo de Lista" />
            		<input type="reset" value="Reiniciar Formulario"/>
    			    <button type="button" class="volver" onclick="location.href='AdminTiposLista.php'">Cancelar</button>
                </div>
			</form>
            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
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
		<title>Crear Lista</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Crear Lista</h1>
            </div>

			<form id="formCrearLista" method="POST" action="procesarCrearLista.php">
				<div class="form-row">
                    <div class="form-group campoForm">
                    	<label for="grupo" class="etiqueta">Grupo </label>
                        <select class="form-control customInput" name="grupo" id="grupo" onchange="showPublicoTerritoriosXTipoLst(this.value)">
                            <option value="Profesionales">Profesionales</option>    
                            <option value="Revisores">Revisores</option>
                        </select>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="tipoLista" class="etiqueta">Tipo de Lista </label>
                        <select class="form-control customInput" name="tipoLista" id="tipoLista">
                            <?php 
                                $stmtTipoLst = $conn->query("SELECT * FROM tipolista;");

                                while ($rowTipoLst = $stmtTipoLst->fetch_assoc()){
                                    echo "<option value=\"".$rowTipoLst['IdTipoLista']."\">".$rowTipoLst['Nombre']."</option>";
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-row" id="auxPubTerritXGrupo">
                        <div class="form-group campoForm">
                        	<label for="publica" class="etiqueta">Publica </label>
                            <select class="form-control customInput" name="publica" id="publica">
                                <option value="1">Si</option>    
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group campoForm">
                        	<label for="territorio" class="etiqueta">Territorio </label>
                            <select class="form-control customInput" name="territorio" id="territorio">
                                <?php 
                                    $stmtTerrit = $conn->query("SELECT * FROM territorio;");

                                    while ($rowTerrit = $stmtTerrit->fetch_assoc()){
                                        echo "<option value=\"".$rowTerrit['IdTerritorio']."\">".$rowTerrit['Nombre']."</option>";
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
				</div>
                <div class="botonera row">
    			    <input type="submit" class="btn btn-success" value="Crear Lista" />
            		<input type="reset" value="Reiniciar Formulario"/>
    			    <button type="button" class="volver" onclick="location.href='AdminListas.php'">Cancelar</button>
                </div>
			</form>
            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
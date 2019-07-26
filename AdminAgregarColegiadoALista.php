<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';
	
	$consLst = "SELECT c.IdLista, d.Nombre TipoLista,c.Nombre Territorio, c.publica FROM 
			(SELECT EC.NumColegiado, EL.IdTipoLista, COUNT(E.IdEspecializacion) cont
			FROM especializacionlista EL, especializacioncolegiado EC, campoespecializacion E
			WHERE E.IdEspecializacion=EC.IdEspecializacion AND E.IdEspecializacion=EL.IdEspecializacion AND EC.NumColegiado=".$_REQUEST['numColegiado']."
			GROUP BY EC.NumColegiado, EL.IdTipoLista) AS u
		INNER JOIN (SELECT TL.IdTipoLista, TL.Nombre, COUNT(EL.IdEspecializacion) cont FROM especializacionlista EL, tipolista TL WHERE El.IdTipoLista=TL.IdTipoLista GROUP BY TL.IdTipoLista, TL.Nombre) AS d
		ON u.IdTipoLista = d.IdTipoLista
		INNER JOIN (SELECT L.*, T.Nombre FROM lista L, territorio T WHERE L.Territorio=T.IdTerritorio) AS c
		ON u.IdTipoLista=c.IdTipoLista
		WHERE u.cont=d.cont AND c.IdLista NOT IN (SELECT IdLista FROM inscripcion WHERE NumColegiado=".$_REQUEST['numColegiado'].")
		ORDER BY c.IdLista;";

	$stmtLst = $conn->query($consLst);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Inscribir Colegiado en una Lista</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Inscribir Colegiado en una Lista</h1>
            </div>

            <?php 
                $stmtColeg = $conn->query("SELECT NumColegiado, Nombre, Apellidos FROM colegiado WHERE NumColegiado='".$_REQUEST["numColegiado"]."'");
                $rowColeg = $stmtColeg->fetch_assoc();
            ?>

			<form id="formCrearSolicitud" method="POST" action="procesarAgregarColegiadoALista.php">
				<div class="form-row">
					<div class="form-group campoForm">
	                    <label for="numColegiado" class="etiqueta">Nº de colegiado </label>
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
	                	<label for="lista" class="etiqueta">Lista * </label>
	                	<select class="form-control customInput" name="lista" id="lista">
	                		<?php 
	                			while ($rowLst = $stmtLst->fetch_assoc()){
	                				$lista = $rowLst['IdLista'];

	                				if ($rowLst['publica'] == NULL) {
	                					$lista .= " - Revisores de ";
	                				} else {
	                					$lista .= " - Profesionales de ";
	                				}

	                				$lista .= $rowLst['TipoLista']." en ".$rowLst['Territorio'];

	                				if ($rowLst['publica'] == 0) {
	                					$lista .= " (Privada)";
	                				} else {
	                					$lista .= " (Pública)";
	                				}
	            					echo "<option value=\"".$rowLst['IdLista']."\">".$lista."</option>";
	                			} 
	                		?>
						</select>
	                </div>
                </div>
                <div class="botonera">
				    <input type="submit" class="btn btn-success" value="Inscribir" />
				    <button type="button" class="volver" onclick="location.href='AdminColegiadoModificar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>'">Cancelar</button>
				</div>
			</form>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
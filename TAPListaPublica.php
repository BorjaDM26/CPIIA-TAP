<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$stmtTipoLst = $conn->query("SELECT * FROM tipolista;");
	$idTipoLst = 1;
	if(isset($_REQUEST['idTipoLst'])){
		$idTipoLst = $_REQUEST['idTipoLst'];
	}

	$stmtTerrit = $conn->query("SELECT T.IdTerritorio, T.Nombre FROM Lista L, Territorio T WHERE L.Territorio=T.IdTerritorio AND L.Publica=1 AND L.IdTipoLista='".$idTipoLst."';");
	$territ = '';
	if(isset($_REQUEST['territ'])){
		$territ = $_REQUEST['territ'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Listas Públicas</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Listas Públicas</h1>
            </div>

			<form id="formCrearColegiado" method="GET" action="TAPListaPublica.php">	
				<div class="form-row">
	                <div class="form-group campoForm offset-md-1">
	                	<label for="idTipoLst" class="etiqueta">Tipo de Lista: </label>
	                	<select class="form-control customInput" name="idTipoLst" id="idTipoLst" onchange="showTerritoriosTipoLst(this.value, 1)">
	                		<?php 
	                			while ($filaTipoLst = $stmtTipoLst->fetch_assoc()){
	                				if ($filaTipoLst['IdTipoLista']==$idTipoLst) {
	                					echo "<option value=\"".$filaTipoLst['IdTipoLista']."\" selected>".$filaTipoLst['Nombre']."</option>";
	                				} else{
	                					echo "<option value=\"".$filaTipoLst['IdTipoLista']."\">".$filaTipoLst['Nombre']."</option>";
	                				}
	                			} 
	                		?>
						</select>
	                </div>
	                <div class="form-group campoForm offset-md-1" id="auxTerritTipoLst">
	                	<label for="territ" class="etiqueta">Territorio: </label>
	                	<select class="form-control customInput" name="territ" id="territ">
	                		<?php 
	                			while ($filaTerrit = $stmtTerrit->fetch_assoc()){
	                				if ($filaTerrit['IdTerritorio']==$territ) {
	                					echo "<option value=\"".$filaTerrit['IdTerritorio']."\" selected>".$filaTerrit['Nombre']."</option>";
	                				} else{
	                					echo "<option value=\"".$filaTerrit['IdTerritorio']."\">".$filaTerrit['Nombre']."</option>";
	                				}
	                			} 
	                		?>
						</select>
	                </div>
	                <input type="submit" class="btn btn-success buscar offset-md-1" value="Buscar" />
				</div>
			</form>

			<?php
				if(isset($_GET['idTipoLst']) AND isset($_GET['territ'])){
					$consColeg="SELECT C.NumColegiado, C.Nombre, C.Apellidos, C.CorreoElectronico, C.TelefonoProfesional, C.URL FROM inscripcion I, colegiado C, lista L WHERE I.NumColegiado=C.NumColegiado AND I.IdLista=L.IdLista AND L.Publica='1' AND L.IdTipoLista=".$_REQUEST['idTipoLst']." AND L.Territorio='".$_REQUEST['territ']."' ORDER BY C.Apellidos, C.Nombre ASC";
					$result=$conn->query($consColeg);
					$resultLst=$conn->query("SELECT TL.Nombre TipoLista, T.Nombre Territorio FROM tipolista TL, Territorio T WHERE TL.IdTipoLista=".$_GET['idTipoLst']." AND T.IdTerritorio='".$_GET['territ']."'");
					if(isset($resultLst)){
						$lst = $resultLst->fetch_assoc();
						echo "<h3> Colegiados de la lista pública de ".$lst['TipoLista']." en ".$lst['Territorio'].".</h3>";
					}
				}
			?>

			<?php if(isset($_GET['idTipoLst']) AND isset($_GET['territ'])): ?>
				<div class="form-row">
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<th class="text-center" scope="col">N. Colegiado</th>
								<th class="text-center" scope="col">Nombre</th>
								<th class="text-center" scope="col">Apellidos</th>
								<th class="text-center" scope="col">Email</th>
								<th class="text-center" scope="col">Teléfono</th>
								<th class="text-center" scope="col">URL</th>
							</tr>
						</thead>
						<tbody>
							<?php while (isset($result) && $row = $result->fetch_assoc()): ?>
							<tr>
				                <td class="text-center"><?php echo $row['NumColegiado']; ?></td>
				                <td class="text-center"><?php echo $row['Nombre']; ?></td>
				                <td class="text-center"><?php echo $row['Apellidos']; ?></td>
				                <td class="text-center"><?php echo $row['CorreoElectronico']; ?></td>
				                <td class="text-center"><?php echo $row['TelefonoProfesional']; ?></td>
				                <td class="text-center">
				                	<?php echo "<a href=\"http://".$row['URL']."\">".$row['URL']."</a>"; ?>
				                </td>
			                </tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
			<div class="push"></div>
		</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
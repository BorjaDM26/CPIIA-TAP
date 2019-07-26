<?php 
	if(!isset($_SESSION)) { session_start(); } 

	if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
	    echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
	}

    require_once 'partials/referencias.php';

	// Clausula where para filtrar las listas
	$buscador = '';
	if(isset($_REQUEST['buscadorTipoLista']) && $_REQUEST['buscadorTipoLista']!='Todos'){
		$buscador = $buscador." AND L.IdTipoLista='".$_REQUEST['buscadorTipoLista']."' ";
	}
	if(isset($_REQUEST['buscadorGrupo']) && $_REQUEST['buscadorGrupo']=='Revisores'){
		$buscador = $buscador.' AND L.Publica IS NULL ';
	} elseif(isset($_REQUEST['buscadorGrupo']) && $_REQUEST['buscadorGrupo']=='Profesionales'){
		$buscador = $buscador.' AND L.Publica IS NOT NULL ';
	}
	if(isset($_REQUEST['buscadorPub']) && $_REQUEST['buscadorPub']!='Todos'){
		$buscador = $buscador.' AND L.Publica='.$_REQUEST['buscadorPub'].' ';
	}

	if(isset($_REQUEST['buscadorTerri']) && $_REQUEST['buscadorTerri']!='Todos'){
		$buscador = $buscador." AND L.Territorio='".$_REQUEST['buscadorTerri']."' ";
	}

	//Consulta de las especializaciones y provincias para los campos de búsqueda
	$stmtTipoLst = $conn->query("SELECT IdTipoLista, Nombre FROM tipolista ORDER BY IdTipoLista");
	$stmtTerri = $conn->query("SELECT * FROM territorio");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administración de Listas</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
            	<div class="left">
            		<h1>Administración - Listas</h1>
            	</div>
            	<div class="right">
					<button class="btn btn-success crear right"  onclick="location.href='AdminListaCrear.php'"><i class="fas fa-plus"> Crear</i></button>
				</div>
			</div>

			<form id="formBuscarLista" method="GET" action="AdminListas.php">
				<div class="form-row">
	                <div class="form-group campoForm">
	                	<label for="buscadorTipoLista" class="etiqueta">Tipo de lista </label>
	                	<select class="form-control customFilter" name="buscadorTipoLista" id="buscadorTipoLista">
	                		<?php 
		                		if (!isset($_REQUEST['buscadorTipoLista']) || $_REQUEST['buscadorTipoLista']=='Todos') {
		                			echo '<option value="Todos" selected> </option>';
		                		} else {
		                			echo '<option value="Todos"> </option>';
		                		}
	                			
								while ($rowTipoLst = $stmtTipoLst->fetch_assoc()){
									if ($_REQUEST['buscadorTipoLista']==$rowTipoLst['IdTipoLista']) {
										echo '<option value="'.$rowTipoLst['IdTipoLista'].'" selected>'.$rowTipoLst['Nombre'].'</option>';
									} else {
										echo '<option value="'.$rowTipoLst['IdTipoLista'].'">'.$rowTipoLst['Nombre'].'</option>';
									}
								} 
	                		?>
						</select>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="buscadorGrupo" class="etiqueta">Grupo </label>
                        <select class="form-control customFilter" name="buscadorGrupo" id="buscadorGrupo">
                        	<?php 
		                		if (!isset($_REQUEST['buscadorGrupo']) || $_REQUEST['buscadorGrupo']=='Todos') {
		                			echo '<option value="Todos" selected> </option>';
		                			echo '<option value="Profesionales">Profesionales </option>';
		                			echo '<option value="Revisores">Revisores </option>';
		                		} elseif ($_REQUEST['buscadorGrupo']=='Profesionales') {
		                			echo '<option value="Todos"> </option>';
		                			echo '<option value="Profesionales" selected>Profesionales </option>';
		                			echo '<option value="Revisores">Revisores </option>';
		                		} else {
		                			echo '<option value="Todos"> </option>';
		                			echo '<option value="Profesionales">Profesionales </option>';
		                			echo '<option value="Revisores" selected>Revisores </option>';
		                		}
	                		?>
						</select>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="buscadorPub" class="etiqueta">Pública </label>
                        <select class="form-control customFilter" name="buscadorPub" id="buscadorPub">
                        	<?php 
		                		if (!isset($_REQUEST['buscadorPub']) || $_REQUEST['buscadorPub']=='Todos') {
		                			echo '<option value="Todos" selected> </option>';
		                			echo '<option value="1">Si </option>';
		                			echo '<option value="0">No </option>';
		                		} elseif ($_REQUEST['buscadorPub']=='1') {
		                			echo '<option value="Todos"> </option>';
		                			echo '<option value="1" selected>Si </option>';
		                			echo '<option value="0">No </option>';
		                		} else {
		                			echo '<option value="Todos"> </option>';
		                			echo '<option value="1">Si </option>';
		                			echo '<option value="0" selected>No </option>';
		                		}
	                		?>
						</select>
	                </div>
	                <div class="form-group campoForm">
	                	<label for="buscadorTerri" class="etiqueta">Territorio </label>
	                	<select class="form-control customFilter" name="buscadorTerri" id="buscadorTerri">
	                		<?php 
		                		if (!isset($_REQUEST['buscadorTerri']) || $_REQUEST['buscadorTerri']=='Todos') {
		                			echo '<option value="Todos" selected> </option>';
		                		} else {
		                			echo '<option value="Todos"> </option>';
		                		}
	                			
								while ($rowTerri = $stmtTerri->fetch_assoc()){
									if ($_REQUEST['buscadorTerri']==$rowTerri['IdTerritorio']) {
										echo '<option value="'.$rowTerri['IdTerritorio'].'" selected>'.$rowTerri['Nombre'].'</option>';
									} else {
										echo '<option value="'.$rowTerri['IdTerritorio'].'">'.$rowTerri['Nombre'].'</option>';
									}
								} 
	                		?>
						</select>
	                </div>
			    	<input type="submit" class="btn btn-success buscar" value="Filtrar" />
				</div>
			</form>
				
			<?php
				$columns = array('IdLista', 'TipoLista', 'Publica', 'Territorio');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

				$cons = "SELECT L.IdLista, TL.Nombre TipoLista, L.Publica, T.Nombre Territorio FROM lista L, tipolista TL, Territorio T	WHERE L.IdTipoLista=TL.IdTipoLista AND L.Territorio=T.IdTerritorio ".$buscador." ORDER BY ".$column." ".$sort_order;

				if ($result=$conn->query($cons)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
			?>

			<table class="table table-sm table-hover col-md-11">
				<thead>
					<tr>
						<?php 
							$param = '';
							if (isset($_REQUEST['buscadorTipoLista'])) {
								$param .= 'buscadorTipoLista='.$_REQUEST['buscadorTipoLista'].'&';
							}
							if (isset($_REQUEST['buscadorGrupo'])) {
								$param .= 'buscadorGrupo='.$_REQUEST['buscadorGrupo'].'&';
							}
							if (isset($_REQUEST['buscadorPub'])) {
								$param .= 'buscadorPub='.$_REQUEST['buscadorPub'].'&';
							}
							if (isset($_REQUEST['buscadorTerri'])) {
								$param .= 'buscadorTerri='.$_REQUEST['buscadorTerri'].'&';
							}
						?>
						<th class="text-center" scope="col"><a href="AdminListas.php?<?php echo $param; ?>column=IdLista&order=<?php echo $asc_or_desc; ?>">Id. de lista<i class="fas fa-sort<?php echo $column == 'IdLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminListas.php?<?php echo $param; ?>column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
		                <th class="text-center" scope="col">Grupo</th>
						<th class="text-center" scope="col"><a href="AdminListas.php?<?php echo $param; ?>column=Publica&order=<?php echo $asc_or_desc; ?>">Pública<i class="fas fa-sort<?php echo $column == 'Publica' ? '-' . $up_or_down : '' ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminListas.php?<?php echo $param; ?>column=Territorio&order=<?php echo $asc_or_desc; ?>">Territorio<i class="fas fa-sort<?php echo $column == 'Territorio' ? '-' . $up_or_down : '' ?>"></i></a></th>
		                <th class="text-center" scope="col">Consultar</th>
		                <th class="text-center" scope="col">Modificar</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch_assoc()){
						echo "<tr>";
			                echo "<td class=\"text-center\">".$row['IdLista']."</td>";
			                echo "<td class=\"text-center\">".$row['TipoLista']."</td>";
			                if(is_null($row['Publica'])){
			                	echo "<td class=\"text-center\"> Revisores </td>";
			                	echo "<td class=\"text-center\"> No </td>";
			                } elseif($row['Publica']=='0') {
			                	echo "<td class=\"text-center\"> Profesionales </td>";
			                	echo "<td class=\"text-center\"> No </td>";
			                } else{
			                	echo "<td class=\"text-center\"> Profesionales </td>";
			                	echo "<td class=\"text-center\"> Si </td>";
			                }
			                echo "<td class=\"text-center\">".$row['Territorio']."</td>";
		                    echo "<td class=\"text-center\"><a href=\"AdminListaConsultar.php?idLista=".$row['IdLista']."\"><i class=\"fas fa-eye\"></i></a></td>";
		                    echo "<td class=\"text-center\"><a href=\"AdminListaModificar.php?idLista=".$row['IdLista']."\"><i class=\"fas fa-edit\"></i></a></td>";
		                echo "</tr>";
					} ?>
				</tbody>
			</table>
            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
	</body>
</html>
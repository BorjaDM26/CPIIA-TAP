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
		<title>Administración de Proyectos</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
            <div class="titulo row">
            	<div class="left">
            		<h1>Administración - Proyectos</h1>
            	</div>
			</div>
            
            
			<?php 
				$columns = array('IdProyecto'); 
				$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
				$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

				$consultaProyectos = "(SELECT SO.IdSolicitudAct IdProyecto, CONCAT(CA.NumColegiado, ' - ', CA.Nombre, ' ', CA.Apellidos) Encargado, CONCAT(CB.NumColegiado, ' - ', CB.Nombre, ' ', CB.Apellidos) Revisor, SO.Estado FROM solicitudactuacion SO, servicioactuacion SE, colegiado CA, colegiado CB WHERE SO.IdSolicitudAct=SE.IdSolicitudAct AND SE.NumColegiado=CA.NumColegiado AND SE.NumColegiadoRevisor=CB.NumColegiado)
					UNION
					(SELECT SO.IdSolicitudAct IdProyecto, CONCAT(CA.NumColegiado, ' - ', CA.Nombre, ' ', CA.Apellidos) Encargado, NULL Revisor, SO.Estado FROM solicitudactuacion SO, servicioactuacion SE, colegiado CA WHERE SO.IdSolicitudAct=SE.IdSolicitudAct AND SE.NumColegiado=CA.NumColegiado AND SE.NumColegiadoRevisor IS NULL)
					UNION
					(SELECT SO.IdSolicitudAct IdProyecto, NULL Encargado, NULL Revisor, SO.Estado FROM solicitudactuacion SO WHERE SO.IdSolicitudAct NOT IN (SELECT IdSolicitudAct FROM servicioactuacion))
					ORDER BY ".$column.' '.$sort_order;

				if ($result=$conn->query($consultaProyectos)) {
					$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
					$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
					$add_class = ' class="highlight"';
				}
			?>

			<table class="table table-sm table-hover col-md-11">
				<thead>
					<tr>
						<th class="text-center" scope="col"><a href="AdminProyectos.php?column=IdProyecto&order=<?php echo $asc_or_desc; ?>">Id. Comisión<i class="fas fa-sort<?php echo $column == 'IdProyecto' ? '-' . $up_or_down : '' ?>"></i></a></th>
		                <th class="text-center" scope="col">Encargado</th>
		                <th class="text-center" scope="col">Revisor</th>
		                <th class="text-center" scope="col">Estado</th>
		                <th class="text-center" scope="col">Consultar</th>
		                <th class="text-center" scope="col">Modificar</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch_assoc()): ?>
					<tr>
		                <td class="text-center"><?php echo $row['IdProyecto']; ?></td>
		                <td class="text-center"><?php echo $row['Encargado']; ?></td>
		                <td class="text-center"><?php echo $row['Revisor']; ?></td>
		                <td class="text-center"><?php echo $row['Estado']; ?></td>
	                    <td class="text-center"><a <?php echo "href=\"AdminProyectoConsultar.php?idProyecto=".$row['IdProyecto']."\"" ?>><i class="fas fa-eye"></i></a></td>
	                    <td class="text-center"><a <?php echo "href=\"AdminProyectoModificar.php?idProyecto=".$row['IdProyecto']."\"" ?>><i class="fas fa-edit"></i></a></td>
	                </tr>
					<?php endwhile; ?>
				</tbody>
			</table>

            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
	</body>
</html>
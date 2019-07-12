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
		<title>Administración de Comisiones</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
            <div class="titulo row">
            	<div class="left">
            		<h1>Administración - Comisiones</h1>
            	</div>
            	<div class="right">
					<button class="btn btn-success crear right"  onclick="location.href='procesarCrearComision.php'"><i class="fas fa-plus"> Crear</i></button>
				</div>
			</div>
            
            
			<?php 
				$columns = array('IdComision', 'TipoLista'); 
				$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
				$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

				if ($result=$conn->query('(SELECT CT.IdComision, TL.Nombre TipoLista, CONCAT(CT.Presidente, " - ", C.Nombre, " ", C.Apellidos) Presidente FROM comisiontap CT, tipolista TL, colegiado C WHERE CT.IdComision=TL.IdComision AND (CT.Presidente=C.NumColegiado OR CT.Presidente IS NULL) GROUP BY CT.IdComision) UNION (SELECT CT.IdComision, NULL TipoLista, CONCAT(CT.Presidente, " - ", C.Nombre, " ", C.Apellidos) Presidente FROM comisiontap CT, colegiado C WHERE CT.IdComision NOT IN (SELECT IdComision FROM tipolista) AND (CT.Presidente=C.NumColegiado OR CT.Presidente IS NULL)) ORDER BY '.$column.' '.$sort_order)) {
					$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
					$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
					$add_class = ' class="highlight"';
				}
			?>

			<table class="table table-sm table-hover col-md-11">
				<thead>
					<tr>
						<th class="text-center" scope="col"><a href="AdminComisiones.php?column=IdComision&order=<?php echo $asc_or_desc; ?>">Id. Comisión<i class="fas fa-sort<?php echo $column == 'IdComision' ? '-' . $up_or_down : '' ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminComisiones.php?column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo de Lista <i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : ''; ?>"></i></a></th>
		                <th class="text-center" scope="col">Presidente</th>
		                <th class="text-center" scope="col">Consultar</th>
		                <th class="text-center" scope="col">Modificar</th>
		                <th class="text-center" scope="col">Eliminar</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch_assoc()): ?>
					<tr>
		                <td class="text-center"><?php echo $row['IdComision']; ?></td>
		                <td class="text-center"><?php echo $row['TipoLista']; ?></td>
		                <td class="text-center"><?php echo $row['Presidente']; ?></td>
	                    <td class="text-center"><a <?php echo "href=\"AdminComisionConsultar.php?idComision=".$row['IdComision']."\"" ?>><i class="fas fa-eye"></i></a></td>
	                    <td class="text-center"><a <?php echo "href=\"AdminComisionModificar.php?idComision=".$row['IdComision']."\"" ?>><i class="fas fa-edit"></i></a></td>
	                    <td class="text-center"><a <?php echo "href=\"procesarEliminarComision.php?idComision=".$row['IdComision']."\"" ?> onclick="return confirm('¿Está seguro que desea borrar la comisión?')"><i class="fas fa-times red"></i></a></td>
	                </tr>
					<?php endwhile; ?>
				</tbody>
			</table>

            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
	</body>
</html>
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
		<title>Lista de Colegiados</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
            <div class="titulo row">
            	<div class="left">
            		<h1>Administración - Colegiados</h1>
            	</div>
            	<div class="right">
					<button class="btn btn-success crear right"  onclick="location.href='AdminColegiadoCrear.php'"><i class="fas fa-plus"> Crear</i></button>
				</div>
			</div>
            
            
			<?php 
				$columns = array('NumColegiado', 'Nombre', 'Apellidos', 'Rol'); 
				$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
				$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

				if ($result=$conn->query('SELECT NumColegiado, Nombre, Apellidos, Rol FROM colegiado ORDER BY '.$column.' '.$sort_order)) {
					$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
					$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
					$add_class = ' class="highlight"';
				}
			?>
			<table class="table table-sm table-hover col-md-11">
				<thead>
					<tr>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?column=NumColegiado&order=<?php echo $asc_or_desc; ?>">N. Colegiado<i class="fas fa-sort<?php echo $column == 'NumColegiado' ? '-' . $up_or_down : '' ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre <i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : ''; ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?column=Apellidos&order=<?php echo $asc_or_desc; ?>">Apellidos <i class="fas fa-sort<?php echo $column == 'Apellidos' ? '-' . $up_or_down : ''; ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?column=Rol&order=<?php echo $asc_or_desc; ?>">Rol<i class="fas fa-sort<?php echo $column == 'Rol' ? '-' . $up_or_down : ''; ?>"></i></a></th>
		                <th class="text-center" scope="col">Consultar</th>
		                <th class="text-center" scope="col">Modificar</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch_assoc()): ?>
					<tr>
		                <td class="text-center"><?php echo $row['NumColegiado']; ?></td>
		                <td class="text-center"><?php echo $row['Nombre']; ?></td>
		                <td class="text-center"><?php echo $row['Apellidos']; ?></td>
		                <td class="text-center"><?php echo $row['Rol']; ?></td>
	                    <td class="text-center"><a <?php echo "href=\"AdminColegiadoConsultar.php?numColegiado=".$row['NumColegiado']."\"" ?>><i class="fas fa-eye"></i></a></td>
	                    <td class="text-center"><a <?php echo "href=\"AdminColegiadoModificar.php?numColegiado=".$row['NumColegiado']."\"" ?>><i class="fas fa-edit"></i></a></td>
	                </tr>
					<?php endwhile; ?>
				</tbody>
			</table>
            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
		</div>
	</body>
</html>
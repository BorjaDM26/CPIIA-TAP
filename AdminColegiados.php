<?php 
	if(!isset($_SESSION)) { session_start(); } 

	if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
	    echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
	}

    require_once 'partials/referencias.php';

	//Paginación de la tabla de colegiados
    $numColegiados = $conn->query("SELECT * FROM colegiado")->num_rows;
    $maxPaginas = ceil($numColegiados/$porPagina);

    if (isset($_GET["pagina"])) { 
        $pagina  = $_GET["pagina"]; 
    } else { 
        $pagina=1; 
    };

    $paginaComienzo = ($pagina-1) * $porPagina;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administración de Colegiados</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
            <div class="titulo row">
            	<div class="left">
            		<h1>Administración - Colegiados</h1>
            	</div>
            	<div class="right">
					<button class="btn-success crear right"  onclick="location.href='AdminColegiadoCrear.php'"><i class="fas fa-plus"> Crear</i></button>
				</div>
			</div>
            
            
			<?php 
				$columns = array('NumColegiado', 'Nombre', 'Apellidos', 'Rol'); 
				$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
				$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

				if ($result=$conn->query('SELECT NumColegiado, Nombre, Apellidos, Rol FROM colegiado ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina)) {
					$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
					$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
					$add_class = ' class="highlight"';
				}
			?>
			<table class="table table-sm table-hover col-md-11">
				<thead>
					<tr>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?pagina=<?php echo $pagina; ?>&column=NumColegiado&order=<?php echo $asc_or_desc; ?>">Nº de colegiado<i class="fas fa-sort<?php echo $column == 'NumColegiado' ? '-' . $up_or_down : '' ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?pagina=<?php echo $pagina; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre <i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : ''; ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?pagina=<?php echo $pagina; ?>&column=Apellidos&order=<?php echo $asc_or_desc; ?>">Apellidos <i class="fas fa-sort<?php echo $column == 'Apellidos' ? '-' . $up_or_down : ''; ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminColegiados.php?pagina=<?php echo $pagina; ?>&column=Rol&order=<?php echo $asc_or_desc; ?>">Rol<i class="fas fa-sort<?php echo $column == 'Rol' ? '-' . $up_or_down : ''; ?>"></i></a></th>
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
			<nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                        $clausulaORD = '';
                        if(isset($_GET['column'])){$clausulaORD .= '&colunm='.$_GET['column'];}
                        if(isset($_GET['order'])){$clausulaORD .= '&order='.$_GET['order'];}
                        $prevPage = $pagina-1; 
                        $nextPage = $pagina+1;

                        $paginacionBotones=paginacionBotones($maxPaginas, $pagina);

                        if($pagina<=1){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminColegiados.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminColegiados.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                        	if($paginacionBotones['Inicio']==$pagina){
								echo '<li class="page-item active"><a class="page-link" href="AdminColegiados.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                        	} else {
								echo '<li class="page-item"><a class="page-link" href="AdminColegiados.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                        	}
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminColegiados.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminColegiados.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
	</body>
</html>
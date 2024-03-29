<?php 
	if(!isset($_SESSION)) { session_start(); } 

	if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
	    echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
	}

    require_once 'partials/referencias.php';

	//Paginación de la tabla de comisiones
    $numComisiones = $conn->query("SELECT * FROM comisiontap")->num_rows;
    $maxPaginas = ceil($numComisiones/$porPagina);

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

				if ($result=$conn->query('(SELECT CT.IdComision, TL.Nombre TipoLista, CONCAT(CT.Presidente, " - ", C.Nombre, " ", C.Apellidos) Presidente FROM comisiontap CT, tipolista TL, colegiado C WHERE CT.IdComision=TL.IdComision AND (CT.Presidente=C.NumColegiado OR CT.Presidente IS NULL) GROUP BY CT.IdComision) UNION (SELECT CT.IdComision, NULL TipoLista, CONCAT(CT.Presidente, " - ", C.Nombre, " ", C.Apellidos) Presidente FROM comisiontap CT, colegiado C WHERE CT.IdComision NOT IN (SELECT IdComision FROM tipolista) AND (CT.Presidente=C.NumColegiado OR CT.Presidente IS NULL)) ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina)) {
					$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
					$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
					$add_class = ' class="highlight"';
				}
			?>

			<table class="table table-sm table-hover col-md-11">
				<thead>
					<tr>
						<th class="text-center" scope="col"><a href="AdminComisiones.php?pagina=<?php echo $pagina; ?>&column=IdComision&order=<?php echo $asc_or_desc; ?>">Id. de comisión<i class="fas fa-sort<?php echo $column == 'IdComision' ? '-' . $up_or_down : '' ?>"></i></a></th>
						<th class="text-center" scope="col"><a href="AdminComisiones.php?pagina=<?php echo $pagina; ?>&column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo de lista <i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : ''; ?>"></i></a></th>
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
	                    <?php
	                    	if($row['TipoLista']==NULL){
	                    		echo '<td class="text-center"><a href="procesarEliminarComision.php?idComision='.$row['IdComision'].'" onclick="return confirm(\'¿Está seguro que desea borrar la comisión?\')"><i class="fas fa-times red"></i></a></td>';
	                    	} else {
	                    		echo '<td></td>';
	                    	}
	                    ?>
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
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminComisiones.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminComisiones.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                        	if($paginacionBotones['Inicio']==$pagina){
								echo '<li class="page-item active"><a class="page-link" href="AdminComisiones.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                        	} else {
								echo '<li class="page-item"><a class="page-link" href="AdminComisiones.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                        	}
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminComisiones.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminComisiones.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
	</body>
</html>
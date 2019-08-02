<?php 
    if(!isset($_SESSION)) { session_start(); } 

    if (!isset($_SESSION['SesionRol'])) {
        echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
    }

    require_once 'partials/referencias.php';

    //Paginación de la tabla de proyectos
    $consProyectos = "SELECT * FROM servicioactuacion WHERE NumColegiado=".$_SESSION['SesionNumColegiado']." OR NumColegiadoRevisor=".$_SESSION['SesionNumColegiado']." OR NumColegiadoTutela=".$_SESSION['SesionNumColegiado'];
    $numProyectos = $conn->query($consProyectos)->num_rows;
    $maxPaginas = ceil($numProyectos/$porPagina);

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
		<title>Mis Proyectos</title>
	</head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Mis Proyectos</h1>
            </div>
            
            
            <?php 
                $columns = array('IdProyecto', 'Funcion');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = '(SELECT SE.IdSolicitudAct IdProyecto, "Profesional" Funcion, SE.EstadoProyecto Estado FROM servicioactuacion SE WHERE SE.NumColegiado='.$_SESSION['SesionNumColegiado'].') 
                UNION
                (SELECT SE.IdSolicitudAct, "Revisor" Funcion, SE.EstadoVisado Estado FROM servicioactuacion SE WHERE SE.NumColegiadoRevisor='.$_SESSION['SesionNumColegiado'].')
                UNION
                (SELECT SE.IdSolicitudAct, "Tutelador" Funcion, SE.EstadoProyecto Estado FROM servicioactuacion SE WHERE SE.NumColegiadoTutela='.$_SESSION['SesionNumColegiado'].') ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="ColegMisProyectos.php?pagina=<?php echo $pagina; ?>&column=IdProyecto&order=<?php echo $asc_or_desc; ?>">Id. del proyecto<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="ColegMisProyectos.php?pagina=<?php echo $pagina; ?>&column=Funcion&order=<?php echo $asc_or_desc; ?>">Función<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while ($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '  <td class="text-center">'.$row['IdProyecto'].'</td>';
                            echo '  <td class="text-center">'.$row['Funcion'].'</td>';
                            echo '  <td class="text-center">'.$row['Estado'].'</td>';
                            echo '<tr>';
                        }
                    ?>
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
                            echo '<li class="page-item disabled"><a class="page-link" href="ColegMisProyectos.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="ColegMisProyectos.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                            if($paginacionBotones['Inicio']==$pagina){
                                echo '<li class="page-item active"><a class="page-link" href="ColegMisProyectos.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="ColegMisProyectos.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            }
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="ColegMisProyectos.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="ColegMisProyectos.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>
            
            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
    </body>
</html>
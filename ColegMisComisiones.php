<?php 
    if(!isset($_SESSION)) { session_start(); } 

    if (!isset($_SESSION['SesionRol'])) {
        echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
    }

    require_once 'partials/referencias.php';

    //Paginación de la tabla de comisiones
    $consComisiones = "SELECT * FROM miembrocomision WHERE NumColegiado=".$_SESSION['SesionNumColegiado'];
    $numComisiones = $conn->query($consComisiones)->num_rows;
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
		<title>Mis Comisiones</title>
	</head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Mis Comisiones</h1>
            </div>
                        
            <?php 
                $columns = array('IdComision','TipoLista', 'Cargo');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT TL.IdComision, TL.Nombre TipoLista, (SELECT IF(C.Presidente='.$_SESSION['SesionNumColegiado'].', "Presidente", "Miembro")) Cargo FROM miembrocomision M, comisiontap C, tipolista TL WHERE M.IdComision=C.IdComision AND C.IdComision=TL.IdComision AND M.NumColegiado='.$_SESSION['SesionNumColegiado'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-8">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="ColegMisComisiones.php?pagina=<?php echo $pagina; ?>&column=IdComision&order=<?php echo $asc_or_desc; ?>">Id. de comisión<i class="fas fa-sort<?php echo $column == 'IdComision' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="ColegMisComisiones.php?pagina=<?php echo $pagina; ?>&column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="ColegMisComisiones.php?pagina=<?php echo $pagina; ?>&column=Cargo&order=<?php echo $asc_or_desc; ?>">Cargo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while ($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '  <td class="text-center">'.$row['IdComision'].'</td>';
                            echo '  <td class="text-center">'.$row['TipoLista'].'</td>';
                            echo '  <td class="text-center">'.$row['Cargo'].'</td>';
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
                            echo '<li class="page-item disabled"><a class="page-link" href="ColegMisComisiones.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="ColegMisComisiones.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                            if($paginacionBotones['Inicio']==$pagina){
                                echo '<li class="page-item active"><a class="page-link" href="ColegMisComisiones.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="ColegMisComisiones.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            }
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="ColegMisComisiones.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="ColegMisComisiones.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>
            
            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
    </body>
</html>
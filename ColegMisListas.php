<?php 
    if(!isset($_SESSION)) { session_start(); } 
    if (!isset($_SESSION['SesionRol'])) {
        echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
    }

    require_once 'partials/referencias.php';

    //Paginación de la tabla de listas
    $consInscripciones = "SELECT * FROM inscripcion WHERE NumColegiado=".$_SESSION['SesionNumColegiado'];
    $numInscripciones = $conn->query($consInscripciones)->num_rows;
    $maxPaginas = ceil($numInscripciones/$porPagina);

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
		<title>Mis Listas</title>
	</head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Mis Listas</h1>
            </div>
            
            <?php 
                $columns = array('IdLista', 'TipoLista', 'Publica', 'Territorio');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT L.IdLista, L.Publica, TL.Nombre TipoLista, T.Nombre Territorio, I.Estado FROM inscripcion I, lista l, tipolista TL, territorio T WHERE I.IdLista=L.IdLista AND L.IdTipoLista=TL.IdTipoLista AND L.Territorio=T.IdTerritorio AND I.NumColegiado='.$_SESSION['SesionNumColegiado'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="ColegMisListas.php?pagina=<?php echo $pagina; ?>&column=IdLista&order=<?php echo $asc_or_desc; ?>">Id. de lista<i class="fas fa-sort<?php echo $column == 'IdLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col">Grupo</th>
                        <th class="text-center" scope="col"><a href="ColegMisListas.php?pagina=<?php echo $pagina; ?>&column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="ColegMisListas.php?pagina=<?php echo $pagina; ?>&column=Publica&order=<?php echo $asc_or_desc; ?>">Pública <i class="fas fa-sort<?php echo $column == 'Publica' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="ColegMisListas.php?pagina=<?php echo $pagina; ?>&column=Territorio&order=<?php echo $asc_or_desc; ?>">Territorio <i class="fas fa-sort<?php echo $column == 'Territorio' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col">Precediendo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while ($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '  <td class="text-center">'.$row['IdLista'].'</td>';
                            if(is_null($row['Publica'])){
                                echo '<td class="text-center">Revisores</td>';
                                echo '<td class="text-center">'.$row['TipoLista'].'</td>';
                                echo '<td class="text-center">No</td>';
                            } else{
                                echo '<td class="text-center">Profesionales</td>';
                                echo '<td class="text-center">'.$row['TipoLista'].'</td>';
                                if($row['Publica'] == 0){
                                    echo '<td class="text-center">No</td>';
                                } else{
                                    echo '<td class="text-center">Si</td>';
                                }
                            }
                            echo '  <td class="text-center">'.$row['Territorio'].'</td>';

                            if ($row['Estado']=='Esperando Turno') {
                                $consPrecendiendo = "SELECT I.IdLista, COUNT(*) Precediendo FROM inscripcion I, colegiado C, colegiado CB WHERE I.NumColegiado=C.NumColegiado AND IdLista=".$row['IdLista']." AND I.Estado='Esperando Turno' AND CB.NumColegiado=".$_SESSION['SesionNumColegiado']." AND CONCAT(C.Apellidos, ' ', C.Nombre)<CONCAT(CB.Apellidos, ' ', CB.Nombre)  ORDER BY C.Apellidos, C.Nombre;";
                                $prec = $conn->query($consPrecendiendo)->fetch_assoc()['Precediendo'];
                            } else {
                                $consPrecendiendo = "SELECT IdLista, SUM(Precediendo) Suma FROM ((SELECT I.IdLista, COUNT(*) Precediendo FROM inscripcion I, colegiado C, colegiado CB WHERE I.NumColegiado=C.NumColegiado AND IdLista=".$row['IdLista']." AND I.Estado='Esperando Turno' AND CONCAT(C.Apellidos, ' ', C.Nombre)>CONCAT(CB.Apellidos, ' ', CB.Nombre) AND CB.NumColegiado=".$_SESSION['SesionNumColegiado']." ORDER BY C.Apellidos, C.Nombre) UNION
                                (SELECT I.IdLista, COUNT(*) Precediendo FROM inscripcion I, colegiado C, colegiado CB WHERE I.NumColegiado=C.NumColegiado AND IdLista=".$row['IdLista']." AND CB.NumColegiado=".$_SESSION['SesionNumColegiado']." AND CONCAT(C.Apellidos, ' ', C.Nombre)<CONCAT(CB.Apellidos, ' ', CB.Nombre) ORDER BY C.Apellidos, C.Nombre)) AS Precediendo;";
                                $prec = $conn->query($consPrecendiendo)->fetch_assoc()['Suma'];
                            }
                            echo '  <td class="text-center">'.$prec.'</td>';
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
                            echo '<li class="page-item disabled"><a class="page-link" href="ColegMisListas.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="ColegMisListas.php?pagina='.$prevPage.$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                            if($paginacionBotones['Inicio']==$pagina){
                                echo '<li class="page-item active"><a class="page-link" href="ColegMisListas.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="ColegMisListas.php?pagina='.$paginacionBotones['Inicio'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            }
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="ColegMisListas.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="ColegMisListas.php?pagina='.$nextPage.$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="push"></div>
        </div>
        
        <?php require 'partials/footer.php' ?>
    </body>
</html>
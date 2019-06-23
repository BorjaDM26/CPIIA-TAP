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
		<title>Mis Comisiones</title>
	</head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <h1>Mis Comisiones</h1>
            
            <?php 
                $columns = array('TipoLista', 'Cargo');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT TL.Nombre TipoLista, (SELECT IF(C.Presidente='.$_SESSION['SesionNumColegiado'].', "Presidente", "Miembro")) Cargo FROM miembrocomision M, comisiontap C, tipolista TL WHERE M.IdComision=C.IdComision AND C.IdComision=TL.IdComision AND M.NumColegiado='.$_SESSION['SesionNumColegiado'].' ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-8">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="ColegMisComisiones.php?column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="ColegMisComisiones.php?column=Cargo&order=<?php echo $asc_or_desc; ?>">Cargo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while ($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '  <td class="text-center">'.$row['TipoLista'].'</td>';
                            echo '  <td class="text-center">'.$row['Cargo'].'</td>';
                            echo '<tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <?php require 'partials/footer.php' ?>
    </body>
</html>
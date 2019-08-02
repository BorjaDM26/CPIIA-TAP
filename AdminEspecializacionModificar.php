<?php 
    if(!isset($_SESSION)) { session_start(); } 

    if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
        echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
    }

    require_once 'partials/referencias.php';

    //Paginación de la tabla de colegiados
    $numColegiados = $conn->query("SELECT * FROM especializacioncolegiado WHERE IdEspecializacion=".$_REQUEST['idEspecializacion'])->num_rows;
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
		<title>Modificar Especialización</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Modificar Especialización</h1>
            </div>

            <?php 
                $stmt = $conn->query("SELECT * FROM campoespecializacion WHERE IdEspecializacion='".$_REQUEST["idEspecializacion"]."'");
                $row = $stmt->fetch_assoc();
            ?>

            <form id="formModificarEspecializacion" method="POST" action="procesarModificarEspecializacion.php?idEspecializacion=<?php echo $_REQUEST["idEspecializacion"] ?>">
        		<div class="form-row">
                    <div class="form-group campoForm">
                        <label for="nuevoIdEspecializacion" class="etiqueta">Id. de especialización </label>
                        <input class="form-control customInput" type="number" id="nuevoIdEspecializacion" name="nuevoIdEspecializacion" <?php echo 'value="'.$row['IdEspecializacion'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="nombre" class="etiqueta">Nombre </label>
                        <input class="form-control customInput" type="text" id="nombre" name="nombre" <?php echo 'value="'.$row['Nombre'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="descripcion" class="etiqueta">Descripción </label>
                        <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="94" required="true" > <?php echo $row['Descripcion']; ?> </textarea>
                    </div>
        		</div>
                <div class="botonera">
                    <input type="submit" class="btn btn-success" value="Modificar Especialización" />
                    <input type="reset" value="Reiniciar Formulario"/>
                    <button type="button" class="volver" onclick="location.href='AdminEspecializaciones.php'">Cancelar</button>
                </div>
            </form>

            <!-- Colegiados con conocimientos en dicha especialización -->
            <div class="subtitulo row">
                <h3>Colegiados especializados</h3>
            </div>

            <?php 
                $columns = array('NumColegiado','Nombre', 'Apellidos', 'CorreoElectronico', 'TelefonoProfesional', 'URL');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT C.NumColegiado, C.Nombre, C.Apellidos, C.CorreoElectronico, C.TelefonoProfesional, C.URL FROM especializacioncolegiado EC, colegiado C WHERE EC.NumColegiado=C.NumColegiado AND EC.IdEspecializacion='.$_GET['idEspecializacion'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminEspecializacionModificar.php?pagina=<?php echo $pagina; ?>&idEspecializacion=<?php echo $_REQUEST["idEspecializacion"]; ?>&column=NumColegiado&order=<?php echo $asc_or_desc; ?>">Nº de colegiado <i class="fas fa-sort<?php echo $column == 'NumColegiado' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminEspecializacionModificar.php?pagina=<?php echo $pagina; ?>&idEspecializacion=<?php echo $_REQUEST["idEspecializacion"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre <i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminEspecializacionModificar.php?pagina=<?php echo $pagina; ?>&idEspecializacion=<?php echo $_REQUEST["idEspecializacion"]; ?>&column=Apellidos&order=<?php echo $asc_or_desc; ?>">Apellidos <i class="fas fa-sort<?php echo $column == 'Apellidos' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col">Correo electrónico</th>
                        <th class="text-center" scope="col">Teléfono</th>
                        <th class="text-center" scope="col">Web personal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while (isset($result) && $row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?php echo $row['NumColegiado']; ?></td>
                        <td class="text-center"><?php echo $row['Nombre']; ?></td>
                        <td class="text-center"><?php echo $row['Apellidos']; ?></td>
                        <td class="text-center"><?php echo $row['CorreoElectronico']; ?></td>
                        <td class="text-center"><?php echo $row['TelefonoProfesional']; ?></td>
                        <td class="text-center">
                            <?php echo "<a href=\"http://".$row['URL']."\">".$row['URL']."</a>"; ?>
                        </td>
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
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminEspecializacionModificar.php?pagina='.$prevPage.'&idEspecializacion='.$_REQUEST['idEspecializacion'].$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminEspecializacionModificar.php?pagina='.$prevPage.'&idEspecializacion='.$_REQUEST['idEspecializacion'].$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                            if($paginacionBotones['Inicio']==$pagina){
                                echo '<li class="page-item active"><a class="page-link" href="AdminEspecializacionModificar.php?pagina='.$paginacionBotones['Inicio'].'&idEspecializacion='.$_REQUEST['idEspecializacion'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="AdminEspecializacionModificar.php?pagina='.$paginacionBotones['Inicio'].'&idEspecializacion='.$_REQUEST['idEspecializacion'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            }
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminEspecializacionModificar.php?pagina='.$nextPage.'&idEspecializacion='.$_REQUEST['idEspecializacion'].$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminEspecializacionModificar.php?pagina='.$nextPage.'&idEspecializacion='.$_REQUEST['idEspecializacion'].$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
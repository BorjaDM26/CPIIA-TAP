<?php 
    if(!isset($_SESSION)) { session_start(); } 

    if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
        echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
    }

    require_once 'partials/referencias.php';

    //Paginación de la tabla de miembros
    $numMiembros = $conn->query("SELECT * FROM miembrocomision WHERE IdComision=".$_REQUEST['idComision'])->num_rows;
    $maxPaginas = ceil($numMiembros/$porPagina);

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
		<title>Modificar Comisión</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Modificar Comisión</h1>
            </div>

            <?php 
                $stmt = $conn->query("(SELECT CT.IdComision, TL.Nombre TipoLista, CONCAT(CT.Presidente, ' - ', C.Nombre, ' ', C.Apellidos) Presidente  FROM comisiontap CT, tipolista TL, colegiado C  WHERE CT.IdComision=TL.IdComision AND (CT.Presidente=C.NumColegiado OR CT.Presidente IS NULL) AND CT.IdComision=".$_REQUEST["idComision"]."  GROUP BY CT.IdComision) 
                UNION
                (SELECT CT.IdComision, NULL TipoLista, CONCAT(CT.Presidente, ' - ', C.Nombre, ' ', C.Apellidos) Presidente FROM comisiontap CT, colegiado C WHERE CT.IdComision NOT IN (SELECT IdComision FROM tipolista) AND (CT.Presidente=C.NumColegiado OR CT.Presidente IS NULL) AND CT.IdComision=".$_REQUEST["idComision"].");");
                $row = $stmt->fetch_assoc();
            ?>

            <form id="formModificarComision" method="POST" action="procesarModificarComision.php?idComision=<?php echo $_REQUEST["idComision"] ?>">
        		<div class="form-row">
                    <div class="form-group campoForm">
                        <label for="nuevoIdComision" class="etiqueta">Id. de comisión </label>
                        <input class="form-control customInput" type="number" id="nuevoIdComision" name="nuevoIdComision" <?php echo 'value="'.$row['IdComision'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="tipoLista" class="etiqueta">Tipo de lista </label>
                        <select class="form-control customInput" name="tipoLista" id="tipoLista" readonly="true">
                            <?php 
                                echo '<option value="'.$row['TipoLista'].'" selected>'.$row['TipoLista'].'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group campoForm">
                        <label for="presidente" class="etiqueta">Presidente </label>
                        <select class="form-control customInput" name="presidente" id="presidente">
                            <?php 
                                echo '<option value=""> </option>';

                                $stmtMiembrosComision = $conn->query("SELECT C.NumColegiado, CONCAT(C.NumColegiado, ' - ', C.Nombre, ' ', C.Apellidos) Miembro FROM miembrocomision M, colegiado C WHERE M.NumColegiado=C.NumColegiado AND M.IdComision=".$_REQUEST["idComision"]);

                                while ($rowMiembrosComision = $stmtMiembrosComision->fetch_assoc()){
                                    if($rowMiembrosComision['Miembro']==$row['Presidente']){
                                        echo '<option value="'.$rowMiembrosComision['NumColegiado'].'" selected>'.$rowMiembrosComision['Miembro'].'</option>';
                                    } else {
                                        echo '<option value="'.$rowMiembrosComision['NumColegiado'].'">'.$rowMiembrosComision['Miembro'].'</option>';
                                    }
                                } 
                            ?>
                        </select>
                    </div>
        		</div>
                <div class="botonera">
                    <input type="submit" class="btn btn-success" value="Modificar Comisión" />
                    <input type="reset" value="Reiniciar Formulario"/>
                    <button type="button" class="volver" onclick="location.href='AdminComisiones.php'">Cancelar</button>
                </div>
            </form>

            <!-- Colegiados que forman parte de la comisión -->
            <div class="subtitulo row">
                <h3>Miembros</h3>
            </div>

            <?php 
                $columns = array('NumColegiado','Nombre', 'Apellidos', 'CorreoElectronico', 'TelefonoProfesional', 'URL');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT C.NumColegiado, C.Nombre, C.Apellidos, C.CorreoElectronico, C.TelefonoProfesional, C.URL FROM miembrocomision M, colegiado C WHERE M.NumColegiado=C.NumColegiado AND M.IdComision='.$_GET['idComision'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminComisionModificar.php?pagina=<?php echo $pagina; ?>&idComision=<?php echo $_REQUEST["idComision"]; ?>&column=NumColegiado&order=<?php echo $asc_or_desc; ?>">Nº de colegiado <i class="fas fa-sort<?php echo $column == 'NumColegiado' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminComisionModificar.php?pagina=<?php echo $pagina; ?>&idComision=<?php echo $_REQUEST["idComision"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre <i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminComisionModificar.php?pagina=<?php echo $pagina; ?>&idComision=<?php echo $_REQUEST["idComision"]; ?>&column=Apellidos&order=<?php echo $asc_or_desc; ?>">Apellidos <i class="fas fa-sort<?php echo $column == 'Apellidos' ? '-' . $up_or_down : ''; ?>"></i></a></th>
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
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminComisionModificar.php?pagina='.$prevPage.'&idComision='.$_REQUEST['idComision'].$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminComisionModificar.php?pagina='.$prevPage.'&idComision='.$_REQUEST['idComision'].$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotones['Inicio'] <= $paginacionBotones['Fin']){
                            if($paginacionBotones['Inicio']==$pagina){
                                echo '<li class="page-item active"><a class="page-link" href="AdminComisionModificar.php?pagina='.$paginacionBotones['Inicio'].'&idComision='.$_REQUEST['idComision'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="AdminComisionModificar.php?pagina='.$paginacionBotones['Inicio'].'&idComision='.$_REQUEST['idComision'].$clausulaORD.'">'.$paginacionBotones['Inicio'].'</a></li>';
                            }
                            $paginacionBotones['Inicio']++;
                        }
                        if($pagina>=$maxPaginas){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminComisionModificar.php?pagina='.$nextPage.'&idComision='.$_REQUEST['idComision'].$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminComisionModificar.php?pagina='.$nextPage.'&idComision='.$_REQUEST['idComision'].$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
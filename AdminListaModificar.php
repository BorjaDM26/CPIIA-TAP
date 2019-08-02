<?php 
    if(!isset($_SESSION)) { session_start(); } 

    if (!isset($_SESSION['SesionRol']) || ($_SESSION['SesionRol']!=='Responsable')) {
        echo'<script type="text/javascript"> alert("Acceso restringido."); window.location.href="index.php"; </script>';
    }

    require_once 'partials/referencias.php';

    //Paginación de la tabla de colegiados
    $numColegiados = $conn->query("SELECT * FROM inscripcion WHERE IdLista=".$_REQUEST['idLista'])->num_rows;
    $maxPaginasColegiados = ceil($numColegiados/$porPagina);
    if (isset($_GET["paginaColegiados"])) { 
        $paginaColegiados  = $_GET["paginaColegiados"]; 
    } else { 
        $paginaColegiados=1; 
    };
    $paginaColegiadosComienzo = ($paginaColegiados-1) * $porPagina;

    //Paginación de la tabla de especializaciones
    $numEspecs = $conn->query("SELECT * FROM especializacionlista E, lista L WHERE L.IdTipoLista=E.IdTipoLista AND L.IdLista=".$_REQUEST['idLista'])->num_rows;
    $maxPaginasEspecs = ceil($numEspecs/$porPagina);
    if (isset($_GET["paginaEspecs"])) { 
        $paginaEspecs  = $_GET["paginaEspecs"]; 
    } else { 
        $paginaEspecs=1; 
    }
    $paginaEspecsComienzo = ($paginaEspecs-1) * $porPagina;

    //Paginación de la tabla de proyectos
    $numProyectos = $conn->query("SELECT * FROM solicitudactuacion WHERE IdLista=".$_REQUEST['idLista'])->num_rows;
    $maxPaginasProyectos = ceil($numProyectos/$porPagina);
    if (isset($_GET["paginaProyectos"])) { 
        $paginaProyectos  = $_GET["paginaProyectos"]; 
    } else { 
        $paginaProyectos=1; 
    }
    $paginaProyectosComienzo = ($paginaProyectos-1) * $porPagina;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Modificar Lista</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Modificar Lista</h1>
            </div>

            <?php 
                $stmt = $conn->query("SELECT * FROM lista WHERE IdLista='".$_REQUEST["idLista"]."'");
                $row = $stmt->fetch_assoc();
            ?>

			<form id="formModificarLista" method="POST" action="procesarModificarLista.php?idLista=<?php echo $_REQUEST["idLista"] ?>">
				<div class="form-row">
                    <div class="form-group campoForm">
                        <label for="nuevoIdLista" class="etiqueta">Id. de lista </label>
                        <input class="form-control customInput" type="number" id="nuevoIdLista" name="nuevoIdLista" <?php echo 'value="'.$row['IdLista'].'"'; ?> readonly="true"/>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="grupo" class="etiqueta">Grupo </label>
                        <select class="form-control customInput" name="grupo" id="grupo" onchange="showPublicoTerritoriosXTipoLst(this.value)">
                            <?php
                            if($row['Publica']==null){
                                echo '<option value="Profesionales">Profesionales</option>';
                                echo '<option value="Revisores" selected>Revisores</option>';
                            } else {
                                echo '<option value="Profesionales" selected>Profesionales</option>';
                                echo '<option value="Revisores">Revisores</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group campoForm">
                    	<label for="tipoLista" class="etiqueta">Tipo de lista </label>
                        <select class="form-control customInput" name="tipoLista" id="tipoLista">
                            <?php 
                                $stmtTipoLst = $conn->query("SELECT * FROM tipolista;");

                                while ($rowTipoLst = $stmtTipoLst->fetch_assoc()){
                                    if($rowTipoLst['IdTipoLista']==$row['IdTipoLista']){
                                        echo "<option value=\"".$rowTipoLst['IdTipoLista']."\" selected>".$rowTipoLst['Nombre']."</option>";
                                    } else {
                                        echo "<option value=\"".$rowTipoLst['IdTipoLista']."\">".$rowTipoLst['Nombre']."</option>";
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-row" id="auxPubTerritXGrupo">
                        <div class="form-group campoForm">
                        	<label for="publica" class="etiqueta">Pública </label>
                            <select class="form-control customInput" name="publica" id="publica" <?php if($row['Publica']==null){echo 'disabled="true"';} ?>>
                            <?php
                            if($row['Publica']==1){
                                echo '<option value="1" selected>Si</option>';
                                echo '<option value="0">No</option>';
                            } else {
                                echo '<option value="1">Si</option>';
                                echo '<option value="0" selected>No</option>';
                            }
                            ?>
                            </select>
                        </div>
                        <div class="form-group campoForm">
                        	<label for="territorio" class="etiqueta">Territorio </label>
                            <select class="form-control customInput" name="territorio" id="territorio" <?php if($row['Publica']==null){echo 'disabled="true"';} ?>>
                                <?php 
                                    $stmtTerrit = $conn->query("SELECT * FROM territorio;");

                                    while ($rowTerrit = $stmtTerrit->fetch_assoc()){
                                        if ($rowTerrit['IdTerritorio']==$row['Territorio']) {
                                            echo "<option value=\"".$rowTerrit['IdTerritorio']."\" selected>".$rowTerrit['Nombre']."</option>";
                                        } else {
                                            echo "<option value=\"".$rowTerrit['IdTerritorio']."\">".$rowTerrit['Nombre']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
				</div>
                <div class="botonera">
    			    <input type="submit" class="btn btn-success" value="Modificar Lista" />
            		<input type="reset" value="Reiniciar Formulario"/>
    			    <button type="button" class="volver" onclick="location.href='AdminListas.php'">Cancelar</button>
                </div>
			</form>

            <!-- Colegiados inscritos en la lista -->
            <div class="subtitulo row">
                <h3>Colegiados inscritos</h3>
            </div>

            <?php 
                $columns = array('NumColegiado','Nombre', 'Apellidos');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT C.NumColegiado, C.Nombre, C.Apellidos, C.CorreoElectronico, I.Estado FROM inscripcion I, colegiado C WHERE I.NumColegiado=C.NumColegiado AND I.IdLista='.$_GET['idLista'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaColegiadosComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>
            <div class="form-row">
                <table class="table table-sm table-hover col-md-11">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaColegiados=<?php echo $paginaColegiados; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=NumColegiado&order=<?php echo $asc_or_desc; ?>">Nº de colegiado<i class="fas fa-sort<?php echo $column == 'NumColegiado' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                            <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaColegiados=<?php echo $paginaColegiados; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre <i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                            <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaColegiados=<?php echo $paginaColegiados; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=Apellidos&order=<?php echo $asc_or_desc; ?>">Apellidos <i class="fas fa-sort<?php echo $column == 'Apellidos' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                            <th class="text-center" scope="col">Correo electrónico</th>
                            <th class="text-center" scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <col width="190"><col width="200"><col width="200"><col width="200"><col width="300">
                        <?php while (isset($result) && $row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $row['NumColegiado']; ?></td>
                            <td class="text-center"><?php echo $row['Nombre']; ?></td>
                            <td class="text-center"><?php echo $row['Apellidos']; ?></td>
                            <td class="text-center"><?php echo $row['CorreoElectronico']; ?></td>
                            <td class="text-center">
                                <select class="form-control customInput inTable" name="estado" id="tutelador" <?php echo 'onchange="actualizarEstadoInscripcion(this.value, '.$_REQUEST['idLista'].', '.$row['NumColegiado'].')"'; ?>>
                                    <?php 
                                        foreach ($estadosInscripcion as $i => $value) {
                                            if($value == $row['Estado']){
                                                echo "<option value='$i' selected>$value</option>";
                                            } else {
                                                echo "<option value='$i'>$value</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                        $clausulaORD = '';
                        if(isset($_GET['column'])){$clausulaORD .= '&colunm='.$_GET['column'];}
                        if(isset($_GET['order'])){$clausulaORD .= '&order='.$_GET['order'];}
                        $prevPage = $paginaColegiados-1; 
                        $nextPage = $paginaColegiados+1;

                        $paginacionBotonesColegiados=paginacionBotones($maxPaginasColegiados, $paginaColegiados);

                        if($paginaColegiados<=1){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminListaModificar.php?paginaColegiados='.$prevPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaColegiados='.$prevPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotonesColegiados['Inicio'] <= $paginacionBotonesColegiados['Fin']){
                            if($paginacionBotonesColegiados['Inicio']==$paginaColegiados){
                                echo '<li class="page-item active"><a class="page-link" href="AdminListaModificar.php?paginaColegiados='.$paginacionBotonesColegiados['Inicio'].'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">'.$paginacionBotonesColegiados['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaColegiados='.$paginacionBotonesColegiados['Inicio'].'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">'.$paginacionBotonesColegiados['Inicio'].'</a></li>';
                            }
                            $paginacionBotonesColegiados['Inicio']++;
                        }
                        if($paginaColegiados>=$maxPaginasColegiados){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminListaModificar.php?paginaColegiados='.$nextPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaColegiados='.$nextPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>


            <!-- Especializaciones requeridas para inscribirse en la lista -->
            <div class="subtitulo row">
                <h3>Especializaciones requeridas</h3>
            </div>
                        
            <?php 
                $columns = array('IdEspecializacion', 'Nombre');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT E.* FROM lista L, tipolista TL, especializacionlista EL, campoespecializacion E WHERE L.IdTipoLista=TL.IdTipoLista AND TL.IdTipoLista=EL.IdTipoLista AND EL.IdEspecializacion=E.IdEspecializacion AND L.IdLista='.$_GET['idLista'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaEspecsComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaEspecs=<?php echo $paginaEspecs; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=IdEspecializacion&order=<?php echo $asc_or_desc; ?>">Id. de especialización<i class="fas fa-sort<?php echo $column == 'IdEspecializacion' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaEspecs=<?php echo $paginaEspecs; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre<i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <col width="190"><col width="150"><col width="600">
                    <?php 
                        while ($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '  <td class="text-center">'.$row['IdEspecializacion'].'</td>';
                            echo '  <td class="text-center">'.$row['Nombre'].'</td>';
                            echo '  <td class="text-justified">'.$row['Descripcion'].'</td>';
                            echo '<tr>';
                        }
                    ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                        $prevPage = $paginaEspecs-1; 
                        $nextPage = $paginaEspecs+1;

                        $paginacionBotonesEspecs=paginacionBotones($maxPaginasEspecs, $paginaEspecs);

                        if($paginaEspecs<=1){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminListaModificar.php?paginaEspecs='.$prevPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaEspecs='.$prevPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotonesEspecs['Inicio'] <= $paginacionBotonesEspecs['Fin']){
                            if($paginacionBotonesEspecs['Inicio']==$paginaEspecs){
                                echo '<li class="page-item active"><a class="page-link" href="AdminListaModificar.php?paginaEspecs='.$paginacionBotonesEspecs['Inicio'].'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">'.$paginacionBotonesEspecs['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaEspecs='.$paginacionBotonesEspecs['Inicio'].'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">'.$paginacionBotonesEspecs['Inicio'].'</a></li>';
                            }
                            $paginacionBotonesEspecs['Inicio']++;
                        }
                        if($paginaEspecs>=$maxPaginasEspecs){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminListaModificar.php?paginaEspecs='.$nextPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaEspecs='.$nextPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>


            <!-- Proyectos asignados -->
            <div class="subtitulo row">
                <h3>Proyectos asignados</h3>
            </div>
                        
            <?php 
                $columns = array('IdSolicitudAct', 'Nombre');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT S.IdSolicitudAct, S.Nombre, S.CorreoElectronico, S.Telefono, S.Estado FROM lista L, solicitudactuacion S WHERE L.IdLista=S.IdLista AND L.IdLista='.$_GET['idLista'].' ORDER BY '.$column.' '.$sort_order.' LIMIT '.$paginaProyectosComienzo.', '.$porPagina;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaProyectos=<?php echo $paginaProyectos; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=IdSolicitud&order=<?php echo $asc_or_desc; ?>">Id. del proyecto<i class="fas fa-sort<?php echo $column == 'IdSolicitud' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminListaModificar.php?paginaProyectos=<?php echo $paginaProyectos; ?>&idLista=<?php echo $_REQUEST["idLista"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Solicitante<i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col">Correo electrónico</th>
                        <th class="text-center" scope="col">Teléfono</th>
                        <th class="text-center" scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while ($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '  <td class="text-center">'.$row['IdSolicitudAct'].'</td>';
                            echo '  <td class="text-center">'.$row['Nombre'].'</td>';
                            echo '  <td class="text-center">'.$row['CorreoElectronico'].'</td>';
                            echo '  <td class="text-center">'.$row['Telefono'].'</td>';
                            echo '  <td class="text-center">'.$row['Estado'].'</td>';
                            echo '<tr>';
                        }
                    ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                        $prevPage = $paginaProyectos-1; 
                        $nextPage = $paginaProyectos+1;

                        $paginacionBotonesProyectos=paginacionBotones($maxPaginasProyectos, $paginaProyectos);

                        if($paginaProyectos<=1){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminListaModificar.php?paginaProyectos='.$prevPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Anterior</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaProyectos='.$prevPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Anterior</a></li>';
                        }
                        while ($paginacionBotonesProyectos['Inicio'] <= $paginacionBotonesProyectos['Fin']){
                            if($paginacionBotonesProyectos['Inicio']==$paginaProyectos){
                                echo '<li class="page-item active"><a class="page-link" href="AdminListaModificar.php?paginaProyectos='.$paginacionBotonesProyectos['Inicio'].'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">'.$paginacionBotonesProyectos['Inicio'].'</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaProyectos='.$paginacionBotonesProyectos['Inicio'].'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">'.$paginacionBotonesProyectos['Inicio'].'</a></li>';
                            }
                            $paginacionBotonesProyectos['Inicio']++;
                        }
                        if($paginaProyectos>=$maxPaginasProyectos){
                            echo '<li class="page-item disabled"><a class="page-link" href="AdminListaModificar.php?paginaProyectos='.$nextPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Siguiente</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="AdminListaModificar.php?paginaProyectos='.$nextPage.'&idLista='.$_REQUEST['idLista'].$clausulaORD.'">Siguiente</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
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
        <title>Consultar Colegiado</title>
    </head>

    <body>
        <?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Consultar Colegiado</h1>
            </div>
            
            <?php 
                $stmt = $conn->query("SELECT * FROM colegiado WHERE numColegiado='".$_REQUEST["numColegiado"]."'");
                $row = $stmt->fetch_assoc();

                if($row["FinInhabilitacion"] == NULL){
                    $fecha='';
                } else {
                    $fecha=date("d/m/Y",strtotime($row['FinInhabilitacion']));
                }
            ?>

            <div class="form-row">
                <div class="form-group campoForm">
                    <label for="numColegiado" class="etiqueta">Número de colegiado </label>
                    <input class="form-control customInput" type="text" id="numColegiado" name="numColegiado" readonly="true" <?php echo 'value="'.$row['NumColegiado'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="nombre" class="etiqueta">Nombre </label>
                    <input class="form-control customInput" type="text" id="nombre" name="nombre" readonly="true" <?php echo 'value="'.$row['Nombre'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="apellidos" class="etiqueta">Apellidos </label>
                    <input class="form-control customInput" type="text" id="apellidos" name="apellidos" readonly="true" <?php echo 'value="'.$row['Apellidos'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="rol" class="etiqueta">Rol </label>
                    <input class="form-control customInput" type="text" id="rol" name="rol" readonly="true" <?php echo 'value="'.$row['Rol'].'"'; ?> />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group campoForm">
                    <label for="domicilio" class="etiqueta">Domicilio profesional </label>
                    <input class="form-control customInput" type="text" id="domicilio" name="domicilio" readonly="true" <?php echo 'value="'.$row['DomicilioProfesional'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="localidad" class="etiqueta">Localidad </label>
                    <input class="form-control customInput" type="text" id="localidad" name="localidad" readonly="true" <?php echo 'value="'.$row['Localidad'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="codigoPostal" class="etiqueta">Código postal </label>
                    <input class="form-control customInput" type="text" id="codigoPostal" name="codigoPostal" readonly="true" <?php echo 'value="'.$row['CodigoPostal'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="provincia" class="etiqueta">Provincia </label>
                    <input class="form-control customInput" type="text" id="provincia" name="provincia" readonly="true" <?php echo 'value="'.$row['Provincia'].'"'; ?> />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group campoForm">
                    <label for="telefonoProfesional" class="etiqueta">Teléfono profesional </label>
                    <input class="form-control customInput" type="text" id="telefonoProfesional" name="telefonoProfesional" readonly="true" <?php echo 'value="'.$row['TelefonoProfesional'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="email" class="etiqueta">Correo electrónico </label>
                    <input class="form-control customInput" type="text" id="email" name="email" readonly="true" <?php echo 'value="'.$row['CorreoElectronico'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="URL" class="etiqueta">Web personal </label>
                    <input class="form-control customInput" type="text" id="URL" name="URL" readonly="true" <?php echo 'value="'.$row['URL'].'"'; ?> />
                </div>
                <div class="form-group campoForm">
                    <label for="finInhabilitacion" class="etiqueta"> Fin de inhabilitación </label>
                    <input class="form-control customInput" type="text" id="finInhabilitacion" name="finInhabilitacion" readonly="true" <?php echo 'value="'.$fecha.'"'; ?> />
                </div>

            </div>
            <button type="button" class="volver" onclick="location.href='AdminColegiados.php'">Volver</button>


            <!-- Listas en las que está inscrito el colegiado -->
            <div class="subtitulo row">
                <h3>Listas a las que pertenece</h3>
            </div>

            <?php 
                $columns = array('IdLista', 'TipoLista', 'Publica', 'Territorio');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT L.IdLista, L.Publica, TL.Nombre TipoLista, T.Nombre Territorio FROM inscripcion I, lista l, tipolista TL, territorio T WHERE I.IdLista=L.IdLista AND L.IdTipoLista=TL.IdTipoLista AND L.Territorio=T.IdTerritorio AND I.NumColegiado='.$_GET['numColegiado'].' ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=IdLista&order=<?php echo $asc_or_desc; ?>">Id. de lista<i class="fas fa-sort<?php echo $column == 'IdLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col">Grupo</th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=Publica&order=<?php echo $asc_or_desc; ?>">Pública <i class="fas fa-sort<?php echo $column == 'Publica' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=Territorio&order=<?php echo $asc_or_desc; ?>">Territorio <i class="fas fa-sort<?php echo $column == 'Territorio' ? '-' . $up_or_down : ''; ?>"></i></a></th>
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
                            echo '<tr>';
                        }
                    ?>
                </tbody>
            </table>


            <!-- Comisiones en las que está participa el colegiado -->
            <div class="subtitulo row">
                <h3>Comisiones en las que participa</h3>
            </div>
                        
            <?php 
                $columns = array('TipoLista', 'Cargo');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT TL.Nombre TipoLista, M.IdComision, (SELECT IF(C.Presidente='.$_SESSION['SesionNumColegiado'].', "Presidente", "Miembro")) Cargo FROM miembrocomision M, comisiontap C, tipolista TL WHERE M.IdComision=C.IdComision AND C.IdComision=TL.IdComision AND M.NumColegiado='.$_GET['numColegiado'].' ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-8">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=IdComision&order=<?php echo $asc_or_desc; ?>">Id. de comisión<i class="fas fa-sort<?php echo $column == 'IdComision' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=TipoLista&order=<?php echo $asc_or_desc; ?>">Tipo<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=Cargo&order=<?php echo $asc_or_desc; ?>">Cargo<i class="fas fa-sort<?php echo $column == 'Cargo' ? '-' . $up_or_down : '' ?>"></i></a></th>
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


            <!-- Especializaciones reconocidas del colegiado -->
            <div class="subtitulo row">
                <h3>Especializaciones reconocidas</h3>
            </div>
                        
            <?php 
                $columns = array('IdEspecializacion', 'Nombre');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT E.* FROM especializacioncolegiado EC, campoespecializacion E WHERE EC.IdEspecializacion=E.IdEspecializacion AND EC.NumColegiado='.$_GET['numColegiado'].' ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=IdEspecializacion&order=<?php echo $asc_or_desc; ?>">Id. de especialización<i class="fas fa-sort<?php echo $column == 'IdEspecializacion' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre<i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : '' ?>"></i></a></th>
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


            <!-- Proyectos asignados al colegiado (como profesional, revisor o tutelador) -->
            <div class="subtitulo row">
                <h3>Proyectos asignados</h3>
            </div>
                        
            <?php 
                $columns = array('IdProyecto', 'Funcion');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = '(SELECT SE.IdSolicitudAct IdProyecto, "Profesional" Funcion, SE.EstadoProyecto Estado FROM servicioactuacion SE WHERE SE.NumColegiado='.$_GET['numColegiado'].') 
                UNION
                (SELECT SE.IdSolicitudAct, "Revisor" Funcion, SE.EstadoVisado Estado FROM servicioactuacion SE WHERE SE.NumColegiadoRevisor='.$_GET['numColegiado'].')
                UNION
                (SELECT SE.IdSolicitudAct, "Tutelador" Funcion, SE.EstadoProyecto Estado FROM servicioactuacion SE WHERE SE.NumColegiadoTutela='.$_GET['numColegiado'].') ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=IdProyecto&order=<?php echo $asc_or_desc; ?>">Id. del proyecto<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminColegiadoConsultar.php?numColegiado=<?php echo $_REQUEST["numColegiado"]; ?>&column=Funcion&order=<?php echo $asc_or_desc; ?>">Función<i class="fas fa-sort<?php echo $column == 'TipoLista' ? '-' . $up_or_down : '' ?>"></i></a></th>
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


            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
    </body>
</html>
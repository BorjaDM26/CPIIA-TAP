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
		<title>Modificar Proyecto</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Modificar Proyecto</h1>
            </div>

            <?php 
                $stmt = $conn->query("SELECT *  FROM solicitudactuacion WHERE IdSolicitudAct=".$_REQUEST["idProyecto"]);
                $row = $stmt->fetch_assoc();
            ?>

    		<div class="form-row">
                <div class="form-group campoForm">
                    <label for="idProyecto" class="etiqueta">Id. Proyecto</label>
                    <input class="form-control customInput" type="number" id="idProyecto" name="idProyecto" <?php echo 'value="'.$row['IdSolicitudAct'].'"'; ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="solicitante" class="etiqueta">Solicitante *</label>
                    <input class="form-control customInput" type="text" id="solicitante" name="solicitante" <?php echo 'value="'.$row['Nombre'].'"'; ?> required="true" readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="visado" class="etiqueta">Visado</label>
                    <select class="form-control customInput" name="visado" id="visado" disabled="true">
                        <?php
                            if($row['Visado']=='0'){
                                echo '<option value="0" selected>No</option>';
                                echo '<option value="1">Si</option>';
                            } else {
                                echo '<option value="0">No</option>';
                                echo '<option value="1" selected>Si</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group campoForm">
                    <label for="fecha" class="etiqueta">Fecha de Solicitud</label>
                    <input class="form-control customInput" type="date" id="fecha" name="fecha" <?php echo 'value="'.$row['FechaSolicitud'].'"'; ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="email" class="etiqueta">Correo Electrónico *</label>
                    <input class="form-control customInput" type="text" id="email" name="email" <?php echo 'value="'.$row['CorreoElectronico'].'"'; ?> required="true" readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="telefono" class="etiqueta">Teléfono</label>
                    <input class="form-control customInput" type="text" id="telefono" name="telefono" <?php echo 'value="'.$row['Telefono'].'"'; ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="estado" class="etiqueta">Estado </label>
                    <select class="form-control customInput" name="estado" id="estado" disabled="true">
                    <?php
                        foreach ($estadosSolicitud as $i => $value) {
                            if($value == $row['Estado']){
                                echo "<option value='$i' selected>$value</option>";
                            } else {
                                echo "<option value='$i'>$value</option>";
                            }
                            
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group campoForm">
                    <label for="lista" class="etiqueta">Lista</label>
                    <select class="form-control customInput" name="lista" id="lista" readonly="true">
                        <?php
                            ;
                            $stmtLst = $conn->query("SELECT L.IdLista, CONCAT(L.IdLista, ' - Profesionales de ', TL.Nombre, ' en ', T.Nombre, IF(L.Publica=1, ' (Pública)', ' (Privada)')) Lista FROM lista L, tipolista TL, territorio T WHERE L.IdTipoLista=TL.IdTipoLista AND L.Territorio=T.IdTerritorio AND L.Publica IS NOT NULL ORDER BY L.IdLista");

                            while ($rowLst = $stmtLst->fetch_assoc()){
                                if ($rowLst['IdLista'] == $row['IdLista']) {
                                    echo "<option value=\"".$rowLst['IdLista']."\" selected>".$rowLst['Lista']."</option>";
                                } else {
                                    echo "<option value=\"".$rowLst['IdLista']."\">".$rowLst['Lista']."</option>";
                                }
                            } 
                        ?>
                    </select>
                </div>
                <div class="form-group campoForm">
                    <label for="descripcion" class="etiqueta">Descripción *</label>
                    <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="80" required="true" readonly="true"> <?php echo $row['Descripcion']; ?> </textarea>
                </div>
    		</div>
            <div class="botonera row">
                <button type="button" class="volver" onclick="location.href='AdminProyectos.php'">Cancelar</button>
            </div>

            <!-- Colegiados a los que les fue asignado el proyecto -->
            <div class="subtitulo row">
                <h3>Encargados</h3>
            </div>

            <?php
                $encargados=$conn->query('SELECT CE.NumColegiado, CE.Nombre, CE.Apellidos, SE.NumColegiadoTutela, SE.EstadoProyecto Estado FROM servicioactuacion SE, colegiado CE WHERE SE.NumColegiado=CE.NumColegiado AND SE.IdSolicitudAct='.$_REQUEST['idProyecto'].' ORDER BY SE.EstadoProyecto');
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Num. Colegiado</th>
                        <th class="text-center" scope="col">Nombre</th>
                        <th class="text-center" scope="col">Apellidos</th>
                        <th class="text-center" scope="col">Tutelador</th>
                        <th class="text-center" scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while (isset($encargados) && $rowEncargado = $encargados->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?php echo $rowEncargado['NumColegiado']; ?></td>
                        <td class="text-center"><?php echo $rowEncargado['Nombre']; ?></td>
                        <td class="text-center"><?php echo $rowEncargado['Apellidos']; ?></td>
                        <td class="text-center">
                            <?php
                                $tutelador = $rowEncargado['NumColegiadoTutela'];
                                if($tutelador != NULL){
                                    $tutelador = $conn->query("SELECT CONCAT(NumColegiado, ' - ', Nombre, ' ', Apellidos) Tutelador FROM colegiado WHERE NumColegiado=".$rowEncargado['NumColegiadoTutela'])->fetch_assoc()['Tutelador'];
                                }
                                echo $tutelador;
                            ?>
                        </td>
                        <td class="text-center"><?php echo $rowEncargado['Estado']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Revisores a los que les fue asignado el proyecto -->
            <div class="subtitulo row">
                <h3>Revisores</h3>
            </div>

            <?php
                $revisores=$conn->query('SELECT SE.NumColegiado IdEncargado, CR.NumColegiado IdRevisor, CR.Nombre, CR.Apellidos, SE.EstadoVisado Estado FROM servicioactuacion SE, colegiado CR WHERE SE.NumColegiadoRevisor=CR.NumColegiado AND SE.IdSolicitudAct='.$_REQUEST['idProyecto'].' ORDER BY SE.EstadoProyecto');
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Num. Colegiado</th>
                        <th class="text-center" scope="col">Nombre</th>
                        <th class="text-center" scope="col">Apellidos</th>
                        <th class="text-center" scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while (isset($revisores) && $rowRevisor = $revisores->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?php echo $rowRevisor['IdRevisor']; ?></td>
                        <td class="text-center"><?php echo $rowRevisor['Nombre']; ?></td>
                        <td class="text-center"><?php echo $rowRevisor['Apellidos']; ?></td>
                        <td class="text-center"><?php echo $rowRevisor['Estado']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
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

            <form id="formModificarProyecto" method="POST" action="procesarModificarProyecto.php?idProyecto=<?php echo $_REQUEST["idProyecto"] ?>">
        		<div class="form-row">
                    <div class="form-group campoForm">
                        <label for="idProyecto" class="etiqueta">Id. Proyecto</label>
                        <input class="form-control customInput" type="number" id="idProyecto" name="idProyecto" <?php echo 'value="'.$row['IdSolicitudAct'].'"'; ?> readonly="true"/>
                    </div>
                    <div class="form-group campoForm">
                        <label for="solicitante" class="etiqueta">Solicitante *</label>
                        <input class="form-control customInput" type="text" id="solicitante" name="solicitante" <?php echo 'value="'.$row['Nombre'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="visado" class="etiqueta">Visado</label>
                        <select class="form-control customInput" name="visado" id="visado">
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
                        <label for="fecha" class="etiqueta">Fecha de Solicitud *</label>
                        <input class="form-control customInput" type="date" id="fecha" name="fecha" <?php echo 'value="'.$row['FechaSolicitud'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="email" class="etiqueta">Correo Electrónico *</label>
                        <input class="form-control customInput" type="date" id="email" name="email" <?php echo 'value="'.$row['CorreoElectronico'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="telefono" class="etiqueta">Teléfono *</label>
                        <input class="form-control customInput" type="text" id="telefono" name="telefono" <?php echo 'value="'.$row['Telefono'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="estado" class="etiqueta">Estado </label>
                        <select class="form-control customInput" name="estado" id="estado">
                            <option value='Pendiente de revision'>Pendiente de revision</option>
                            <option value='Pendiente de presupuesto'>Pendiente de presupuesto</option>
                            <option value='En desarrollo'>En desarrollo</option>
                            <option value='Finalizada'>Finalizada</option>
                            <option value='Cancelada'>Cancelada</option>
                            <option value='Pendiente de aceptacion del presupuesto'>Pendiente de aceptacion del presupuesto</option>
                        </select>
                    </div>
                    <div class="form-group campoForm">
                        <label for="lista" class="etiqueta">Lista * </label>
                        <select class="form-control customInput" name="lista" id="lista">
                            <?php
                                ;
                                $stmtLst = $conn->query("SELECT L.IdLista, CONCAT(L.IdLista, IF(L.Publica IS NULL, ' - Revisores de ', ' - Profesionales de '), TL.Nombre, ' en ', T.Nombre, IF(L.Publica=1, ' (Pública)', ' (Privada)')) Lista FROM lista L, tipolista TL, territorio T WHERE L.IdTipoLista=TL.IdTipoLista AND L.Territorio=T.IdTerritorio ORDER BY L.IdLista");

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
                        <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="80" required="true" > <?php echo $row['Descripcion']; ?> </textarea>
                    </div>
        		</div>
                <div class="botonera row">
                    <input type="submit" class="btn btn-success" value="Modificar Proyecto" />
                    <input type="reset" value="Reiniciar Formulario"/>
                    <button type="button" class="volver" onclick="location.href='AdminProyectos.php'">Cancelar</button>
                </div>
            </form>

            <!-- Colegiados a los que les fue asignado el proyecto -->
            <div class="subtitulo row">
                <h3>Colegiado Encargado</h3>
            </div>

            <?php
                $encargados=$conn->query('SELECT CE.NumColegiado, CE.Nombre, CE.Apellidos, SE.NumColegiadoTutela, SE.EstadoProyecto Estado FROM servicioactuacion SE, colegiado CE WHERE SE.NumColegiado=CE.NumColegiado AND SE.IdSolicitudAct='.$_REQUEST['idProyecto'].' ORDER BY CE.NumColegiado');
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
                            <select class="form-control customInput inTable" name="tutelador" id="tutelador">
                                <?php
                                    $tuteladores=$conn->query("SELECT CT.NumColegiado, CONCAT(CT.NumColegiado, ' - ', CT.Nombre, ' ', CT.Apellidos) Tutelador FROM colegiado CT ORDER BY CT.NumColegiado");
                                    while(isset($tuteladores) && $rowTutelador = $tuteladores->fetch_assoc()){
                                        if($rowEncargado['NumColegiadoTutela']==$rowTutelador['NumColegiado']){
                                            echo "<option value=\"".$rowTutelador['NumColegiado']."\" selected>".$rowTutelador['Tutelador']."</option>";
                                        } else {
                                            echo "<option value=\"".$rowTutelador['NumColegiado']."\">".$rowTutelador['Tutelador']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="text-center"><?php echo $rowEncargado['Estado']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
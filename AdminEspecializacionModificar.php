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
                        <label for="nuevoIdEspecializacion" class="etiqueta">Id. Especialización </label>
                        <input class="form-control customInput" type="number" id="nuevoIdEspecializacion" name="nuevoIdEspecializacion" <?php echo 'value="'.$row['IdEspecializacion'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="nombre" class="etiqueta">Nombre </label>
                        <input class="form-control customInput" type="text" id="nombre" name="nombre" <?php echo 'value="'.$row['Nombre'].'"'; ?> />
                    </div>
                    <div class="form-group campoForm">
                        <label for="descripcion" class="etiqueta">Descripción </label>
                        <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="80" required="true" > <?php echo $row['Descripcion']; ?> </textarea>
                    </div>
        		</div>
                <div class="botonera row">
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

                $consulta = 'SELECT C.NumColegiado, C.Nombre, C.Apellidos, C.CorreoElectronico, C.TelefonoProfesional, C.URL FROM especializacioncolegiado EC, colegiado C WHERE EC.NumColegiado=C.NumColegiado AND EC.IdEspecializacion='.$_GET['idEspecializacion'].' ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminEspecializacionModificar.php?idEspecializacion=<?php echo $_REQUEST["idEspecializacion"]; ?>&column=NumColegiado&order=<?php echo $asc_or_desc; ?>">N. Colegiado <i class="fas fa-sort<?php echo $column == 'NumColegiado' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminEspecializacionModificar.php?idEspecializacion=<?php echo $_REQUEST["idEspecializacion"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre <i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminEspecializacionModificar.php?idEspecializacion=<?php echo $_REQUEST["idEspecializacion"]; ?>&column=Apellidos&order=<?php echo $asc_or_desc; ?>">Apellidos <i class="fas fa-sort<?php echo $column == 'Apellidos' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                        <th class="text-center" scope="col">Email</th>
                        <th class="text-center" scope="col">Teléfono</th>
                        <th class="text-center" scope="col">URL</th>

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

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
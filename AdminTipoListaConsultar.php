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
		<title>Consultar Tipo de Lista</title>
	</head>

	<body>
		<?php require 'partials/menuSuperior.php' ?>

        <div class="contenido col-md-9">
            <div class="titulo row">
                <h1>Administración - Consultar Tipo de Lista</h1>
            </div>

            <?php 
                $stmt = $conn->query("SELECT TL.* FROM tipolista TL WHERE TL.IdTipoLista='".$_REQUEST["idTipoLista"]."'");
                $row = $stmt->fetch_assoc();
            ?>

			<div class="form-row">
                <div class="form-group campoForm">
                    <label for="nuevoIdTipoLista" class="etiqueta">Id. de tipo de lista </label>
                    <input class="form-control customInput" type="number" id="nuevoIdTipoLista" name="nuevoIdTipoLista" <?php echo 'value="'.$row['IdTipoLista'].'"'; ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="nombre" class="etiqueta">Nombre </label>
                    <input class="form-control customInput" type="text" id="nombre" name="nombre" <?php echo 'value="'.$row['Nombre'].'"'; ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                	<label for="comision" class="etiqueta">Comisión </label>
                    <select class="form-control customInput" name="comision" id="comision" disabled="true">
                        <?php
                            echo '<option value="'.$row['IdComision'].'" selected>Comision '.$row['IdComision'].'</option>';
                        ?>
                    </select>
                </div>
                <div class="form-group campoForm">
                    <label for="iniciovacaciones" class="etiqueta">Inicio vacacional </label>
                    <input class="form-control customInput" type="text" id="iniciovacaciones" name="iniciovacaciones" <?php if($row['FechaIniVacacional']!=NULL){echo 'value="'.date("d/m/Y", strtotime($row['FechaIniVacacional'])).'"';} ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="finvacaciones" class="etiqueta">Fin vacacional </label>
                    <input class="form-control customInput" type="text" id="finvacaciones" name="finvacaciones" <?php if($row['FechaFinVacacional']!=NULL){echo 'value="'.date("d/m/Y", strtotime($row['FechaFinVacacional'])).'"';} ?> readonly="true"/>
                </div>
                <div class="form-group campoForm">
                    <label for="descripcion" class="etiqueta">Descripción </label>
                    <textarea id="descripcion" name="descripcion" class="form-control customInput" rows="5" cols="94" required="true" readonly="true"><?php echo $row['Descripcion']; ?> </textarea>
                </div>
			</div>
			<button type="button" class="volver" onclick="location.href='AdminTiposLista.php'">Volver</button>


            <!-- Especializaciones requeridas para inscribirse en las listas de este tipo -->
            <div class="subtitulo row">
                <h3>Especializaciones requeridas</h3>
            </div>
                        
            <?php 
                $columns = array('IdEspecializacion', 'Nombre');
                $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                $consulta = 'SELECT E.IdEspecializacion, E.Nombre, E.Descripcion FROM tipolista TL, especializacionlista EL, campoespecializacion E WHERE TL.IdTipoLista=EL.IdTipoLista AND EL.IdEspecializacion=E.IdEspecializacion AND TL.IdTipoLista='.$_GET['idTipoLista'].' ORDER BY '.$column.' '.$sort_order;

                if ($result=$conn->query($consulta)) {
                    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
                    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                    $add_class = ' class="highlight"';
                }
            ?>

            <table class="table table-sm table-hover col-md-11">
                <thead>
                    <tr>
                        <th class="text-center" scope="col"><a href="AdminTipoListaConsultar.php?idTipoLista=<?php echo $_REQUEST["idTipoLista"]; ?>&column=IdEspecializacion&order=<?php echo $asc_or_desc; ?>">Id. de especialización<i class="fas fa-sort<?php echo $column == 'IdEspecializacion' ? '-' . $up_or_down : '' ?>"></i></a></th>
                        <th class="text-center" scope="col"><a href="AdminTipoListaConsultar.php?idTipoLista=<?php echo $_REQUEST["idTipoLista"]; ?>&column=Nombre&order=<?php echo $asc_or_desc; ?>">Nombre<i class="fas fa-sort<?php echo $column == 'Nombre' ? '-' . $up_or_down : '' ?>"></i></a></th>
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

            <div class="push"></div>
        </div>

        <?php require 'partials/footer.php' ?>
	</body>
</html>
<?php 
    require_once 'partials/referencias.php';

    $consActualizarEstadoServicio = "UPDATE `".$database."`.`servicioactuacion` SET `EstadoProyecto`=? WHERE `IdSolicitudAct`=? AND `NumColegiado`=?";

    $stmt = $conn->prepare($consActualizarEstadoServicio);
    $stmt->bind_param("sii", $estadoservicio, $proyecto, $encargado);

    $estadoservicio=$_REQUEST["estado"];
    $proyecto=$_REQUEST["proyecto"];
    $encargado=$_REQUEST["encargado"];
    
    if($stmt->execute()){
        echo 'Estado del servicio actualizado correctamente';
    } else {
        echo 'Error. No se ha podido actualizar el estado del servicio.';
    }
?>

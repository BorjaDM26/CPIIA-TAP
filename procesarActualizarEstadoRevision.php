<?php 
    require 'AdminModificarRevisionDeProyecto.php';

    $consActualizarEstadoRevision = "UPDATE `".$database."`.`servicioactuacion` SET `EstadoVisado`=?, `DescripcionVisado`=? WHERE `IdSolicitudAct`=? AND `NumColegiado`=?";

    $stmt = $conn->prepare($consActualizarEstadoRevision);
    $stmt->bind_param("ssii", $estado, $descripcion, $proyecto, $encargado);

    $proyecto=$_REQUEST["idProyecto"];
    $encargado=$_REQUEST["encargado"];
    $estado=$_REQUEST["estado"];
    $descripcion=$_REQUEST["descripcion"];
    
    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Visado actualizado correctamente"); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';        
    } else {
        echo '<script type="text/javascript"> alert("Error. No se ha podido actualizar el estado del visado."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';        
    }
?>

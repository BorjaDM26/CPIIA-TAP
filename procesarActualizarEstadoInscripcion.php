<?php 
    require_once 'partials/referencias.php';

    $consActualizarEstadoInscripcion = "UPDATE `".$database."`.`inscripcion` SET `Estado`=? WHERE `IdLista`=? AND `NumColegiado`=?";

    $stmt = $conn->prepare($consActualizarEstadoInscripcion);
    $stmt->bind_param("sii", $estado, $idLista, $numColegiado);

    $estado=$_REQUEST["estado"];
    $idLista=$_REQUEST["idLista"];
    $numColegiado=$_REQUEST["numColegiado"];
    
    if($stmt->execute()){
        echo 'Estado de inscripción actualizado correctamente';
    } else {
        echo 'Error. No se ha podido actualizar el estado de la inscripción.';
    }
?>

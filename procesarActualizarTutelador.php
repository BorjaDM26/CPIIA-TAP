<?php 
    require_once 'partials/referencias.php';

    $consActualizarTutelador = "UPDATE `".$database."`.`servicioactuacion` SET `NumColegiadoTutela`=? WHERE `IdSolicitudAct`=? AND `NumColegiado`=?";

    //echo $consActualizarTutelador;

    $stmt = $conn->prepare($consActualizarTutelador);
    $stmt->bind_param("iii", $tutelador, $proyecto, $encargado);

    $tutelador=$_REQUEST["tutelador"];
    if($tutelador==''){
        $tutelador=NULL;
    }
    $proyecto=$_REQUEST["proyecto"];
    $encargado=$_REQUEST["encargado"];
    
    if($stmt->execute()){
        echo 'Tutelador actualizado correctamente';
    } else {
        echo 'Error. No se ha podido actualizar el tutelador.';
    }
?>

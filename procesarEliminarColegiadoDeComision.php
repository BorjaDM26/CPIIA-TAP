<?php 
    require 'AdminColegiadoModificar.php';

    $consEliminarMiembroComision = "DELETE FROM `".$database."`.`miembrocomision` WHERE `NumColegiado`=? AND `IdComision`=?";

    $stmt = $conn->prepare($consEliminarMiembroComision);

    $stmt->bind_param("ii", $numColegiado, $idComision);
    $numColegiado=$_REQUEST["numColegiado"];
    $idComision=$_REQUEST["idComision"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Colegiado expulsado de la comisión correctamente"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al expulsar al colegiado de la comisión"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    }
?>
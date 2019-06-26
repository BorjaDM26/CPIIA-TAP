<?php 
    require 'AdminColegiadoModificar.php';

    $consEliminarInscripcion = "DELETE FROM `".$database."`.`inscripcion` WHERE `NumColegiado`=? AND `IdLista`=?";

    $stmt = $conn->prepare($consEliminarInscripcion);

    $stmt->bind_param("ii", $numColegiado, $idLista);
    $numColegiado=$_REQUEST["numColegiado"];
    $idLista=$_REQUEST["idLista"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Colegiado expulsado de la lista correctamente"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al expulsar al colegiado de la lista"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    }
?>

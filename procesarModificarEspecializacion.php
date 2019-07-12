<?php 
    require 'AdminEspecializacionModificar.php';

    $consModificarEspecializacion = "UPDATE `".$database."`.`campoespecializacion` SET `IdEspecializacion` = ?, `Nombre` = ?, `Descripcion` = ? WHERE `IdEspecializacion` = ?";

    $stmt = $conn->prepare($consModificarEspecializacion);

    $stmt->bind_param("issi", $nuevoIdEspecializacion, $nombre, $descripcion, $idEspecializacion);

    $idEspecializacion=$_REQUEST["idEspecializacion"];
    $nuevoIdEspecializacion=$_REQUEST["nuevoIdEspecializacion"];
    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];
    
    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Especialización modificada correctamente"); window.location.href="AdminEspecializaciones.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar la especialización. Ya existe otra con el mismo identificador o el mismo nombre."); window.location.href="AdminEspecializacionModificar.php?idEspecializacion='.$idEspecializacion.'"; </script>';
    }
?>
<?php 
    require 'AdminEspecializacionModificar.php';

    $idEspecializacion=$_REQUEST["idEspecializacion"];
    $nuevoIdEspecializacion=$_REQUEST["nuevoIdEspecializacion"];
    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];

    // Comprobación de que los datos introducidos cumplen con el formato adecuado
    $errorFormato = '';
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $nombre)) { $errorFormato .= '\r\n -Nombre'; }

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al modificar la especialización. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminEspecializacionModificar.php?idEspecializacion='.$idEspecializacion.'"; </script>';
        exit();
    }


    // Modificación de la especialización
    $consModificarEspecializacion = "UPDATE `".$database."`.`campoespecializacion` SET `IdEspecializacion` = ?, `Nombre` = ?, `Descripcion` = ? WHERE `IdEspecializacion` = ?";

    $stmt = $conn->prepare($consModificarEspecializacion);
    $stmt->bind_param("issi", $nuevoIdEspecializacion, $nombre, $descripcion, $idEspecializacion);

    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Especialización modificada correctamente"); window.location.href="AdminEspecializaciones.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar la especialización. Ya existe otra con el mismo identificador o el mismo nombre."); window.location.href="AdminEspecializacionModificar.php?idEspecializacion='.$idEspecializacion.'"; </script>';
    }
?>
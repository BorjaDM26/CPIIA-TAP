<?php 
    require 'AdminEspecializacionCrear.php';

    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];

    // Comprobación de que los datos introducidos cumplen con el formato adecuado
    $errorFormato = '';
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $nombre)) { $errorFormato .= '\r\n -Nombre'; }

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al crear la especialización. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminEspecializacionCrear.php"; </script>';
        exit();
    }


    // Creación de la especialización
    $consInsertarEspecializacion = "INSERT INTO `".$database."`.`campoespecializacion` (`Nombre`, `Descripcion`) VALUES (?, ?)";

    $stmt = $conn->prepare($consInsertarEspecializacion);
    $stmt->bind_param("ss", $nombre, $descripcion);

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Especialización creada correctamente"); window.location.href="AdminEspecializaciones.php"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al crear la especialización. Ya existe otra con el mismo nombre."); window.location.href="AdminEspecializacionCrear.php"; </script>';
    }
?>
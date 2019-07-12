<?php 
    require 'AdminEspecializacionCrear.php';

    $consInsertarEspecializacion = "INSERT INTO `".$database."`.`campoespecializacion` (`Nombre`, `Descripcion`) VALUES (?, ?)";

    $stmt = $conn->prepare($consInsertarEspecializacion);

    $stmt->bind_param("ss", $nombre, $descripcion);

    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Especialización creada correctamente"); window.location.href="AdminEspecializaciones.php"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al crear la especialización. Ya existe otra con el mismo nombre."); window.location.href="AdminEspecializacionCrear.php"; </script>';
    }
?>
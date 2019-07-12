<?php 
    require 'AdminComisiones.php';

    $stmt = $conn->prepare("INSERT INTO `".$database."`.`comisiontap` (`Presidente`) VALUES (NULL)");

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Comisión creada correctamente"); window.location.href="AdminComisiones.php"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al crear la comisión."); window.location.href="AdminComisiones.php"; </script>';
    }
?>
<?php 
    require 'AdminComisiones.php';

    $consEliminarComision = "DELETE FROM `".$database."`.`comisiontap` WHERE `IdComision`=?";

    $stmt = $conn->prepare($consEliminarComision);

    $stmt->bind_param("i", $idComision);
    $idComision=$_REQUEST["idComision"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Comisión eliminada correctamente."); window.location.href="AdminComisiones.php"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al eliminar la comisión."); window.location.href="AdminComisiones.php"; </script>';
    }
?>

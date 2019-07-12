<?php 
    require 'AdminComisionModificar.php';

    $consModificarComision = "UPDATE `".$database."`.`comisiontap` SET `IdComision`=?, `Presidente`=? WHERE `IdComision`=?";

    $stmt = $conn->prepare($consModificarComision);

    $stmt->bind_param("iii", $nuevoIdComision, $presidente, $idComision);

    $idComision=$_REQUEST["idComision"];
    $nuevoIdComision=$_REQUEST["nuevoIdComision"];
    $presidente=$_REQUEST["presidente"];
    if($presidente==''){
        $presidente = NULL;
    }
    
    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Comisión modificada correctamente"); window.location.href="AdminComisiones.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar la comisión. El identificar que trata de asignar ya corresponde a otra comisión."); window.location.href="AdminComisiones.php"; </script>';
    }
?>
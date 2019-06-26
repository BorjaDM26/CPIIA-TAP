<?php 
    require 'AdminAgregarColegiadoAComision.php';

    $consAgregarMiembroComision = "INSERT INTO `".$database."`.`miembrocomision` (`NumColegiado`, `IdComision`) VALUES (?, ?)";

    $stmt = $conn->prepare($consAgregarMiembroComision);

    $stmt->bind_param("ii", $numColegiado, $idComision);
    $numColegiado=$_REQUEST["numColegiado"];
    $idComision=$_REQUEST["comision"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Colegiado incluido en la comisión correctamente"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al incluir el colegiado en la comisión"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    }
?>

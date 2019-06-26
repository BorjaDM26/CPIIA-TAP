<?php 
    require 'AdminAgregarEspecializacionAColegiado.php';

    $consAgregarMiembroComision = "INSERT INTO `".$database."`.`especializacioncolegiado` (`NumColegiado`, `IdEspecializacion`) VALUES (?, ?)";

    $stmt = $conn->prepare($consAgregarMiembroComision);

    $stmt->bind_param("ii", $numColegiado, $idEspecializacion);
    $numColegiado=$_REQUEST["numColegiado"];
    $idEspecializacion=$_REQUEST["espec"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Especialización registrada al colegiado correctamente"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al registrar la especialización del colegiado"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    }
?>

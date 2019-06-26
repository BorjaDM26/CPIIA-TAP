<?php 
    require 'AdminAgregarColegiadoALista.php';

    $consAgregarInscripcion = "INSERT INTO `".$database."`.`inscripcion` (`NumColegiado`, `IdLista`) VALUES (?, ?)";

    $stmt = $conn->prepare($consAgregarInscripcion);

    $stmt->bind_param("ii", $numColegiado, $idLista);
    $numColegiado=$_REQUEST["numColegiado"];
    $idLista=$_REQUEST["lista"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Inscripción registrada correctamente"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al registrar la inscripción"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$_REQUEST["numColegiado"].'"; </script>';
    }
?>

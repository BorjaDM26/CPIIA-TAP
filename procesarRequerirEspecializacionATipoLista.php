<?php 
    require 'AdminRequerirEspecializacionATipoLista.php';

    $consRequerirEspecATipoLista = "INSERT INTO `".$database."`.`especializacionlista` (`IdTipoLista`, `IdEspecializacion`) VALUES (?, ?)";

    $stmt = $conn->prepare($consRequerirEspecATipoLista);

    $stmt->bind_param("ii", $idTipoLista, $idEspecializacion);
    $idTipoLista=$_REQUEST["idTipoLista"];
    $idEspecializacion=$_REQUEST["espec"];

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Requerimiento de especialización asignado al tipo de lista correctamente"); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$_REQUEST["idTipoLista"].'"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al registrar la especialización del colegiado"); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$_REQUEST["idTipoLista"].'"; </script>';
    }
?>

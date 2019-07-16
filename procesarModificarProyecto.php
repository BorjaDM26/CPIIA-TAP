<?php 
    require 'AdminProyectoModificar.php';

    $consModificarProyecto = "UPDATE `".$database."`.`solicitudactuacion` SET `Nombre`=?, `Descripcion`=?, `Visado`=?, `Estado`=?, `CorreoElectronico`=?, `Telefono`=?, `IdLista`=? WHERE `IdSolicitudAct`=?";

    $stmt = $conn->prepare($consModificarProyecto);
    $stmt->bind_param("ssisssii", $solicitante, $descripcion, $visado, $estado, $email, $telefono, $lista, $idProyecto);

    $idProyecto=$_REQUEST['idProyecto'];
    $solicitante=$_REQUEST["solicitante"];
    $visado=$_REQUEST["visado"];
    $email=$_REQUEST["email"];
    $telefono=$_REQUEST["telefono"];
    if($telefono==''){
        $telefono = NULL;
    }
    $estado=$_REQUEST["estado"];
    $lista=$_REQUEST["lista"];
    $descripcion=$_REQUEST["descripcion"];
    
    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Proyecto modificado correctamente"); window.location.href="AdminProyectos.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar el proyecto."); window.location.href="AdminProyectos.php"; </script>';
    }
?>
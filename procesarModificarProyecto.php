<?php 
    require 'AdminProyectoModificar.php';

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


    // Comprobación de que los datos introducidos cumplen con el formato adecuado
    $errorFormato = '';
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $solicitante)) { $errorFormato .= '\r\n -Solicitante'; }
    if ($telefono!=NULL && !preg_match("/^[0-9]{9}$/", $telefono)) { $errorFormato .= '\r\n -Teléfono'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ $errorFormato .= '\r\n -Correo electrónico'; }

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al modificar la solicitud. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminProyectoModificar.php?idProyecto='.$idProyecto.'"; </script>';
        exit();
    }

    // Modificación de la solicitud proyecto
    $consModificarProyecto = "UPDATE `".$database."`.`solicitudactuacion` SET `Nombre`=?, `Descripcion`=?, `Visado`=?, `Estado`=?, `CorreoElectronico`=?, `Telefono`=?, `IdLista`=? WHERE `IdSolicitudAct`=?";

    $stmt = $conn->prepare($consModificarProyecto);
    $stmt->bind_param("ssisssii", $solicitante, $descripcion, $visado, $estado, $email, $telefono, $lista, $idProyecto);

    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Proyecto modificado correctamente"); window.location.href="AdminProyectos.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar el proyecto."); window.location.href="AdminProyectos.php"; </script>';
    }
?>
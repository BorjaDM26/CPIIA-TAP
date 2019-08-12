<?php 
    require 'AdminColegiadoCrear.php';

    $nuevoNumColegiado=$_REQUEST["nuevoNumColegiado"];
    $numColegiado=$_REQUEST["numColegiado"];
    $nombre=$_REQUEST["nombre"];
    $apellidos=$_REQUEST["apellidos"];
    $rol=$_REQUEST["rol"];
    $domicilio=$_REQUEST["domicilio"];
    $localidad=$_REQUEST["localidad"];
    $codigoPostal=$_REQUEST["codigoPostal"];
    $provincia=$_REQUEST["provincia"];
    $telefonoProfesional=$_REQUEST["telefonoProfesional"];
    $email=$_REQUEST["email"];
    if($_REQUEST["URL"] != ""){
        $url=$_REQUEST["URL"];
    } else {
        $url=NULL;
    }
    if($_REQUEST["finInhabilitacion"] != ""){
        $finInhabilitacion=$_REQUEST["finInhabilitacion"];
    } else {
        $finInhabilitacion=NULL;
    }

    // Comprobación de que los datos introducidos cumplen con el formato adecuado
    $errorFormato = '';
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $nombre)) { $errorFormato .= '\r\n -Nombre'; }
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $apellidos)) { $errorFormato .= '\r\n -Apellidos'; }
    if (!preg_match("/^([a-zA-Z áéíóúÁÉÍÓÚñÑ0-9º,.]+)$/", $domicilio)) { $errorFormato .= '\r\n -Domicilio profesional'; }
    if (!preg_match("/^([a-zA-Z áéíóúÁÉÍÓÚñÑ]+)$/", $localidad)) { $errorFormato .= '\r\n -Localidad'; }
    if (!preg_match("/^[0-9]{5}$/", $codigoPostal)) { $errorFormato .= '\r\n -Código postal'; }
    if (!preg_match("/^([a-zA-Z áéíóúÁÉÍÓÚñÑ]+)$/", $provincia)) { $errorFormato .= '\r\n -Provincia'; }
    if (!preg_match("/^[0-9]{9}$/", $telefonoProfesional)) { $errorFormato .= '\r\n -Teléfono profesional'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ $errorFormato .= '\r\n -Correo electrónico'; }
    if ($finInhabilitacion!=NULL && $finInhabilitacion <= date("Y-m-d", time())){ $errorFormato .= '\r\n -Fin de inhabilitación'; }

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al modificar el colegiado. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminColegiadoModificar.php?numColegiado='.$numColegiado.'"; </script>';
        exit();
    }

    
    // Modificación del colegiado
    $consModificarColeg = "UPDATE `".$database."`.`colegiado` SET `NumColegiado`=?, `Rol`=?, `Nombre`=?, `Apellidos`=?, `DomicilioProfesional`=?,`Localidad`=?, `CodigoPostal`=?, `Provincia`=?, `TelefonoProfesional`=?, `CorreoElectronico`=?, `URL`=?, `FinInhabilitacion`=? WHERE `NumColegiado`=?";

    $stmt = $conn->prepare($consModificarColeg);
    $stmt->bind_param("isssssssssssi", $nuevoNumColegiado, $rol, $nombre, $apellidos, $domicilio, $localidad, $codigoPostal, $provincia, $telefonoProfesional, $email, $url, $finInhabilitacion, $numColegiado);
    
    if($stmt->execute()){
        if($_REQUEST["finInhabilitacion"] != ""){
            //Borra la pertenencia a comisiones y listas en caso de inhabilitación 
            $conn->query("DELETE FROM `".$database."`.`miembrocomision` WHERE `NumColegiado`=".$numColegiado);
            $conn->query("DELETE FROM `".$database."`.`inscripcion` WHERE `NumColegiado`=".$numColegiado);
        }
        echo'<script type="text/javascript"> alert("Colegiado modificado correctamente"); window.location.href="AdminColegiados.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar el colegiado"); window.location.href="AdminColegiados.php"; </script>';
    }
?>
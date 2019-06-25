<?php 
    require 'AdminColegiadoCrear.php';

    $consModificarColeg = "UPDATE `".$database."`.`colegiado` SET `NumColegiado`=?, `Rol`=?, `Nombre`=?, `Apellidos`=?, `DomicilioProfesional`=?,`Localidad`=?, `CodigoPostal`=?, `Provincia`=?, `TelefonoProfesional`=?, `CorreoElectronico`=?, `URL`=?, `FinInhabilitacion`=? WHERE `NumColegiado`=?";

    $stmt = $conn->prepare($consModificarColeg);

    $stmt->bind_param("isssssssssssi", $nuevoNumColegiado, $rol, $nombre, $apellidos, $domicilio, $localidad, $codigoPostal, $provincia, $telefonoProfesional, $email, $url, $finInhabilitacion, $numColegiado);

    $nuevoNumColegiado=$_REQUEST["nuevoNumColegiado"];
    $numColegiado=$_REQUEST["numColegiado"];
    $rol=$_REQUEST["rol"];
    $nombre=$_REQUEST["nombre"];
    $apellidos=$_REQUEST["apellidos"];
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
        //Borra la pertenencia a comisiones y listas en caso de inhabilitación 
        $conn->query("DELETE FROM `".$database."`.`miembrocomision` WHERE `NumColegiado`=".$numColegiado);
        $conn->query("DELETE FROM `".$database."`.`inscripcion` WHERE `NumColegiado`=".$numColegiado);
    } else {
        $finInhabilitacion=NULL;
    }
    
    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Colegiado modificado correctamente"); window.location.href="AdminColegiados.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar el colegiado"); window.location.href="AdminColegiados.php"; </script>';
    }
?>
<?php 
    require 'AdminColegiadoCrear.php';

    $consInsertarColeg = "INSERT INTO `".$database."`.`colegiado` (`NumColegiado`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`,`Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($consInsertarColeg);

    $stmt->bind_param("issssssssssi", $numColegiado, $cryptedpass, $rol, $nombre, $apellidos, $domicilio, $localidad, $codigoPostal, $provincia, $telefonoProfesional, $email, $url);
    $numColegiado=$_REQUEST["numColegiado"];
	$pass = generateRandomString(); //Contraseña autogenerada
    $cryptedpass = hash('sha256', $pass);
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

    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Colegiado creado correctamente"); window.location.href="AdminColegiados.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al crear el colegiado"); window.location.href="AdminColegiadoCrear.php"; </script>';
    }
?>

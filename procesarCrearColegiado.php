<?php 
    require 'AdminColegiadoCrear.php';

    $numColegiado=$_REQUEST["numColegiado"];
	$pass = numeroAleatorio(10); //Contraseña autogenerada
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

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al crear el colegiado. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminColegiadoCrear.php"; </script>';
        exit();
    }

    
    // Creación del colegiado
    $consInsertarColeg = "INSERT INTO `".$database."`.`colegiado` (`NumColegiado`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`,`Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($consInsertarColeg);
    $stmt->bind_param("issssssssssi", $numColegiado, $cryptedpass, $rol, $nombre, $apellidos, $domicilio, $localidad, $codigoPostal, $provincia, $telefonoProfesional, $email, $url);

    if($stmt->execute()){
        correoAltaColegiado($numColegiado, $pass, $email, $nombre.' '.$apellidos);
        echo'<script type="text/javascript"> alert("Colegiado creado correctamente"); window.location.href="AdminColegiados.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al crear el colegiado"); window.location.href="AdminColegiadoCrear.php"; </script>';
    }
?>

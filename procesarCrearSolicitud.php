<?php 
	require 'TAPSolicitarActuacion.php';

    // Comprobación de que los datos introducidos cumplen con el formato adecuado
    $nombre=$_REQUEST["nombre"];
    $email=$_REQUEST["email"];
    $telefono=$_REQUEST["telefono"];
    $idTipoLst=$_REQUEST["tipoLst"];
    $prov=$_REQUEST["provincia"];
    $visado=$_REQUEST["visado"];
    $descrip=$_REQUEST["descripcion"];
    $fecha=date("Y/m/d<br>", time());

    $errorFormato = '';
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $nombre)) { $errorFormato .= '\r\n -Nombre del solicitante'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ $errorFormato .= '\r\n -Correo electrónico'; }
    if (!preg_match("/^[0-9]{9}$/", $telefono)) { $errorFormato .= '\r\n -Teléfono de contacto'; }

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al enviar la solicitud. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="TAPSolicitarActuacion.php"; </script>';
        exit();
    }


    // Obtener el id de la lista del tipo y la provincia seleccionadas
    $idlista=0;
    $lstProv = $conn->query("SELECT IdLista FROM lista WHERE Publica=0 AND IdTipoLista=".$idTipoLst." AND Territorio='".$prov."';");

    if($lstProv->num_rows == 1){
    	$idlista = $lstProv->fetch_assoc()['IdLista'];
    } else {
    	if($prov=='ALM' OR $prov=='GRA' OR $prov=='JAE' OR $prov=='MAL'){
    		$lstReg = $conn->query("SELECT IdLista FROM lista WHERE Publica=0 AND IdTipoLista=".$idTipoLst." AND Territorio='AOR'");
    	} else {
    		$lstReg = $conn->query("SELECT IdLista FROM lista WHERE Publica=0 AND IdTipoLista=".$idTipoLst." AND Territorio='AOC'");
    	}

    	if($lstReg->num_rows == 1){
	    	$idlista = $lstReg->fetch_assoc()['IdLista'];
	    } else {
	    	$lstCom = $conn->query("SELECT IdLista FROM lista WHERE Publica=0 AND IdTipoLista=".$idTipoLst." AND (Territorio='AND' OR Territorio='NAC')");
	    	if($lstCom->num_rows == 1){
		    	$idlista = $lstCom->fetch_assoc()['IdLista'];
		    } else {
		    	$var = $conn->query("SELECT t.Nombre Territorio, l.Nombre TipoLst FROM territorio T, tipolista l WHERE t.IdTerritorio='".$prov."' AND l.IdTipoLista=".$idTipoLst)->fetch_assoc();
		    	echo '<script type="text/javascript"> alert("Lo Lamentamos.\nNo existe ninguna lista disponible de '.$var['TipoLst'].' en '.$var['Territorio'].' actualmente"); window.location.href="TAPSolicitarActuacion.php"; </script>';
		    	exit();
		    }
	    }
    }


    // Crear la solicitud de actuacion
	$consSolic = "INSERT INTO `".$database."`.`solicitudactuacion` (`Nombre`, `Descripcion`, `Visado`, `FechaSolicitud`, `CorreoElectronico`, `Telefono`, `IdLista`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($consSolic);
    $stmt->bind_param("ssssssi", $nombre, $descrip, $visado, $fecha, $email, $telefono, $idlista);

    if($stmt->execute()){
        $datos = $conn->query("SELECT T.Nombre Provincia, TL.Nombre TipoLista FROM Territorio T, tipolista TL WHERE IdTerritorio='$prov' AND TL.IdTipoLista=$idTipoLst")->fetch_assoc();
        correoCrearSolicitudActuacion($nombre, $email, $telefono, $datos['TipoLista'], $datos['Provincia'], $visado, $descrip);
        echo'<script type="text/javascript"> alert("Solicitud enviada correctamente"); window.location.href="index.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al enviar la solicitud de actuacion"); window.location.href="TAPSolicitarActuacion.php"; </script>';
    }
?>

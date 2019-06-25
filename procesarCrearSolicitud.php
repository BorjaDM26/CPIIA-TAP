<?php 
	require 'TAPSolicitarActuacion.php';

	// Obtener el id de la lista del tipo y la provincia seleccionadas
    $idTipoLst=$_REQUEST["tipoLst"];
    $prov=$_REQUEST["provincia"];
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

    echo "Identificador de la lista = ".$idlista;

    // Crear la solicitud de actuacion
	$consSolic = "INSERT INTO `".$database."`.`solicitudactuacion` (`Nombre`, `Descripcion`, `Visado`, `FechaSolicitud`, `CorreoElectronico`, `Telefono`, `IdLista`) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($consSolic);
    $stmt->bind_param("ssssssi", $nombre, $descrip, $visado, $fecha, $email, $telefono, $idlista);

    $nombre=$_REQUEST["nombre"];
    $descrip=$_REQUEST["descripcion"];
    $visado=$_REQUEST["visado"];
    $fecha=date("Y/m/d<br>", time());
    $email=$_REQUEST["email"];
    $telefono=$_REQUEST["telefono"];

    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Solicitud enviada correctamente"); window.location.href="index.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al enviar la solicitud de actuacion"); window.location.href="TAPSolicitarActuacion.php"; </script>';
    } 
?>

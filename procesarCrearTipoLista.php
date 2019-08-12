<?php 
    require 'AdminTipoListaCrear.php';

    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];
    $comision=$_REQUEST["comision"];
    if($_REQUEST["iniciovacaciones"] != ""){
        $iniciovacaciones=$_REQUEST["iniciovacaciones"];
    } else {
        $iniciovacaciones=NULL;
    }
    if($_REQUEST["finvacaciones"] != ""){
        $finvacaciones=$_REQUEST["finvacaciones"];
    } else {
        $finvacaciones=NULL;
    }


    // Comprobación de que los datos introducidos cumplen con el formato adecuado
    $errorFormato = '';
    if (!preg_match("/^([a-zA-Z' áéíóúÁÉÍÓÚñÑ]+)$/", $nombre)) { $errorFormato .= '\r\n -Nombre'; }

    if ($iniciovacaciones != NULL && $finvacaciones != NULL) {
        if(strtotime($iniciovacaciones) >= strtotime($finvacaciones)){
            $errorFormato .= '\r\n -Periodo vacacional (el inicio debe ser anterior al fin)';
        } elseif (substr($iniciovacaciones, 0 , 4) != date("Y", time())){
            $errorFormato .= '\r\n -Periodo vacacional (el inicio debe corresponder al presente año)';
        }
    } elseif ($iniciovacaciones != NULL || $finvacaciones != NULL){
        $errorFormato .= '\r\n -Periodo vacacional (debe ser cerrado)';
    }

    if($errorFormato != ''){
        echo'<script type="text/javascript"> alert("Error al crear el tipo de lista. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminTipoListaCrear.php"; </script>';
        exit();
    }

    // Creación del tipo de lista
    $consInsertarTipoLista = "INSERT INTO `".$database."`.`tipolista` (`Nombre`, `Descripcion`, `FechaIniVacacional`, `FechaFinVacacional`, `IdComision`) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($consInsertarTipoLista);
    $stmt->bind_param("ssssi", $nombre, $descripcion, $iniciovacaciones, $finvacaciones, $comision);
    
    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Tipo de lista creado correctamente"); window.location.href="AdminTiposLista.php"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. Ya existe otra con el mismo nombre."); window.location.href="AdminTipoListaCrear.php"; </script>';
    }
?>
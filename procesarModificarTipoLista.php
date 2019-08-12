<?php 
    require 'AdminTipoListaModificar.php';

    $idTipoLista=$_REQUEST["idTipoLista"];
    $nuevoIdTipoLista=$_REQUEST["nuevoIdTipoLista"];
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
        echo'<script type="text/javascript"> alert("Error al modificar el tipo de lista. Los siguientes campos no cumplen con el formato adecuado:'.$errorFormato.'"); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$idTipoLista.'"; </script>';
        exit();
    }


    // Modificación del tipo de lista
    $consModificarTipoLista = "UPDATE `".$database."`.`tipolista` SET `IdTipoLista` = ?, `Nombre` = ?, `Descripcion` = ?, `FechaIniVacacional` = ?, `FechaFinVacacional` = ?, `IdComision` = ? WHERE `tipolista`.`IdTipoLista` = ?";

    $stmt = $conn->prepare($consModificarTipoLista);
    $stmt->bind_param("issssii", $nuevoIdTipoLista, $nombre, $descripcion, $iniciovacaciones, $finvacaciones, $comision, $idTipoLista);

    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Tipo de lista modificada correctamente"); window.location.href="AdminTiposLista.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar el tipo de lista. Ya existe otro con el mismo nombre."); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$idTipoLista.'"; </script>';
    }
?>
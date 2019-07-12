<?php 
    require 'AdminTipoListaModificar.php';

    $consModificarTipoLista = "UPDATE `".$database."`.`tipolista` SET `IdTipoLista` = ?, `Nombre` = ?, `Descripcion` = ?, `FechaIniVacacional` = ?, `FechaFinVacacional` = ?, `IdComision` = ? WHERE `tipolista`.`IdTipoLista` = ?";

    $stmt = $conn->prepare($consModificarTipoLista);

    $stmt->bind_param("issssii", $nuevoIdTipoLista, $nombre, $descripcion, $iniciovacaciones, $finvacaciones, $comision, $idTipoLista);

    $idTipoLista=$_REQUEST["idTipoLista"];
    $nuevoIdTipoLista=$_REQUEST["nuevoIdTipoLista"];
    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];
    $comision=$_REQUEST["comision"];
    if ($_REQUEST["iniciovacaciones"] != '' && $_REQUEST["finvacaciones"] != '') {
        $iniciovacaciones=$_REQUEST["iniciovacaciones"];
        $finvacaciones=$_REQUEST["finvacaciones"];
        if(strtotime($iniciovacaciones) >= strtotime($finvacaciones)){
            echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. El inicio del periodo vacacional debe ser anterior al fin del mismo."); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$idTipoLista.'"; </script>';
            exit();
        } elseif (substr($iniciovacaciones, 0 , 4) != date("Y", time()) || substr($finvacaciones, 0 , 4) != date("Y", time())){
            echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. El inicio y fin del periodo vacacional deben corresponder al presente año."); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$idTipoLista.'"; </script>';
            exit();
        }
    } elseif ($_REQUEST["iniciovacaciones"] == '' && $_REQUEST["finvacaciones"] == ''){
        $iniciovacaciones=NULL;
        $finvacaciones=NULL;
    } else {
        echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. El periodo vacacional debe ser cerrado."); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$idTipoLista.'"; </script>';
        exit();
    }
    
    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Tipo de lista modificada correctamente"); window.location.href="AdminTiposLista.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al modificar el tipo de lista. Ya existe otro con el mismo nombre."); window.location.href="AdminTipoListaModificar.php?idTipoLista='.$idTipoLista.'"; </script>';
    }
?>
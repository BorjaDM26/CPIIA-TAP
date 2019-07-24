<?php 
    require 'AdminTipoListaCrear.php';

    $consInsertarTipoLista = "INSERT INTO `".$database."`.`tipolista` (`Nombre`, `Descripcion`, `FechaIniVacacional`, `FechaFinVacacional`, `IdComision`) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($consInsertarTipoLista);

    $stmt->bind_param("ssssi", $nombre, $descripcion, $iniciovacaciones, $finvacaciones, $comision);
    $nombre=$_REQUEST["nombre"];
    $descripcion=$_REQUEST["descripcion"];
    $comision=$_REQUEST["comision"];
    if ($_REQUEST["iniciovacaciones"] != '' && $_REQUEST["finvacaciones"] != '') {
        $iniciovacaciones=$_REQUEST["iniciovacaciones"];
        $finvacaciones=$_REQUEST["finvacaciones"];
        if(strtotime($iniciovacaciones) >= strtotime($finvacaciones)){
            echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. El inicio del periodo vacacional debe ser anterior al fin del mismo."); window.location.href="AdminTipoListaCrear.php"; </script>';
            exit();
        } elseif (substr($iniciovacaciones, 0 , 4) != date("Y", time()) || substr($finvacaciones, 0 , 4) != date("Y", time())){
            echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. El inicio y fin del periodo vacacional deben corresponder al presente año."); window.location.href="AdminTipoListaCrear.php"; </script>';
            exit();
        }
    } elseif ($_REQUEST["iniciovacaciones"] == '' && $_REQUEST["finvacaciones"] == ''){
        $iniciovacaciones=NULL;
        $finvacaciones=NULL;
    } else {
        echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. El periodo vacacional debe ser cerrado."); window.location.href="AdminTipoListaCrear.php"; </script>';
        exit();
    }

    if($stmt->execute()){
        echo '<script type="text/javascript"> alert("Tipo de lista creado correctamente"); window.location.href="AdminTiposLista.php"; </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error al crear el tipo de lista. Ya existe otra con el mismo nombre."); window.location.href="AdminTipoListaCrear.php"; </script>';
    }
?>
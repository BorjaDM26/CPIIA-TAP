<?php 
    require 'AdminListaCrear.php';

    $consInsertarLista = "INSERT INTO `".$database."`.`lista` (`IdTipoLista`, `Publica`, `Territorio`) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($consInsertarLista);
    echo $consInsertarLista;

    $stmt->bind_param("iis", $idTipoLista, $publica, $idTerritorio);
    $idTipoLista=$_REQUEST["tipoLista"];
    if ($_REQUEST["grupo"]=='Revisores') {
        $publica=NULL;
        $idTerritorio='NAC';
    } else{
        $publica=$_REQUEST["publica"];
        $idTerritorio=$_REQUEST["territorio"];
    }

    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Lista creada correctamente"); window.location.href="AdminListas.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al crear la lista. Ya existe otra con esas características"); window.location.href="AdminListaCrear.php"; </script>';
    }
?>
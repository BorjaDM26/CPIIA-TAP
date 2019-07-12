<?php 
    require 'AdminListaModificar.php';

    $consModificarLista = "UPDATE `".$database."`.`lista` SET `IdTipoLista`=?, `Publica`=?, `Territorio`=? WHERE `IdLista`=?";

    $stmt = $conn->prepare($consModificarLista);

    $stmt->bind_param("iisi", $tipoLista, $publica, $territorio, $idLista);

    $idLista=$_REQUEST["idLista"];
    $tipoLista=$_REQUEST["tipoLista"];
    if($_REQUEST["grupo"] == "Revisores"){
        $publica=null;
        $territorio='NAC';
    } else {
        $publica=$_REQUEST["publica"];
        $territorio=$_REQUEST["territorio"];
    }
    
    if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Lista modificada correctamente"); window.location.href="AdminListas.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error. Está tratando de crear una lista repetida."); window.location.href="AdminListas.php"; </script>';
    }
?>
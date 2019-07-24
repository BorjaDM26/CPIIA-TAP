<?php 
    //require 'AdminProyectoModificar.php';
    require_once 'partials/referencias.php';

    $consAsignarRevisorAProyecto = "CALL asignarProyectoARevisor(?,@res);";

    $stmt = $conn->prepare($consAsignarRevisorAProyecto);
    $stmt->bind_param("i", $idProyecto);
    $idProyecto=$_REQUEST["idProyecto"];

    if($stmt->execute()){
        $res = $conn->query('SELECT @res;')->fetch_assoc()['@res'];
        if($res == -1){
            echo '<script type="text/javascript"> alert("Error al asignar la revisión. El proyecto no tiene asignado un encargado o ya esta siendo revisado por otro colegiado."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
        } elseif ($res == -2) {
            echo '<script type="text/javascript"> alert("Error al asignar la revisión. No existe una lista de revisores para el tipo de lista de la solicitud."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';            
        } elseif ($res == -3) {
            echo '<script type="text/javascript"> alert("Error al asignar la revisión. No existen colegiados disponibles en la lista de revisores."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';            
        } elseif ($res>0){
            echo '<script type="text/javascript"> alert("Revisión asignada al colegiado con ID '.$res.'."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
        } else {
            echo '<script type="text/javascript"> alert("Hans"); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("Error al asignar la revisión del proyecto."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
    }
?>

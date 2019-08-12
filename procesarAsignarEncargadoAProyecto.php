<?php 
    require 'AdminProyectoModificar.php';

    $consAsignarEncargadoAProyecto = "CALL asignarProyectoAEncargado(?,@res);";

    $stmt = $conn->prepare($consAsignarEncargadoAProyecto);
    $stmt->bind_param("i", $idProyecto);
    $idProyecto=$_REQUEST["idProyecto"];

    if($stmt->execute()){
        $res = $conn->query('SELECT @res;')->fetch_assoc()['@res'];
        if($res == -1){
            echo '<script type="text/javascript"> alert("Error al encargar el proyecto. Ya esta siendo realizado por otro colegiado."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
        } elseif ($res == -2) {
            echo '<script type="text/javascript"> alert("Error al encargar el proyecto. No existen colegiados disponibles en la lista de profesionales."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';            
        } else {
            $consultaDatosCorreo = "SELECT CONCAT(C.Nombre, ' ', C.Apellidos) Encargado, C.CorreoElectronico EmailEncargado, SO.IdSolicitudAct, SO.Nombre Solicitante, SO.Descripcion,  IF(SO.Visado=1, 'Si', 'No') Visado, SO.CorreoElectronico EmailSolicitante, SO.Telefono, TL.Nombre TipoLista, T.Nombre Territorio FROM colegiado C, solicitudactuacion SO, lista L, tipolista TL, territorio T WHERE C.NumColegiado=$res AND SO.IdSolicitudAct=$idProyecto AND SO.IdLista=L.IdLista AND L.IdTipoLista=TL.IdTipoLista AND L.Territorio=T.IdTerritorio";
            $datos = $conn->query($consultaDatosCorreo)->fetch_assoc();
            correoAsignacionEncargado($datos);
            echo '<script type="text/javascript"> alert("Proyecto asignado al colegiado con ID '.$res.'."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("Error al encargar el proyecto a un colegiado."); window.location.href="AdminProyectoModificar.php?idProyecto='.$_REQUEST["idProyecto"].'"; </script>';
    }
?>

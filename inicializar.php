<?php
	require 'partials/baseDatos.php';
	$stmt = $conn->prepare("INSERT INTO `".$database."`.`colegiado` (`NumColegiado`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`,`Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`, `Inhabilitado`) VALUES (1, ?, 'Responsable', 'Administrador', 'PHP', 'Calle del Olmo, N01, 1ºA', 'Málaga', '11111', 'Málaga', '650000001','RamonG@mail.com', 'www.ramonggg.com', 0)");
	$stmt->bind_param("s", $cryptedpass);
	$cryptedpass = password_hash('1234', PASSWORD_BCRYPT);

	if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Inicialización correcta"); window.location.href="index.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al inicializar"); window.location.href="index.php"; </script>';
    }
?>
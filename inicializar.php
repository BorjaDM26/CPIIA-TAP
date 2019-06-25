<?php
	require_once 'partials/referencias.php';
	$consInsertarColeg = "INSERT INTO `".$database."`.`colegiado` (`NumColegiado`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`,`Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`) VALUES 
		(1, ?, 'Responsable', 'Administrador', 'PHP', 'Calle del Olmo, N01, 1ºA', 'Málaga', '11111', 'Málaga', '650000001','admin@mail.com', 'www.adminAAA.com'),
		(2, ?, 'Colegiado', 'Colegiado', 'PHP', 'Calle del Abeto, N02, 2ºB', 'Cádiz', '22222', 'Cádiz', '650000002','colegiado@mail.com', 'www.colegiadoCCC.com')";


	$stmt = $conn->prepare($consInsertarColeg);
	$stmt->bind_param("ss", $cryptedpass, $cryptedpass);
	$cryptedpass = password_hash('1234', PASSWORD_BCRYPT);

	if($stmt->execute()){
        echo'<script type="text/javascript"> alert("Inicialización correcta"); window.location.href="index.php"; </script>';
    } else {
        echo'<script type="text/javascript"> alert("Error al inicializar"); window.location.href="index.php"; </script>';
    }
?>
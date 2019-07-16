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


    /* 
    //Inserciones de relleno:
	INSERT INTO `bdtapcpiia`.`colegiado` (`Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`,`Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`) VALUES 
		('1234', 'Colegiado', 'Angel', 'Álvarez', 'Calle Falsa 1', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.AA.com'), 
		('1234', 'Colegiado', 'Borja', 'Bermúdez', 'Calle Falsa 2', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.BB.com'), 
		('1234', 'Colegiado', 'Carlos', 'Correa', 'Calle Falsa 3', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.CC.com'), 
		('1234', 'Colegiado', 'Daniel', 'Díaz', 'Calle Falsa 4', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.DD.com'), 
		('1234', 'Colegiado', 'Eric', 'Encina', 'Calle Falsa 5', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.EE.com'), 
		('1234', 'Colegiado', 'Francisco', 'Fernández', 'Calle Falsa 6', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.FF.com'), 
		('1234', 'Colegiado', 'Guillermo', 'García', 'Calle Falsa 7', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.GG.com'), 
		('1234', 'Colegiado', 'Hector', 'Herrera', 'Calle Falsa 8', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.HH.com'), 
		('1234', 'Colegiado', 'Inés', 'Itziar', 'Calle Falsa 9', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.II.com'), 
		('1234', 'Colegiado', 'Jaime', 'Jurado', 'Calle Falsa 10', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.JJ.com'), 
		('1234', 'Colegiado', 'Kiko', 'Kilo', 'Calle Falsa 11', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.KK.com'), 
		('1234', 'Colegiado', 'Luísa', 'Lleida', 'Calle Falsa 12', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.LL.com'), 
		('1234', 'Colegiado', 'María', 'Martín', 'Calle Falsa 13', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.MM.com'), 
		('1234', 'Colegiado', 'Nuria', 'Navarro', 'Calle Falsa 14', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.NN.com'), 
		('1234', 'Colegiado', 'Ona', 'Ortiz', 'Calle Falsa 15', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.OO.com'), 
		('1234', 'Colegiado', 'Pablo', 'Pérez', 'Calle Falsa 16', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.PP.com'), 
		('1234', 'Colegiado', 'Rubén', 'Rueda', 'Calle Falsa 17', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.RR.com'), 
		('1234', 'Colegiado', 'Silvia', 'Santoral', 'Calle Falsa 18', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.SS.com'), 
		('1234', 'Colegiado', 'Tomás', 'Trujillo', 'Calle Falsa 19', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.TT.com'), 
		('1234', 'Colegiado', 'Unai', 'Unser', 'Calle Falsa 20', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.UU.com'), 
		('1234', 'Colegiado', 'Victoria', 'Vigo', 'Calle Falsa 21', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.VV.com'), 
		('1234', 'Colegiado', 'Zacarías', 'Zafra', 'Calle Falsa 22', 'Málaga', '11111', 'Málaga', '650000001','AA@mail.com', 'www.ZZ.com');
    */
?>
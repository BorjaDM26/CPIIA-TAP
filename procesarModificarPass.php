<?php 
	require_once 'ColegMiPerfil.php';
	
	if(!isset($_SESSION)) { session_start(); } 

	$numColeg=$_SESSION["SesionNumColegiado"];
    $cryptedOldPass = hash('sha256', $_REQUEST['oldPass']);
    $newPass = $_REQUEST['newPass'];
    $confNewPass = $_REQUEST['confNewPass'];

    $row = $conn->query("SELECT Pass FROM colegiado WHERE NumColegiado='".$numColeg."'")->fetch_assoc();
	$bdPass = $row['Pass'];

	if ($cryptedOldPass == $bdPass) {
		if($newPass == $confNewPass){
			$cryptedNewPass = hash('sha256', $newPass);
			$consActPass = "UPDATE `".$database."`.`colegiado` SET `Pass`='".$cryptedNewPass."' WHERE `NumColegiado`=".$numColeg;
			if($conn->query($consActPass)){
		        echo'<script type="text/javascript"> alert("Contraseña actualizada correctamente."); window.location.href="ColegMiPerfil.php"; </script>';
		    } else {
		        echo'<script type="text/javascript"> alert("Error. No se pudo actualizar la contraseña."); window.location.href="ColegMiPerfil.php"; </script>';
		    }
		} else {
			echo'<script type="text/javascript"> alert("Error. La nueva contraseña y su confirmación no son iguales."); window.location.href="ColegMiPerfil.php"; </script>';
		}
	} else {
        echo'<script type="text/javascript"> alert("Error. La contraseña antigua es incorrecta."); window.location.href="ColegMiPerfil.php"; </script>';
	}
?>
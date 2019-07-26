<?php 
	if(!isset($_SESSION)) { session_start(); } 

	require_once 'partials/referencias.php';

	$stmtTipoLst = $conn->query("SELECT Nombre, Descripcion FROM tipolista;");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tipos de Lista</title>
	</head>
	<body>
		<?php require 'partials/menuSuperior.php' ?>

		<div class="contenido col-md-9">
			<div class="titulo row">
                <h1>Tipos de Lista</h1>
            </div>
			
			<?php 
    			while ($filaTipoLst = $stmtTipoLst->fetch_assoc()){
    				echo '<div class="card">';
    				echo '	<div class="card-body">';
    				echo '		<h5 class="card-title text-center"><b>'.$filaTipoLst['Nombre'].'</b></h5>';
    				echo '		<p class="card-text">'.$filaTipoLst['Descripcion'].'</p>';
    				echo '	</div>';
    				echo '</div><br>';
    			} 
    		?>
    		<div class="push"></div>
    	</div>

		<?php require 'partials/footer.php' ?>
	</body>
</html>
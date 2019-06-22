<?php 
	require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/cpiia-tap/partials/referencias.php');

	$idTipoLst=$_GET['idTipoLst'];
	$pub=$_GET['pub'];


	$stmtTerrit = $conn->query("SELECT T.IdTerritorio, T.Nombre FROM Lista L, Territorio T WHERE L.Territorio=T.IdTerritorio AND L.Publica=".$pub." AND L.IdTipoLista='".$idTipoLst."';");
	$territ = '';
	if(isset($_REQUEST['territ'])){
		$territ = $_REQUEST['territ'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Listas Públicas</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<label for="territ" class="etiqueta">Territorio: </label>
		<select class="form-control customInput" name="territ" id="territ">
			<?php 
				while ($filaTerrit = $stmtTerrit->fetch_assoc()){
					if ($filaTerrit['IdTerritorio']==$territ) {
						echo "<option value=\"".$filaTerrit['IdTerritorio']."\" selected>".$filaTerrit['Nombre']."</option>";
					} else{
						echo "<option value=\"".$filaTerrit['IdTerritorio']."\">".$filaTerrit['Nombre']."</option>";
					}
				} 
			?>
		</select>
	</body>
</html>
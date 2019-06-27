<?php 
	require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/cpiia-tap/partials/referencias.php');

	$grupo=$_GET['grupo'];
	$stmtTerrit = $conn->query("SELECT * FROM territorio;");
?>

<!DOCTYPE html>
<html>
	<body>
		<?php if ($grupo=='Profesionales'): ?>
			<div class="form-row">
				<div class="form-group campoForm">
		        	<label for="publica" class="etiqueta">Publica </label>
		            <select class="form-control customInput" name="publica" id="publica">
		                <option value="1">Si</option>    
		                <option value="0" selected>No</option>
		            </select>
		        </div>
		        <div class="form-group campoForm">
		        	<label for="territorio" class="etiqueta">Territorio </label>
		            <select class="form-control customInput" name="territorio" id="territorio">
		                <?php 
		                    while ($rowTerrit = $stmtTerrit->fetch_assoc()){
		                    	if($rowTerrit['IdTerritorio']=='NAC'){
									echo "<option value=\"".$rowTerrit['IdTerritorio']."\" selected>".$rowTerrit['Nombre']."</option>";
		                    	} else{
		                    		echo "<option value=\"".$rowTerrit['IdTerritorio']."\">".$rowTerrit['Nombre']."</option>";
		                    	}
		                    } 
		                ?>
		            </select>
		        </div>
		    </div>
		<?php endif; ?>

		<?php if ($grupo=='Revisores'): ?>
			<div class="form-row">
				<div class="form-group campoForm">
		        	<label for="publica" class="etiqueta">Publica </label>
		            <select class="form-control customInput" name="publica" id="publica" disabled="true">
		                <option value="0" selected>No</option>
		            </select>
		        </div>
		        <div class="form-group campoForm">
		        	<label for="territorio" class="etiqueta">Territorio </label>
		            <select class="form-control customInput" name="territorio" id="territorio" disabled="true">
		                <option value="NAC" selected>Nacional</option>
		            </select>
		        </div>
		    </div>
		<?php endif; ?>
	</body>
</html>
<?php
	session_start();
	include "conectaBanco.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Editar Evento Criado</title>
<?php require ('header.php'); ?>
</head>
<body>
	<?php require('topo.php'); ?>
	<div class="container">
	<form action="" method="post"  enctype="multipart/form-data">

		<div  class= "control-group" > 
			  <label class="control-label" for="novo_nome_sub_evento"> Nome Sub-Evento </label>
		 	
			  <div class="controls">
			 	<input  id="novo_nome_sub_evento" name="novo_nome_sub_evento" type= "text"  class= "form-control"  placeholder= "nome do sub-evento" data-validation-matches-match="novo_nome_sub_evento"
				data-validation-matches-message=
					"DEU MERDA LOKO" required> 
			  </div>
		</div>

		<div  class= "control-group" > 
			  <label class="control-label" for="nova_descr"> Descrição </label>
		 	
			  <div class="controls">
			 	<input  id="nova_descr" name="nova_descr" type= "text"  class= "form-control"  placeholder= "descrição do evento" data-validation-matches-match="nova_descr"
				data-validation-matches-message=
					"DEU MERDA LOKO" required> 
			  </div>
		</div>

		<div  class= "control-group" > 
			  <label class="control-label" for="nova_vagas_totais"> VAGAS </label>
		 	
			  <div class="controls">
			 	<input  id="nova_vagas_totais" name="nova_vagas_totais" type= "text"  class= "form-control"  placeholder= "total de vagas para o evento" data-validation-matches-match="nova_vagas_totais"
				data-validation-matches-message=
					"DEU MERDA LOKO" required> 
			  </div>
		</div>

		<div  class= "control-group" > 
			  <label class="control-label" for="nova_qt_horas"> Duração em Horas </label>
		 	
			  <div class="controls">
			 	<input  id="nova_qt_horas" name="nova_qt_horas" type= "text"  class= "form-control"  placeholder= "duração do evento" data-validation-matches-match="nova_qt_horas"
				data-validation-matches-message=
					"DEU MERDA LOKO" required> 
			  </div>
		</div>

		<?php
			if(isset($_POST['submit_update'] )){
				atualiza_sub_evento();
			} 
		?>
		<br>
	<input type="submit" name="submit_update" id = "submit_update" value="Atualizar Sub Evento"> 			    
	</form>
	</div>
</body>
<html>
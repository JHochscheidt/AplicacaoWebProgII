<?php
	session_start();
	include "conectaBanco.php";
	if(!isset($_SESSION['username'])){	
		header("Location: index.php?cod_error=50&".SID);
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CONTROLE DE EVENTOS</title>

<?php require ('header.php'); ?>
<style type="text/css">
	#exc{
		float: right;
	}
</style>

</head>
<body>
<center>
<?php require('topo.php'); ?>

<div id="global" style=" width:100% ">
<center>SEJA BEM VINDO(A) <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a id="exc" href="index_user.php?exc_user">Excluir Minha Conta</a></center>
	<?php 
		if(isset($_GET['exc_user'])){
			excluir_usuario();
		}
	?>
</div>

<div id="meus_eventos" style=" width:25%; height:500px; float:left">	
					<center>MEUS EVENTOS</center>
<form name="form_meus_eventos" method="post">
	<?php eventos_usuario();
		if(isset($_POST['sub_excluir'])){
			excluir_eventos_user();
		}
	?>
	<input type="submit" name="sub_excluir" value="Excluir">
</form>

</div>

<div id="meus_eventos_criados" style=" width:25%; height:500px; float:right">	
						<center>MEUS EVENTOS CRIADOS</center>
<?php 
	meus_eventos_criados();
	if(isset($_GET['sub_exc'])) {
		exc_event_user_vinc();
	}
	if(isset($_GET['sub_edit'])){
		header("Location: edit_evento.php?".SID);
	}
	
?>
</div>

<div id="cadastrar_eventos" style=" width:50%; height:100%; float:left">	
						<br><center><label>CADASTRO DE EVENTOS</label></center><br>			
<form  method="post" name="form_cad_eventos" enctype="multipart/form-data">

<div  class= "control-group" > 
	  <label class="control-label" for="nome_evento"> Nome Evento </label>
 	
	  <div class="controls">
	 	<input  id="nome_evento" name="nome_evento" type= "text"  class= "form-control"  placeholder= "nome do evento" data-validation-matches-match="nome_evento"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>

<div  class= "control-group" > 
	  <label class="control-label" for="data_inicio"> Data Inicio </label>
 	
	  <div class="controls">
	 	<input  id="data_inicio" name="data_inicio" type= "date"  class= "form-control"  data-validation-matches-match="data_inicio"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>

<div  class= "control-group" > 
	  <label class="control-label" for="data_fim"> Data Fim </label>
 	
	  <div class="controls">
	 	<input  id="data_fim" name="data_fim" type= "date"  class= "form-control"  data-validation-matches-match="data_fim"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>


<div  class= "control-group" > 
	  <label class="control-label" for="banner"> Banner do Evento</label>
 	
	  <div class="controls">
	 	<input  id="banner" name="banner" type= "file"  class= "form-control"  data-validation-matches-match="banner"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>
 
<br>

	<?php
	if(isset($_POST['submit_eventos'] ) ){
		//Tipos de Dados Permitidos
		$tiposPermitidos= array('image/bmp','image/gif', 'image/jpeg', 'image/jpg', 'image/png');
		// Tamanho máximo (em bytes)
		$tamanhoPermitido = 1024 * 10000; // 10000 Kb
		// O nome original do arquivo no computador do usuário
		$arqName = $_FILES['banner']['name'];
		// O tipo mime do arquivo. Um exemplo pode ser "image/gif"
		$arqType = $_FILES['banner']['type'];
		// O tamanho, em bytes, do arquivo
		$arqSize = $_FILES['banner']['size'];
		// O nome temporário do arquivo, como foi guardado no servidor
		$arqTemp = $_FILES['banner']['tmp_name'];
		// O código de erro associado a este upload de arquivo
		$arqError = $_FILES['banner']['error'];
		if($arqError==0){
			if (array_search($arqType, $tiposPermitidos) === false) {
				echo 'O tipo de arquivo enviado é inválido!';
			}else if ($arqSize > $tamanhoPermitido){
				echo 'O tamanho do arquivo enviado é maior que o limite!';
			}else{
				//Não houveram erros, move o arquivo
				$pasta = "img/".$arqName;
				$_SESSION['ender_banner']=$pasta;
				$upload = move_uploaded_file($arqTemp, $pasta);
				if($upload){
					echo "<br><center>Arquivo Carregado com Sucesso!<br></center>";
					cad_eventos(); 
				}else{
					echo "<center>Erro ao carregar arquivo! <br>Tente Novamente!</center>";
				}
				
			}
		}	
	}  
?>
<br>
<input type="submit" name="submit_eventos" id = "submit_eventos" value="Cadastrar Eventos"><br> 
</form>			
</div>

<div id="cadastrar_sub_eventos" style=" width:50%; height:100%; float:left">
<br><br><label>CADASTRO DE SUB EVENTOS</label><br><br>
<form action="" method="post" name="form_cad_sub_eventos" enctype="multipart/form-data">

<label> Evento Associado: </label><br>

<select name="fk_eventos"  size="1">
	<?php 
		sel_event_assoc();
	 ?>
</select>

<br>
<div  class= "control-group" > 
	  <label class="control-label" for="nome_sub_evento"> Nome Sub-Evento </label>
 	
	  <div class="controls">
	 	<input  id="nome_sub_evento" name="nome_sub_evento" type= "text"  class= "form-control"  placeholder= "nome do sub-evento" data-validation-matches-match="nome_sub_evento"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>

<div  class= "control-group" > 
	  <label class="control-label" for="descr"> Descrição </label>
 	
	  <div class="controls">
	 	<input  id="descr" name="descr" type= "text"  class= "form-control"  placeholder= "descrição do evento" data-validation-matches-match="descr"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>

<div  class= "control-group" > 
	  <label class="control-label" for="descr"> VAGAS </label>
 	
	  <div class="controls">
	 	<input  id="vagas_totais" name="vagas_totais" type= "text"  class= "form-control"  placeholder= "total de vagas para o evento" data-validation-matches-match="vagas_totais"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>

<div  class= "control-group" > 
	  <label class="control-label" for="qt_horas"> Duração em Horas </label>
 	
	  <div class="controls">
	 	<input  id="qt_horas" name="qt_horas" type= "text"  class= "form-control"  placeholder= "duração do evento" data-validation-matches-match="qt_horas"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	  </div>
</div>

<?php
	if(isset($_POST['submit_sub'] ) ){
		cad_sub_eventos();
	} 
?>
<br>
<input type="submit" name="submit_sub" id = "submit_sub" value="Cadastrar Sub Eventos"> 			    
</form>
</div>
</center>
</body>

</html>

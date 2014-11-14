<?php
	session_start();
	include "conectaBanco.php";
?>	
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<?php require ('header.php'); ?>

<title>Cadastro de Usuarios</title>

</head>
<body>
<?php require('topo.php'); ?>

<center>
	<div style=" width:80%; height:100%">
<br>
<form  id="cadastro" name="cadastro" method="post"  enctype="multipart/form-data" >
<div  class= "control-group" >
 	 <label class="control-label" for="nome_completo"> Nome Completo </label> 
  	 
  	 <div class="controls"> 	
  	   <input  id="nome_completo" name="nome_completo" type= "text"  class= "form-control"  placeholder= "Nome Completo"  data-validation-matches-match="nome_completo"
		data-validation-matches-message=
			"DEU MERDA LOKO" required > 
  	 </div>
</div>

<div  class= "control-group" > 
   <label class="control-label" for="usuario"> Usuário </label> 

   <div class="controls"> 	
  	<input  id="usuario" name="usuario" type= "text"  class= "form-control"  placeholder= "Login" data-validation-matches-match="usuario"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	</div>
</div>


<div  class= "control-group" > 
   <label class="control-label" for="email"> E-mail </label> 

   <div class="controls"> 	
  	<input  id="email" name="email" type= "text"  class= "form-control"  placeholder= "Seu E-mail aqui"  data-validation-matches-match="email"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	</div>
</div>


<div  class= "control-group" > 
   <label class="control-label" for="password"> Senha </label> 

   <div class="controls"> 	
  	<input  id="password" name="password" type= "password"  class= "form-control"  placeholder= "Escolha uma Senha"  data-validation-matches-match="password"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	</div>
</div>

<div  class= "control-group" > 
   <label class="control-label" for="confirm_pass"> Confirme sua Senha </label> 

   <div class="controls"> 	
  	<input  id="confirm_pass" name="confirm_pass" type= "password"  class= "form-control"  placeholder= "Repita a Senha" data-validation-matches-match="confirm_pass"
		data-validation-matches-message=
			"DEU MERDA LOKO" required> 
	</div>
</div>

<input type="file" name="foto" id="foto" >


<?php
	if(isset($_POST['submit_cad'] ) ){
		//Tipos de Dados Permitidos
		$tiposPermitidos= array('image/bmp','image/gif', 'image/jpeg', 'image/jpg', 'image/png');
		// Tamanho máximo (em bytes)
		$tamanhoPermitido = 1024 * 10000; // 10000 Kb
		// O nome original do arquivo no computador do usuário
		$arqName = $_FILES['foto']['name'];
		// O tipo mime do arquivo. Um exemplo pode ser "image/gif"
		$arqType = $_FILES['foto']['type'];
		// O tamanho, em bytes, do arquivo
		$arqSize = $_FILES['foto']['size'];
		// O nome temporário do arquivo, como foi guardado no servidor
		$arqTemp = $_FILES['foto']['tmp_name'];
		// O código de erro associado a este upload de arquivo
		$arqError = $_FILES['foto']['error'];
		if($arqError==0){
			if (array_search($arqType, $tiposPermitidos) === false) {
				echo 'O tipo de arquivo enviado é inválido!';
			}else if ($arqSize > $tamanhoPermitido){
				echo 'O tamanho do arquivo enviado é maior que o limite!';
			}else{
				//Não houveram erros, move o arquivo
				$pasta = "fotos_usuarios/".$arqName;
				$_SESSION['ender_foto_user'] = $pasta;
				$upload = move_uploaded_file($arqTemp, $pasta);
				CadastroUsuario(); 
			}
		}else{
			echo "Selecione um arquivo!";
		}	
	}  
?>
<br>
<div class="control-group">
  <div class="controls">
  <button class="btn" id="submit_cad" name="submit_cad" type="submit">Cadastrar</button>
  </div>
</div>

</div>
</div>
</center>
</form>	
</body>
</html>	
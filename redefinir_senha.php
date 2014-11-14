<?php
	session_start();
	include "conectaBanco.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Redefinir Senha</title>

<?php require ('header.php'); ?>
</head>
 <body>
 	<?php require('topo.php'); ?>
 	<center>
	<form  action="" method="post"  id="lg_redef" name ="lg_redef">
	<div  class= "control-group" style="width: 50%; height:100%" > 
	  <label class="control-label" for="usuario"> Usuário </label>

	  <div class="controls">
	 	<input  id="usuario" name="usuario" type= "text"  class= "form-control"  placeholder= "Usuário" data-validation-matches-match="usuario"
		data-validation-matches-message=
			"DEU MERDA LOKO" required > 
	  </div>
	</div>

	<div  class= "control-group" style="width: 50%; height:100%"> 
	  <label class="control-label" for="email"> E-mail </label>

	  <div class="controls">
	 	<input  id="email" name="email" type= "text"  class= "form-control"  placeholder= "E-mail Cadastrado"  data-validation-matches-match="email"
		data-validation-matches-message=
			"DEU MERDA LOKO" required > 
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
 
	<br>
	<?php 
		if(isset($_POST['submit_trocar_senha'])){
			redef_senha();
		}
	?>
      <button class="btn" id="submit_trocar_senha" name="submit_trocar_senha" type="submit">Enviar</button>
      </center>
	</form>
</body>
<html>
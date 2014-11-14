<?php
	session_start();
	include "conectaBanco.php";
	cria_bd();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Controle de presença em eventos via web</title>
<?php require ('header.php'); ?>
</head>
<body>
<div  class="container">
	<div class="row clearfix">
		<div class="col-md-4 column">
		</div>
		<div class="col-md-4 column">
			<center>
			<form role="form" action="" method="post"  id="login" name ="login">
			<table>
			<div  class= "form-group" >
				<label class="control-label" for="usuario"> Usuário </label>
				<div class="controls">
				<input  id="usuario" name="usuario" type= "text"  class= "form-control input-small"  placeholder= "Usuário" >
				</div>
			</div>
			<div  class= "form-group" >
				<label class="control-label" for="password"> Senha </label>
				<div class="controls">
				<input  id="password" name="password" type= "password"  class= "form-control"  placeholder= "Senha" >
				</div>
			</div>
			<div class="form-group">
				<div class="controls">
				<input type="checkbox" id="lembrar_senha" name="lembrar_senha"/>
				<label  for="lembrar_senha"> Lembrar senha </label>
				<br>
				<button class="btn" id="submit_login" name="submit_login" type="submit">Logar</button>
				<button class="btn" id="submit_cad" name="submit_cad" type="submit">Cadastrar-se</button>
				<button class="btn" id="submit_red" name="submit_red" type="submit">Esqueci Minha Senha</button>
				</div>
			</div>
			<?php
			if(isset($_POST['submit_red'])){ header("Location: redefinir_senha.php");
			}if(isset($_POST['lembrar_senha'])){ setcookie("lembrar_senha",$_POST['lembrar_senha']);
			}if(isset($_POST['submit_login'] ) ){ loginUsuario();
			}if(isset($_GET['cod_error'])){ $cod = $_GET['cod_error'];
			if($cod == 40){ echo "<br><br><center>Usuario Deletado com Sucesso!<br></center>";
			}else if($cod == 50){ echo "<br><br><center>Faça Login!<br></center>";
			}
			}if(isset($_POST['submit_cad'])){ header("Location: cadastro.php?".SID);
			}
			?>
			</table>
			</form>
			</center>
		</div>
		<div class="col-md-4 column">
		</div>
	</div>
</div>
</body>
<html>
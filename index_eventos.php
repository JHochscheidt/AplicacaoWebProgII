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
<title>Controle de presença em eventos via web</title>

<?php require ('header.php'); ?>

</head>

<body>
	<?php require('topo.php'); ?>

	<div >
	<div >
	    	<?php sessao(); ?>
	</div>

	<div >
		<label>Próximos eventos</label>
		<!-- id_evento_sel -->
		<?php
			eventos();
		?>
	</div>

	  <div  > 
    	<center>EVENTOS</center>
		<?php
		sub_eventos();
		if(isset($_GET['id_evento']) && isset($_GET['id_sub_evento']) ){
			vincular_usuario_evento(); 
		}
		?>
    </div>

     <div > 
    	<center>DETALHES DO EVENTO</center>
		<?php
			if(isset($_GET['ver_mais'])){
				detalhes_eventos(); 
			}
		?>
    </div>
</div>
</body>
<html>
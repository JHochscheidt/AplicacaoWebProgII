<?php 
	session_start();
	if(!isset($_SESSION['username'])){	
		header("Location: index.php?cod_error=50&page=cracha".SID);
	}

	define('DB','bd_cadastro');
	define('USER','root');
	define('SENHA','');
	define('HOST','localhost');

	$conexao = mysqli_connect(HOST,USER,SENHA,DB)or die('Erro na conexão - '.mysql_error());

	$id_evento = $_GET['cracha_evento'];

	$nome_usuario = $_SESSION['username'];
	$id_usuario = $_SESSION['id_usuario'];

	$query = "SELECT * FROM eventos WHERE id_evento = '$id_evento'";

	$sql = mysqli_query($conexao,$query);

	$res = mysqli_fetch_array($sql);
	$nome_evento = $res['nome_evento'];
	$data_inicio = $res['data_inicio'];
	$data_fim = $res['data_fim'];
	$ender_banner = $res['ender_banner'];

	$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";

	$sql2 = mysqli_query($conexao,$query);

	$res2 = mysqli_fetch_array($sql2);

	$ender_foto_user = $res2['ender_foto_user'];

	$html='
	<html>
	<body>
	<center>
	<div>
	<h1>'.$nome_usuario.'</h1><br><h1>'.$nome_evento.'
	</h1><br><h1>'.$data_inicio.'</h1><br><h1>'.$data_fim.'
	</h1><br><img src=\''.$ender_foto_user.'\'/>
	</h1><br><img src=\''.$ender_banner.'\'/>
	</body>
	</html>';

	echo $html;

	//require_once('dompdf/dompdf_config.inc.php');

	//date_default_timezone_set('America/Sao_Paulo');

	//$html = utf8_decode($html);

	//$dompdf= new DOMPDF();

	//$dompdf->load_html($html);

	//$dompdf->set_paper('legal','landscape');

	//$dompdf->render();

	//$dompdf->stream('cracha.pdf');
?>	
<?php
define('HOST','localhost');
define('DB','bd_cadastro');
define('USER','root');
define('PASS','');


function cria_bd(){

    $conexao = mysqli_connect(HOST,USER,PASS) or die("Error".mysqli_error($conexao));

    $query = "CREATE DATABASE IF NOT EXISTS ".DB;

    $sql = mysqli_query($conexao,$query);

    $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

    $query2 = "CREATE TABLE IF NOT EXISTS eventos(
      id_evento int NOT NULL AUTO_INCREMENT, 
      nome_evento varchar(50) NOT NULL UNIQUE,
      data_inicio date NOT NULL,
      data_fim date NOT NULL,
      ender_banner varchar(100) NOT NULL,
      PRIMARY KEY(id_evento)
      )";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "CREATE TABLE IF NOT EXISTS eventos_user_vinc (
        usuario_id int(11) NOT NULL,
        evento_id int(11) NOT NULL,
         UNIQUE KEY evento_id (evento_id),
         KEY usuario_id (usuario_id)
       ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res =  mysqli_query($conexao,$query2);

    $query2 = "CREATE TABLE IF NOT EXISTS eventos_usuario (
        id_eventos_usuario int(11) NOT NULL AUTO_INCREMENT,
        fk_usuario int(11) NOT NULL,
        fk_eventos int(11) NOT NULL,
        fk_sub_eventos int(11) NOT NULL,
        PRIMARY KEY (id_eventos_usuario),
        KEY fk_usuario (fk_usuario),
        KEY fk_eventos (fk_eventos),
        KEY fk_sub_eventos (fk_sub_eventos)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "CREATE TABLE IF NOT EXISTS sub_eventos (
        id_sub_eventos int(11) NOT NULL AUTO_INCREMENT,
        fk_eventos int(11) NOT NULL,
        nome_sub_evento varchar(50) NOT NULL,
        descr text NOT NULL,
        vagas_totais int(11) NOT NULL,
        qt_horas float NOT NULL,
        PRIMARY KEY (id_sub_eventos),
        UNIQUE KEY nome_sub_evento (nome_sub_evento),
        KEY fk_eventos (fk_eventos)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "CREATE TABLE IF NOT EXISTS usuarios (
        id_usuario int(11) NOT NULL AUTO_INCREMENT,
        nome_completo varchar(40) NOT NULL,
        usuario varchar(40) NOT NULL,
        senha varchar(40) NOT NULL,
        email varchar(40) NOT NULL,
        ender_foto_user varchar(100) NOT NULL,
        PRIMARY KEY (id_usuario),
        UNIQUE KEY usuario (usuario)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "ALTER TABLE eventos_user_vinc
         ADD CONSTRAINT eventos_user_vinc_ibfk_4 FOREIGN KEY (usuario_id) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT eventos_user_vinc_ibfk_3 FOREIGN KEY (evento_id) REFERENCES eventos (id_evento) ON DELETE CASCADE ON UPDATE CASCADE";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "ALTER TABLE eventos_usuario
        ADD CONSTRAINT eventos_usuario_ibfk_3 FOREIGN KEY (fk_sub_eventos) REFERENCES sub_eventos (id_sub_eventos) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT eventos_usuario_ibfk_1 FOREIGN KEY (fk_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT eventos_usuario_ibfk_2 FOREIGN KEY (fk_eventos) REFERENCES eventos (id_evento) ON DELETE CASCADE ON UPDATE CASCADE";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "ALTER TABLE sub_eventos
        ADD CONSTRAINT sub_eventos_ibfk_1 FOREIGN KEY (fk_eventos) REFERENCES eventos (id_evento) ON DELETE CASCADE ON UPDATE CASCADE";
    $res =  mysqli_query($conexao,$query2);

    $query2 = "ALTER TABLE eventos_usuario ADD UNIQUE( fk_usuario, fk_eventos, fk_sub_eventos)";
    $res =  mysqli_query($conexao,$query2);

    mysqli_close($conexao);
}

function CadastroUsuario(){
  
    $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

    $nome_completo=$_POST['nome_completo'];
    $usuario=$_POST['usuario'];  
    $senha=$_POST['password'];
    $email=$_POST['email'];

    $ender_foto_user = $_SESSION['ender_foto_user'];    
    session_unset($_SESSION['ender_foto_user']);

    $query = "INSERT INTO usuarios (nome_completo,usuario, senha, email,ender_foto_user) VALUES ('$nome_completo', '$usuario', '$senha','$email','$ender_foto_user')"; 
    $sql =  mysqli_query($conexao,$query);    
    if( $sql ){
        echo "<center><br>Cadastro Realizado com Sucesso!<br></center>";
    }else{
       echo "<center><br>Erro ao Cadastrar!<br></center>";
    }
    mysqli_close($conexao);
}

function excluir_usuario(){
  $id_usuario = $_SESSION['id_usuario'];

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query = "SELECT * FROM usuarios WHERE id_usuario='$id_usuario'"; 
  $sql =  mysqli_query($conexao,$query);
  $res = mysqli_fetch_assoc($sql);

  $arquivo = $res['ender_foto_user'];
  unlink($arquivo);

  $query = "SELECT * FROM eventos_user_vinc WHERE usuario_id='$id_usuario'"; 
  $sql =  mysqli_query($conexao,$query);
  while($res = mysqli_fetch_assoc($sql)){
     $id_exc = $res['evento_id'];

     $query = "SELECT * FROM eventos WHERE id_evento='$id_exc'";
     $sql =  mysqli_query($conexao,$query);
     $res2 = mysqli_fetch_assoc($sql);

     $arquivo2 = $res2['ender_banner'];
     unlink($arquivo2);

     $query = "SELECT * FROM eventos WHERE id_evento='$id_exc'"; 
     $sql =  mysqli_query($conexao,$query);

     while ($res3 = mysqli_fetch_assoc($sql)){
        $id_evento = $res3['id_evento'];

        $query = "DELETE FROM sub_eventos WHERE fk_eventos ='$id_evento'"; 
        $sql =  mysqli_query($conexao,$query);
     }
     $query = "DELETE FROM eventos WHERE id_evento='$id_exc'"; 
     $sql =  mysqli_query($conexao,$query);
  }

  $query = "DELETE FROM eventos_user_vinc WHERE usuario_id = '$id_usuario'"; 
  $sql =  mysqli_query($conexao,$query);

  $query = "DELETE FROM usuarios WHERE id_usuario='$id_usuario'"; 
  $sql =  mysqli_query($conexao,$query);

  if($sql){
    header("Location: index.php?cod_error=40&".SID);
    session_destroy();
  }else{
    echo "<center>Erro ao deletar Conta!</center>";
  }
  mysqli_close($conexao);
}

  function loginUsuario(){

    $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$password' ";
    $consulta = mysqli_query($conexao,$query);
    if( $res =mysqli_fetch_assoc($consulta) ){
        $_SESSION['username'] = $res['nome_completo'];
        $_SESSION['id_usuario'] = $res['id_usuario'];

        header("Location: index_eventos.php?".SID);
    }else{
       echo "<br><br>Erro ao logar! Verifique seu nome de usuário e senha.<br>";
    }
    mysqli_close($conexao);
}
  function cad_eventos(){

  $nome_evento = $_POST['nome_evento'];
  $data_inicio = $_POST['data_inicio'];
  $data_fim = $_POST['data_fim'];

  $usuario_id = $_SESSION['id_usuario']; 

  $ender_banner = $_SESSION['ender_banner'];
  
  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));
  $query1 = "INSERT INTO eventos(nome_evento,data_inicio,data_fim,ender_banner) VALUES('$nome_evento','$data_inicio','$data_fim','$ender_banner')";

  $consulta1 = mysqli_query($conexao,$query1);
  if ( $consulta1 ){
    $query1 = "SELECT * FROM eventos WHERE nome_evento ='$nome_evento' and data_inicio='$data_inicio' and data_fim='$data_fim' and ender_banner='$ender_banner'";

    $consulta1 = mysqli_query($conexao,$query1);
    $res = mysqli_fetch_assoc($consulta1);
    $evento_id = $res['id_evento'];
    
    $query2 = "INSERT INTO eventos_user_vinc(usuario_id,evento_id) VALUES('$usuario_id','$evento_id')";
    $consulta2 = mysqli_query($conexao,$query2);
    if($consulta2){
      echo "<br><center>Voce inseriu um novo evento ao indice!<br></center>";
    }else{
      echo "<br><center>Erro ao inserir no indice!<br></center>";
    }
  }else{
    echo "<br><center>Erro ao inserir novo evento!<br></center>";
  }
  header("Location: index_user.php?".SID);
  mysqli_close($conexao);
}
function cad_sub_eventos(){
  
  $fk_eventos = $_POST['fk_eventos'];
  $nome_sub_evento = $_POST['nome_sub_evento'];
  $descr = $_POST['descr'];
  $vagas_totais = $_POST['vagas_totais'];
  $qt_horas = $_POST['qt_horas'];

  $usuario_id = $_SESSION['id_usuario'];
   
  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query2 = "SELECT * FROM eventos_user_vinc WHERE evento_id='$fk_eventos' and usuario_id='$usuario_id'";

  $consulta2 = mysqli_query($conexao,$query2);

  if($res = mysqli_fetch_assoc($consulta2)){    
     $query2 = "INSERT INTO sub_eventos (fk_eventos,nome_sub_evento,descr, vagas_totais, qt_horas) VALUES('$fk_eventos','$nome_sub_evento','$descr','$vagas_totais','$qt_horas')";

     $consulta2 = mysqli_query($conexao,$query2);
     if ( $consulta2 ){
       echo "Voce inseriu um novo sub_evento com sucesso!";
    }else{
      echo "Erro ao inserir sub evento!";
    }
  }
  mysqli_close($conexao);
}

function eventos_usuario(){

  $fk_usuario = $_SESSION['id_usuario'];

 
  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query2 = "SELECT * FROM eventos_usuario INNER JOIN usuarios ON (eventos_usuario.fk_usuario=usuarios.id_usuario) INNER JOIN eventos ON (eventos.id_evento=eventos_usuario.fk_eventos) INNER JOIN sub_eventos ON (sub_eventos.id_sub_eventos=eventos_usuario.fk_sub_eventos)";

  $consulta2 = mysqli_query($conexao,$query2);
  while( $res = mysqli_fetch_assoc($consulta2)){
    echo "<br><a href='cracha.php?cracha_evento=".$res['id_evento']."'>";
    echo $res['nome_evento'];
    echo "</a>";
    echo " - ".$res['nome_sub_evento']."  ";
    echo "<input type='checkbox' name='sel_exc[]' value='".$res['id_eventos_usuario']."'><br>";              
  }
  mysqli_close($conexao); 
}

function eventos(){ //busca todos os eventos

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));
  $query = "SELECT * FROM eventos";
  $consulta = mysqli_query($conexao,$query);
  while ( $res = mysqli_fetch_assoc($consulta)){
    echo "<table border = 1 width=\"100%\">";
    echo "<tr><td>";
    echo "<a href='index_eventos.php?id=".$res['id_evento']."'>";
    echo $res['nome_evento'];
    echo "</a>";
    echo "</td></tr>";
    echo "</table>";
  }
  mysqli_close($conexao);
}
function sub_eventos(){//retorn os eventos e subeventos associados
  
  $evento_sel = "";
    if(isset($_GET['id'])) $evento_sel = $_GET['id'];

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));
  $query = "SELECT * FROM sub_eventos INNER JOIN eventos ON  eventos.id_evento = sub_eventos.fk_eventos and eventos.id_evento='$evento_sel'";
  $consulta = mysqli_query($conexao,$query);

  while ( $res = mysqli_fetch_assoc($consulta)){
    echo "<table border = 1 width=\"100%\">";
    echo "<tr><h4><td>".$res['nome_sub_evento']."</h4>";
    echo "<a href='index_eventos.php?id_evento=".$res['id_evento']."&id_sub_evento=".$res['id_sub_eventos']."'>";
    echo " <img src='img/certo.gif'/> </a>";

    echo "<a href='index_eventos.php?ver_mais=".$res['id_sub_eventos']."'>";
    echo " Exibir </td></a>";

    echo " </tr>";
    echo "</table>";
  }
  mysqli_close($conexao);
}

function vincular_usuario_evento(){
  $fk_eventos = $_GET['id_evento'];
  $fk_sub_eventos = $_GET['id_sub_evento'];
  $fk_usuario = $_SESSION['id_usuario'];

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query1 = "SELECT * FROM sub_eventos WHERE id_sub_eventos='$fk_sub_eventos'";
  $consulta1 = mysqli_query($conexao,$query1);
  $res = mysqli_fetch_assoc($consulta1);
  if($res['vagas_totais']>=1){
    $fk_eventos = $res['fk_eventos'];
    $fk_sub_eventos = $res['id_sub_eventos'];

    $query1 = "INSERT INTO eventos_usuario(fk_usuario,fk_eventos,fk_sub_eventos) VALUES('$fk_usuario','$fk_eventos','$fk_sub_eventos')";
    $consulta1 = mysqli_query($conexao,$query1);

    $query1 = "UPDATE sub_eventos SET vagas_totais=vagas_totais-1 WHERE id_sub_eventos ='$fk_sub_eventos'";
    $consulta1 = mysqli_query($conexao,$query1);

    if($consulta1){
      echo "<center><br>Presença confirmada!<br></center>";
    }else{
      echo "<center>Erro ao Vincular!</center>";
    } 
  }else{
    echo "<br><br>Não há mais vagas para o evento selecionado!<br>";
  }
  mysqli_close($conexao);   
}
function sessao(){
  if(isset($_SESSION['username'])){
    echo "<center>";
    echo "<h3>VOCE ESTÁ CONECTADO(A) COMO:  <b>".$_SESSION['username']."</b></h3>";
    echo "<a href='index_eventos.php?sair'> Sair </a>";
    echo "</center>";

   
    if(isset($_GET['sair'])){
      session_destroy();
      header("Location:index.php?".SID);     
    }
  }
}
function meus_eventos_criados(){
  $id_usuario = $_SESSION['id_usuario'];

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query1 = "SELECT * FROM eventos_user_vinc WHERE usuario_id ='$id_usuario'";
  $consulta1 = mysqli_query($conexao,$query1);
  if($consulta1){
    while($res = mysqli_fetch_assoc($consulta1)){
      $id_even = $res['evento_id'];
      $query2 = "SELECT * FROM eventos INNER JOIN sub_eventos ON (sub_eventos.fk_eventos = eventos.id_evento) WHERE id_evento='$id_even'";   
      $consulta2 = mysqli_query($conexao,$query2);

      while($res2 = mysqli_fetch_assoc($consulta2)){
        echo "<table border = 1 width=\"100%\">";
        echo "<tr>";
        echo "<td><b>".$res2['nome_evento']."</b></td>";
        echo "<td><b>".$res2['nome_sub_evento']."</b>";

        echo "<a href='index_user.php?sub_exc=".$res2['id_sub_eventos']."'>";
        echo "<img src='img/excluir.gif'/></a>";
        echo "<a href='edit_evento.php?sub_edit=".$res2['id_sub_eventos']."'>";
        echo "<img src='img/edit.gif'/></a></td>";
        echo "</tr>";
        echo "</table>";
      } 
    }
  }
  mysqli_close($conexao);
}

function excluir_eventos_user(){
  if(isset($_POST['sel_exc'])){
    foreach($_POST['sel_exc'] as $sel_event) 
    { 
    $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

    $query1 = "SELECT * FROM eventos_usuario WHERE id_eventos_usuario='$sel_event'";
    $consulta1 = mysqli_query($conexao,$query1);

    while ($res = mysqli_fetch_assoc($consulta1)) {
       $fk_sub_eventos = $res['fk_sub_eventos'];

       $query1 = "UPDATE sub_eventos SET vagas_totais=vagas_totais+1 WHERE id_sub_eventos ='$fk_sub_eventos'";
       $consulta1 = mysqli_query($conexao,$query1);
    }

    $query1 = "DELETE FROM eventos_usuario WHERE id_eventos_usuario='$sel_event'";
    $consulta1 = mysqli_query($conexao,$query1);
   }
   header("Location: index_user.php?".SID);
   mysqli_close($conexao); 
   }else{
     echo "<br>Nenhum Evento foi Selecionado<br>";
   } 
}

function sel_event_assoc(){
  $usuario_id = $_SESSION['id_usuario'];

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));
  
  $query2 = "SELECT * FROM eventos_user_vinc WHERE  usuario_id='$usuario_id'";

  $consulta2 = mysqli_query($conexao,$query2);

  while($res = mysqli_fetch_assoc($consulta2)){
    $id_evento = $res['evento_id'];
    $query3 = "SELECT * FROM eventos WHERE  id_evento='$id_evento'";
    $consulta3 = mysqli_query($conexao,$query3);
    if($res2 = mysqli_fetch_assoc($consulta3)){
      echo "
            <div  class= 'control-group' > 
                <label class='control-label' for='nome_sub_evento'> Nome Sub-Evento </label>
              
                <div class='controls'>
                  <option  value=\"".$res2['id_evento']."\" id='nome_sub_evento' name='nome_sub_evento' class= 'form-control'>".$res2['nome_evento']."</option>   
                </div>
            </div>";      
    }
  }
  mysqli_close($conexao);
}
function detalhes_eventos(){
  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));
  $id_sub_eventos = $_GET['ver_mais'];
  $query2 = "SELECT * FROM sub_eventos WHERE  id_sub_eventos='$id_sub_eventos'";

  $consulta2 = mysqli_query($conexao,$query2);

  while($res = mysqli_fetch_assoc($consulta2)){
    echo "<center>";
    echo "<h4><b>NOME DO EVENTO:</b></h4><br><h2><b>".$res['nome_sub_evento']."</h2></b><br>";

    echo "<h2><b>".$res['descr']."</h2></b><br>";

    echo "<h2><b>"."VAGAS TOTAIS:<br>".$res['vagas_totais']."</h2></b><br>";

    echo "<h2><b>DURAÇÃO DO EVENTO:<br>".$res['qt_horas']." Horas</h2></b><br>";
    echo "</center>";
  }
  mysqli_close($conexao);
}
function exc_event_user_vinc(){

  $id_sub_eventos = $_GET['sub_exc'];
  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query1 = "DELETE FROM sub_eventos WHERE id_sub_eventos='$id_sub_eventos'";
  $consulta1 = mysqli_query($conexao,$query1);
  header("Location: index_user.php?".SID);
  mysqli_close($conexao);
}
function redef_senha(){

  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));
  
  $_SESSION['usuario_temp'] = $_POST['usuario'];
  $_SESSION['email_temp']= $_POST['email'];
  $_SESSION['password'] = $_POST['password'];
  $_SESSION['confirm_pass'] = $_POST['confirm_pass'];

  $usuario = $_SESSION['usuario_temp'];
  $email = $_SESSION['email_temp'];
  $password = $_SESSION['password'];
  $confirm_pass = $_SESSION['confirm_pass'];

  $query1 = "SELECT * FROM usuarios WHERE usuario ='$usuario' and email='$email'";
  $consulta1 = mysqli_query($conexao,$query1);
    if($consulta1){
      $query1 = "UPDATE  usuarios SET senha ='$password' WHERE usuario='$usuario' and email = '$email'";
      $consulta1 = mysqli_query($conexao,$query1);
      if($consulta1){
         echo "<center><br>A senha foi alterada com sucesso!</center><br>";
      }else{
        echo "<br>DEU MERDA CARALHO!!!!!!!!!!!<br>";
      }
    }
  mysqli_close($conexao);
}

function atualiza_sub_evento(){

  
  $update_event = $_GET['sub_edit'];
  $nome_sub_evento = $_POST['novo_nome_sub_evento'];
  $descr = $_POST['nova_descr'];
  $vagas_totais = $_POST['nova_vagas_totais'];
  $qt_horas = $_POST['nova_qt_horas'];

  $usuario_id = $_SESSION['id_usuario'];
  
  $conexao = mysqli_connect(HOST,USER,PASS,DB) or die("Error".mysqli_error($conexao));

  $query2 = "UPDATE sub_eventos SET nome_sub_evento = '$nome_sub_evento', descr = '$descr', vagas_totais = '$vagas_totais', qt_horas = '$qt_horas' WHERE id_sub_eventos = '$update_event'";
  $consulta2 = mysqli_query($conexao,$query2);

  if($consulta2){
    echo "<center><br>SUB EVENTO ATUALIZADO COM SUCESSO!<br></center>";
  }else{
    echo "<center><br>ERRO AO ATUALIZAR! TENTE NOVAMENTE!<br></center>";
  }
  mysqli_close($conexao);
}
?>
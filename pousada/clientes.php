
<?php

require_once('conexao.php');

if(isset($_POST['nome']) && $_POST['nome'] != "" && isset($_POST['documento']) && $_POST['documento'] != "" && isset($_POST['dataNascimento']) && $_POST['dataNascimento'] != ""  && isset($_POST['cidade']) && $_POST['cidade'] != ""){

	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$documento = $_POST['documento'];
	$dataNascimento = str_replace('/', '-', $_POST['dataNascimento']);
	$dataNascimentoFormatada= date('Y-m-d', strtotime($dataNascimento));
	$cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

	if($id == ""){
		$sqlValidacaoCliente = "select documento from clientes where documento = '$documento'";
		$sql = "insert into clientes (nome, documento, data_nascimento, cidade, estado) values ('$nome', '$documento', '$dataNascimentoFormatada', '$cidade', '$estado')";
	}else{
		$sqlValidacaoCliente = "select documento from clientes where documento = '$documento' and id != '$id'";
		$sql = "update clientes set nome = '$nome', documento = '$documento', data_nascimento = '$dataNascimentoFormatada', cidade = '$cidade', estado = '$estado' where id = ".$id;
	}

	$resultadoValidacaoCliente = mysqli_query($conexao, $sqlValidacaoCliente);

	if ($resultadoValidacaoCliente && mysqli_fetch_array($resultadoValidacaoCliente)['documento']!=""){
		$_GET['msg'] = 'Documento já cadastrado';
	} else {
		$resultado = mysqli_query($conexao, $sql);

		if ($resultado && $id==""){
			$_GET['msg'] = 'Dados inseridos com sucesso';
			$_POST = null;
		}elseif($resultado && $id!=""){
			$_GET['msg'] = 'Dados alterados com sucesso';
			$_POST = null;
		}elseif(!$resultado){
			$_GET['msg'] = 'Falha ao inserir o cliente';
		}
	}
}

if(isset($_GET['msg']) && $_GET['msg'] != ""){
	echo '<p class="centralizado">'.$_GET['msg'].'</p>';
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Gerenciamento de clientes</title>
    <meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link rel="stylesheet" type="text/css" href="menu.css">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="quartos.php">Quartos</a></li>
			<li><a href="#">Clientes</a></li>
			<li><a href="reservas.php">Reservas</a></li>
		</ul>
	</div>
	<form action="cliente.php" method="post">
		<h2 class="centralizado"> Gerenciamento de clientes</h2>
		<input type="submit" name="cliente" value="Cadastrar">
	</form>

    <table border=1 width=80% align=center><tr>
        <td><label for="nome">Nome</label></td>
        <td><label for="documento">Documento</label></td>
        <td><label for="dataNascimento">Data Nascimento</label></td>        
        <td><label for="cidade">Cidade</label></td>
        <td><label for="estado">Estado</label></td>
		<td>Opções</td>
    </tr>

    
    <?php
    	$sql = "select * from clientes ";
		$resultado = mysqli_query($conexao, $sql);

		while($dados = mysqli_fetch_array($resultado)){
			echo '<tr><td>'.$dados['nome'].'</td>
				  <td>'.$dados['documento'].'</td>        
				  <td>'.date("d-m-Y", strtotime($dados['data_nascimento'])).'</td>
                  <td>'.$dados['cidade'].'</td>
                  <td>'.$dados['estado'].'</td>
				  <td>
					<a href="excluirCliente.php?id='.$dados['id'].'">Excluir</a>
					<a href="cliente.php?id='.$dados['id'].'">Alterar</a>
				  </td></tr>';
		}
		mysqli_close($conexao);

	?>

    </table>
</body>
</html>
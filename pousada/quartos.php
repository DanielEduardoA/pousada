
<?php

require_once('conexao.php');


if(isset($_POST['numero']) && $_POST['numero'] != ""){

	$id = $_POST['id'];
	$numero = $_POST['numero'];
	$valor = $_POST['valor'];
	
	$valorFomatado = str_replace('.', '', $valor);
	$valorFomatado = str_replace(',', '.', $valorFomatado);

	$tipo = $_POST['tipo'];
	$status = $_POST['status'];

	if($id == ""){
		$sqlValidacaoQuarto = "select numero_porta from quartos where numero_porta = '$numero'";
		$sql = "insert into quartos (numero_porta, status, tipo_quarto, valor) values ('$numero', '$status', '$tipo', '$valorFomatado')";
	}else {
		$sqlValidacaoQuarto = "select numero_porta from quartos where numero_porta = '$numero' and id != '$id'";
		$sql = "update quartos set numero_porta = '$numero', status = '$status', tipo_quarto = '$tipo', valor = '$valorFomatado' where id = ".$id;
	}

	$resultadoValidacaoQuarto = mysqli_query($conexao, $sqlValidacaoQuarto);
	

	if ($resultadoValidacaoQuarto && mysqli_fetch_array($resultadoValidacaoQuarto)['numero_porta']!=""){
		$_GET['msg'] = 'Número do quarto já cadastrado';
	} else {
		$resultado = mysqli_query($conexao, $sql);

		if ($resultado && $id==""){
			$_GET['msg'] = 'Dados inseridos com sucesso';
			$_POST = null;
		}elseif($resultado && $id!=""){
			$_GET['msg'] = 'Dados alterados com sucesso';
			$_POST = null;
		}elseif(!$resultado){
			$_GET['msg'] = 'Falha ao inserir o quarto';
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
    <title>Gerenciamento de quartos</title>
    <meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link rel="stylesheet" type="text/css" href="menu.css">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Quartos</a></li>
			<li><a href="clientes.php">Clientes</a></li>
			<li><a href="reservas.php">Reservas</a></li>
		</ul>
	</div>
	<form action="quarto.php" method="post">
		<h2 class="centralizado">Gerenciamento de quartos</h2>
		<input type="submit" name="quarto" value="Cadastrar">
	</form>

    <table border=1 width=80% align=center><tr>
        <td><label for="numero">Número da porta do quarto</label></td>
        <td><label for="tipo">Tipo do quarto</label></td>
        <td><label for="valor">Valor do quarto</label></td>        
        <td><label for="status">Status do quarto</label></td>
		<td>Opções</td>
    </tr>

    
    <?php
    	$sql = "select * from quartos ";
		$resultado = mysqli_query($conexao, $sql);

		while($dados = mysqli_fetch_array($resultado)){
			echo '<tr><td>'.$dados['numero_porta'].'</td>
				  <td>'.$dados['tipo_quarto'].'</td>        
				  <td>'.$dados['valor'].'</td>
				  <td>'.$dados['status'].'</td>
				  <td>
					<a href="excluirQuarto.php?id='.$dados['id'].'">Excluir</a>
					<a href="quarto.php?id='.$dados['id'].'">Alterar</a>
				  </td></tr>';
		}

		mysqli_close($conexao);

	?>

    </table>
</body>
</html>
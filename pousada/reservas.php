
<?php

require_once('conexao.php');

if(isset($_POST['dataEntrada']) && $_POST['dataEntrada'] != "" && isset($_POST['dataSaida']) && $_POST['dataSaida'] != "" && isset($_POST['valorReserva']) && $_POST['valorReserva'] != ""  && isset($_POST['dataHora']) && $_POST['dataHora'] != ""){

	$id = $_POST['id'];
	$cliente = $_POST['cliente'];
	$quarto = $_POST['quarto'];

	$dataEntrada = str_replace('/', '-', $_POST['dataEntrada']);
	$dataSaida = str_replace('/', '-', $_POST['dataSaida']);

	$dataEntradaTime = strtotime($dataEntrada);
	$dataSaidaTime = strtotime($dataSaida);

	$dataEntradaFormatada= date('Y-m-d', $dataEntradaTime);
	$dataSaidaFormatada= date('Y-m-d', $dataSaidaTime);

	if($dataEntradaTime > $dataSaidaTime ){
		$_GET['msg'] = 'Data entrada deve ser menor ou igual a data de saída';
	} else {
		$valorReserva = $_POST['valorReserva'];
		$status = $_POST['status'];

		$dataHora = str_replace('/', '-', $_POST['dataHora']);
		$dataHoraFormatada= date('Y-m-d H:i',strtotime($dataHora));

		$valorFomatado = str_replace('.', '', $valorReserva);
		$valorFomatado = str_replace(',', '.', $valorFomatado);
		
		if($id == ""){
			$sql = "insert into reservas (id_quarto, id_cliente, data_entrada, data_saida, valor_reserva, status, data_hora) values ('$quarto', '$cliente', '$dataEntradaFormatada', '$dataSaidaFormatada', '$valorFomatado', '$status', '$dataHoraFormatada')";
		}else{
			$sql = "update reservas set data_hora = '$dataHoraFormatada', status = '$status' where id = ".$id;
		}
		
		$resultado = mysqli_query($conexao, $sql);

		if ($resultado && $id==""){
			$_GET['msg'] = 'Dados inseridos com sucesso';
			$_POST = null;
		}elseif($resultado && $id!=""){
			$_GET['msg'] = 'Dados alterados com sucesso';
			$_POST = null;
		}elseif(!$resultado){
			$_GET['msg'] = 'Falha ao inserir a reserva';
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
    <title>Gerenciamento de reservas</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link rel="stylesheet" type="text/css" href="menu.css">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="quartos.php">Quartos</a></li>
			<li><a href="clientes.php">Clientes</a></li>
			<li><a href="#">Reservas</a></li>
		</ul>
	</div>
	<form action="reserva.php" method="post">
		<h2 class="centralizado">Gerenciamento de reservas</h2>
		<input type="submit" name="reserva" value="Cadastrar">
	</form>

    <table border=1 width=80% align=center><tr>
        <td><label for="cliente">Cliente</label></td>
        <td><label for="quarto">Quarto</label></td>
        <td><label for="dataEntrada">Data Entrada</label></td>        
        <td><label for="datSaida">Data Saída</label></td>
        <td><label for="valorReserva">Valor Reserva</label></td>
		<td><label for="statusReserva">Status Reserva</label></td>
		<td><label for="dataHora">Data Hora Reserva</label></td>
		<td>Opções</td>
    </tr>

    
    <?php
    	$sqlReservas = "select * FROM reservas";
		$resultado = mysqli_query($conexao, $sqlReservas);

		while($dados = mysqli_fetch_array($resultado)){
			$sqlCliente = "select nome from clientes where id = " .$dados['id_cliente'];
			$resultadoCliente = mysqli_query($conexao, $sqlCliente);
			if($resultadoCliente){
				$dadoCliente = mysqli_fetch_array($resultadoCliente);
			}

			$sqlQuarto= "select numero_porta from quartos where id = " .$dados['id_quarto'];
			$resultadoQuarto = mysqli_query($conexao, $sqlQuarto);
			if($resultadoQuarto){
				$dadoQuarto = mysqli_fetch_array($resultadoQuarto);
			}

			echo '<tr><td>'.$dadoCliente['nome'].'</td>
				  <td>'.$dadoQuarto['numero_porta'].'</td>        
				  <td>'.date("d-m-Y", strtotime($dados['data_entrada'])).'</td>
				  <td>'.date("d-m-Y", strtotime($dados['data_saida'])).'</td>
                  <td>'.$dados['valor_reserva'].'</td>
				  <td>'.$dados['status'].'</td>
				  <td>'.date('d-m-Y H:i',strtotime($dados['data_hora'])).'</td>
				  <td>
					<a href="reserva.php?id='.$dados['id'].'">Alterar</a>
				  </td></tr>';
		}
		mysqli_close($conexao);

	?>

    </table>
</body>
</html>
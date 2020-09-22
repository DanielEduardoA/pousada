<?php

	require_once('conexao.php');
	
	$quarto = '';
    $cliente = '';
    $dataEntrada = '';
    $dataSaida = '';
    $valorReserva = '';
    $statusReserva = '';
    $dataHora = '';
    $id = '';
    $edit = false;
    
    $sqlClientes = "select id, nome from clientes ";
    $resultadoCliente = mysqli_query($conexao, $sqlClientes);
    if($resultadoCliente){
        $dadosCliente = mysqli_fetch_assoc($resultadoCliente);
    }

    $sqlQuartos = "select id, numero_porta from quartos where status = 'livre'";
    $resultadoQuarto = mysqli_query($conexao, $sqlQuartos);
    if($resultadoQuarto){
        $dadosQuarto = mysqli_fetch_assoc($resultadoQuarto);
    }
	
	if(isset($_GET['id']) && $_GET['id'] != ""){
		$sql = "select * from reservas where id = ".$_GET['id'];
		$resultado = mysqli_query($conexao, $sql);
		if($resultado){
			$dados = mysqli_fetch_array($resultado);
			$cliente = $dados['id_cliente'];
            $quarto = $dados['id_quarto'];
            $dataEntrada = date("d-m-Y", strtotime($dados['data_entrada']));
            $dataSaida = date("d-m-Y", strtotime($dados['data_saida']));
            $valorReserva = number_format($dados['valor_reserva'], 2, ',', '.');
            $statusReserva = $dados['status'];
            $dataHora = date("d-m-Y H:i", strtotime($dados['data_hora']));
            $id = $dados['id'];
            $edit = true;
        }
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Reserva</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="stylesheet" type="text/css" href="menu.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript"></script>
    <script src="mascaraMoeda.js" type="text/javascript"></script>
    <script src="mascaraData.js" type="text/javascript"></script>
    <script src="mascaraDataHora.js" type="text/javascript"></script>
    <script src="validacao.js" type="text/javascript"></script>
</head>
<body background-color = "gray">
    <div  align=center>
    <form class="formulario" method="post" action="reservas.php" align=left> 
        <p class="centralizado"> Gerenciamento de reservas</p>
		
		<input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="field">
            <label for="cliente">Cliente:</label>
            <select name="cliente" required                             
                    <?php 
                        if($edit){
                            echo 'readonly="readonly" tabindex="-1" aria-disabled="true"';
                        } 
                    ?>>
                <option value="">Selecione</option>

                <?php
                    do {?>
                        <option value="<?php echo $dadosCliente['id']?>"
                            <?php 
                                if($cliente==$dadosCliente['id']){
                                    echo 'selected';
                                } ?>>
                            <?php echo $dadosCliente['nome']; ?>
                        </option>
                <?php
                    } while($dadosCliente = mysqli_fetch_assoc($resultadoCliente));
                ?>
            <select>
        </div>

        <div class="field">
            <label for="quarto">Quarto:</label>
            <select name="quarto" required
                <?php 
                    if($edit){
                        echo 'readonly="readonly" tabindex="-1" aria-disabled="true"';
                    } 
                ?>>
            <option value="">Selecione</option>

            <?php
                do {?>
                    <option value="<?php echo $dadosQuarto['id']?>"
                        <?php 
                            if($quarto==$dadosQuarto['id']){
                                echo 'selected';
                            } ?>>
                        <?php echo $dadosQuarto['numero_porta']; ?>
                    </option>
            <?php
                } while($dadosQuarto = mysqli_fetch_assoc($resultadoQuarto));
            ?>
            <select>
        </div>

        <div class="field">
            <label for="dataEntrada">Data Entrada:</label>
            <input type="text" id="dataEntrada" name="dataEntrada" onkeypress="mascaraData( this, event )" onblur="validaData(this,this.value)" value="<?php echo $dataEntrada; ?>" placeholder="Digite a data de entrada*" required
            <?php 
                if($edit){
                    echo 'readonly';
                } 
            ?>>
        </div>

        <div class="field">
            <label for="dataSaida">Data Saida:</label>
            <input type="text" id="dataSaida" name="dataSaida" onkeypress="mascaraData( this, event )" onblur="validaData(this,this.value)" value="<?php echo $dataSaida; ?>" placeholder="Digite a data de saída*" required 
            <?php 
                if($edit){
                    echo 'readonly';
                } 
            ?>>
        </div>

        <div class="field">
            <label for="valorReserva">Valor Reserva:</label>
            <input type="text" id="valor" name="valorReserva" value="<?php echo $valorReserva; ?>" placeholder="Digite o valor da reserva*" required
            <?php 
                if($edit){
                    echo 'readonly';
                } 
            ?>>
        </div>

        <div class="field">
            <label for="status">Status reserva:</label>
            <select name="status" required>
                <option value="">Selecione</option>
                <option value="checkin" <?=($statusReserva == 'checkin')? 'selected' : ''?>>Checkin</option>
                <option value="checkout" <?=($statusReserva == 'checkout')? 'selected' : ''?>>Checkout</option>
                <option value="cancelada" <?=($statusReserva == 'cancelada')? 'selected' : ''?>>Cancelada</option>
            </select>
        </div>
        
        <div class="field">
            <label for="dataHora">Data Hora Reserva:</label>
            <input type="text" id="dataHora" class="data-hora" onblur="validaDataHora(this.value)" name="dataHora" value="<?php echo $dataHora; ?>" placeholder="Digite a data hora da reserva*" required>
        </div>
 
    <input type="submit" name="reservas" value="Enviar">
    <a class="btnVoltar" href="reservas.php">Voltar</a>
        
    </form>
</div>
</body>
</html>
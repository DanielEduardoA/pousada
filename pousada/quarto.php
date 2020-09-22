<?php

	require_once('conexao.php');
	
	$numero = '';
    $valor = '';
    $tipo = '';
    $status = '';
	$id = '';
	
	if(isset($_GET['id']) && $_GET['id'] != ""){
		$sql = "select * from quartos where id = ".$_GET['id'];
		$resultado = mysqli_query($conexao, $sql);
		if($resultado){
			$dados = mysqli_fetch_array($resultado);
			$numero = $dados['numero_porta'];
            $valor = number_format($dados['valor'], 2, ',', '.');
            $tipo = $dados['tipo_quarto'];
            $status = $dados['status'];
			$id = $dados['id'];
		}
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Quarto</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="stylesheet" type="text/css" href="menu.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript"></script>
    <script src="mascaraMoeda.js" type="text/javascript"></script>
</head>
<body background-color = "gray">
    <div width=60% align=center>
    <form class="formulario" method="post" action="quartos.php" align=left> 
        <p class="centralizado"> Gerenciamento de quartos</p>
		
		<input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="field">
            <label for="numero">Número quarto:</label>
            <input type="text" id="numero" name="numero" value="<?php echo $numero; ?>" placeholder="Digite o número do quarto*" required>
        </div>
        
        <div class="field">
            <label for="tipo">Tipo quarto:</label>
            <select name="tipo" required>
                <option value="">Selecione</option>
                <option value="simples" <?=($tipo == 'simples')? 'selected' : ''?>>Simples</option>
                <option value="duplo" <?=($tipo == 'duplo')? 'selected' : ''?>>Duplo</option>
                <option value="triplo" <?=($tipo == 'triplo')? 'selected' : ''?>>Triplo</option>
            </select>
        </div>
 
        <div class="field">
            <label for="valor">Valor quarto:</label>
            <input type="text" id="valor" name="valor" value="<?php echo $valor; ?>" placeholder="Digite o valor do quarto*" required>
        </div>

        <div class="field">
            <label for="status">Status quarto:</label>
            <select name="status" required>
                <option value="">Selecione</option>
                <option value="livre" <?=($status == 'livre')? 'selected' : ''?>>Livre</option>
                <option value="ocupado" <?=($status == 'ocupado')? 'selected' : ''?>>Ocupado</option>
                <option value="bloqueado" <?=($status == 'bloqueado')? 'selected' : ''?>>Bloqueado</option>
            </select>
        </div>
        
 
        <input type="submit" name="quartos" value="Enviar">
        <a class="btnVoltar" href="quartos.php">Voltar</a>
    </form>
</div>
</body>
</html>
<?php

	require_once('conexao.php');
	
	$nome = '';
    $documento = '';
    $dataNascimento = '';
    $cidade = '';
    $estado = '';
    $id = '';
    $estados = array("AC","AL","AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");
	
	if(isset($_GET['id']) && $_GET['id'] != ""){
		$sql = "select * from clientes where id = ".$_GET['id'];
		$resultado = mysqli_query($conexao, $sql);
		if($resultado){
			$dados = mysqli_fetch_array($resultado);
			$nome = $dados['nome'];
            $documento = $dados['documento'];
            $dataNascimento = date("d/m/Y", strtotime($dados['data_nascimento']));
            $cidade = $dados['cidade'];
            $estado = $dados['estado'];
			$id = $dados['id'];
		}
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cliente</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="stylesheet" type="text/css" href="menu.css">
    <script src="mascaraData.js" type="text/javascript"></script>
    <script src="validacao.js" type="text/javascript"></script>
</head>
<body background-color = "gray">
    <div width=60% align=center>
    <form class="formulario" method="post" action="clientes.php" align=left> 
        <p class="centralizado"> Gerenciamento de clientes</p>
		
		<input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="field">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" placeholder="Digite o nome do cliente*" required>
        </div>
        
        <div class="field">
            <label for="documento">Documento:</label>
            <input type="text" id="documento" name="documento" value="<?php echo $documento; ?>" placeholder="Digite o documento do cliente*" required>
        </div>
 
        <div class="field">
            <label for="dataNascimento">Data Nascimento:</label>
            <input type="text" id="dataNascimento" onkeypress="mascaraData( this, event )"  onblur="validaData(this,this.value)" class="date" name="dataNascimento" value="<?php echo $dataNascimento; ?>" placeholder="Digite a data nascimento do cliente*" required>
        </div>

        <div class="field">
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo $cidade; ?>" placeholder="Digite a cidade do cliente*" required>
        </div>

        <div class="field">
            <label for="estado">Estado:</label>
            <select name="estado" required>
            <option value="">Selecione</option>

            <?php foreach ($estados as $uf): ?>
                <option value="<?php echo $uf?>"
                    <?php 
                        if($estado==$uf){
                            echo 'selected';
                        } ?>>
                    <?php echo $uf; ?>
                </option>
            <?php endforeach; ?>
            <select>
        </div>
        
        <input type="submit" name="clientes" value="Enviar">
        <a class="btnVoltar" href="clientes.php">Voltar</a>
    </form>
</div>
</body>
</html>
<?php

	require_once('conexao.php');
	
	$id = $_GET['id'];
	
	if($id != ""){
		
		$sql = "delete from quartos where id = ".$id;
		$resultado = mysqli_query($conexao, $sql);
		if($resultado){
			$msg = "Dados excluidos com sucesso";
		}
		echo "<script>window.location.href='quartos.php?msg=$msg';</script>";
		
	}
	
?>
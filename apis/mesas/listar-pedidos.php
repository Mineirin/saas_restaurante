<?php
  require_once("../config.php");
  require_once('../conexao.php');

$postjson   = $_POST;
$mesa  = $postjson['mesa'];

$id_pedido  = "";
$query 	= $pdo->query("SELECT * FROM pedidos WHERE mesa = '$mesa'");
$res 	= $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {

	foreach($res as $pedido){
		$produtos_query = $pdo->query("SELECT * FROM itens_pedidos where pedido = ".$pedido['id']);
		$produtos = $produtos_query->fetchAll(PDO::FETCH_ASSOC);
		$pago = $pedido['pago'];
		foreach($produtos as $produto){
			$nome = $produto['nome'];
		
		}
		$dados[] = array("nome"=> $nome,"valor" => $produto['valor']);
	}
	$result = json_encode($dados);
	echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

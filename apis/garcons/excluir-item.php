<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$id = @$postjson['id'];


$query2 = $pdo->query("SELECT * FROM itens_pedidos where id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$tipo = $res2[0]['tipo'];
$produto = $res2[0]['item'];
$quantidade = $res2[0]['quantidade'];

if($tipo == 'Produto'){
//ABATER NO ESTOQUE
$query2 = $pdo->query("SELECT * FROM produtos where id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res2[0]['estoque'];

$novo_estoque = $estoque + $quantidade;
$query = $pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE id = '$produto' ");
$query->bindValue(":estoque", "$novo_estoque");
$query->execute();	
}



$pdo->query("DELETE from itens_pedidos WHERE id = '$id'");

$result = json_encode(array('mensagem' => 'Excluído com Sucesso', 'ok' => true));
echo $result;

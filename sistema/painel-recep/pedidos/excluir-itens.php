<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];

$query2 = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$tipo = $res2[0]['tipo'];
$produto = $res2[0]['item'];
$quantidade = $res2[0]['quantidade'];

if($tipo == 'Produto'){
//ABATER NO ESTOQUE
$query2 = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' and id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res2[0]['estoque'];

$novo_estoque = $estoque + $quantidade;
$query = $pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE empresa = '$id_empresa' and id = '$produto' ");
$query->bindValue(":estoque", "$novo_estoque");
$query->execute();	
}



$pdo->query("DELETE from itens_pedidos WHERE empresa = '$id_empresa' and id = '$id'");


echo 'Excluído com Sucesso!';
?>
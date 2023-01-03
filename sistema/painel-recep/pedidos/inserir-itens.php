<?php 
require_once("../../../conexao.php");

$produto = $_POST['id'];
$quantidade = $_POST['quant'];
$pedido = $_POST['pedido'];
$mesa = $_POST['mesa'];
$tipo = $_POST['tipo'];

if($quantidade <= 0){
	exit();
}


if($tipo  == 'Produto'){
$query2 = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' and id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$valor = $res2[0]['valor_venda'];
$estoque = $res2[0]['estoque'];
$nome_prod = $res2[0]['nome'];
$status = 'Pronto';

if($quantidade > $estoque){
	echo 'Estoque Insuficiente, você tem apenas '.$estoque.' '.$nome_prod.' no estoque!';
	exit();
}

//ABATER NO ESTOQUE
$novo_estoque = $estoque - $quantidade;
$query = $pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE id = '$produto' ");
$query->bindValue(":estoque", "$novo_estoque");
$query->execute();

}else{
	$query2 = $pdo->query("SELECT * FROM pratos where id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$valor = $res2[0]['valor'];
$status = 'Preparando';
}


$total = $valor * $quantidade;


$query = $pdo->prepare("INSERT INTO itens_pedidos SET pedido = :pedido, item = :item, tipo = :tipo, valor = :valor, quantidade = :quantidade, total = :total, mesa = :mesa, status = :status ");


$query->bindValue(":pedido", "$pedido");
$query->bindValue(":item", "$produto");
$query->bindValue(":valor", "$valor");
$query->bindValue(":quantidade", "$quantidade");
$query->bindValue(":total", "$total");
$query->bindValue(":mesa", "$mesa");
$query->bindValue(":tipo", "$tipo");
$query->bindValue(":status", "$status");

$query->execute();



echo 'Salvo com Sucesso!';

 ?>
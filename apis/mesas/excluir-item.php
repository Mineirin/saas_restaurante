<?php
require_once("../../config.php");
require_once('../conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);

$id         = @$postjson['id'];
$idEmpresa  = $postjson['empresa'];


$query2     = $pdo->query("SELECT * FROM itens_pedidos where id = '$id' AND itens_pedidos.empresa='$idEmpresa' ");
$res2       = $query2->fetchAll(PDO::FETCH_ASSOC);
$tipo       = $res2[0]['tipo'];
$produto    = $res2[0]['item'];
$quantidade = $res2[0]['quantidade'];

if($tipo == 'Produto'){
//ABATER NO ESTOQUE
$query2       = $pdo->query("SELECT * FROM produtos where id = '$produto' AND produtos.empresa = '$idEmpresa' ");
$res2         = $query2->fetchAll(PDO::FETCH_ASSOC);
$estoque      = $res2[0]['estoque'];

$novo_estoque = $estoque + $quantidade;
$query = $pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE id = '$produto' and produtos.empresa = '$idEmpresa'");
$query->bindValue(":estoque", "$novo_estoque");
$query->execute();	
}

$pdo->query("DELETE from itens_pedidos WHERE id = '$id' and  itens_pedidos.empresa = '$idEmpresa'");
$pdo->query("DELETE from pedidos WHERE id = '$id'  and  pedidos.empresa = '$idEmpresa' ");
$result = json_encode(array('mensagem' => 'Excluído com Sucesso', 'ok' => true));
echo $result;

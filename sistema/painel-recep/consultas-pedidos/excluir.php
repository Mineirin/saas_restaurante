<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * from pedidos WHERE id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$comissao = $res[0]['comissao'];
$subtotal = $res[0]['subtotal'];

$novo_total = $subtotal - $comissao;

$pdo->query("UPDATE pedidos SET comissao = '0.00', subtotal = '$novo_total' WHERE id = '$id'");

echo 'Excluído com Sucesso!';
?>
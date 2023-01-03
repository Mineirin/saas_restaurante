<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];

@session_start();
$id_usuario = $_SESSION['id'];


$query_con = $pdo->query("UPDATE pedidos SET pago = 'Sim' WHERE id = '$id'");



//LANÇAR NAS MOVIMENTAÇÕES
$query_con = $pdo->query("SELECT * FROM pedidos WHERE empresa = '$id_empresa' and id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
$mesa = $res_con[0]['mesa'];
$valor = $res_con[0]['subtotal'];

$descricao = 'Pedido Mesa '.$mesa;

$res = $pdo->query("INSERT INTO movimentacoes SET tipo = 'Entrada', data = curDate(), usuario = '$id_usuario', descricao = '$descricao', valor = '$valor', id_mov = '$id'");



echo 'Baixado com Sucesso!';
?>
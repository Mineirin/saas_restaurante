<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
$pdo->query("UPDATE itens_pedidos SET status = 'Pronto' WHERE empresa = '$id_empresa' and id = '$id'");


echo 'Baixado com Sucesso!';
?>
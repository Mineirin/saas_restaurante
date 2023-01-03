<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];


$pdo->query("DELETE from clientes WHERE id = '$id'");


echo 'Excluído com Sucesso!';
?>
<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];

$pdo->query("DELETE from fornecedores WHERE empresa = '$id_empresa' and id = '$id'");


echo 'Excluído com Sucesso!';
?>
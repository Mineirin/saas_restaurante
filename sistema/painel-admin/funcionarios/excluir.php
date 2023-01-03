<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
//BUSCAR O REGISTRO JÁ CADASTRADO NO BANCO
$query = $pdo->query("SELECT * FROM funcionarios WHERE empresa = '$id_empresa' and id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_banco = @$res[0]['cpf'];


$pdo->query("DELETE from funcionarios WHERE empresa = '$id_empresa' and id = '$id'");
$pdo->query("DELETE from usuarios WHERE empresa = '$id_empresa' and cpf = '$cpf_banco'");

echo 'Excluído com Sucesso!';
?>
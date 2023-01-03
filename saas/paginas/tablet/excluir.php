<?php
$tabela = 'tablet';
require_once("../../../conexao.php");

$id = $_POST['id'];

//excluir os usuários relacionados a empresa
$pdo->query("DELETE FROM usuarios where empresa = '$id'");

$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';
 ?>
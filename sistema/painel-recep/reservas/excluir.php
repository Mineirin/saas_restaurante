<?php 
require_once("../../../conexao.php");

$id = $_POST['id-reserva'];


$pdo->query("DELETE from reservas WHERE id = '$id'");


echo 'Excluído com Sucesso!';
?>
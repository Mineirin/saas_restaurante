<?php
require_once("../config.php");
require_once('../conexao.php');
$postjson = $_POST;

$id = @$postjson['id'];


$query = $pdo->prepare("UPDATE pedidos SET pago = 'Sim' WHERE id = '$id' ");
$query->execute();	





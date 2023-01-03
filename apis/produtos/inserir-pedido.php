<?php
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$empresa = $postjson['empresa'];
$mesa = $postjson['mesa'];



$query = $pdo->query("SELECT * FROM mesa where cpf = '$empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_usuario = $res[0]['id'];

if($mesa > 0 and $mesa != ""){
$query = $pdo->prepare("INSERT INTO pedidos SET mesa = :mesa, data = curDate(), empresa = :empresa, couvert = '$couvert', pago = 'Não'");


$query->bindValue(":empresa", "$empresa");
$query->bindValue(":mesa", "$mesa");
$query->execute();

}

$result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'ok' => true));
echo $result;

<?php
require_once('../../config.php');
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$cpf_usuario = $postjson['cpf'];
$mesa = $postjson['mesa'];

$query = $pdo->query("SELECT * FROM funcionarios where cpf = '$cpf_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_funcionario = $res[0]['id'];

$query = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_usuario = $res[0]['id'];

if($mesa > 0 and $mesa != ""){
$query = $pdo->prepare("INSERT INTO pedidos SET mesa = :mesa, funcionario = :funcionario, data = curDate(), garcon = :garcon, comissao = '$comissao', couvert = '$couvert', pago = 'Não'");


$query->bindValue(":garcon", "$id_usuario");
$query->bindValue(":mesa", "$mesa");
$query->bindValue(":funcionario", "$id_funcionario");
$query->execute();

}

$result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'ok' => true));
echo $result;

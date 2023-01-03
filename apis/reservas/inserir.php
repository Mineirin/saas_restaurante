<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$quantidade = $postjson['quantidade'];
$comentario = $postjson['comentario'];
$mesa = $postjson['mesa'];
$cliente = $postjson['cliente'];
$id_usuario = $postjson['usuario'];
$data = $postjson['data'];

if ($quantidade == "") {
    echo json_encode(array('mensagem' => 'Preencha o Campo Quantidade!'));
    exit();
}


$query = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_usuario = $res[0]['cpf'];

$query = $pdo->query("SELECT * FROM funcionarios where cpf = '$cpf_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_funcionario = $res[0]['id'];


$res = $pdo->prepare("INSERT INTO reservas SET cliente = '$cliente', mesa = '$mesa', pessoas = :pessoas, obs = :obs, funcionario = :funcionario, data = :data");

$res->bindValue(":pessoas", $quantidade);
$res->bindValue(":obs", $comentario);
$res->bindValue(":funcionario", $id_funcionario);
$res->bindValue(":data", $data);
$res->execute();


$result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'ok' => true));
echo $result;

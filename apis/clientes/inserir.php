<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$nome = $postjson['nome'];
$email = $postjson['email'];
$telefone = $postjson['telefone'];
$id = @$postjson['id'];
$antigo = @$postjson['antigo'];


if ($nome == "") {
    echo json_encode(array('mensagem' => 'Preencha o Campo Nome!'));
    exit();
}

if ($email == "") {
    echo json_encode(array('mensagem' => 'Preencha o Campo Email!'));
    exit();
}



// EVITAR DUPLICIDADE NO EMAIL
if ($antigo != $email) {

    $query_con = $pdo->prepare("SELECT * from clientes WHERE email = :email");
    $query_con->bindValue(":email", $email);
    $query_con->execute();
    $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
    if (@count($res_con) > 0) {
        echo json_encode(array('mensagem' => 'Email já Cadastrado!'));
        exit();
    }
}


if ($id == "") {
    $res = $pdo->prepare("INSERT INTO clientes SET nome = :nome, email = :email, telefone = :telefone");
} else {
    $res = $pdo->prepare("UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id");
    $res->bindValue(":id", $id);
}

$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":telefone", $telefone);
$res->execute();


$result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'ok' => true));
echo $result;

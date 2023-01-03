<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$id_usuario = $postjson['id_usuario'];
$id = $postjson['id'];
$quantidade = $postjson['quantidade'];
$fornecedor = $postjson['fornecedor'];
$valor_compra = $postjson['valor_compra'];
$valor_compra = str_replace(',', '.', $valor_compra);

if ($quantidade == "") {
    echo json_encode(array('mensagem' => 'Preencha o Campo Quantidade!'));
    exit();
}

if($quantidade == 0){
	echo json_encode(array('mensagem' => 'A quantidade precisa ser superior a 0!'));
	exit();
}

if ($fornecedor == "") {
    echo json_encode(array('mensagem' => 'Preencha o Campo Fornecedor!'));
    exit();
}

if ($valor_compra == "") {
    echo json_encode(array('mensagem' => 'Preencha o Campo Valor da Compra!'));
    exit();
}


$total_compra = $quantidade * $valor_compra;

//ATUALIZAR ESTOQUE
$query_q = $pdo->query("SELECT * FROM produtos WHERE id = '$id'");
$res_q = $query_q->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res_q[0]['estoque'];
$quantidade += $estoque;

$res = $pdo->prepare("UPDATE produtos SET estoque = :quantidade, fornecedor = :fornecedor, valor_compra = :valor_compra WHERE id = :id");
$res->bindValue(":quantidade", $quantidade);
$res->bindValue(":fornecedor", $fornecedor);
$res->bindValue(":valor_compra", $valor_compra);
$res->bindValue(":id", $id);
$res->execute();



$res = $pdo->prepare("INSERT compras SET total = :total, data = curDate(), usuario = :usuario, fornecedor = :fornecedor, pago = 'Não'");
$res->bindValue(":usuario", $id_usuario);
$res->bindValue(":fornecedor", $fornecedor);
$res->bindValue(":total", $total_compra);
$res->execute();
$id_compra = $pdo->lastInsertId();


$res = $pdo->prepare("INSERT contas_pagar SET vencimento = curDate(), descricao = 'Compra de Produtos', valor = :valor, data = curDate(), usuario = :usuario, pago = 'Não', arquivo = 'sem-foto.jpg', id_compra = '$id_compra'");
$res->bindValue(":usuario", $id_usuario);
$res->bindValue(":valor", $total_compra);
$res->execute();

$result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'ok' => true));
echo $result;

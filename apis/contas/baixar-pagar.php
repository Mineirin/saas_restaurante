<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$id = @$postjson['id'];

$id_usuario = $postjson['id_usuario'];

$query_con = $pdo->query("UPDATE contas_pagar SET pago = 'Sim', usuario = '$id_usuario' WHERE id = '$id'");


//VERIFICAR SE É UMA COMPRA DE PRODUTO PARA PODER CONFIRMAR A COMPRA COMO PAGA
$query_con = $pdo->query("SELECT * FROM contas_pagar WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res_con);
if ($total_reg > 0) {
    $descricao = $res_con[0]['descricao'];
    $id_compra = $res_con[0]['id_compra'];
    if ($descricao == 'Compra de Produtos') {
        $query_con = $pdo->query("UPDATE compras SET pago = 'Sim' WHERE id = '$id_compra'");
    }
}



//LANÇAR NAS MOVIMENTAÇÕES
$query_con = $pdo->query("SELECT * FROM contas_pagar WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
$descricao = $res_con[0]['descricao'];
$valor = $res_con[0]['valor'];

$res = $pdo->prepare("INSERT INTO movimentacoes SET tipo = 'Saída', data = curDate(), usuario = :usuario, descricao = :descricao, valor = :valor, id_mov = :id");
$res->bindValue(":usuario", $id_usuario);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":valor", $valor);
$res->bindValue(":id", $id);
$res->execute();

$result = json_encode(array('mensagem' => 'Baixada com Sucesso', 'ok' => true));
echo $result;

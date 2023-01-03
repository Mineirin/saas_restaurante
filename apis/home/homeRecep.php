<?php

require_once('../../config.php');
require_once('../conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);

if (!isset($nivel_estoque_minimo) or $nivel_estoque_minimo = "") {
    $nivel_estoque_minimo = 10;
}

$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual . "-" . $mes_atual . "-01";



$entradas = 0;
$saidas = 0;
$saldo = 0;
$entradasF = 0;
$saidasF = 0;
$saldoF = 0;
$classeMov = "";
$classeSaldo = "";
$query = $pdo->query("SELECT * from movimentacoes where data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }


        if ($res[$i]['tipo'] == 'Entrada') {

            $entradas += $res[$i]['valor'];
        } else {

            $saidas += $res[$i]['valor'];
        }

        $saldo = $entradas - $saidas;

        $entradasF = number_format($entradas, 2, ',', '.');
        $saidasF = number_format($saidas, 2, ',', '.');
        $saldoF = number_format($saldo, 2, ',', '.');

        if ($saldo < 0) {
            $classeSaldo = 'text-danger';
        } else {
            $classeSaldo = 'text-success';
        }
    }
}



$query = $pdo->query("SELECT * from movimentacoes order by id desc limit 1");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$valorMov = $res[0]['valor'];
$descricaoMov = $res[0]['descricao'];
$tipoMov = $res[0]['tipo'];
$valorMov = number_format($valorMov, 2, ',', '.');
if ($tipoMov == 'Entrada') {
    $classeMov = 'text-success';
} else {
    $classeMov = 'text-danger';
}


$query = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasReceberVencidas = @count($res);


$query = $pdo->query("SELECT * from contas_receber where vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasReceberHoje = @count($res);


$query = $pdo->query("SELECT * from contas_pagar where vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasPagarVencidas = @count($res);


$query = $pdo->query("SELECT * from contas_pagar where vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasPagarHoje = @count($res);

$dados = array(
    'totalEntradas' => $entradasF,
    'totalSaidas' => $saidasF,
    'saldoDia' => $saldoF,
    'ultimaMov' => $valorMov,
    'descricaoMov' => $descricaoMov,
    'contasPagarHoje' => $contasPagarHoje,
    'contasPagarVencidas' => $contasPagarVencidas,
    'contasReceberHoje' => $contasReceberHoje,
    'contasReceberVencidas' => $contasReceberVencidas,
    'classeSaldo' => $classeSaldo,
    'classeMov' => $classeMov,

);

$result = json_encode(array('ok' => true, 'dado' => $dados));
echo $result;

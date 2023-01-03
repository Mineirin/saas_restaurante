<?php
require_once('../../config.php');
require_once('../conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);

/*
if(!isset($nivel_estoque_minimo) or $nivel_estoque_minimo = ""){
    $nivel_estoque_minimo = 10;
}
*/

$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$query = $pdo->query("SELECT * from produtos");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalProdutos = @count($res);

	$query = $pdo->query("SELECT * from fornecedores");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalFornecedores = @count($res);

	$query = $pdo->query("SELECT * from produtos where estoque < $nivel_estoque");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalEstoque = @count($res);

	$query = $pdo->query("SELECT * from pedidos where data = curDate() and valor > 0");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalVendas = @count($res);


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
        'totalProdutos' => $totalProdutos,
        'totalEstoque' => $totalEstoque,
        'totalFornecedores' => $totalFornecedores,
        'totalVendas' => $totalVendas,
        'contasPagarHoje' => $contasPagarHoje,
        'contasPagarVencidas' => $contasPagarVencidas,
        'contasReceberHoje' => $contasReceberHoje,
        'contasReceberVencidas' => $contasReceberVencidas,
        
    );

    $result = json_encode(array('mensagem' => 'Logado com Sucesso', 'ok' => true, 'dado'=>$dados));
    echo $result;






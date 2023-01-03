<?php
require_once('../config.php');
require_once('../conexao.php');


$postjson = $_POST;

$id_pedido  = $postjson['pedido'];
$idEmpresa  = $postjson['empresa'];
$comissao_valor = $postjson['comissao'];
$porcentagem = $postjson['porcentagem'];
if(!$comissao_valor){
	$comissao = 0;
}else{
	$comissao = ($porcentagem / 100);
}

$query_con 	 = $pdo->query("SELECT * FROM itens_pedidos WHERE pedido = '$id_pedido' AND itens_pedidos.empresa= '$idEmpresa' order by id desc");
$res 		 = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_venda = 0;
$total_reg = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){	}
		$valor_total_item 	= $res[$i]['total'];
		$total_venda 		+= $valor_total_item;
		$vlr_comissao 		= $total_venda * $comissao;
		$subtotal 			= $total_venda + $couvert + $vlr_comissao;
	}
}
$query_con1 	 = $pdo->query("SELECT * FROM pedidos WHERE id = '$id_pedido' AND empresa= '$idEmpresa'");
$res1 		 = $query_con1->fetch(PDO::FETCH_ASSOC);

if($res1['subtotal']>0.00){
	$result = json_encode(array('mensagem' => 'Pedido já fechado!', 'ok' => false));
}else{

	$query = $pdo->query("UPDATE pedidos SET valor = '$total_venda', subtotal = '$subtotal', comissao = '$vlr_comissao' where id = '$id_pedido' and pedidos.empresa='$idEmpresa'");
	$result = json_encode(array('mensagem' => 'Item Adicionado', 'ok' => true));
}

echo $result;

<?php
require_once('../config.php');
require_once('../conexao.php');
$postjson = $_POST;

$id_pedido = $postjson['pedido'];


$query_con = $pdo->query("SELECT * FROM itens_pedidos WHERE pedido = '$id_pedido' order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_venda = 0;
$total_reg = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){	}

		
		$valor_total_item = $res[$i]['total'];
		
		$total_venda += $valor_total_item;
		$vlr_comissao = $total_venda * $comissao;
		$subtotal = $total_venda + $couvert + $vlr_comissao;
		
}
}



$query = $pdo->query("UPDATE pedidos SET valor = '$total_venda', subtotal = '$subtotal', comissao = '$vlr_comissao' where id = '$id_pedido'");



$result = json_encode(array('mensagem' => 'Item Adicionado', 'ok' => true));
echo $result;

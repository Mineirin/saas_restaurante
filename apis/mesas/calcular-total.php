<?php
require_once('../config.php');
require_once('../conexao.php');
setlocale(LC_MONETARY,"pt_");

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
$result = json_encode(array("comissao"=> $vlr_comissao, "total" => $subtotal, "total_produtos" => $total_venda));

?>


					<li class="flexBetCenter colorblack strong font-semibig">
					<span>Subtotal</span>
					<span>R$<?php echo number_format($total_venda, 2, ',', '.'); ?></span></li>
					<li class="flexBetCenter colorblack strong font-semibig"><span>Gorjeta</span>
					<span>R$<?php echo number_format($vlr_comissao, 2, ',', '.'); ?></span></li>
					<li class="flexBetCenter colorblack strong font-semibig"><span>Total</span>
					<span>R$<?php echo number_format($subtotal, 2, ',', '.'); ?></span>
					</li>

<script>global_valor = <?php echo $subtotal; ?>
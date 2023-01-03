<?php
require_once('../config.php');
require_once('../conexao.php');

$postjson = $_POST;

$limite     = 100;
$start      = 0;
$nome_mesa  = intVal($postjson['mesa']);
$id_pedido  = intVal(@$postjson['pedido']);
$idEmpresa  = $postjson['empresa'];

$total_venda    = 0;
$total_vendaF   = 0;

if($id_pedido){
    $query_pedido    = $pdo->query("SELECT * FROM pedidos where id = $id_pedido and pago = 'Não'");
}else{
    $query_pedido    = $pdo->query("SELECT * FROM pedidos where mesa = '$nome_mesa' and empresa = '$idEmpresa' and pago = 'Não'");
}



$pedido         = $query_pedido->fetch(PDO::FETCH_ASSOC);

if($pedido){
$id = $pedido['id'];
$query_con      = $pdo->query("SELECT itens_pedidos.* FROM itens_pedidos where itens_pedidos.mesa = '$nome_mesa' AND itens_pedidos.empresa = '$idEmpresa' and pedido = '$id' ORDER BY itens_pedidos.id desc");
$res            = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg      = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){	}

		$id_ped             = $res[$i]['id'];
		$id_item            = $res[$i]['item'];
		$tipo               = $res[$i]['tipo'];
		$quantidade         = $res[$i]['quantidade'];
		$valor              = $res[$i]['valor'];
		$status             = $res[$i]['status'];
		$valor_total_item   = $res[$i]['total'];
		$descricao_produto  = $res[$i]['comentario'];
		$valor_total_itemF  = number_format($valor_total_item, 2, ',', '.');

		$total_venda        += $valor_total_item;
		$total_vendaF       =  number_format($total_venda, 2, ',', '.');

        if($tipo  == 'Produto'){
            
            $query2             = $pdo->query("SELECT produtos.* FROM produtos WHERE produtos.id = '$id_item' AND produtos.empresa='$idEmpresa'");
            $res2               = $query2->fetchAll(PDO::FETCH_ASSOC);
            $valor_produto      = $res2[0]['valor_venda'];
            $nome_produto       = $res2[0]['nome'];
            $foto_produto       = $res2[0]['imagem'];
        
            $pasta = 'produtos';
        }
        else{
            $query2             = $pdo->query("SELECT pratos.* FROM pratos where pratos.id = '$id_item' AND pratos.empresa = '$idEmpresa'");
            $res2               = $query2->fetchAll(PDO::FETCH_ASSOC);
            $valor_produto      = $res2[0]['valor'];
            $nome_produto       = $res2[0]['nome'];
            $foto_produto       = $res2[0]['imagem'];
         
            $pasta              = 'pratos';
        }

        $dados[] = array(
            'id'            => $res[$i]['id'],
            'quantidade'    => $quantidade,
            'valor_venda'   => $valor_total_itemF,
            'status'        => $status,
            'imagem'        => $foto_produto, 
            'nome'          => $nome_produto,
            'descricao'     => $descricao_produto,
            'pasta'         => $pasta,
            
        );
    }
    
    $result = json_encode(array('itens' => $dados, 'total_venda' => $total_vendaF,"pedido" => $pedido['id']));
    echo $result;
} 
else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}
}
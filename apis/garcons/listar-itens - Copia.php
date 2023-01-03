<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$limite = intVal($postjson['limit']);
$start = intVal($postjson['start']);
$nome_mesa = intVal($postjson['mesa']);
$id_pedido = intVal($postjson['pedido']);


$total_venda = 0;
$total_vendaF = 0;
$query_con = $pdo->query("SELECT * FROM itens_pedidos WHERE pedido = '$id_pedido' order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){	}

		$id_ped = $res[$i]['id'];
		$id_item = $res[$i]['item'];
		$tipo = $res[$i]['tipo'];
		$quantidade = $res[$i]['quantidade'];
		$valor = $res[$i]['valor'];
		$status = $res[$i]['status'];
		$valor_total_item = $res[$i]['total'];
		$valor_total_itemF =  number_format($valor_total_item, 2, ',', '.');

		$total_venda += $valor_total_item;
		$total_vendaF =  number_format($total_venda, 2, ',', '.');



if($tipo  == 'Produto'){
$query2 = $pdo->query("SELECT * FROM produtos where id = '$id_item'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$valor_produto = $res2[0]['valor_venda'];
$nome_produto = $res2[0]['nome'];
$foto_produto = $res2[0]['imagem'];
$pasta = 'produtos';
}else{
	$query2 = $pdo->query("SELECT * FROM pratos where id = '$id_item'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$valor_produto = $res2[0]['valor'];
$nome_produto = $res2[0]['nome'];
$foto_produto = $res2[0]['imagem'];
$pasta = 'pratos';
}



		

        
        $dados[] = array(
            'id' => $res[$i]['id'],
            'quantidade' => $quantidade,
            'valor_venda' => $valor_total_itemF,
            'status' => $status,
            'imagem' => $foto_produto, 
            'nome' => $nome_produto,
            'pasta' => $pasta,
                       

        );
    }

    $result = json_encode(array('itens' => $dados, 'total_venda' => $total_vendaF));
    echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

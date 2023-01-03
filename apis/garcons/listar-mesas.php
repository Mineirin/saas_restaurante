<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$limite = intVal($postjson['limit']);
$start = intVal($postjson['start']);

$id_pedido = "";

$query = $pdo->query("SELECT * FROM mesas order by id asc limit $start, $limite");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {

    $query = $pdo->query("SELECT * FROM mesas order by id asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	for($i=0; $i < @count($res); $i++){
		foreach ($res[$i] as $key => $value){	}
		$id_mesa = $res[$i]['id'];
		$nome_mesa = $res[$i]['nome'];

		$query2 = $pdo->query("SELECT * FROM reservas where mesa = '$nome_mesa' and data = curDate()");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);


		$query4 = $pdo->query("SELECT * FROM pedidos where mesa = '$nome_mesa' and data = curDate() and valor = '0.00'");
		$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
				
		$query6 = $pdo->query("SELECT * FROM pedidos where mesa = '$nome_mesa' and data = curDate() and subtotal > '0.00'");
		$res6 = $query6->fetchAll(PDO::FETCH_ASSOC);
				

        $classe = 'cor-texto-verde';
		$img = 'disponivel.png';
		$texto = 'DISPONÍVEL';
		$texto_if =  'DISPONÍVEL';
		$nome_cliente = '';


		if(@count($res2) > 0 and @count($res6) == 0){
			$classe = 'cor-texto-vermelha';
			$texto_if =  'RESERVADA';
			
			$id_cliente = $res2[0]['cliente'];

			
			$query3 = $pdo->query("SELECT * FROM clientes where id = '$id_cliente'");
			$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
			$nome_cliente = ' - ' .$res3[0]['nome'];
            $texto = 'RESERVADA'.$nome_cliente;
            $img = 'reservada.png';
		}



		if(@count($res4) > 0){
            $classe = 'cor-texto-azul';
			$img = 'aberta.png';
			$texto_if =  'ABERTA';
			$id_pedido = $res4[0]['id'];
			$obs = $res4[0]['obs'];

			$query5 = $pdo->query("SELECT * FROM itens_pedidos where pedido = '$id_pedido'");
			$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
			$texto =  'ABERTA ('.@count($res5).')';
		}


		

        
        $dados[] = array(
            'id' => $res[$i]['id'],
            'mesa' => $nome_mesa,
            'texto' => $texto,
            'textoif' => $texto_if,
            'img' => $img, 
            'classe' => $classe,
			'id_pedido' => $id_pedido,           

        );
    }

    $result = json_encode(array('itens' => $dados));
    echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

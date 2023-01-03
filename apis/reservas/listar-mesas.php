<?php
require_once("../../config.php");
require_once('../conexao.php');
$postjson = json_decode(file_get_contents('php://input'), true);

$limite = intVal($postjson['limit']);
$start = intVal($postjson['start']);

$busca = $postjson['nome'];
if ($busca == "") {
    $busca = date('Y-m-d');
}


$query = $pdo->query("SELECT * FROM mesas order by id asc limit $start, $limite");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {

for($i=0; $i < @count($res); $i++){
	foreach ($res[$i] as $key => $value){	}
		$id_reg = $res[$i]['id'];
	    $nome_mesa = $res[$i]['nome'];



    $query2 = $pdo->query("SELECT * FROM reservas where mesa = '$nome_mesa' and data = '$busca'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res2);
    if ($total_reg > 0) {
        $reserva = 'Reservada';
    }else{
        $reserva = 'Disponível';
    }

        
        $dados[] = array(
            'id' => $res[$i]['id'],
            'reserva' => $reserva,
            'mesa' => $nome_mesa,
            'data' => $busca,
                       

        );
    }

    $result = json_encode(array('itens' => $dados));
    echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

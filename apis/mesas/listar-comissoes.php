<?php
require_once("../../config.php");
require_once('../conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);

$limite     = intVal($postjson['limit']);
$start      = intVal($postjson['start']);
$dataIni    = $postjson['dataIni'];
$dataFin    = $postjson['dataFin'];
$id_usuario = $postjson['id_usuario'];
$idEmpresa  = $postjson['empresa'];

if ($dataIni == "") {
    $dataIni = date('Y-m-d');
}

if ($dataFin == "") {
    $dataFin = date('Y-m-d');
}

$query = $pdo->query("SELECT * FROM pedidos where comissao > 0 and garcon = '$id_usuario' and data >= '$dataIni' and data <= '$dataFin' AND pedidos.empresa='$idEmpresa' order by data asc limit $start, $limite");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    for ($i = 0; $i < @count($res); $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id_reg = $res[$i]['id'];
        $garcon = $res[$i]['garcon'];
        $pago   = $res[$i]['pago'];
        $valor  = $res[$i]['comissao'];
        $mesa   = $res[$i]['mesa'];
        $data   = $res[$i]['data'];
        $data   = implode('/', array_reverse(explode('-', $data)));

        $dados[] = array(
            'id'    => $res[$i]['id'],
            'pago'  => $pago,
            'valor' => $valor,
            'mesa'  => $mesa,
            'data'  => $data,

        );
    }

    $result = json_encode(array('itens' => $dados, 'dt' => $dataIni));
    echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

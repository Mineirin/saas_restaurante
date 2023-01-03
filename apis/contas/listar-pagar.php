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

$query = $pdo->query("SELECT * FROM contas_pagar where data = '$busca' order by id desc limit $start, $limite");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id_usu = $res[$i]['usuario'];
        $query_p = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
        $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
        $nome_usu = $res_p[0]['nome'];

        $data = implode('/', array_reverse(explode('-', $res[$i]['vencimento'])));

        $valor = number_format( $res[$i]['valor'] , 2, ',', '.');


        $dados[] = array(
            'id' => $res[$i]['id'],
            'pago' => $res[$i]['pago'],
            'descricao' => $res[$i]['descricao'],
            'valor' => $valor,
            'vencimento' => $data,
            'usuario' => $nome_usu,
            

        );
    }

    $result = json_encode(array('itens' => $dados));
    echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

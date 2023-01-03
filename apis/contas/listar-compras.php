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

$query = $pdo->query("SELECT * FROM compras where data = '$busca' order by id desc limit $start, $limite");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        //BUSCAR OS DADOS DO USUARIO
        $id_usu = $res[$i]['usuario'];
        $query_f = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
        $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
        $total_reg_f = @count($res_f);
        if ($total_reg_f > 0) {
            $nome_usuario = $res_f[0]['nome'];
        }


        //BUSCAR OS DADOS DO FORNECEDOR
        $id_forn = $res[$i]['fornecedor'];
        $query_f = $pdo->query("SELECT * from fornecedores where id = '$id_forn'");
        $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
        $total_reg_f = @count($res_f);
        if ($total_reg_f > 0) {
            $nome_forn = $res_f[0]['nome'];
            $tel_forn = $res_f[0]['telefone'];
        }

        $data = implode('/', array_reverse(explode('-', $res[$i]['data'])));

        $valor = number_format( $res[$i]['total'] , 2, ',', '.');


        $dados[] = array(
            'id' => $res[$i]['id'],
            'valor' => $valor,
            'pago' => $res[$i]['pago'],
            'data' => $data,
            'usuario' => $nome_usuario,
            'fornecedor' => $nome_forn,
            'tel_forn' => $tel_forn,

        );
    }

    $result = json_encode(array('itens' => $dados));
    echo $result;
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

<?php
require_once('../config.php');
require_once('../conexao.php');

$postjson   = $_POST;
$mesa       = $postjson['mesa'];//2
$idEmpresa  = $postjson['empresa'];//1
$id = 0;

$query 	= $pdo->query("SELECT * FROM pedidos WHERE mesa = '$mesa' and pago = 'Não'");
$res = $query->fetch(PDO::FETCH_ASSOC);
    if($res){
        $id = $res['id'];
        $pdo->prepare("UPDATE  pedidos set subtotal = 0.00, valor = 0.00  where id = ?")->execute([$id]);
    }else{
        if($mesa > 0 and $mesa != ""){
            $query = $pdo->prepare("INSERT INTO pedidos SET mesa = :mesa, data = curDate(), couvert = '$couvert', pago = 'Não', empresa= :empresa, visto = '0'");
            $query->bindValue(":mesa", "$mesa");
            $query->bindValue(":empresa", "$idEmpresa");
            $query->execute();
            $id = $pdo->lastInsertId();
            $result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'id' => $id));
        }
    
    }



        $result = json_encode(array('mensagem' => 'Salvo com Sucesso', 'id' => $id));
        echo $result;



<?php
require_once("../conexao.php");
$empresa = @$_POST['empresa'];
$mesa = $_POST['mesa'];
$info =  $_POST['comentario'];

$query 	= $pdo->query("SELECT * FROM chamadas_garcom WHERE mesa = '$mesa' and visto = '0'");
$chamada 	= $query->fetchAll(PDO::FETCH_ASSOC);

if(count($chamada)>0){
    $result = json_encode(array('mensagem' => 'Você já realizou uma solicitação!', 'ok' => false));
    echo $result;
}else{
$query = $pdo->prepare("INSERT INTO chamadas_garcom set empresa = $empresa, mesa = $mesa, info = '$info', visto = '0'");
$query->execute();
}


<?php
    require_once("../config.php");
    require_once('../conexao.php');
$mesa= @$_POST['mesa'];
$url =  "http://".$_SERVER['HTTP_HOST'];
$query = $pdo->query("SELECT * FROM carrinho where mesa = $mesa order by id desc");

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
    foreach($res as $item){ 
        $produto_id =$item['prato'];
        $query2 = $pdo->query("SELECT * FROM pratos where id = $produto_id ");

        $produto = $query2->fetch(PDO::FETCH_ASSOC);
        $query3 = $pdo->query("SELECT * FROM categorias where id = ".$produto['categoria']);

        $categoria = $query3->fetch(PDO::FETCH_ASSOC);
        $nome = $produto['nome'];

        $valor = $produto['valor'];
    
        $produtos[] = array("nome" => $nome, "valor" => $valor , "quantidade" => $item['quantidade'], "produto" => $produto_id, "comentario" => $item['descricao'], "categoria" => $categoria['nome']);



    }

    $result = json_encode($produtos);

    echo $result;
 }

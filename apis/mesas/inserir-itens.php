<?php
require_once('../config.php');
require_once('../conexao.php');

$postjson = $_POST;

$produto    = $postjson['id'];
$quantidade = $postjson['quantidade'];
$tipo       = $postjson['tipo'];
$mesa       = $postjson['mesa'];
$pedido     = $postjson['pedido'];
$idEmpresa  = $postjson['empresa'];
$comentario = $postjson['comentario'];


if ($tipo  == 'Produto') {
    $query2     = $pdo->query("SELECT * FROM produtos where id = '$produto' AND produtos.empresa='$idEmpresa' ");
    $res2       = $query2->fetchAll(PDO::FETCH_ASSOC);
    $valor      = $res2[0]['valor_venda'];
    $estoque    = $res2[0]['estoque'];
    $nome_prod  = $res2[0]['nome'];
    $status     = 'Pronto';

    if ($quantidade > $estoque) {
        echo 'Estoque Insuficiente, você tem apenas ' . $estoque . ' ' . $nome_prod . ' no estoque!';
        exit();
    }

    //ABATER NO ESTOQUE
    $novo_estoque = $estoque - $quantidade;
    $query = $pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE id = '$produto' AND produtos.empresa='$idEmpresa'");
    $query->bindValue(":estoque", "$novo_estoque");
    $query->execute();
} 
else {
    
    $query2 = $pdo->query("SELECT * FROM pratos where id = '$produto' AND pratos.empresa='$idEmpresa' ");
    $res2   = $query2->fetchAll(PDO::FETCH_ASSOC);
    $valor  = $res2[0]['valor'];
    $status = 'Preparando';
}

$total = $valor * $quantidade;

if ($pedido > 0 and $pedido != "") {

    $query = $pdo->prepare("INSERT INTO itens_pedidos SET pedido = :pedido, item = :item, tipo = :tipo, valor = :valor, empresa = :empresa,  quantidade = :quantidade, total = :total, comentario = '$comentario', mesa = :mesa, status = :status ");
    $query->bindValue(":pedido", "$pedido");
    $query->bindValue(":item", "$produto");
    $query->bindValue(":valor", "$valor");
    $query->bindValue(":quantidade", "$quantidade");
    $query->bindValue(":total", "$total");
    $query->bindValue(":mesa", "$mesa");
    $query->bindValue(":tipo", "$tipo");
    $query->bindValue(":status", "$status");
    $query->bindValue(":empresa", "$idEmpresa");
    $query->execute();
}
$pdo->prepare("DELETE FROM carrinho where mesa = ?")->execute([$mesa]);
$pdo->prepare("UPDATE  pedidos set visto = 0  where id = ?")->execute([$pedido]);
$result = json_encode(array('mensagem' => 'Item Adicionado', 'ok' => true));
print_r($postjson);

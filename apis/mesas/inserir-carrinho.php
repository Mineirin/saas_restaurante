<?php
require_once("../conexao.php");
$produto = @$_POST['prato'];
$mesa = $_POST['mesa'];
$descricao =  $_POST['comentario'];
$qtd = $_POST['qtd'];
$url =  "http://".$_SERVER['HTTP_HOST'];
$query = $pdo->prepare("INSERT INTO carrinho set prato = $produto , mesa = $mesa, descricao = '$descricao', quantidade = $qtd");
$query->execute();
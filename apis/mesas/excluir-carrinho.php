<?php
    require_once("../config.php");
    require_once('../conexao.php');
$id = @$_POST['id'];
$url =  "http://".$_SERVER['HTTP_HOST'];
$pdo->prepare("DELETE FROM carrinho where id = ?")->execute([$id]);
if($total_reg > 0){

 }

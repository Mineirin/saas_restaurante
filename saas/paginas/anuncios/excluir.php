<?php
$tabela = 'banners';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['imagem'];

if($foto != "sem-foto.jpg"){
	@unlink('../../images/banners/'.$foto);
}



$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';

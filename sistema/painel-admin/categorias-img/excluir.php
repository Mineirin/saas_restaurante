<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * from imagens WHERE categoria = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Existem imagens relacionadas a essa categoria, primeiro exclua essas imagens para depois excluir a categoria!';
	exit();
}

$pdo->query("DELETE from categorias_img WHERE id = '$id'");

echo 'Excluído com Sucesso!';
?>
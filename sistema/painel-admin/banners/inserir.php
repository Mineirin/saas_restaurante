<?php 
require_once("../../../conexao.php");

$descricao = $_POST['descricao'];
$titulo = $_POST['titulo'];
$subtitulo = $_POST['subtitulo'];
$link = $_POST['link'];
$id_empresa = $_POST['id_empresa'];
$id = $_POST['id'];


//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/banners/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



if($id == ""){
	$query = $pdo->prepare("INSERT INTO banners SET titulo = :titulo, subtitulo = :subtitulo, link = :link, descricao = :descricao, imagem = :imagem, empresa = '$id_empresa'");
	$query->bindValue(":imagem", "$imagem");
}else{
	if($imagem == "sem-foto.jpg"){
		$query = $pdo->prepare("UPDATE banners SET titulo = :titulo, subtitulo = :subtitulo, link = :link, descricao = :descricao WHERE id = '$id'");
	}else{
		$query = $pdo->prepare("UPDATE banners SET titulo = :titulo, subtitulo = :subtitulo, link = :link, descricao = :descricao, imagem = :imagem WHERE id = '$id'");
		$query->bindValue(":imagem", "$imagem");
	}
	
}

$query->bindValue(":titulo", "$titulo");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":subtitulo", "$subtitulo");
$query->bindValue(":link", "$link");

$query->execute();




echo 'Salvo com Sucesso!';

?>
<?php 
require_once("../../../conexao.php");

$nome = @$_POST['nome'];

$id = @$_POST['id'];

//BUSCAR O REGISTRO JÁ CADASTRADO NO BANCO
$query = $pdo->query("SELECT * FROM categorias WHERE empresa = '$id_empresa' and id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_banco = @$res[0]['nome'];


if($nome != $nome_banco){
	$query = $pdo->prepare("SELECT * FROM categorias WHERE  nome = :nome");
	$query->bindValue(":nome", "$nome");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'Categoria já Cadastrada!';
		exit();
	}
}
//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/categorias/' .$nome_img;
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
	$query = $pdo->prepare("INSERT INTO categorias SET nome = :nome, imagem = :imagem");
	$query->bindValue(":imagem", "$imagem");
}else{
	if($imagem == "sem-foto.jpg"){
		$query = $pdo->prepare("UPDATE categorias SET nome = :nome WHERE id = '$id'");
	}else{
		$query = $pdo->prepare("UPDATE categorias SET nome = :nome, imagem = :imagem WHERE id = '$id'");
		$query->bindValue(":imagem", "$imagem");
	}
	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":imagem", "$imagem");

$query->execute();




echo 'Salvo com Sucesso!';
?>
<?php 
require_once("../../conexao.php");

$nome = $_POST['nome_perfil'];
$email = $_POST['email_perfil'];
$cpf = $_POST['cpf_perfil'];
$senha = $_POST['senha_perfil'];

$especialidade = $_POST['especialidade_perfil'];
$facebook = $_POST['facebook'];
$youtube = $_POST['youtube'];
$instagram = $_POST['instagram'];
$linkedin = $_POST['linkedin'];

$id = $_POST['id_perfil'];
$id_func = $_POST['id_perfil_func'];

//BUSCAR O CPF JÁ CADASTRADO NO BANCO
$query = $pdo->query("SELECT * FROM usuarios WHERE  id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_banco = $res[0]['cpf'];
$email_banco = $res[0]['email'];

if($cpf != $cpf_banco){
	$query = $pdo->prepare("SELECT * FROM usuarios WHERE  cpf = :cpf");
	$query->bindValue(":cpf", "$cpf");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'CPF já Cadastrado!';
		exit();
	}
}

if($email != $email_banco){
	$query = $pdo->prepare("SELECT * FROM usuarios WHERE  email = :email");
	$query->bindValue(":email", "$email");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'Email já Cadastrado!';
		exit();
	}
}


$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha WHERE id = :id");
$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":email", "$email");
$query->bindValue(":senha", "$senha");
$query->bindValue(":id", "$id");
$query->execute();


$query = $pdo->prepare("UPDATE funcionarios SET nome = :nome, email = :email, cpf = :cpf WHERE cpf = '$cpf_banco'");
$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":email", "$email");
$query->execute();




//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem-perfil']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../img/chef/' .$nome_img;
if (@$_FILES['imagem-perfil']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem-perfil']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}


if($imagem == "sem-foto.jpg"){
	$query = $pdo->prepare("UPDATE chef SET especialidade = :especialidade, instagram = :instagram, youtube = :youtube, linkedin = :linkedin, facebook = :facebook WHERE funcionario = '$id_func'");
}else{
$query = $pdo->prepare("UPDATE chef SET especialidade = :especialidade, instagram = :instagram, youtube = :youtube, linkedin = :linkedin, facebook = :facebook, imagem = :imagem WHERE funcionario = '$id_func'");
	$query->bindValue(":imagem", "$imagem");
}
$query->bindValue(":especialidade", "$especialidade");
$query->bindValue(":instagram", "$instagram");
$query->bindValue(":youtube", "$youtube");
$query->bindValue(":linkedin", "$linkedin");
$query->bindValue(":facebook", "$facebook");
$query->execute();


echo 'Salvo com Sucesso!';
?>
<?php 
require_once("../../conexao.php");

$nome = $_POST['nome_perfil'];
$email = $_POST['email_perfil'];
$cpf = $_POST['cpf_perfil'];
$senha = $_POST['senha_perfil'];
$id = $_POST['id_perfil'];

//BUSCAR O CPF JÁ CADASTRADO NO BANCO
$query = $pdo->query("SELECT * FROM usuarios WHERE empresa = '$id_empresa' and id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_banco = $res[0]['cpf'];
$email_banco = $res[0]['email'];

if($cpf != $cpf_banco){
	$query = $pdo->prepare("SELECT * FROM usuarios WHERE empresa = '$id_empresa' and cpf = :cpf");
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
	$query = $pdo->prepare("SELECT * FROM usuarios WHERE empresa = '$id_empresa' and email = :email");
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



echo 'Salvo com Sucesso!';
?>
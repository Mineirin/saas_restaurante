<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$nivel = @$_POST['nivel'];
$cargo = $_POST['cargo'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];

$senha = '123';
$senha_crip = md5($senha);


if($email == "" and $cpf == ""){
	echo 'Preencha o CPF ou o Email!';
	exit();
}

//validar cpf
if($cpf != ""){
	$query = $pdo->query("SELECT * from $tabela where empresa = '$id_empresa' and cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'CPF já Cadastrado, escolha outro!!';
		exit();
	}
}


//validar email
if($email != ""){
	$query = $pdo->query("SELECT * from $tabela where empresa = '$id_empresa' and email = '$email'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'Email já Cadastrado, escolha outro!!';
		exit();
	}
}

if($id == ""){
	$query = $pdo->prepare("INSERT INTO funcionarios SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, endereco = :endereco, data_cadastro = curDate(), cargo = :cargo, empresa = '$id_empresa'");
}else{
	$query = $pdo->prepare("UPDATE funcionarios SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, endereco = :endereco, data_cadastro = curDate(), cargo = :cargo WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":cargo", "$cargo");
$query->execute();
$id_funcionario = $pdo->lastInsertId();


//trazer o nome do cargo
$query = $pdo->query("SELECT * FROM cargos WHERE empresa = '$id_empresa' and id = '$cargo'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_cargo = @$res[0]['nome'];


//LANÇAR OU EDITAR DADOS NA TABELA DOS USUÁRIOS
if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, ativo = 'Sim', data = curDate(), endereco = :endereco, nivel = :cargo, foto = 'sem-foto.jpg', senha = '123', senha_crip = '$senha_crip' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, ativo = 'Sim', endereco = :endereco, nivel = :cargo WHERE id = '$id' ");
	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":cargo", "$nome_cargo");
$query->execute();


echo 'Salvo com Sucesso';
 ?>
<?php 
require_once("../../../conexao.php");
@session_start();

if(@$_POST['id_res_email'] != ""){

	$id_reserva_email = $_POST['id_res_email'];
	$email = $_POST['email'];

	$pessoas = $_POST['pessoas'];
	$data = $_POST['data'];
	$obs = $_POST['mensagem'];
	$id_usuario = $_POST['nome'];
	$id_empresa = $_POST['id_empresa_mesas'];

	$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa' and email = '$email'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$cliente = $res[0]['id'];

	$mesa = '';

	$query = $pdo->query("SELECT * FROM mesas where empresa = '$id_empresa' order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	for($i=0; $i < @count($res); $i++){
	foreach ($res[$i] as $key => $value){	}
		$id_mesa = $res[$i]['id'];
		$nome_mesa = $res[$i]['nome'];


		$query2 = $pdo->query("SELECT * FROM reservas where empresa = '$id_empresa' and mesa = '$nome_mesa' and data = '$data' ");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res2) == 0){
			$mesa = $nome_mesa;

			//ATUALIZA A RESERVA EMAIL PARA RESERVADA
			$query2 = $pdo->query("UPDATE reservas_email SET reservado = 'Sim' where id = '$id_reserva_email'");
						
		}
		
	}
	
	
}else{
	$nome = $_POST['nome'];
	$cliente = $_POST['id_cliente'];
	$mesa = $_POST['mesa'];
	$pessoas = $_POST['pessoas'];
	$data = $_POST['data-reserva'];
	$obs = $_POST['obs'];

	if($nome == ""){
		echo 'Selecione um Cliente!';
		exit();
	}
}


if($mesa == ''){
	echo 'Não existem mesas disponíveis para essa Data!';
	exit();
}


$cpf_usuario = $_SESSION['cpf'];
$id_empresa = $_SESSION['id_empresa'];
$query = $pdo->query("SELECT * FROM funcionarios where empresa = '$id_empresa' and cpf = '$cpf_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_funcionario = $res[0]['id'];





$query = $pdo->prepare("INSERT INTO reservas SET empresa = '$id_empresa', clientes = :cliente, mesa = :mesa, pessoas = :pessoas, obs = :obs, reservado = 'Sim', funcionario = :funcionario, data = :data");


$query->bindValue(":cliente", "$cliente");
$query->bindValue(":mesa", "$mesa");
$query->bindValue(":pessoas", "$pessoas");
$query->bindValue(":obs", "$obs");
$query->bindValue(":funcionario", "$id_funcionario");
$query->bindValue(":data", "$data");

$query->execute();



$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa' and id = '$cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$email_cliente = $res[0]['email'];
$nome_cliente = $res[0]['nome'];


$dataF = implode('/', array_reverse(explode('-', $data)));

//enviar email confirmando a reserva
$destinatario = $email_cliente;
$assunto = $nome_site . ' - Confirmação de Reserva';
$mensagem = 'Olá '.$nome_cliente.', sua reserva para mesa '.$mesa.' foi confirmada para data '.$dataF. "\r\n"."\r\n". 'Observações: '.$obs. '!';
    
$cabecalhos = "From: ".$email_adm;
@mail($destinatario, $assunto, $mensagem, $cabecalhos);


echo 'Salvo com Sucesso!';
?>
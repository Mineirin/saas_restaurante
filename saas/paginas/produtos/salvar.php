<?php 

$tabela = 'pratos';
require_once("../../../conexao.php");
$nome 		= $_POST['nome'];
$categoria 	= $_POST['categoria'];
$valor 		= $_POST['valor'];
if(isset($_POST['vibrar'])){
	$vibrar = 1;
}else{
	$vibrar = 0;
}
$tempo 		= $_POST['tempo'];
$descricao 	= $_POST['descricao'];
$valor 		= str_replace(',', '.', $valor);
$id 		= @$_POST['id_prato'];
$id_empresa = $_POST['id_empresa'];



//validar troca da foto
$query 	= $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res 	= $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['imagem'];
}else{
	$foto = 'sem-foto.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/pratos/'.$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('../../images/pratos/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', nome = :nome, descricao = :descricao, valor = :valor, categoria = '$categoria', ativo = 'Sim', imagem = '$foto', vibrar = '$vibrar', tempo ='$tempo' "); 	
}
else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, descricao = :descricao, valor = :valor, categoria = '$categoria', imagem = '$foto', vibrar = '$vibrar' , tempo ='$tempo' WHERE id = '$id' ");
	
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":valor", "$valor");
//$query->bindValue(":vibrar", "$vibrar");
//$query->bindValue(":tempo", "$tempo");
$query->execute();

echo 'Salvo com Sucesso';

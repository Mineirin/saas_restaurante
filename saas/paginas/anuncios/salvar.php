<?php 
$tabela = 'banners';
require_once("../../../conexao.php");
$titulo = $_POST['titulo'];
if(isset($_POST['pedir'])){
	$pedir = $_POST['pedir'];
}else{
	$pedir = 'nao';
}
$id = @$_POST['id_anuncio'];
$id_empresa = $_POST['id_empresa'];
$prato = $_POST['produto1'];
//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['imagem'];
}else{
	$foto = 'sem-foto.jpg';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/'.$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('../../images/banners/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET titulo = :titulo, pedir = '$pedir', empresa = '$id_empresa', imagem = '$foto', prato = '$prato' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET titulo = :titulo, pedir = '$pedir', empresa = '$id_empresa', imagem = '$foto', prato = '$prato' WHERE id = '$id' ");
	
}


$query->bindValue(":titulo", "$titulo");
$query->execute();




echo 'Salvo com Sucesso';
 ?>
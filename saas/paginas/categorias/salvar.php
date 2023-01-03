<?php 
$tabela = 'categorias';
require_once("../../../conexao.php");
$nome 		= $_POST['nome'];
$ativo 		= $_POST['nmAtivo'];
$id 		= @$_POST['id_categoria'];
$id_empresa = $_POST['id_empresa'];




if($nome != ""){
	$query = $pdo->query("SELECT * from $tabela where nome = '$nome' and empresa = '$id_empresa' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'Categoria já Cadastrada, escolha outro!!';
		exit();
	}
}
	$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['fImage1']['name'];
	$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
	$caminho = '../../images/categorias/'.$nome_img;
	$imagem_temp = @$_FILES['fImage1']['tmp_name']; 
	if(@$_FILES['fImage1']['name'] != ""){
		$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
		if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp'){ 
				//EXCLUO A FOTO ANTERIOR
				if(@$foto != "sem-foto.jpg"){
					@unlink('../../images/categorias/'.$foto);
				}
				$foto = $nome_img;
			move_uploaded_file($imagem_temp, $caminho);
		}else{
			echo 'Extensão de Imagem não permitida!';
			exit();
		}
	}
if($id == ""){
	//faz o upload da foto para o servidor

	//insere as infos no banco 
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome_cat, imagem='$nome_img', ativo = '$ativo', empresa = '$id_empresa' "); 	
	
}
else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome_cat, imagem='$nome_img', ativo = '$ativo', empresa = '$id_empresa' where id = $id");

}
$query->bindValue(":nome_cat", "$nome");
$query->execute();

	echo 'salvo com sucesso!';

?>
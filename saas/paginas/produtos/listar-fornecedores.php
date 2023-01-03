<?php 
require_once("../../../conexao.php");

$id_empresa = @$_POST['id_empresa'];

echo '<option value="0">Selecionar Fornecedor</option>';								

$query = $pdo->query("SELECT * FROM fornecedores where empresa = '$id_empresa' order by nome asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
	
echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';

}

?>
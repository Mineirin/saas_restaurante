<?php 
require_once("../../../conexao.php");

$data = $_POST['data'];

echo "<div class='col-md-12 mt-2'>";

$id_empresa = $_POST['id_empresa'];
$query = $pdo->query("SELECT * FROM mesas where empresa = '$id_empresa' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){
	foreach ($res[$i] as $key => $value){	}
		$id_reg = $res[$i]['id'];
	$nome_mesa = $res[$i]['nome'];


	echo "<div class='mx-2 mb-4' style='float:left;'>";

	$query2 = $pdo->query("SELECT * FROM reservas where empresa = '$id_empresa' and mesa = '$nome_mesa' and data = '$data'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	
	if(@count($res2) > 0){
		$id_reserva = $res2[0]['id'];
		echo "<a href='#' onclick='modalExcluirReserva($id_reserva)' type='button' class='btn btn-danger' style='width:90px;'>Mesa ". $nome_mesa."</a>";
	}else{
		echo "<a href='#' onclick='modalReserva($nome_mesa)' type='button' class='btn btn-success' style='width:90px;'>Mesa ". $nome_mesa."</a>";
	}

	
	echo "</div>";

}

echo "</div>";

?>
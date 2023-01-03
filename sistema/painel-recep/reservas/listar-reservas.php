<?php 
require_once("../../../conexao.php");

$data = $_POST['data'];
$id_empresa = $_POST['id_empresa'];
echo "<div class='row mx-1'>";

$query = $pdo->query("SELECT * FROM reservas where empresa = '$id_empresa' and data = '$data' order by mesa asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){
	foreach ($res[$i] as $key => $value){	}
		$id_cliente = $res[$i]['clientes'];
		$nome_mesa = $res[$i]['mesa'];
		$obs = $res[$i]['obs'];

		$query2 = $pdo->query("SELECT * FROM clientes where id = '$id_cliente'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome_cli = $res2[0]['nome'];
		$telefone_cli = $res2[0]['telefone'];

		echo "<div class='col-lg-4 col-md-6 col-md-12 mb-2'>";
			echo "<div class='card shadow h-100'>";
				echo "<div class='card-body'>";
					echo "<div class='row no-gutters align-items-center'>";
						echo "<div class='col mr-2'>";
							echo "<div class='text-xs font-weight-bold  text-primary text-uppercase'>".$nome_cli."</div>";
							echo "<div class='text-xs text-secondary'>".$telefone_cli." </div>";
							echo "<div class='text-xs text-muted'>".$obs." </div>";
						echo "</div>";
						echo "<div class='col-auto' align='center'>
							<i class='far fa-calendar-alt fa-2x  text-primary'></i><br><span class='text-xs'>Mesa ".$nome_mesa."</span>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";

		}

	echo "</div>";


 ?>
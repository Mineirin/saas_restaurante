<?php 

$pagina = 'tela-chamada';

require_once("../../conexao.php");
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$id_empresa = $_SESSION['id_empresa'];
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title><?php echo $nome_site ?></title>

	
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	
	<link rel="shortcut icon" href="../img/icone2.ico" type="image/x-icon">


<!-- Custom fonts for this template-->
    <link href="../painel-recep/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom styles for this template-->
    <link href="../painel-recep/vendor/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../painel-recep/vendor/css/style.css" rel="stylesheet">
		

</head>
<body class="bg-secondary">

<div class="row mx-1 my-2">

<?php 

$query = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and status = 'Preparando' order by id asc LIMIT $itens_tela_chamada");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

for($i=0; $i < @count($res); $i++){
    
				foreach ($res[$i] as $key => $value){	}

					$id_reg = $res[$i]['id'];
					$pedido = $res[$i]['pedido'];
					$item = $res[$i]['item'];
					$quantidade = $res[$i]['quantidade'];

					$query_ped = $pdo->query("SELECT * FROM pedidos where empresa = '$id_empresa' and id = '$pedido' order by id asc");
			$res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);
			$garcon = @$res_ped[0]['garcon'];
					

					//BUSCAR O NOME RELACIONADO
				$query2 = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and id = '$garcon'");
				$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
				$nome_garcon = @$res2[0]['nome'];


				$query2 = $pdo->query("SELECT * FROM pratos where empresa = '$id_empresa' and id = '$item'");
				$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
				$nome_prato = @$res2[0]['nome'];


				$query_ult = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and status = 'Preparando' order by id asc LIMIT 1");
				$res_ult = $query_ult->fetchAll(PDO::FETCH_ASSOC);
				$id_ult = $res_ult[0]['id'];

				if($id_ult != @$_GET['id']){
					
					echo '<audio autoplay="true">
						<source src="../img/audio.mp3" type="audio/mpeg" />
						</audio>';
				}

				if($id_ult == $id_reg){
					$classe = 'text-light';
					$classe_bg = 'bg-danger';
					$classe_texto = 'text-light';
				}else{
					$classe = 'text-primary';
					$classe_bg = '';
					$classe_texto = 'text-dark';
				}


				$ult_id_antigo = $id_ult;
				
				
				

 ?>

<div class='col-<?php echo $card_coluna ?> mb-4'>
			<div class='card shadow h-100'>
				<div class='card-body <?php echo $classe_bg ?>'>
					<div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
							<div class='text-ls <?php echo $classe ?> text-uppercase' style="font-size:30px"><?php echo @$quantidade ?> <?php echo @strtoupper(@$nome_prato) ?></div>
							<div class='text-ls <?php echo $classe_texto ?>'>MESA <?php echo strtoupper(@$res_ped[0]['mesa']) ?> - <?php echo @strtoupper(@$nome_garcon) ?>  </div>
						</div>
						
					</div>
				</div>
			</div>
</div>

<?php } ?>


</div>


</body>
</html>



<?php 

echo "<meta HTTP-EQUIV='refresh' CONTENT='$tempo_atualizacao_tela_chamadas;URL=tela-chamada.php?id=$ult_id_antigo'>"; 
 ?>
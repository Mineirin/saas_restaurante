<?php 
$pagina = 'tela';
require_once("../../conexao.php");
session_start();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title><?php echo $nome_site ?></title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="shortcut icon" href="../img/icone2.ico" type="image/x-icon">
	
</head>
<body>

	<div class="container-tela ml-2">
		<big><big>
			<table class="table table-lg mt-3">
				<thead class="thead-light">
					<tr>
						<th scope="col">Item</th>
						<th scope="col">Quantidade</th>
						<th scope="col">Mesa</th>
						<th scope="col">Garçon</th>

					</tr>
				</thead>
				<tbody>



					<?php


					$itens_por_pagina = $itens_tela;

		//PEGAR A PÁGINA ATUAL
					$pagina_pag = intval(@$_GET['pagina']);

					$limite = $pagina_pag * $itens_por_pagina;

		//CAMINHO DA PAGINAÇÃO
					$caminho_pag = 'tela.php?'; 
					$id_empresa = $_SESSION['id_empresa'];
					$query = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and status = 'Preparando' order by id asc LIMIT $limite, $itens_por_pagina");


					$res = $query->fetchAll(PDO::FETCH_ASSOC);

//TOTALIZAR OS REGISTROS PARA PAGINAÇÃO
					$res_todos = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and status = 'Preparando'");
					$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
					$num_total = count($dados_total);

		//DEFINIR O TOTAL DE PAGINAS
					$num_paginas = ceil($num_total/$itens_por_pagina);



					for ($i=0; $i < count($res); $i++) { 
						foreach ($res[$i] as $key => $value) {
						}

						$id_reg = $res[$i]['id'];
						$pedido = $res[$i]['pedido'];
						$item = $res[$i]['item'];
                        $comentario  = $res[$i]['comentario'];
						$query_ped = $pdo->query("SELECT * FROM pedidos where empresa = '$id_empresa' and id = '$pedido' order by id asc");
						$res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);
						$garcon = $res_ped[0]['garcon'];


					//BUSCAR O NOME RELACIONADO
						$query2 = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and id = '$garcon'");
						$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
						$nome_garcon = $res2[0]['nome'];


						$query2 = $pdo->query("SELECT * FROM pratos where empresa = '$id_empresa' and id = '$item'");
						$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
						$nome_prato = $res2[0]['nome'];
						?>


						<td><?php echo $nome_prato ?><br><small><?php echo $comentario; ?></small></td>
						<td><?php echo $res[$i]['quantidade'] ?></td>
						<td><?php echo $res[$i]['mesa'] ?></td>
						<td><?php echo $nome_garcon ?></td>


					</tr>

				<?php } ?>


			</tbody>
		</table> 



		<!--ÁREA DA PÁGINAÇÃO -->
		<nav class="paginacao" aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item">
					<a class="btn btn-outline-dark btn-sm mr-1" href="<?php echo $caminho_pag; ?>pagina=0&itens=<?php echo $itens_por_pagina ?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
						<span class="sr-only">Previous</span>
					</a>
				</li>
				<?php 
				for($i=0;$i<$num_paginas;$i++){
					$estilo = "";
					if($pagina_pag == $i)
						$estilo = "active";
					?>
					<li class="page-item"><a class="btn btn-outline-dark btn-sm mr-1 <?php echo $estilo; ?>" href="<?php echo $caminho_pag; ?>pagina=<?php echo $i; ?>&itens=<?php echo $itens_por_pagina ?>"><?php echo $i+1; ?></a></li>
				<?php } ?>

				<li class="page-item">
					<a class="btn btn-outline-dark btn-sm" href="<?php echo $caminho_pag; ?>pagina=<?php echo $num_paginas-1; ?>&itens=<?php echo $itens_por_pagina ?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
						<span class="sr-only">Next</span>
					</a>
				</li>
			</ul>
		</nav>



	</big></big>
</div>

</body>
</html>


<?php 

if(!isset($_GET['pagina']) || $_GET['pagina'] >= ($num_paginas - 1)){
	echo "<meta HTTP-EQUIV='refresh' CONTENT='$tempo_atualizacao_tela;URL=tela.php?pagina=0'>"; 
}else{
	$valor = @$_GET['pagina'] + 1;
	echo "<meta HTTP-EQUIV='refresh' CONTENT='$tempo_atualizacao_tela;URL=tela.php?pagina=$valor'>"; 
}


?>
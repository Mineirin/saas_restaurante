<?php 
require_once("../../conexao.php"); 

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));


?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Pratos</title>
	<link rel="shortcut icon" href="../img/favicon.ico" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>

		@page {
			margin: 0px;

		}

		body{
			margin-top:15px;
		}


		<?php if($relatorio_pdf == 'Sim'){ ?>

		.footer {
			margin-top:20px;
			width:100%;
			background-color: #ebebeb;
			padding:10px;
			position:absolute;
			bottom:0;
		}

		<?php }else{ ?>
		.footer {
			margin-top:20px;
			width:100%;
			background-color: #ebebeb;
			padding:10px;
			
		}

		<?php } ?>

		.cabecalho {    
			background-color: #ebebeb;
			padding:10px;
			margin-bottom:30px;
			width:100%;
			height:100px;
		}

		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}

		.areaTotais{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			position:absolute;
			right:20;
		}

		.areaTotal{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			background-color: #f9f9f9;
			margin-top:2px;
		}

		.pgto{
			margin:1px;
		}

		.fonte13{
			font-size:13px;
		}

		.esquerda{
			display:inline;
			width:50%;
			float:left;
		}

		.direita{
			display:inline;
			width:50%;
			float:right;
		}

		.table{
			padding:15px;
			font-family:Verdana, sans-serif;
			margin-top:20px;
		}

		.texto-tabela{
			font-size:12px;
		}


		.esquerda_float{

			margin-bottom:10px;
			float:left;
			display:inline;
		}


		.titulos{
			margin-top:10px;
		}

		.image{
			margin-top:-10px;
		}

		.margem-direita{
			margin-right: 80px;
		}

		.margem-direita50{
			margin-right: 50px;
		}

		hr{
			margin:8px;
			padding:1px;
		}


		.titulorel{
			margin:0;
			font-size:25px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.margem-superior{
			margin-top:30px;
		}

		.areaSubtituloCab{
			margin-top:15px;
			margin-bottom:15px;
		}




		.area-tab{
			
			display:block;
			width:100%;
			height:30px;

		}

		
		.coluna{
			margin: 0px;
			float:left;
			height:30px;
		}


		hr .hr-table{
			
			padding:2px;
			margin:0px;
		}

		.titulo-cardapio{
			width:100%;
			background-color: #f7f7f7;
			padding:3px;
			font-size:13px;
			font-weight: bold;
			margin-bottom:10px;
			margin-top:10px;
		}



	</style>


</head>
<body>

	

		<div class="img-cabecalho my-4">
			<img src="<?php echo $url ?>sistema/img/topo.jpg" width="100%">
		</div>

	

	<div class="container">

		
		<div align="center" class="">	
			<span class="titulorel">Relatório de Pratos </span>
		</div>
		

		<hr>
		<br><br>


		<!--PERIODO DE APURAÇÃO
		<div class="row margem-superior">
			<div class="col-md-12">
				<div class="esquerda_float margem-direita50">	
					<span class=""> <b> Período da Apuração </b> </span>
				</div>
				<div class="esquerda_float margem-direita50">	
					<span class=""> <?php //echo $apuracao ?> </span>
				</div>
				
			</div>
		</div>

		<hr>
	-->


	<section class="area-tab">
					
						<div class="linha-cab">
							<div class="coluna" style="width:60%"><b>Nome</b></div>
							<div class="coluna" style="width:25%"><b>Valor</b></div>
							
							<div class="coluna" style="width:15%"><b>Foto</b></div>
							
						</div>
					
				</section>
				<hr class="hr-table">
		<?php 
		
		$query = $pdo->query("SELECT * FROM pratos  order by id desc");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalItens = @count($res);
		
		for ($i=0; $i < @count($res); $i++) { 
			foreach ($res[$i] as $key => $value) {
			}
			$nome = $res[$i]['nome'];
			$valor = $res[$i]['valor'];
						
			$foto = $res[$i]['imagem'];
			
			
			$id = $res[$i]['id'];

			
			$valor = number_format($valor, 2, ',', '.');
			
			?>

			<section class="area-tab">
					
				<div class="linha-cab">
				
				<div class="coluna" style="width:60%"><?php echo $nome ?> </div>
				
				<div class="coluna" style="width:25%">R$ <?php echo $valor ?> </div>
				
				<div class="coluna" style="width:15%"><img src="<?php echo $url ?>sistema/img/pratos/<?php echo $foto ?>" width="30px"> </div>
				

			</div>
		</section>
		<hr class="hr-table">
		<?php } ?>



	

	<hr>


	<div class="row margem-superior">
		<div class="col-md-12">
			<div class="" align="right">
				
				<span class=""> <b> Total de Pratos :  <?php echo $totalItens ?> </b> </span>
			</div>

		</div>
	</div>

	<hr>


</div>


<div class="footer">
	<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p> 
</div>




</body>
</html>

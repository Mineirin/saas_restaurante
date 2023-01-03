<?php 
if(@$pag_painel != ""){
	$pagina = $pag_painel.'/pedidos';
	$url_pag = '../painel-recep/';
}else{
	$pagina = 'pedidos';
	$url_pag = '';
}
$agora = date('Y-m-d');
@session_start();
$id_usuario = $_SESSION['id'];

if(@$_SESSION['nivel'] != 'Recepcionista' and @$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Garçom'){
	echo "<script language='javascript'> window.location='../' </script>";

	exit();
}

?>


<!-- Custom fonts for this template-->
<link href="<?php echo $url_pag ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Custom styles for this template-->
<link href="<?php echo $url_pag ?>vendor/css/sb-admin-2.min.css" rel="stylesheet">
<link href="<?php echo $url_pag ?>vendor/css/style.css" rel="stylesheet">
<link href="<?php echo $url_pag ?>vendor/css/telapdv.css" rel="stylesheet">



<div class="row mr-2">

	<?php 
	$query = $pdo->query("SELECT * FROM mesas where empresa = '$id_empresa' order by id asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	for($i=0; $i < @count($res); $i++){
		foreach ($res[$i] as $key => $value){	}
			$id_mesa = $res[$i]['id'];
		$nome_mesa = $res[$i]['nome'];

		$query2 = $pdo->query("SELECT * FROM reservas where empresa = '$id_empresa' and mesa = '$nome_mesa' and data = curDate()");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);


		$query4 = $pdo->query("SELECT * FROM pedidos where empresa = '$id_empresa' and mesa = '$nome_mesa' and data = curDate() and valor = '0.00'");
		$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);

		


		$classe = 'text-success';
		$texto = 'DISPONÍVEL';
		$texto_if =  'DISPONÍVEL';
		$nome_cliente = '';


		if(@count($res4) > 0){
			$classe = 'text-primary';
			$texto_if =  'ABERTA';
			$id_pedido = $res4[0]['id'];
			$obs = $res4[0]['obs'];

			$query5 = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and pedido = '$id_pedido'");
			$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
			$texto =  'ABERTA ('.@count($res5).')';
		}


		if(@count($res2) > 0){
			$classe = 'text-danger';
			$texto_if =  'RESERVADA';
			$texto = 'RESERVADA';
			$id_cliente = $res2[0]['cliente'];

			$query3 = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa' and id = '$id_cliente'");
			$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
			$nome_cliente = ' - ' .$res3[0]['nome'];
		}


		
		?>


		<div class='col-lg-3 col-md-4 col-sm-12 mb-4'>
			<?php if($texto_if == 'ABERTA'){ ?>
				<a href="#" onclick="modalPDV(<?php echo $nome_mesa ?>, <?php echo $id_pedido ?>, '<?php echo $obs ?>')" style="text-decoration: none">	
				<?php }else{ ?>
					<a href="#" onclick="modalReserva(<?php echo $nome_mesa ?>)" style="text-decoration: none">
					<?php } ?>
					<div class='card shadow h-100'>
						<div class='card-body'>
							<div class='row no-gutters align-items-center'>
								<div class='col mr-2'>
									<div class='text-ls   <?php echo $classe ?> text-uppercase'>Mesa <?php echo $nome_mesa ?></div>
									<div class='text-ls text-secondary'><small><?php echo $texto ?> <?php echo $nome_cliente ?></small> </div>
								</div>
								<div class='col-auto' align='center'>
									<i class='far fa-calendar-alt fa-3x  <?php echo $classe ?>'></i><br>

								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

		<?php } ?>

	</div>






	<!-- Modal -->
	<div class="modal fade" id="modal-reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Abertura de Mesa - Mesa <span id="mesa-label"></span></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post" id="form-reserva">
					<div class="modal-body">


						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Garçon </label>
							<select class="form-select" aria-label="Default select example" name="garcon">
								<?php 
								$query = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and nivel = 'Garçon' order by nome asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								for($i=0; $i < @count($res); $i++){
									foreach ($res[$i] as $key => $value){	}
										$id_reg = $res[$i]['id'];
									$nome_reg = $res[$i]['nome'];
									?>
									<option <?php if(@$id_reg == @$id_usuario){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>

								<?php } ?>


							</select>
						</div>	


						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Observações </label>
							<textarea type="text" class="form-control" id="obs" name="obs"></textarea>
						</div>	

						<input type="hidden" name="mesa" id="mesa" >


						<small><div align="center" id="mensagem-reserva">
						</div></small>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-reserva">Fechar</button>
						<button type="submit" class="btn btn-success">Abrir Mesa</button>
					</div>
				</form>
			</div>
		</div>
	</div>






	<!-- Modal -->
	<div class="modal fade" id="modal-pdv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
		<div class="modal-dialog modal-xl" style="overflow-y: initial !important">
			<div class="modal-content">
				
				<div class="modal-body" style="max-height: calc(100vh - 45px);
    overflow-y: auto;">

					<input type="hidden" name="mesa" id="mesa-consumo" >
					<input type="hidden" name="pedido" id="pedido-consumo" >
					

					<div class='checkout'>
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class='order py-2'>
									<p class="background">LISTA DE ITENS MESA <span id="mesa-label-consumo-pdv"></span> 

										<a data-bs-toggle="modal" data-bs-target="#modalObs" style="text-decoration:none" class="text-light ml-2" href="#" title="Ver Observações"><i class="bi bi-exclamation-circle"></i> <small>OBSERVAÇÕES</small> </a>

									</p>

									<span id="listar-itens-pdv">

									</span>


								</div>
							</div>



							<div id='payment' class='payment col-md-7'>
								<div class="row py-2">

									<p class="background">LISTA DE PRODUTOS</p>

									<small>
										<table id="example" class="table table-sm my-4" style="width:98%;">
											<thead>
												<tr>
													<td style="display:none">Categoria</td>
													<th style="width:35%">Nome</th>
													<th style="text-align:center; width:20%">Valor</th>
													<th style="text-align:center">Estoque</th>
													<th style="text-align:center">Imagem</th>

													<th style="text-align:center">Quantidade</th>

													<th style="text-align:center">ADD</th>

												</tr>
											</thead>
											<tbody>
												<?php 
												$query = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' and estoque > 0 order by id desc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												for($i=0; $i < @count($res); $i++){
													foreach ($res[$i] as $key => $value){	}
														$id_reg = $res[$i]['id'];


													$valor_venda = number_format($res[$i]['valor_venda'], 2, ',', '.');

													$id_cat = $res[$i]['categoria'];

					//BUSCAR O NOME RELACIONADO
													$query2 = $pdo->query("SELECT * FROM categorias where empresa = '$id_empresa' and id = '$id_cat'");
													$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
													$nome_cat = $res2[0]['nome'];


													?>
													<tr>
														<td style="display:none">R$ <?php echo $nome_cat ?></td>
														<td style="width:40%"><?php echo $res[$i]['nome'] ?></td>

														<td style="text-align:center; width:20%">R$ <?php echo $valor_venda ?></td>


														<td style="text-align:center"><?php echo $res[$i]['estoque'] ?></td>
														<td style="text-align:center"><img src="../img/produtos/<?php echo $res[$i]['imagem'] ?>" width="25"></td>


														<td style="text-align:center">

															<input class="form-control form-control-sm" value="1" type="number" id="qtd-<?php echo $id_reg ?>" >

														</td>

														<td style="text-align:center">

															<a href="" onclick="addProduto(<?php echo $id_reg ?>, 'Produto')" title="Add Produto">
																<i class="bi bi-check-square text-primary"></i></a>

															</td>
														</tr>

													<?php } ?>

												</tbody>
											</table>
											<div class="mt-4" id="mensagem-add"></div>
										</small>

										<p class="background mt-2">LISTA DE PRATOS</p>

										<small>
											<table id="example2" class="table table-sm my-4" style="width:98%;">
												<thead>
													<tr>
														<td style="display:none">Categoria</td>
														<th style="width:40%">Nome</th>
														<th style="text-align:center; width:20%">Valor</th>

														<th style="text-align:center">Imagem</th>

														<th style="text-align:center">Quantidade</th>

														<th style="text-align:center">ADD</th>

													</tr>
												</thead>
												<tbody>
													<?php 
													$query = $pdo->query("SELECT * FROM pratos where empresa = '$id_empresa' order by id desc");
													$res = $query->fetchAll(PDO::FETCH_ASSOC);
													for($i=0; $i < @count($res); $i++){
														foreach ($res[$i] as $key => $value){	}
															$id_reg = $res[$i]['id'];


														$valor_venda = number_format($res[$i]['valor'], 2, ',', '.');

														$id_cat = $res[$i]['categoria'];

					//BUSCAR O NOME RELACIONADO
														$query2 = $pdo->query("SELECT * FROM categorias where empresa = '$id_empresa' and id = '$id_cat'");
														$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
														$nome_cat = $res2[0]['nome'];


														?>
														<tr>
															<td style="display:none">R$ <?php echo $nome_cat ?></td>
															<td style="width:40%"><?php echo $res[$i]['nome'] ?></td>

															<td style="text-align:center; width:20%">R$ <?php echo $valor_venda ?></td>



															<td style="text-align:center"><img src="../img/pratos/<?php echo $res[$i]['imagem'] ?>" width="25"></td>


															<td style="text-align:center">

																<input class="form-control form-control-sm" value="1" type="number" id="qtdPrato-<?php echo $id_reg ?>" >

															</td>

															<td style="text-align:center">

																<a href="" onclick="addProduto(<?php echo $id_reg ?>, 'Prato')" title="Add Prato">
																	<i class="bi bi-check-square text-primary"></i></a>

																</td>
															</tr>

														<?php } ?>

													</tbody>
												</table>
											</small>


										</div>


									</div>


								</div>
							</div>


						</div>

					</div>
				</div>
			</div>





			<!-- Modal -->
			<div class="modal fade" id="modalObs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					
						<form method="post" id="form-obs">
							<div class="modal-body bg-light">


								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label"><h5>Observações do Pedido</h5></label>
									<textarea type="text" class="form-control" id="obs-texto" name="obs-texto"></textarea>
								</div>	


								<input type="hidden" name="pedido-obs" id="pedido-obs" >

								<small><div align="center" id="mensagem-obs">
								</div></small>


							</div>
							<div class="modal-footer bg-light">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-obs">Fechar</button>
								<button type="submit" class="btn btn-primary">Editar</button>
							</div>
						</form>
					</div>
				</div>
			</div>







			<!-- Modal -->
			<div class="modal fade" id="modalFecharMesa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					
						
							<div class="modal-body bg-light">


								<h5>Fechar Mesa <span id="nome-mesa"></span></h5>
								<hr>
								<p>Deseja realmente fechar a mesa? O valor total consumido foi de R$ <span id="total-consumido">.</span></p>

								
								<small><div align="center" id="mensagem-fechar-mesa">
								</div></small>


							</div>
							<div class="modal-footer bg-light">
								<a href="index.php?pag=pedidos" type="button" class="btn btn-danger"  id="btn-fechar-mesa">Sair</a>
								<a href="#" onclick="fecharMesa()" class="btn btn-primary">Fechar Mesa</a>
							</div>
						
					</div>
				</div>
			</div>





			<script type="text/javascript">
				$(document).ready(function() {
					$('#example').DataTable({
						"ordering": false,
						"lengthMenu": [[4, 5, 6, -1], [4, 5, 6, "Todos"]],
					});
				} );
			</script>

			<script type="text/javascript">
				$(document).ready(function() {
					$('#example2').DataTable({
						"ordering": false,
						"lengthMenu": [[4, 5, 6, -1], [4, 5, 6, "Todos"]],
					});
				} );
			</script>



			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function modalReserva(mesa){
					event.preventDefault();
					$('#mesa').val(mesa);
					$('#mesa-label').text(mesa);
					var myModal = new bootstrap.Modal(document.getElementById('modal-reservas'), {

					});
					myModal.show();
				}
			</script>




			<!-- Ajax para inserir ou editar dados -->
			<script type="text/javascript">
				$("#form-reserva").submit(function () {
					event.preventDefault();
					var formData = new FormData(this);
					var pag = "<?=$pagina?>";

					$.ajax({
						url: pag + "/inserir.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {

							$('#mensagem-reserva').removeClass()
							$('#mensagem-reserva').text('')

							if (mensagem.trim() == "Salvo com Sucesso!") {
								window.location = "index.php?pag="+pag;



							} else {

								$('#mensagem-reserva').addClass('text-danger')
								$('#mensagem-reserva').text(mensagem)
							}



						},

						cache: false,
						contentType: false,
						processData: false,

					});

				});
			</script>




			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function modalPDV(mesa, pedido, obs){

					event.preventDefault();
					$('#mesa-consumo').val(mesa);
					$('#pedido-consumo').val(pedido);
					$('#obs-texto').val(obs);
					$('#pedido-obs').val(pedido);

					$('#nome-mesa').text(mesa);


					listarItensPDV();

		//$('#pedido-consumo').val(pedido);
		$('#mesa-label-consumo-pdv').text($('#mesa-consumo').val());
		var myModal = new bootstrap.Modal(document.getElementById('modal-pdv'), {

		});
		myModal.show();
	}
</script>





<script type="text/javascript">
	var pag = "<?=$pagina?>";
	function addProduto(id, tipo){
		event.preventDefault();
		if(tipo === 'Produto'){
			var quant = $('#qtd-'+id).val();
		}else{
			var quant = $('#qtdPrato-'+id).val();
		}
		
		var pedido = $('#pedido-consumo').val();
		var mesa = $('#mesa-consumo').val();

		$.ajax({
			url: pag + "/inserir-itens.php",
			method: 'POST',
			data: {id, quant, pedido, mesa, tipo},
			dataType: "text",

			success: function (mensagem) {

				$('#mensagem-add').removeClass()
				$('#mensagem-add').text('');


				if (mensagem.trim() == "Salvo com Sucesso!") {
					if(tipo === 'Produto'){
						$('#qtd-'+id).val('1');
						
					}else{
						$('#qtdPrato-'+id).val('1');
						
					}
					listarItensPDV();

				}else{
					$('#mensagem-add').addClass('text-danger')
					$('#mensagem-add').text(mensagem)
				}
			},

		});


	}
</script>




<!--AJAX PARA MOSTRAR OS PRODUTOS DO ITEM DA VENDA -->

<script type="text/javascript">
	var pag = "<?=$pagina?>";
	function listarItensPDV(){
		var idpedido = $('#pedido-consumo').val();
		$.ajax({
			url: pag + "/listar-itens-pdv.php",
			method: 'POST',
			data: {idpedido},
			dataType: "html",

			success:function(result){
				$("#listar-itens-pdv").html(result);
				$('#total-consumido').text($('#sub_total').text());
			} 

		});
	}
</script>





<script type="text/javascript">
	function excluirItem(id){
		event.preventDefault();
		var pag = "<?=$pagina?>";
		console.log(id)
		$.ajax({
			url: pag + "/excluir-itens.php",
			method: 'POST',
			data: {id},
			dataType: "text",

			success: function (mensagem) {


				if (mensagem.trim() == "Excluído com Sucesso!") {
					listarItensPDV();

				} 
			},

		});

		
	}
</script>






<!-- Ajax para inserir ou editar dados -->
<script type="text/javascript">
	$("#form-obs").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);
		var pag = "<?=$pagina?>";

		$.ajax({
			url: pag + "/editar-obs.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				$('#mensagem-obs').removeClass()
				$('#mensagem-obs').text('')

				if (mensagem.trim() == "Salvo com Sucesso!") {
					$('#btn-fechar-obs').click();

				} else {

					$('#mensagem-obs').addClass('text-danger')
					$('#mensagem-obs').text(mensagem)
				}



			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>





<script type="text/javascript">
	var pag = "<?=$pagina?>";
	function fecharMesa(){
		event.preventDefault();
		
		var pedido = $('#pedido-consumo').val();
		
		$.ajax({
			url: pag + "/fechar-mesa.php",
			method: 'POST',
			data: {pedido},
			dataType: "text",

			success: function (mensagem) {

				$('#mensagem-fechar-mesa').removeClass()
				$('#mensagem-fechar-mesa').text('');


				if (mensagem.trim() == "Salvo com Sucesso!") {

					let a= document.createElement('a');
         			 a.target= '_blank';
          			a.href= '../rel/rel_comprovante_class.php?id=' + pedido;
          			a.click();

				}else{
					$('#mensagem-fechar-mesa').addClass('text-danger')
					$('#mensagem-fechar-mesa').text(mensagem)
				}
			},

		});


	}
</script>





			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function ModalFecharMesa(){

		
		var myModal = new bootstrap.Modal(document.getElementById('modalFecharMesa'), {
			backdrop: 'static',
		});
		myModal.show();
	}
</script>

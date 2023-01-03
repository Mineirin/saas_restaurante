<?php 

if(@$pag_painel != ""){
	$pagina = $pag_painel.'/reservas';
}else{
	$pagina = 'reservas';
}
require_once("verificar.php");
$agora = date('Y-m-d');
?>


<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Custom styles for this template-->
<link href="vendor/css/sb-admin-2.min.css" rel="stylesheet">
<link href="vendor/css/style.css" rel="stylesheet">



<div class="row">
	<div class="col-lg-4 col-md-5 col-sm-12">
		<div class="row mx-2">
			<div class="col-mb-6 col-lg-6 col-sm-12">
				<span>Reservas de Mesas 
				<?php 
				$query = $pdo->query("SELECT * FROM reservas where empresa = '$id_empresa' and reservado = 'Não'");
				$res = $query->fetchAll(PDO::FETCH_ASSOC);
				if(@count($res) > 0){
					?>

					<a data-bs-toggle="modal" data-bs-target="#modalReservasEmail" href="#" title="Ver Reservas Pendentes">
						<i class="bi bi-info-circle-fill text-warning"></i></a>

					<?php } ?>

				</span>
				<hr>
			</div>

				<div class="col-mb-6 col-lg-6 col-sm-12">
					<div class="mb-3">
						<form id="form-data">
							<input type="hidden" id="id_empresa_mesas" name="id_empresa">
							<input type="hidden" id="id_empresa_reservas" name="id_reservas">
							<input onchange="mudarData(this.value)" type="date" class="form-control" id="data" name="data" placeholder="Data" value="<?php echo @$agora ?>">
						</form>
					</div>	
				</div>
			</div>


			<div id="listar">
				
			</div>

		</div>

		<div class="col-lg-8 col-md-7 col-sm-12">

			<div id="listar-reservas">

			</div>




		</div>
	</div>





	<!-- Modal -->
	<div class="modal fade" id="modal-reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nova Reserva - Mesa <span id="mesa-label"></span></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post" id="form-reserva">
					<div class="modal-body">

						<small>
							<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
								<thead>
									<tr>
										<th>Nome</th>
										<th>Email</th>

										<th>Telefone</th>


										<th>Ações</th>

									</tr>
								</thead>
								<tbody>
									<?php 
									$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa' order by id desc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){	}
											$id_cli = $res[$i]['id'];
										$nome_cli = $res[$i]['nome'];


										?>
										<tr>
											<td><?php echo $nome_cli ?></td>
											<td><?php echo $res[$i]['email'] ?></td>

											<td><?php echo $res[$i]['telefone'] ?></td>


											<td>
												<a href="" onclick="pegarCliente('<?php echo $id_cli ?>', '<?php echo $nome_cli ?>')" title="Selecionar Cliente">
													<i class="bi bi-check-square mr-1 text-primary"></i></a>



												</td>
											</tr>

										<?php } ?>

									</tbody>
								</table>
							</small>

							<div class="row">
								<div class="col-md-4">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Nome </label>
										<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo @$nome ?>" readonly required>
									</div>	
								</div>

								<div class="col-md-4">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Pessoas </label>
										<input type="number" class="form-control" id="pessoas" name="pessoas" placeholder="Número de Pessoas" required value="1">
									</div>	
								</div>

								<div class="col-md-4">

									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data </label>
										<input type="date" class="form-control" id="data-reserva" name="data-reserva" placeholder="Nome" value="<?php echo @$agora ?>"  required>
									</div>	
								</div>
							</div>


							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Observações </label>
								<textarea type="text" class="form-control" id="obs" name="obs"></textarea>
							</div>	

							<input type="hidden" name="mesa" id="mesa" >
							<input type="hidden" name="id_cliente" id="id_cliente" >
							<input type="hidden" id="id_empresa_mesas" name="id_empresa">
							<input type="hidden" id="id_empresa_reservas" name="id_reservas">
							<small><div align="center" id="mensagem-reserva">
							</div></small>


						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-reserva">Fechar</button>
							<button type="submit" class="btn btn-primary">Reservar</button>
						</div>
					</form>
				</div>
			</div>
	</div>






		<!-- Modal -->
		<div class="modal fade" id="modal-excluir-reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir Reserva</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" id="form-excluir">
						<div class="modal-body">

							Deseja Realmente Excluir esta Reserva?

							<input type="hidden" name="id-reserva" id="id-reserva">

							<small><div align="center" id="mensagem-excluir">
							</div></small>


						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-excluir">Fechar</button>
							<button type="submit" class="btn btn-danger">Excluir</button>
						</div>
					</form>
				</div>
			</div>
		</div>






		<!-- Modal -->
		<div class="modal fade" id="modalReservasEmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Reservas por Email</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" id="form-excluir">
						<div class="modal-body">



							<small>
								<table id="example2" class="table table-hover table-sm my-4" style="width:98%;">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Email</th>
											<th>Telefone</th>
											<th>Pessoas</th>
											<th>Data</th>
											<th>Mensagem</th>
											<th>Confirmar</th>

										</tr>
									</thead>
									<tbody>
										<?php 
										$query = $pdo->query("SELECT * FROM reservas_email where empresa = '$id_empresa' and reservado = 'Não' order by id asc");
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										for($i=0; $i < @count($res); $i++){
											foreach ($res[$i] as $key => $value){	}
												$id_reg = $res[$i]['id'];


											?>
											<tr>
												<td><?php echo $res[$i]['nome'] ?></td>
												<td><?php echo $res[$i]['email'] ?></td>

												<td><?php echo $res[$i]['telefone'] ?></td>
												<td><?php echo $res[$i]['pessoas'] ?></td>
												<td><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></td>

												<td><?php echo $res[$i]['mensagem'] ?></td>


												<td>
													<a href="#" onclick="reservaEmail('<?php echo $res[$i]['id'] ?>', '<?php echo $res[$i]['email'] ?>', '<?php echo $res[$i]['pessoas'] ?>', '<?php echo $res[$i]['data'] ?>', '<?php echo $res[$i]['mensagem'] ?>')" title="Confirmar Reserva" style="text-decoration: none">
									<i class="bi bi-check-square-fill text-success mx-1"></i>



														</td>
													</tr>

												<?php } ?>

											</tbody>
										</table>

										<div align="center" id="mensagem-tab-reserva"></div>
									</small>




								</div>

							</form>
						</div>
					</div>
				</div>





				<script type="text/javascript">
					$(document).ready(function() {
						
					mostrarMesas();
					mostrarReservas();
				} );
			</script>




			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function mostrarMesas(){
					var id_empresa = localStorage.id_empresa;
					$('#id_empresa_mesas').val(id_empresa)
					$.ajax({
						url: pag + "/listar-mesas.php",
						method: 'POST',
						data: $('#form-data').serialize(),
						dataType: "html",

						success:function(result){
							$("#listar").html(result);
						}
					});
				}
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




			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function mudarData(data){
					mostrarMesas();
					mostrarReservas();
					$('#data-reserva').val(data);

				}
			</script>



			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function pegarCliente(id, nome){
					event.preventDefault();
					console.log(id, nome)
					$('#id_cliente').val(id);
					$('#nome').val(nome);


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

								$('#nome').val('');
								$('#pessoas').val('1');
								$('#btn-fechar-reserva').click();
                    //window.location = "index.php?pag="+pag;
                    var data = $('#data-reserva').val();
                    mudarData(data);


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
				function modalExcluirReserva(id){
					event.preventDefault();
					$('#id-reserva').val(id);

					var myModal = new bootstrap.Modal(document.getElementById('modal-excluir-reservas'), {

					});
					myModal.show();
				}
			</script>





			<!-- Ajax para excluir dados -->
			<script type="text/javascript">
				$("#form-excluir").submit(function () {
					event.preventDefault();
					var formData = new FormData(this);
					var pag = "<?=$pagina?>";

					$.ajax({
						url: pag + "/excluir.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {

							$('#mensagem-excluir').removeClass()
							$('#mensagem-excluir').text('');


							if (mensagem.trim() == "Excluído com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-excluir').click();
                    //window.location = "index.php?pag="+pag;
                    var data = $('#data-reserva').val();
                    mudarData(data);

                } else {

                	$('#mensagem-excluir').addClass('text-danger')
                	$('#mensagem-excluir').text(mensagem)

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
				function mostrarReservas(){
					var id_empresa = localStorage.id_empresa;
					$('#id_empresa_reservas').val(id_empresa)
					$.ajax({
						url: pag + "/listar-reservas.php",
						method: 'POST',
						data: $('#form-data').serialize(),
						dataType: "html",

						success:function(result){
							$("#listar-reservas").html(result);
						}
					});
				}
			</script>




			<script type="text/javascript">
				var pag = "<?=$pagina?>";
				function reservaEmail(id_res_email, email, pessoas, data, mensagem){
					event.preventDefault();
					
					$.ajax({
			url: pag + "/inserir.php",
			method: 'POST',
			data: {id_res_email, email, pessoas, data, mensagem},
			dataType: "text",

			success: function (mensagem) {
				
				$('#mensagem-tab-reserva').removeClass()
				$('#mensagem-tab-reserva').text('');
				if (mensagem.trim() == "Salvo com Sucesso!") {
					
					window.location="index.php?pag="+pag;

				}else{
					$('#mensagem-tab-reserva').addClass('text-danger')
                	
				}
				$('#mensagem-tab-reserva').text(mensagem)
			},

		});

				}
			</script>
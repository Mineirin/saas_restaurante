<?php 
$pagina = 'funcionarios';
require_once("verificar.php");

?>
<a href="index.php?pag=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-secondary mt-2 mb-4">Novo Funcionário</a>

<small>
	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Email</th>
				<th>CPF</th>
				<th>Telefone</th>
				<th>Cargo</th>
				<th>Cadastro</th>
				<th>Ações</th>

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM funcionarios where empresa = '$id_empresa' order by id desc");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			for($i=0; $i < @count($res); $i++){
				foreach ($res[$i] as $key => $value){	}
					$id_reg = $res[$i]['id'];

				$id_cargo = $res[$i]['cargo'];
					//BUSCAR O NOME RELACIONADO
				$query2 = $pdo->query("SELECT * FROM cargos where empresa = '$id_empresa' and id = '$id_cargo'");
				$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
				$nome_cargo = $res2[0]['nome'];


				$data = implode('/', array_reverse(explode('-', $res[$i]['data_cadastro'])));

				?>
				<tr>
					<td><?php echo $res[$i]['nome'] ?></td>
					<td><?php echo $res[$i]['email'] ?></td>
					<td><?php echo $res[$i]['cpf'] ?></td>
					<td><?php echo $res[$i]['telefone'] ?></td>
					<td><?php echo $nome_cargo ?></td>
					<td><?php echo $data ?></td>
					<td>
						<a href="index.php?pag=<?php echo $pagina ?>&funcao=editar&id=<?php echo $id_reg ?>" title="Editar Registro">
							<i class="bi bi-pencil-square mr-1 text-primary"></i></a>

							<a href="index.php?pag=<?php echo $pagina ?>&funcao=excluir&id=<?php echo $id_reg ?>" title="Excluir Registro">
								<i class="bi bi-trash text-danger"></i></a>

								<a href="" onclick="dados('<?php echo $res[$i]["nome"] ?>', '<?php echo $res[$i]["cpf"] ?>', '<?php echo $res[$i]["email"] ?>', '<?php echo $res[$i]["telefone"] ?>', '<?php echo $nome_cargo ?>', '<?php echo $res[$i]["endereco"] ?>')" title="Ver Dados">
									<i class="bi bi-info-circle-fill text-secondary"></i></a>

								</td>
							</tr>

						<?php } ?>

					</tbody>
				</table>
			</small>





			<!-- Modal -->
			<div class="modal fade" id="cadastro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<?php 
							if(@$_GET['funcao'] == 'novo'){
								$titulo_modal = 'Inserir Registro';
							}else{
								$titulo_modal = 'Editar Registro';
								$id = @$_GET['id'];
								$query = $pdo->query("SELECT * FROM funcionarios WHERE empresa = '$id_empresa' and id = '$id'");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$nome = @$res[0]['nome'];
								$cpf = @$res[0]['cpf'];
								$email = @$res[0]['email'];
								$telefone = @$res[0]['telefone'];
								$endereco = @$res[0]['endereco'];
								$cargo = @$res[0]['cargo'];
								$data_cadastro = @$res[0]['data_cadastro'];
							}
							?>
							<h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo_modal ?></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="post" id="form">
							<div class="modal-body">

								<div class="row">
									<div class="col-6">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Nome </label>
											<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo @$nome ?>" required>
										</div>	
									</div>
									<div class="col-6">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Email </label>
											<input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required value="<?php echo @$email ?>">
										</div>	
									</div>

								</div>




								<div class="row">
									<div class="col-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">CPF </label>
											<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required value="<?php echo @$cpf ?>">
										</div>	
									</div>

									<div class="col-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Telefone </label>
											<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" value="<?php echo @$telefone ?>" required>
										</div>	
									</div>

									<div class="col-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Cargo </label>
											<select class="form-select" aria-label="Default select example" name="cargo">
												<?php 
												$query = $pdo->query("SELECT * FROM cargos where empresa = '$id_empresa' order by nome asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												for($i=0; $i < @count($res); $i++){
													foreach ($res[$i] as $key => $value){	}
														$id_cargo = $res[$i]['id'];
													$nome_cargo = $res[$i]['nome'];
													?>
													<option <?php if(@$id_cargo == @$cargo){ ?> selected <?php } ?> value="<?php echo $id_cargo ?>"><?php echo $nome_cargo ?></option>

												<?php } ?>


											</select>
										</div>	
									</div>
								</div>

								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Endereço </label>
									<input type="text" class="form-control" id="endereco" name="endereco"  value="<?php echo @$endereco ?>" placeholder="Rua A Numero 50 Bairro x">
								</div>	



								<input type="hidden" name="id"  value="<?php echo @$id ?>">
								<input type="hidden" name="id_empresa"  value="<?php echo @$id_empresa ?>">					

								<small><div align="center" id="mensagem">
								</div></small>


							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar">Fechar</button>
								<button type="submit" class="btn btn-primary">Salvar</button>
							</div>
						</form>
					</div>
				</div>
			</div>


			<!-- Modal -->
			<div class="modal fade" id="excluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Excluir Registro</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="post" id="form-excluir">
							<div class="modal-body">

								Deseja Realmente Excluir este Registro?

								<input type="hidden" name="id"  value="<?php echo @$id ?>">
								<input type="hidden" name="id_empresa"  value="<?php echo $id_empresa ?>">
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
			<div class="modal fade" id="modal-dados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="nome_registro"></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
							<div class="modal-body">

								<div class="mb-2">
								<span><b>CPF : </b></span><span id="cpf_registro"></span>
								</div>

								<div class="mb-2">
								<span><b>Email : </b></span><span id="email_registro"></span>
								</div>

								<div class="mb-2">
								<span><b>Telefone : </b></span><span id="telefone_registro"></span>
								</div>

								<div class="mb-2">
								<span><b>Cargo : </b></span><span id="cargo_registro"></span>
								</div>

								<div class="mb-2">
								<span><b>Endereço : </b></span><span id="endereco_registro"></span>
								</div>

							</div>
							
						
					</div>
				</div>
			</div>



			<?php 
			if(@$_GET['funcao'] == 'novo'){ ?>
				<script type="text/javascript">
					var myModal = new bootstrap.Modal(document.getElementById('cadastro'), {
						backdrop: 'static'
					})

					myModal.show();
				</script>
			<?php } ?>


			<?php 
			if(@$_GET['funcao'] == 'editar'){ ?>
				<script type="text/javascript">
					var myModal = new bootstrap.Modal(document.getElementById('cadastro'), {
						backdrop: 'static'
					})

					myModal.show();
				</script>
			<?php } ?>


			<?php 
			if(@$_GET['funcao'] == 'excluir'){ ?>
				<script type="text/javascript">
					var myModal = new bootstrap.Modal(document.getElementById('excluir'), {

					})

					myModal.show();
				</script>
			<?php } ?>




			<script type="text/javascript">
				$(document).ready(function() {
					$('#example').DataTable({
						"ordering": false
					});
				} );
			</script>




			<!-- Ajax para inserir ou editar dados -->
			<script type="text/javascript">
				$("#form").submit(function () {
					event.preventDefault();
					var formData = new FormData(this);
					var pag = "<?=$pagina?>";
					var id_empresa = localStorage.id_empresa;
					$('#id_empresa').val(id_empresa)
					$.ajax({
						url: pag + "/inserir.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {
							window.location = "index.php?pag="+pag;
							$('#mensagem').removeClass()

							if (mensagem.trim() == "Salvo com Sucesso!") {
								
                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag="+pag;

                } else {

                	$('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

				});
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

							if (mensagem.trim() == "Excluído com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-excluir').click();
                    window.location = "index.php?pag="+pag;

                } else {

                	$('#mensagem-excluir').addClass('text-danger')
                }

                $('#mensagem-excluir').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

				});
			</script>


<script type="text/javascript">
	function dados(nome, cpf, email, telefone, cargo, endereco){
		event.preventDefault();
		var myModal = new bootstrap.Modal(document.getElementById('modal-dados'), {
						
					});

		myModal.show();
		$('#nome_registro').text(nome);
		$('#cpf_registro').text(cpf);
		$('#email_registro').text(email);
		$('#telefone_registro').text(telefone);
		$('#cargo_registro').text(cargo);
		$('#endereco_registro').text(endereco);
	}
</script>
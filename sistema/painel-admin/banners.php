<?php 
$pagina = 'banners';
require_once("verificar.php");
?>
<a href="index.php?pag=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-secondary mt-2 mb-4">Novo Banner</a>

<small>
	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				<th>Título</th>
				<th>Subtitulo</th>
				<th>Link</th>
				<th>Imagem</th>
				<th>Ações</th>

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM banners where empresa = '$id_empresa' order by id desc");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			for($i=0; $i < @count($res); $i++){
				foreach ($res[$i] as $key => $value){	}
					$id_reg = $res[$i]['id'];

				
				?>
				<tr>
					<td><?php echo $res[$i]['titulo'] ?></td>
					<td><?php echo $res[$i]['subtitulo'] ?></td>
					<td><?php echo $res[$i]['link'] ?></td>
					
					<td><img src="../img/<?php echo $pagina ?>/<?php echo $res[$i]['imagem'] ?>" width="40"></td>
					<td>
						<a href="index.php?pag=<?php echo $pagina ?>&funcao=editar&id=<?php echo $id_reg ?>" title="Editar Registro">
							<i class="bi bi-pencil-square mr-1 text-primary"></i></a>

							<a href="index.php?pag=<?php echo $pagina ?>&funcao=excluir&id=<?php echo $id_reg ?>" title="Excluir Registro">
								<i class="bi bi-trash text-danger"></i></a>

								
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
								$query = $pdo->query("SELECT * FROM banners WHERE  id = '$id'");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								
								$descricao = @$res[0]['descricao'];
								$titulo = @$res[0]['titulo'];
								$subtitulo = @$res[0]['subtitulo'];
								$link = @$res[0]['link'];
								$imagem = @$res[0]['imagem'];
							}
							?>
							<h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo_modal ?></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="post" id="form">
							<div class="modal-body">

								<div class="row">
									<div class="col-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Título </label>
											<input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="<?php echo @$titulo ?>" required>
										</div>	
									</div>
									


									<div class="col-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">SubTítulo </label>
											<input type="text" class="form-control" id="subtitulo" name="subtitulo" placeholder="SubTítulo" value="<?php echo @$subtitulo ?>" required>
										</div>	
									</div>

									<div class="col-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Link </label>
											<input type="text" class="form-control" id="link" name="link" placeholder="Link" value="<?php echo @$link ?>">
										</div>	
									</div>

									
								</div>


								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Descrição </label>
									<input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Banner"  value="<?php echo @$descricao ?>">
								</div>	


								<div class="form-group">
									<label >Imagem</label>
									<input type="file" value="<?php echo @$imagem ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
								</div>

								<div id="divImgConta" class="mt-4">
									<?php if(@$imagem != ""){ ?>
										<img src="../img/<?php echo $pagina ?>/<?php echo @$imagem ?>"  width="170px" id="target">
									<?php  }else{ ?>
										<img src="../img/sem-foto.jpg" width="170px" id="target">
									<?php } ?>
								</div>



								<input type="hidden" name="id"  value="<?php echo @$id ?>">
								<input type="hidden" name="id_empresa"  value="<?php echo $id_empresa ?>">		

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

					$.ajax({
						url: pag + "/inserir.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {

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


		



			<!--SCRIPT PARA CARREGAR IMAGEM -->
			<script type="text/javascript">

				function carregarImg() {

					var target = document.getElementById('target');
					var file = document.querySelector("input[type=file]").files[0];

					var arquivo = file['name'];
					resultado = arquivo.split(".", 2);
        //console.log(resultado[1]);

        if(resultado[1] === 'pdf'){
        	$('#target').attr('src', "../img/pdf.png");
        	return;
        }

        var reader = new FileReader();

        reader.onloadend = function () {
        	target.src = reader.result;
        };

        if (file) {
        	reader.readAsDataURL(file);


        } else {
        	target.src = "";
        }
    }

</script>



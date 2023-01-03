<?php 
$pagina = 'consultas-pedidos';
require_once("verificar.php");
?>

<small>
	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				<th>Pago</th>
				<th>Valor</th>
				<th>Serviço</th>
				<th>Couvert</th>
				<th>SubTotal</th>
				<th>Mesa</th>
				<th>Data</th>
				<th>Garçon</th>
				<th>Ações</th>

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM pedidos where empresa = '$id_empresa' and valor > 0 order by id desc");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			for($i=0; $i < @count($res); $i++){
				foreach ($res[$i] as $key => $value){	}

					$id_reg = $res[$i]['id'];
					$garcon = $res[$i]['garcon'];
					$pago = $res[$i]['pago'];

					

					//BUSCAR O NOME RELACIONADO
				$query2 = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and id = '$garcon'");
				$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
				$nome_func = $res2[0]['nome'];


				if($res[$i]['pago'] == 'Sim'){
							$classe = 'text-success';
						}else{
							$classe = 'text-danger';
						}

				
				?>
				<tr>
					<td><i class="bi bi-square-fill <?php echo $classe ?>"></i></td>
					<td>R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></td>
					<td>R$ <?php echo number_format($res[$i]['comissao'], 2, ',', '.'); ?></td>
					<td>R$ <?php echo number_format($res[$i]['couvert'], 2, ',', '.'); ?></td>
					<td>R$ <?php echo number_format($res[$i]['subtotal'], 2, ',', '.'); ?></td>
					<td><?php echo $res[$i]['mesa'] ?></td>
					<td><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></td>
					<td><?php echo $nome_func ?></td>
										
					<td>

							<a href="../rel/rel_comprovante_class.php?id=<?php echo $id_reg ?>" target="_blank" title="Gerar Comprovante">
							<i class="bi bi-file-earmark-check text-primary"></i></a>
							
							<a href="index.php?pag=<?php echo $pagina ?>&funcao=excluir&id=<?php echo $id_reg ?>" title="Excluir Comissão">
							<i class="bi bi-trash text-danger"></i></a>

							<?php if($pago != 'Sim'){ ?>

							<a href="index.php?pag=<?php echo $pagina ?>&funcao=baixar&id=<?php echo $id_reg ?>" title="Confirmar Pagamento">
							<i class="bi bi-check-square text-success"></i></a>

						<?php } ?>

							
							</td>
						</tr>

					<?php } ?>

				</tbody>
			</table>
		</small>






		<!-- Modal -->
		<div class="modal fade" id="excluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir Comissão Garçon</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" id="form-excluir">
						<div class="modal-body">

							

							<input type="hidden" name="id"  value="<?php echo @$_GET['id'] ?>">

							<span class="mb-2">Deseja Realmente Excluir a comissão deste Pedido?</span>
							<br><br>
							<small><div align="center" id="mensagem-excluir" >
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






<div class="modal fade" tabindex="-1" id="modalBaixar" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmar Recebimento</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" id="form-baixar">
				<div class="modal-body">

					<p>Deseja Realmente confirmar o Recebimento do pagamento deste Pedido?</p>

					<small><div align="center" class="mt-1" id="mensagem-baixar">
						
					</div> </small>

				</div>
				<div class="modal-footer">
					<button type="button" id="btn-fechar-baixar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button name="btn-baixar" id="btn-excluir" type="submit" class="btn btn-success">Baixar</button>

					<input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

				</div>
			</form>
		</div>
	</div>
</div>





		<?php 
		if(@$_GET['funcao'] == 'excluir'){ ?>
			<script type="text/javascript">
				var myModal = new bootstrap.Modal(document.getElementById('excluir'), {
					
				})

				myModal.show();
			</script>
		<?php } ?>


	<?php 
		if(@$_GET['funcao'] == 'baixar'){ ?>
			<script type="text/javascript">
				var myModal = new bootstrap.Modal(document.getElementById('modalBaixar'), {
					
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




<!-- Ajax para excluir dados -->
		<script type="text/javascript">
			$("#form-baixar").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);
				var pag = "<?=$pagina?>";

				$.ajax({
					url: pag + "/baixar.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {

						$('#mensagem-baixar').removeClass()

						if (mensagem.trim() == "Baixado com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-baixar').click();
                    window.location = "index.php?pag="+pag;

                } else {

                	$('#mensagem-baixar').addClass('text-danger')
                }

                $('#mensagem-excluir').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

			});
		</script>
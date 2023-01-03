<?php 
$pagina = 'pedidos';
require_once("verificar.php");
?>


	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				<th>Item</th>
				<th>Quantidade</th>
				<th>Mesa</th>
				<th>Garçon</th>
				<th>Ações</th>

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM itens_pedidos where empresa = '$id_empresa' and status = 'Preparando' order by id asc");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			
			for($i=0; $i < @count($res); $i++){
				foreach ($res[$i] as $key => $value){	}

					$id_reg = $res[$i]['id'];
					$pedido = $res[$i]['pedido'];
					$item = $res[$i]['item'];

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
				<tr>
					
					<td><?php echo $nome_prato ?></td>
					<td><?php echo $res[$i]['quantidade'] ?></td>
					<td><?php echo $res[$i]['mesa'] ?></td>
					<td><?php echo $nome_garcon ?></td>
										
					<td>

							

							<a href="index.php?pag=<?php echo $pagina ?>&funcao=baixar&id=<?php echo $id_reg ?>" title="Finalizar Prato">
							<i class="bi bi-check-square text-success"></i></a>

						

							
							</td>
						</tr>

					<?php } ?>

				</tbody>
			</table>
		






<div class="modal fade" tabindex="-1" id="modalBaixar" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Finalizar Prato</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" id="form-baixar">
				<div class="modal-body">

					<p>Deseja confirmar a finaliação deste prato?</p>

					<small><div align="center" class="mt-1" id="mensagem-baixar">
						
					</div> </small>

				</div>
				<div class="modal-footer">
					<button type="button" id="btn-fechar-baixar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button name="btn-baixar" id="btn-excluir" type="submit" class="btn btn-success">Baixar</button>

					<input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">
            <input name="id_empresa" type="hidden" value="<?php echo $id_empresa; ?>">
				</div>
			</form>
		</div>
	</div>
</div>





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





<!-- Ajax para baixar dados -->
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
    console.log(mensagem);
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
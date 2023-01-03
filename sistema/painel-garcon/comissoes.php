<?php 
$pagina = 'comissoes';
require_once("verificar.php");
?>

<small>
	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				
				<th>Valor</th>
				<th>Comissão</th>
				<th>Couvert</th>
				<th>SubTotal</th>
				<th>Mesa</th>
				<th>Data</th>
				

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM pedidos where empresa = '$id_empresa' and pago = 'Sim' and comissao > 0 and garcon = '$id_usuario' order by id desc");
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
					
					<td>R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></td>
					<td>R$ <?php echo number_format($res[$i]['comissao'], 2, ',', '.'); ?></td>
					<td>R$ <?php echo number_format($res[$i]['couvert'], 2, ',', '.'); ?></td>
					<td>R$ <?php echo number_format($res[$i]['subtotal'], 2, ',', '.'); ?></td>
					<td><?php echo $res[$i]['mesa'] ?></td>
					<td><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></td>
					
										
					
						</tr>

					<?php } ?>

				</tbody>
			</table>
		</small>





		<script type="text/javascript">
			$(document).ready(function() {
				$('#example').DataTable({
					"ordering": false
				});
			} );
		</script>



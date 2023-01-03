<?php 
$pagina = 'movimentacoes';
require_once("verificar.php");
?>

<small>
	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				<th>Tipo</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>Funcionário</th>
				<th>Data</th>
				

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM movimentacoes where empresa = '$id_empresa' order by id desc");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			for($i=0; $i < @count($res); $i++){
				foreach ($res[$i] as $key => $value){	}
					$id_reg = $res[$i]['id'];
				
				$id_func = $res[$i]['usuario'];


					//BUSCAR O NOME RELACIONADO
				$query2 = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and id = '$id_func'");
				$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
				$nome_func = $res2[0]['nome'];


				if($res[$i]['tipo'] == 'Entrada'){
							$classe = 'text-success';
						}else{
							$classe = 'text-danger';
						}

				
				?>
				<tr>
					<td><i class="bi bi-square-fill <?php echo $classe ?>"></i> <?php echo $res[$i]['tipo'] ?></td>
					<td><?php echo $res[$i]['descricao'] ?></td>
					<td>R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></td>
					
					<td><?php echo $nome_func ?></td>
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


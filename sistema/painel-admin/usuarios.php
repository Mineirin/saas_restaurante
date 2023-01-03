<?php 
require_once("verificar.php");
 ?>
<small>
	<table id="example" class="table table-hover table-sm my-4" style="width:98%;">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Email</th>
				<th>CPF</th>
				<th>Senha</th>
				<th>Nível</th>

			</tr>
		</thead>
		<tbody>
			<?php 
			$query = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' order by id desc");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			for($i=0; $i < @count($res); $i++){
				foreach ($res[$i] as $key => $value){	}

			 ?>
			<tr>
				<td><?php echo $res[$i]['nome'] ?></td>
				<td><?php echo $res[$i]['email'] ?></td>
				<td><?php echo $res[$i]['cpf'] ?></td>
				<td><?php echo $res[$i]['senha'] ?></td>
				<td><?php echo $res[$i]['nivel'] ?></td>
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
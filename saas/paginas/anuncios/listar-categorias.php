<?php
$pag = 'categorias';

use FontLib\Table\Type\name;

$tabela = 'categorias';
require_once("../../../conexao.php");
$id_empresa = $_POST['id_empresa'];
$query_empresa = $pdo->query("SELECT * FROM empresas  where id = $id_empresa");
$empresa = $query_empresa->fetch(PDO::FETCH_ASSOC);
$empresa = $empresa['nome'];
$query = $pdo->query("SELECT * FROM $tabela  where empresa = $id_empresa");
$categorias = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if (count($categorias) > 0) { ?>
	<?php echo <<<HTML
	<small>
	<table class="table table-hover" id="tabela-categorias">
	<thead> 
	<tr> 
	<th>Nome</th>
	<th></th>
	<th></th>		
	<th></th>		
	<th>Ações</th>
	</tr>
	</thead>
	<tbody>

	HTML;
	?>
	<?php foreach ($categorias as $categoria) {
		$id_categoria = $categoria['id'];
		$nome = $categoria['nome'];

		if ($categoria['ativo'] == 'Sim') {
			$icone = 'fa-check-square';
			$titulo_link = 'Desativar Item';
			$acao = 'Não';
			$classe_ativo = '';
		} else {
			$icone = 'fa-square-o';
			$titulo_link = 'Ativar Item';
			$acao = 'Sim';
			$classe_ativo = '#c4c4c4';
		}
		echo <<<HTML
	<tr style="color:{$classe_ativo}">
	<td class="esc">{$categoria['nome']}</td>
	<td></td>
	<td></td>
	<td></td>
	<td>
		<big><a href="#" onclick="editar('{$id_empresa}', '{$id_categoria}','{$nome}')" title="Editar Categoria {$nome}"><i class="fa fa-edit text-primary"></i></a></big>
		<big><a href="#" onclick="ativar2('{$id_categoria}', '{$acao}', '{$id_empresa}','{$empresa}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
		<big><a href="#" onclick="excluir('{$id_categoria}','{$id_empresa}','{$empresa}')" title="{$titulo_link}"><i class="fa fa-trash-o text-danger"></i></a></big>
	</td>
	
	</tr>
	HTML;
	} ?>

	</tbody>
	<small>
		<div align="center" id="mensagem-excluir"></div>
	</small>
	</table>
	</small>


<?php } else { ?>

	<h3 class="text-center">Esta empresa não possui nenhuma categoria cadastrada!</h3>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {

		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
		$('#tabela-categorias').DataTable({
			"ordering": false,
			"stateSave": true
		});
	});
</script>
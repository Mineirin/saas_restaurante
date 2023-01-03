<?php
$pag = 'produtos';

use FontLib\Table\Type\name;

$tabela = 'pratos';
require_once("../../../conexao.php");
$id_empresa = $_POST['id_empresa'];
$query_empresa = $pdo->query("SELECT * FROM empresas  where id = $id_empresa");
$empresa = $query_empresa->fetch(PDO::FETCH_ASSOC);
$empresa = $empresa['nome'];
$query = $pdo->query("SELECT * FROM $tabela  where empresa = $id_empresa");
$pratos = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if (count($pratos) > 0) { ?>
	<?php echo <<<HTML
	<small>
	<table class="table table-hover" id="tabela-pratos">
	<thead> 
	<tr> 
	<th>Imagem</th>
	<th>Nome</th>
	<th>Descrição</th>	
	<th>Valor</th>	
	<th>Categoria</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>

	HTML;
	?>
	<?php foreach ($pratos as $prato) {
		$id_prato = $prato['id'];
		$nome = $prato['nome'];
		$id_cat = $prato['categoria'];
		$prato['imagem'] = 'images/pratos/' . $prato['imagem'];
		$query = $pdo->query("SELECT * FROM categorias  where id = $id_cat");
		$categoria = $query->fetch(PDO::FETCH_ASSOC);
		if ($categoria) {
			$categoria = $categoria['nome'];
		} else {
			$categoria = '';
		}
		if ($prato['ativo'] == 'Sim') {
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
	<td class="esc"><img src="{$prato['imagem']}"  width="30px" id="target">	</td>
	<td class="esc">{$prato['nome']}</td>
	<td>{$prato['descricao']}</td>
	<td>R$ {$prato['valor']}</td>
	<td>{$categoria}</td>
	<td>
		<big><a href="#" onclick="editar('{$id_empresa}', '{$id_prato}','{$nome}','{$id_cat}')" title="Editar Prato {$nome}"><i class="fa fa-edit text-primary"></i></a></big>
		<big><a href="#" onclick="ativar2('{$id_prato}', '{$acao}', '{$id_empresa}','{$empresa}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
		<big><a href="#" onclick="excluir('{$id_prato}','{$id_empresa}','{$empresa}')" title="{$titulo_link}"><i class="fa fa-trash-o text-danger"></i></a></big>
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

	<h3 class="text-center">Esta empresa não possui nenhum prato cadastrado!</h3>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {

		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
		$('#tabela-pratos').DataTable({
			"ordering": false,
			"stateSave": true
		});
	});
</script>
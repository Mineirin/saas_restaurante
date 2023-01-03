<?php
$tabela = 'empresas';
$pag = 'produtos';
require_once("../../../conexao.php");
$id_empresa = $_POST['id_empresa'];
$query = $pdo->query("SELECT * FROM $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
	echo <<<HTML

	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>
	<th></th>	
	<th></th>	
	<th></th>	
	<th></th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

	for ($i = 0; $i < $total_reg; $i++) {
		$id = $res[$i]['id'];
		$nome = $res[$i]['nome'];
		$ativo = $res[$i]['ativo'];
		$data_cad = $res[$i]['data_cad'];
		$data_pgto = $res[$i]['data_pgto'];
		$valor = $res[$i]['valor'];
		$endereco = $res[$i]['endereco'];
		
		$valorF = number_format($valor, 2, ',', '.');
		$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
		$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));




		if ($ativo == 'Sim') {
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

		$query2 = $pdo->query("SELECT * FROM categorias where empresa = '$id_empresa'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if ($total_reg2 > 0) {
			$nome_cat = @$res2[0]['nome_cat'];
		} else {
			$nome_cat = "Nenhuma";
		}

		echo <<<HTML
<tr style="color:{$classe_ativo}">
<td >{$nome}</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>

<big><a href="#" onclick="adicionar('{$id}', '{$nome}')" title="Adicionar Prato"><i class="fa fa-plus text-verde"></i></a></big>

<!-- <big><a href="#" onclick="excluirModal('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-trash-o text-danger"></i></a></big> -->

<big><a href="#" id="btn-edit" onclick="mostrar('{$id}','{$nome}')" title="Mostrar pratos"><i class="fa fa-info-circle text-primary"></i></a></big>

</td>
</tr>
HTML;
	}

	echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>

HTML;
} else {
	echo '<small>Não possui registros cadastrados!</small>';
}

?>


<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>

<script type="text/javascript">
	$(document).ready(function() {
		var pag = '<?php echo $pag; ?>';
		$('#tabela').DataTable({
			"ordering": false,
			"stateSave": true
		});
		$('#tabela_filter label input').focus();
	});
</script>




<script type="text/javascript">
	var id_prato = '';

	function adicionar(id, nome) {
		limparCampos();
		$('#id_empresa').val(id);
		$("#form").html("");
		$("#form").load("paginas/" + pag + "/form-produto.php", {
			id_prato: id_prato
		}, function() {
			listarSelects(id);

			$('#titulo_inserir').text("Adicionando produto em " + nome);
			$('#id_empresa').val(id_empresa);
			$('#modalForm').modal('show');

		});

	}

	function excluir(id, id_empresa, nome) {
		$("#titulo_excluir").text("Excluir produto de " + nome);
		$("#prato_id").val(id);
		$("#empresa_id").val(id_empresa);
		$("#nome_empresa").val(nome);
		$("#modalExcluir").modal('show');
	}

	function editar(id_empresa, id_prato, nome, cat_id, id_fornecedor) {
		$("#form").html("");

		$("#form").load("paginas/" + pag + "/form-produto.php", {
			id_prato: id_prato
		}, function() {
			$("#nome").val(nome);
			listarSelects(id_empresa);
			setTimeout(() => {
				$('#categoria option[value=' + cat_id + ']').attr("selected", "selected");

				$('#categoria').change();

				console.log("teste");
			}, 500);
			$('#titulo_inserir').text("Editando produto " + nome);
			$('#id_empresa').val(id_empresa);
			$("#id_prato").val(id_prato)
			$('#modalForm').modal('show');
			$('#modalDados').modal('hide');
		});


	}

	function ativar2(id_prato, acao, id_empresa, nome_empresa) {
		ativar(id_prato, acao);

		mostrar(id_empresa, nome_empresa);

	}

	function mostrar(id_empresa, nome) {
		$('#titulo_dados').text("Pratos de " + nome);
		$("#dados-pratos").load("paginas/" + pag + "/listar-produtos.php", {
			id_empresa: id_empresa
		}, function() {
			$('#modalDados').modal('show');
		});



	}

	function limparCampos() {
		$('#id').val('');
		$('#nome').val('');
		$('#id_empresa').val('');
		$('#id_prato').val('');
	}
</script>
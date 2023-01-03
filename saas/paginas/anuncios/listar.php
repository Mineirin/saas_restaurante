<?php
$tabela = 'empresas';
$pag = 'anuncios';
require_once("../../../conexao.php");
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


		echo <<<HTML
<tr style="color:{$classe_ativo}">
<td >{$nome}</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>

<big><a href="#" onclick="adicionar('{$id}', '{$nome}')" title="Adicionar banner"><i class="fa fa-plus text-verde"></i></a></big>

<!-- <big><a href="#" onclick="excluirModal('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-trash-o text-danger"></i></a></big> -->

<big><a href="#" id="btn-edit" onclick="mostrar('{$id}','{$nome}')" title="Mostrar banners"><i class="fa fa-info-circle text-primary"></i></a></big>

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
	var id_anuncio = '';

	function adicionar(id, nome, empresa) {

		limparCampos();
		$("#form").html("");
		$("#form").load("paginas/" + pag + "/form-anuncio.php", {
			id_anuncio: id_anuncio
		}, function() {


			$('#titulo_inserir').text("Adicionando anuncio em " + nome);
			$('#id_empresa').val(id);
			listarSelects(id);
			$('#modalForm').modal('show');

		});

	}

	function excluir(id, id_empresa, nome) {
		$("#titulo_excluir").text("Excluir anuncio " + nome);
		$("#banner_id").val(id);
		$("#empresa_id").val(id_empresa);
		$("#nome_empresa").val(nome);
		$("#modalExcluir").modal('show');
	}

	function editar(id_empresa, id_anuncio, nome, prato) {
		$("#form").html("");

		$("#form").load("paginas/" + pag + "/form-anuncio.php", {
			id_anuncio: id_anuncio
		}, function() {
			$("#nome").val(nome);
			
			$('#titulo_inserir').text("Editando anuncio " + nome);
			$('#id_empresa').val(id_empresa);
			$("#id_anuncio").val(id_anuncio)
			$('#modalForm').modal('show');
			$('#modalDados').modal('hide');
			listarSelects(id_empresa);
			setTimeout(() => {
				$('#produto1 option[value=' + prato + ']').attr("selected", "selected");

				$('#produto1').change();

				console.log("teste");
			}, 500);
		});
		
	}

	function ativar2(id_anuncio, acao, id_empresa, nome_empresa) {
		ativar(id_anuncio, acao);

		mostrar(id_empresa, nome_empresa);

	}

	function mostrar(id_empresa, nome) {
		$('#titulo_dados').text("Anuncios de " + nome);
		$("#dados-anuncios").load("paginas/" + pag + "/listar-anuncios.php", {
			id_empresa: id_empresa
		}, function() {
			$('#modalDados').modal('show');
		});
			
	}

	function limparCampos() {
		$('#id').val('');
		$('#nome').val('');
		$('#id_empresa').val('');
		$('#id_anuncio').val('');
	}
</script>
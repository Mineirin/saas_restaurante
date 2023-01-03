<?php 
$tabela = 'empresas';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * FROM $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];


//verificar se a empresa tem conta vencida
$query2 = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' and pessoa = '$id' order by data_venc asc");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
		$conta_pendente = 'text-danger';
	}else{
		$conta_pendente = '';
	}


echo <<<HTML
<tr>
<td class="{$conta_pendente}">{$nome}</td>
<td>

<big><a href="#" onclick="editar('{$id}','{$nome}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

<big><a href="#" onclick="excluirModal('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-trash-o text-danger"></i></a></big>





</td>
</tr>
HTML;
}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
</small>
HTML;

}else{
	echo '<small>Não possui registros cadastrados!</small>';
}

 ?>




 <script type="text/javascript">
	$(document).ready( function () {
    $('#tabela').DataTable({
    		"ordering": false,
			"stateSave": true
    	});
    $('#tabela_filter label input').focus();
} );
</script>




<script type="text/javascript">
	function editar(id, nome){
		$('#id').val(id);
		$('#nome').val(nome);	
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}



	function mostrar(nome){
		
		$('#titulo_dados').text(nome);
				
		$('#modalDados').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
	}



	function arquivo(id, nome){
		
		$('#titulo_arquivo').text(nome);		
		$('#id_arquivo').val(id);	
		$('#id_usuario_arquivo').val(localStorage.id_usu);	
		$('#target').attr("src", "images/arquivos/sem-foto.png");			
		$('#id_arquivo').val(id);				
		$('#modalArquivos').modal('show');
		listarArquivos(id);
		limparArquivos();
	}

	function limparArquivos(){
		$('#nome_arquivo').val('');
		$('#data_validade').val('');
		$('#foto').val('');
		$('#target').attr("src", "images/arquivos/sem-foto.png");
	}



	function contas(id, nome){
		
		$('#titulo_contas').text(nome);		
		$('#modalContas').modal('show');
		listarContas(id);
		
	}


	function contrato(id, nome){		
		$('#titulo_contrato').text(nome);
		$('#id_contrato').val(id);		
		$('#modalContrato').modal('show');
		listarTextoContrato(id);
		
	}



	function excluirModal(id, nome){
		$('#id_usuario_excluir').val(localStorage.id_usu);	
		$('#titulo_excluir').text(nome);		
		$('#id_excluir').val(id);				
		$('#modalExcluir').modal('show');		
	}

</script>
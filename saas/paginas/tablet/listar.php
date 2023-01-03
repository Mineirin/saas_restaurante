<?php 
$tabela = 'tablet';
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
	
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$img_menu = $res[$i]['Fundo_Menu'];
$img_promocao = $res[$i]['Fundo_Promo'];
$img_vendidos = $res[$i]['Vendidos'];
$cor_menu = $res[$i]['Cor_Menu'];
$cor_barra = $res[$i]['Cor_Barra'];
$cor_botao = $res[$i]['Cor-Botao'];
$descricao = $res[$i]['descricao'];
$status = $res[$i]['status'];
$valor = $res[$i]['valor'];
$promocao = $res[$i]['Promocao'];	

$valorF = number_format($valor, 2, ',', '.');
$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));




if($ativo == 'Sim'){
	$icone = 'fa-check-square';
	$titulo_link = 'Desativar Item';
	$acao = 'Não';
	$classe_ativo = '';
}else{
	$icone = 'fa-square-o';
	$titulo_link = 'Ativar Item';
	$acao = 'Sim';
	$classe_ativo = '#c4c4c4';
}		

echo <<<HTML
<tr style="color:{$classe_ativo}">
<td>{$nome}</td>
<td class="esc">{$img_menu}</td>
<td class="esc">{$img_promocao}</td>
<td class="esc">{$img_vendidos}</td>
<td class="esc">{$cor_menu}</td>
<td class="esc">{$cor_barra}</td>
<td class="esc">{$cor_botao}</td>
<td class="esc">{$descricao}</td>
<td class="esc">{$status}</td>
<td class="esc">R$ {$valor}</td>
<td class="esc">{$promocao}</td>

<td>

<big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$cpf}','{$cnpj}','{$valor}','{$data_pgto}','{$endereco}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>


<big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$cpf}','{$cnpj}','{$valorF}','{$data_pgtoF}','{$endereco}','{$ativo}','{$data_cadF}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>



<big><a href="http://api.whatsapp.com/send?1=pt_BR&phone=$whats&text=" target="_blank" title="Abrir Whatsapp" class="text-verde"><i class="fa fa-whatsapp text-verde"></i></a></big>


<big><a href="#" onclick="arquivo('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-file-archive-o text-primary"></i></a></big>

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
	function editar(id, nome, email, telefone, cpf, cnpj, valor, data_pgto, endereco){
		$('#id').val(id);
		$('#nome').val(nome);
		$('#email').val(email);
		$('#telefone').val(telefone);
		$('#cpf').val(cpf);
		$('#cnpj').val(cnpj);
		$('#valor').val(valor);
		$('#data_pgto').val(data_pgto);
		$('#endereco').val(endereco);		
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}



	function mostrar(nome, email, telefone, cpf, cnpj, valor, data_pgto, endereco, ativo, data_cad){
		
		$('#titulo_dados').text(nome);
		$('#email_dados').text(email);
		$('#telefone_dados').text(telefone);
		$('#cpf_dados').text(cpf);
		$('#cnpj_dados').text(cnpj);
		$('#valor_dados').text(valor);
		$('#data_pgto_dados').text(data_pgto);
		$('#endereco_dados').text(endereco);	
		$('#ativo_dados').text(ativo);	
		$('#data_cad_dados').text(data_cad);
				
		$('#modalDados').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
		$('#email').val('');
		$('#telefone').val('');
		$('#cpf').val('');
		$('#cnpj').val('');
		$('#valor').val('');
		$('#data_pgto').val('');
		$('#endereco').val('');
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

</script>
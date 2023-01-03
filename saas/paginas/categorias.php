<?php
$pag = 'categorias';

//verificar se ele tem a permissão de estar nessa página
if(@$categorias == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}
?>

<!-- <a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Empresa</a> -->


<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>



<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form" method="POST">
				<div class="modal-body">


					<div class="row">

						<div class="col-md-6">
							<input type="text" class="form-control" id="nome_cat" name="nome_cat" placeholder="Digite a Categoria" required>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary" style="float: left;">Salvar</button>
						</div>
					</div>

					<input type="hidden" name="id_empresa" id="id">
					<span id="msgAlerta"></span>

					<br>
					<small>
						<div id="mensagem" align="center"></div>
					</small>

				</div>
				<div class="bs-example widget-shadow" style="padding:15px" id="listarCategorias">

				</div>
			</form>

		</div>
	</div>
</div>


<!-- Modal Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="row" style="margin-top: 0px">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Telefone: </b></span><span id="telefone_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>CPF: </b></span><span id="cpf_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Email: </b></span><span id="email_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>CNPJ: </b></span><span id="cnpj_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Valor Mensal: </b></span><span id="valor_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data PGTO: </b></span><span id="data_pgto_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_cad_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>Endereço: </b></span><span id="endereco_dados"></span>
					</div>
				</div>

			</div>



		</div>
	</div>
</div>


<!-- Modal Excluir -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_excluir"></span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-excluir">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<label>Senha Administrador <small>(Confirmar Exclusão da Empresa e de Todos os Seus Dados no Sistema)</small></label>
						</div>

						<div class="col-md-4">
							<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha para Exclusão" required>
						</div>


					</div>


					<input type="hidden" name="id_usuario" id="id_usuario_excluir">
					<input type="hidden" name="id" id="id_excluir">

					<small>
						<div id="mensagem-excluir-modal" align="center"></div>
					</small>


				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
				</div>
			</form>

		</div>
	</div>
</div>




<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>

<script type="text/javascript">
	function listarCategorias(){
	var id_empresa = $('#id').val();
	
    $.ajax({
        url: 'paginas/' + pag + "/listar-categorias.php",
        method: 'POST',
        data: {id_empresa},
        dataType: "html",

        success:function(result){
			
            $("#listarCategorias").html(result);
			alert(result);           
        }
    });

}
</script>
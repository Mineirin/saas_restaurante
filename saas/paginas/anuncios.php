<?php

use FontLib\Table\Type\name;

$pag = 'anuncios';


?>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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
			<form id="form">


			</form>
		</div>
	</div>
</div>






<!-- Modal Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados">Banners</span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="dados-anuncios">



			</div>



		</div>
	</div>
</div>


<!-- Modal Excluir -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_excluir">Exclusão de banners</span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-excluir">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<label>Tem certeza que deseja excluir este banner</label>
						</div>
					</div>


					<input type="hidden" name="id" id="banner_id">
					<input type="hidden" name="empresa_id" id="empresa_id">
					<input type="hidden" name="nome_empresa" id="nome_empresa">
					<small>
						<div id="mensagem-excluir-modal" align="center"></div>
					</small>


				</div>

				<div class="modal-footer">
					<a href="#" id="cancel" class="btn btn-primary">Cancelar</a> <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
				</div>
			</form>

		</div>
	</div>
</div>




<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js?ver=10"></script>


<script type="text/javascript">
	$("#cancel").click(function() {
		$("#modalExcluir").modal("hide");
	})
	$("#form-excluir").submit(function() {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/excluir.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem-excluir-modal').text('');
				$('#mensagem-excluir-modal').removeClass()
				if (mensagem.trim() == "Excluído com Sucesso") {
					var id_empresa = $("#empresa_id").val();
					var nome_empresa = $("#nome_empresa").val();
					mostrar(id_empresa, nome_empresa);
					$('#btn-fechar-excluir').click();
					listar();

				} else {

					$('#mensagem-excluir-modal').addClass('text-danger')
					$('#mensagem-excluir-modal').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>




<script type="text/javascript">
		function listarSelects(id) {
console.log(id);
id_empresa = id;
$.ajax({
	url: 'paginas/' + pag + "/listar-produtos.php",
	method: 'POST',
	data: {
		id_empresa
	},
	dataType: "html",

	success: function(result) {

		$("#produto1").html(result);
	}
});

}
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];

		var arquivo = file['name'];
		resultado = arquivo.split(".", 2);


		var reader = new FileReader();

		reader.onloadend = function() {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}
</script>


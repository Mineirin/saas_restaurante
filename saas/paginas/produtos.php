<?php

use FontLib\Table\Type\name;

$pag = 'produtos';


 ?>

<a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Produto</a>
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
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6">							
                            <label>Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo @$nome ?>" required>							
						</div>
						<div class="col-md-6"> 
								<label>Empresa</label> 
									<select class="form-control sel2" name="empresa" id="empresa" style="width:100%;" required onchange="listarSelects()"> 
									<option value="">Selecione uma Empresa</option>
									<?php 
									$query = $pdo->query("SELECT * FROM empresas");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
								
							</div>
						<br>
					</div>
                    <div class="row">
                        <div class="col-md-12">							
                            <label>Descrição </label>
                            <textarea type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Produto"  value="<?php echo @$descricao ?>"></textarea>							
						</div>
                    </div>


					<div class="row">
						<div class="col-md-4">							
                            <label>Valor Compra</label>
                            <input type="text" class="form-control" id="valor_c" name="valor_c" placeholder="Valor da Compra" required value="<?php echo @$valor_venda ?>">							
						</div>

						<div class="col-md-4">							
                            <label>Valor Venda</label>
                            <input type="text" class="form-control" id="valor_venda" name="valor_venda" placeholder="Valor da Venda" required value="<?php echo @$valor_venda ?>">							
						</div>

						<div class="col-md-4">							
                            <label>Estoque</label>
                            
                            <input type="text" class="form-control" id="estoque" name="estoque" placeholder="" required value="<?php echo @$estoque ?>">							
                        </div>
					</div>
					
					<div class="row">
                        <div class="col-md-6">
						<label>Categoria</label>
						
							<select class="form-control sel2" name="categoria" id="categoria" style="width:100%;" require>
																
							</select>	
                        </div>

						<div class="col-md-6">
						<label>Fornecedor</label>
							<select class="form-control sel2" name="fornecedor" id="fornecedor" style="width:100%;" require>
																
							</select>	
                        </div>
					</div>

					
                    
                    
                    <div class="row">
						<div class="col-md-6">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto" name="foto" value="" onchange="carregarImg()">							
						</div>

						<div class="col-md-6">								
							<img src=""  width="80px" id="target">								
							
						</div>
                    </div>				

					<input type="hidden" name="id_empresa" id="id">					
					<input type="hidden" name="id" id="id_empresa">

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
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
						<span><b>Nome: </b></span><span id="nome_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Descrição: </b></span><span id="descricao_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Valor Compra: </b></span><span id="valor_c_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Valor Venda: </b></span><span id="valor_venda_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Categoria: </b></span><span id="categoria_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Fornecedor: </b></span><span id="fornecedor_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Estoque: </b></span><span id="estoque_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Imagem: </b></span><span id="imagem_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>
				</div>
					
			</div>	

			

		</div>
	</div>
</div>







<!-- Modal Arquivos -->
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>

			


		<script type="text/javascript">
			function carregarImg() {
				var target = document.getElementById('target');
    			var file = document.querySelector("#foto").files[0];

				var arquivo = file['name'];
				resultado = arquivo.split(".", 2);
			

				var reader = new FileReader();

				reader.onloadend = function () {
					target.src = reader.result;
				};

				if (file) {
					reader.readAsDataURL(file);

				} else {
					target.src = "";
				}
			}
		</script>





 <script type="text/javascript">
	
$("#form-arquivos").submit(function () {
	var id_empresa = $('#id_arquivo').val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-arquivo.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-arquivo').text('');
            $('#mensagem-arquivo').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                //$('#btn-fechar-arquivo').click();
                limparArquivos();
                listarArquivos(id_empresa);          

            } else {

                $('#mensagem-arquivo').addClass('text-danger')
                $('#mensagem-arquivo').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>


<script type="text/javascript">
	function listarArquivos(id){
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/listar-arquivos.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){
            $("#listar-arquivos").html(result);           
        }
    });
}



function excluirArquivo(id){
	var id_usuario = localStorage.id_usu;
	var id_empresa = $('#id_arquivo').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-arquivo.php",
        method: 'POST',
        data: {id, id_usuario},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarArquivos(id_empresa);
            } 
        }
    });
}



function listarSelects(){
	var id_empresa = $('#empresa').val();
	
    $.ajax({
        url: 'paginas/' + pag + "/listar-categorias.php",
        method: 'POST',
        data: {id_empresa},
        dataType: "html",

        success:function(result){
			
            $("#categoria").html(result);           
        }
    });

	$.ajax({
        url: 'paginas/' + pag + "/listar-fornecedores.php",
        method: 'POST',
        data: {id_empresa},
        dataType: "html",

        success:function(result){
            $("#fornecedor").html(result);           
        }
    });
}


</script>
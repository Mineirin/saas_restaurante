<?php 
@session_start();
require_once("../../conexao.php");
require_once("verificar.php");

//MENUS PARA O PAINEL
$menu1 = 'pedidos';
$menu2 = 'comissoes';


if(@$_GET['pag'] == '' || @$_GET['pag'] == 'pedidos'){
  $classeMenu = 'text-dark';
}


//recuperar os dados do usuário
$id_usuario = $_SESSION['id'];
$query = $pdo->query("SELECT * FROM usuarios WHERE empresa = '$id_empresa' and id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$nome_usu = $res[0]['nome'];
	$email_usu = $res[0]['email'];
	$cpf_usu = $res[0]['cpf'];
	$senha_usu = $res[0]['senha'];
	$nivel_usu = $res[0]['nivel'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Painel Garçon</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

	<link rel="shortcut icon" href="../img/icone2.ico" type="image/x-icon">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">   

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../vendor/DataTables/datatables.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">


</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php"><img src="../img/logo.png" width="150"></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active text-light" aria-current="page" href="index.php?pag=<?php echo $menu1 ?>">Pedidos</a>
					</li>

					<li class="nav-item">
						<a class="nav-link active text-light" aria-current="page" href="index.php?pag=<?php echo $menu2 ?>">Comissões</a>
					</li>

            <li class="nav-item">
            <a class="nav-link active text-light" aria-current="page" href="" data-bs-toggle="modal" data-bs-target="#ModalRelComissoes">Relatório de Comissões</a>
          </li>

          


						</ul>
					</li>


				</ul>
			
      <div class="d-flex mr-4">
          <img class="img-profile rounded-circle" src="../img/sem-usuario.jpg" width="40px" height="40px">
          
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo $nome_usu ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                   <li><a class="dropdown-item <?php echo @$classeMenu ?>" href="" data-bs-toggle="modal" data-bs-target="#modalPerfil">Editar Perfil</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item <?php echo @$classeMenu ?>" href="../logout.php">Sair</a></li>

                </ul>
              </li>
            </ul>
          </div>




        </div>


			</div>
		</div>
	</nav>

	<div class="container-fluid mt-4 mx-4 px-4">
     	<?php 
     		if(@$_GET['pag'] == $menu1){
     			$pag_painel = '../painel-recep/';
        require_once('../painel-recep/'.$menu1.'.php');

     		}else if(@$_GET['pag'] == $menu2){
     			require_once($menu2.'.php');
     		
     		     		

     		}

     		else{
     			$pag_painel = '../painel-recep/';
        require_once('../painel-recep/'.$menu1.'.php');
     		}
     	 ?>
	</div>

</body>
</html>




<!-- Modal -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" id="form-perfil">
				<div class="modal-body">

					<div class="mb-3">
						<label for="exampleFormControlInput1" class="form-label">Nome </label>
						<input type="text" class="form-control" id="nome_perfil" name="nome_perfil" placeholder="Nome" value="<?php echo $nome_usu ?>" required>
					</div>	

					<div class="mb-3">
						<label for="exampleFormControlInput1" class="form-label">Email </label>
						<input type="email" class="form-control" id="email_perfil" name="email_perfil" placeholder="nome@exemplo.com" required value="<?php echo $email_usu ?>">
					</div>	

					<div class="row">
						<div class="col-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">CPF </label>
								<input type="text" class="form-control" id="cpf" name="cpf_perfil" placeholder="CPF" required value="<?php echo $cpf_usu ?>">
							</div>	
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Senha </label>
								<input type="text" class="form-control" id="senha_perfil" name="senha_perfil" placeholder="senha" required value="<?php echo $senha_usu ?>">
							</div>
						</div>
					</div>

					<input type="hidden" name="id_perfil"  value="<?php echo $id_usuario ?>">

					
					<small><div align="center" id="mensagem-perfil">
					</div></small>
				

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-perfil">Fechar</button>
					<button type="submit" class="btn btn-primary">Editar</button>
				</div>
			</form>
		</div>
	</div>
</div>






<!--  Modal Rel Compras-->
<div class="modal fade" tabindex="-1" id="ModalRelCompras" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatório de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="../rel/rel_compras_class.php" method="POST" target="_blank">
       
                <div class="modal-body">

                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label >Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataInicial" >
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataFinal" >
                        </div>


                    </div>

                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Pago</label>
                            <select class="form-select mt-1"  name="status">
                                <option value="">Todas</option>
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                               
                            </select>
                        </div>


                    </div>

                </div>     

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Gerar Relatório</button>
         
        </div>
        </form>


    </div>
</div>
</div>







<div class="modal fade" tabindex="-1" id="ModalRelPagar" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatório de Contas à Pagar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="../rel/rel_pagar_class.php" method="POST" target="_blank">
       
                <div class="modal-body">

                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label >Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataInicial" >
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataFinal" >
                        </div>


                    </div>

                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Pago</label>
                            <select class="form-select mt-1"  name="status">
                                <option value="">Todas</option>
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                               
                            </select>
                        </div>


                    </div>

                </div>     

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Gerar Relatório</button>
         
        </div>
        </form>


    </div>
</div>
</div>






<div class="modal fade" tabindex="-1" id="ModalRelReceber" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatório de Contas à Receber</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="../rel/rel_receber_class.php" method="POST" target="_blank">
       
                <div class="modal-body">

                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label >Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataInicial" >
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataFinal" >
                        </div>


                    </div>

                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Pago</label>
                            <select class="form-select mt-1"  name="status">
                                <option value="">Todas</option>
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                               
                            </select>
                        </div>


                    </div>

                </div>     

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Gerar Relatório</button>
         
        </div>
        </form>


    </div>
</div>
</div>






<!--  Modal Rel Compras-->
<div class="modal fade" tabindex="-1" id="ModalRelMov" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatório de Movimentações</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="../rel/rel_mov_class.php" method="POST" target="_blank">
       
                <div class="modal-body">

                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label >Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataInicial" >
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataFinal" >
                        </div>


                    </div>

                    <div class="col-md-4">

                        <div class="form-group mb-3">
                            <label >Tipo</label>
                            <select class="form-select mt-1"  name="status">
                                <option value="">Todas</option>
                                <option value="Entrada">Entradas</option>
                                <option value="Saída">Saídas</option>
                               
                            </select>
                        </div>


                    </div>

                </div>     

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Gerar Relatório</button>
         
        </div>
        </form>


    </div>
</div>
</div>






<!--  Modal Rel Compras-->
<div class="modal fade" tabindex="-1" id="ModalRelReservas" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatório de Reservas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="../rel/rel_reservas_class.php" method="POST" target="_blank">
       
                <div class="modal-body">

                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataInicial" >
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label >Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataFinal" >
                        </div>


                    </div>

                   

                </div>     

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Gerar Relatório</button>
         
        </div>
        </form>


    </div>
</div>
</div>





<!-- Mascaras JS -->
  <script type="text/javascript" src="../../assets/js/mascaras.js"></script>

 <!-- Ajax para funcionar Mascaras JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 


 <!-- Ajax para inserir ou editar dados -->
<script type="text/javascript">
	$("#form-perfil").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				$('#mensagem-perfil').removeClass()

				if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-perfil').click();
                    //window.location = "index.php?pagina="+pag;

                } else {

                	$('#mensagem-perfil').addClass('text-danger')
                }

                $('#mensagem-perfil').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

	});
</script>







<!--  Modal Rel Comissoes-->
<div class="modal fade" tabindex="-1" id="ModalRelComissoes" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatório de Comissões</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="../rel/rel_comissoes_class.php" method="POST" target="_blank">
       
                <div class="modal-body">

                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataInicial" >
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label >Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1"  name="dataFinal" >
                        </div>


                    </div>

                   

                </div>     

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Gerar Relatório</button>
         
        </div>
        </form>


    </div>
</div>
</div>

<?php 
@session_start();
require_once("../../conexao.php");
require_once("verificar.php");

//MENUS PARA O PAINEL
$menu1 = 'blog';


//recuperar os dados do usuário
$id_usuario = $_SESSION['id'];
$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$nome_usu = $res[0]['nome'];
	$email_usu = $res[0]['email'];
	$cpf_usu = $res[0]['cpf'];
	$senha_usu = $res[0]['senha'];
	$nivel_usu = $res[0]['nivel'];
}


$query = $pdo->query("SELECT * FROM funcionarios WHERE cpf = '$cpf_usu'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$id_func_perfil = $res[0]['id'];
}


$query = $pdo->query("SELECT * FROM chef WHERE funcionario = '$id_func_perfil'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$especialidade = $res[0]['especialidade'];
	$facebook = $res[0]['facebook'];
	$youtube = $res[0]['youtube'];
	$linkedin = $res[0]['linkedin'];
	$instagram = $res[0]['instagram'];
	$imagem_perfil = $res[0]['imagem'];

	if($imagem_perfil == ""){
		$imagem_perfil = 'sem-foto.jpg';
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Painel do Chef</title>
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
			<a class="navbar-brand" href="index.php"><img src="../img/logo-texto-grande.png" width="150"></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active text-light" aria-current="page" href="index.php?pag=<?php echo $menu1 ?>">Blog</a>
					</li>

					<li class="nav-item">
						<a class="nav-link active text-light" aria-current="page" href="" data-bs-toggle="modal" data-bs-target="#perfil">Editar Perfil</a>
					</li>

					<li class="nav-item">
						<a class="nav-link active text-light" aria-current="page" href="../logout.php">Sair</a>
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
                   <li><a class="dropdown-item <?php echo @$classeMenu ?>" href="" data-bs-toggle="modal" data-bs-target="#perfil">Editar Perfil</a></li>
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
			require_once($menu1.'.php');


		}else{
			require_once($menu1.'.php');
		}
		?>
	</div>

</body>
</html>




<!-- Modal -->
<div class="modal fade" id="perfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" id="form-perfil">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Nome </label>
								<input type="text" class="form-control" id="nome_perfil" name="nome_perfil" placeholder="Nome" value="<?php echo $nome_usu ?>" required>
							</div>	

						</div>
						<div class="col-md-4">

							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Email </label>
								<input type="email" class="form-control" id="email_perfil" name="email_perfil" placeholder="nome@exemplo.com" required value="<?php echo $email_usu ?>">
							</div>
						</div>
						<div class="col-md-4">



							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">CPF </label>
								<input type="text" class="form-control" id="cpf" name="cpf_perfil" placeholder="CPF" required value="<?php echo $cpf_usu ?>">
							</div>	
						</div>

						
					</div>

					

					
					<div class="row">
					<div class="col-4">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Senha </label>
							<input type="text" class="form-control" id="senha_perfil" name="senha_perfil" placeholder="senha" required value="<?php echo $senha_usu ?>">
						</div>
					</div>

					<div class="col-8">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Especialidade </label>
							<input type="text" class="form-control" id="especialidade_perfil" name="especialidade_perfil" placeholder="Especialidade do Chef" required value="<?php echo $especialidade ?>">
						</div>
					</div>

				</div>




				<div class="row">
					<div class="col-6">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Facebook </label>
							<input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook" value="<?php echo $facebook ?>">
						</div>
					</div>

					<div class="col-6">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Instagram </label>
							<input type="text" class="form-control" id="instagram" name="instagram" placeholder="Instagram do Chef" value="<?php echo $instagram ?>">
						</div>
					</div>

				</div>


				<div class="row">
					<div class="col-6">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Youtube </label>
							<input type="text" class="form-control" id="youtube" name="youtube" placeholder="Youtube" value="<?php echo $youtube ?>">
						</div>
					</div>

					<div class="col-6">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Linkedin </label>
							<input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="Linkedin"  value="<?php echo $linkedin ?>">
						</div>
					</div>

				</div>


				<div class="form-group">
									<label >Imagem</label>
									<input type="file" value="<?php echo @$imagem ?>"  class="form-control-file" id="imagem-perfil" name="imagem-perfil" onChange="carregarImgPerfil();">
								</div>

								<div id="divImgContaPerfil" class="mt-4">								
										<img src="../img/chef/<?php echo @$imagem_perfil ?>"  width="170px" id="target-perfil">
									
								</div>
					

					<input type="hidden" name="id_perfil"  value="<?php echo $id_usuario ?>">
					<input type="hidden" name="id_perfil_func"  value="<?php echo $id_func_perfil ?>">

					
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



			<!--SCRIPT PARA CARREGAR IMAGEM -->
			<script type="text/javascript">

				function carregarImgPerfil() {

					var target = document.getElementById('target-perfil');
					var file = document.querySelector("#imagem-perfil").files[0];

					var arquivo = file['name'];
					resultado = arquivo.split(".", 2);
        //console.log(resultado[1]);

        if(resultado[1] === 'pdf'){
        	$('#target-perfil').attr('src', "../img/pdf.png");
        	return;
        }

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

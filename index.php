<?php 
require_once("conexao.php");
$senha = '123';
$senha_crip = md5($senha);

//Criar um usuário caso não tenha nenhum super adm sas
$query = $pdo->query("SELECT * FROM usuarios WHERE nivel = 'SAS'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg == 0){
  $pdo->query("INSERT into usuarios SET empresa = '0', nome = 'Administrador SAS', cpf = '000.000.000-00', email = 'admin@gmail.com', senha = '$senha', senha_crip = '$senha_crip', ativo = 'Sim', foto = 'sem-foto.jpg', nivel = 'SAS', data = curDate() ");
}



//Criar uma empresa de teste caso não tenha nenhuma
$query = $pdo->query("SELECT * FROM empresas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg == 0){
  $pdo->query("INSERT into empresas SET nome = 'Empresa Teste', email = 'teste@hotmail.com', telefone = '(00)00000-0000', ativo = 'Sim', data_cad = curDate() ");
  $id_empresa = $pdo->lastInsertId();
  
  $pdo->query("INSERT into usuarios SET empresa = '$id_empresa', nome = 'Administrador', cpf = '111.111.111-11', email = 'teste@hotmail.com', senha = '$senha', senha_crip = '$senha_crip', ativo = 'Sim', foto = 'sem-foto.jpg', nivel = 'Administrador', data = curDate() ");

}


?>
<!DOCTYPE html>
<html>
<head>
  <title>ViteSystem</title>  
<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

   <link rel="stylesheet" href="css/login.css">

   <link rel="icon" type="image/png" href="img/icone.png" />

</head>
<body>



  <div class="main">   

    <div class="container">
      <center>
     
           <div class="logo-mobile">            
              <img src="img/logo.png">           
              <br>
          </div>

        <div class="middle">

           
          <div id="login">

            <form action="autenticar.php" method="post">

              <fieldset class="clearfix">

                <p ><span class="fa fa-user"></span>
                  <input type="text" name="usuario"  Placeholder="Email ou CPF" required></p> <!-- JS because of IE support; better: placeholder="Username" -->
                <p><span class="fa fa-lock"></span>
                  <input type="password" name="senha"  Placeholder="Senha" required></p> <!-- JS because of IE support; better: placeholder="Password" -->

                <div>
                  <span style="width:48%; text-align:left;  display: inline-block;"><a class="" href="" data-toggle="modal" data-target="#exampleModal">Recuperar Senha</a></span>
                  <span style="width:50%; text-align:right;  display: inline-block;"><input type="submit" value="Login"></span>
                </div>

              </fieldset>
              <div class="clearfix"></div>
            </form>

            <div class="clearfix"></div>

          </div> <!-- end login -->
          <div class="logo">
            <span class="texto-logo">
              <img src="img/logo.png" width="350px">
            </span>
            <div class="clearfix"></div>
          </div>

        </div>
      </center>
    </div>

  </div>

</body>
</html>





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:350px">

       <button id="btn-fechar-rec" type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; right:10px; top:10px">
          <span aria-hidden="true" >&times;</span>
        </button>
     
      <form method="post" id="form-recuperar">
      <div class="modal-body"  style="width:300px">
        
          <input placeholder="Digite seu Email" class="form-control" type="email" name="email" id="email-recuperar" required>   
          <br>
          <button style="width:100%" type="submit" class="btn btn-primary">Recuperar</button>      
       
       <br>
       <small><div id="mensagem-recuperar" align="center"></div></small>
      </div>
      
  </form>
    </div>
  </div>
</div>





<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


 <script type="text/javascript">
  $("#form-recuperar").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: "recuperar-senha.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {
        $('#mensagem-recuperar').text('');
        $('#mensagem-recuperar').removeClass()
        if (mensagem.trim() == "Recuperado com Sucesso") {
          //$('#btn-fechar-rec').click();         
          $('#email-recuperar').val('');
          $('#mensagem-recuperar').addClass('text-success')
          $('#mensagem-recuperar').text('Sua Senha foi enviada para o Email')     

        } else {

          $('#mensagem-recuperar').addClass('text-danger')
          $('#mensagem-recuperar').text(mensagem)
        }


      },

      cache: false,
      contentType: false,
      processData: false,

    });

  });
</script>




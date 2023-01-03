<?php
require_once("../conexao.php");
$id_usuario   = @$_POST['empresa'];
$query        = $pdo->query("SELECT * FROM banners where empresa = '$id_usuario'  order by id asc");
$res          = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg    = @count($res);

if ($total_reg > 0) {
  for ($i = 0; $i < $total_reg; $i++) {
    $imagem   = $res[$i]["imagem"];
    $pedir    = $res[$i]["pedir"];
    $titulo   = $res[$i]["titulo"];
    $produto    = $res[$i]['prato'];

    $query2        = $pdo->query("SELECT * FROM pratos where empresa = '$id_usuario' and id = $produto");
    $res2       = $query2->fetch(PDO::FETCH_ASSOC);
    $categoria = $res2['categoria'];
    if ($i == 0) {
      echo '<div class="carousel-item active">';
      echo '<img class="d-block  mx-auto" style="width:100%; height:100%;  object-fit: scale-down;"  src="' . $url . 'saas/images/banners/' . $imagem . '" alt="' . $i . ' slide">' ;
      if ($pedir ==  'sim') {
        echo '<button class="btn btn-success btn-pedir pedir-anuncio" produto="'.$produto.'" categoria="'.$categoria.'">Pedir</button>';
      }
      echo '</div>';
    } else {
      echo '<div class="carousel-item">';
      echo '<img class="d-block  mx-auto" style="width:100%; height:100%;  object-fit: scale-down;"  src="' . $url . 'saas/images/banners/' . $imagem . '" alt="' . $i . ' slide">' ;
      if ($pedir == 'sim') {
        echo '<button class="btn btn-success btn-pedir pedir-anuncio" produto="'.$produto.'" categoria="'.$categoria.'">Pedir</button>';
      }
      echo '</div>';
      
    }
?>
<script>                    $(document).ready(function(){
                        $(".pedir-anuncio").click(function () {
                            console.log("teste");
                            var categoria = $(this).attr("categoria");
                            var produto = $(this).attr("produto");
                            $.ajax({
                                url: url_api + 'mesas/detalhe.php',
                                method: 'POST',
                                data: {
                                    produto: produto, categoria: categoria
                                },
                                dataType: "html",
    
                                success: function (result) {
    
                                    $("#detalhe").html(result);
                                    $("#modalDetalhe").fadeIn();
                                    $("#modalVibrar").fadeOut();
    
                                }
                            });
    
                        })
                    })</script>
  <?php }
} else {
  $result = json_encode(array('total de itens cadastrados = 0'));
  echo $result;
}

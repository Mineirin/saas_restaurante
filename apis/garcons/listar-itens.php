<?php
require_once("../config.php");
require_once('../conexao.php');
$postjson = $_POST;

$limite = 100;
$start = 0;
$nome_mesa = intVal($postjson['mesa']);
$id_pedido = intVal($postjson['pedido']);


$total_venda = 0;
$total_vendaF = 0;
$query_pedido = $pdo->query("SELECT * FROM pedidos WHERE id= '$id_pedido'");
$pedido = $query_pedido->fetch(PDO::FETCH_ASSOC);
$query_con = $pdo->query("SELECT * FROM itens_pedidos WHERE pedido = '$id_pedido' order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$visto = $pedido['visto'];
if($total_reg > 0){ ?>
<h3 class="text-center">Mesa <?php echo $nome_mesa; ?></h3>
<div class="mx-auto" style="height:150px;  overflow:scroll;  border:solid 1px #CCCCCC; background-color:aliceblue;">

<?php
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){	}

		$id_ped = $res[$i]['id'];
		$id_item = $res[$i]['item'];
		$tipo = $res[$i]['tipo'];
		$quantidade = $res[$i]['quantidade'];
		$valor = $res[$i]['valor'];
		$status = $res[$i]['status'];
		$valor_total_item = $res[$i]['total'];
		$valor_total_itemF =  number_format($valor_total_item, 2, ',', '.');

		$total_venda += $valor_total_item;
		$total_vendaF =  number_format($total_venda, 2, ',', '.');



if($tipo  == 'Produto'){
$query2 = $pdo->query("SELECT * FROM produtos where id = '$id_item'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$valor_produto = $res2[0]['valor_venda'];
$nome_produto = $res2[0]['nome'];
$foto_produto = $res2[0]['imagem'];
$pasta = 'produtos';
}else{
	$query2 = $pdo->query("SELECT * FROM pratos where id = '$id_item'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$valor_produto = $res2[0]['valor'];
$nome_produto = $res2[0]['nome'];
$foto_produto = $res2[0]['imagem'];
$pasta = 'pratos';
}



		

        
        $dados[] = array(
            'id' => $res[$i]['id'],
            'quantidade' => $quantidade,
            'valor_venda' => $valor_total_itemF,
            'status' => $status,
            'imagem' => $foto_produto, 
            'nome' => $nome_produto,
            'pasta' => $pasta,
                       

        );
?>

<div class="form-group">
        <div class="col-md-12">
<span style="font-size:16px;"><?php echo $quantidade; ?> x <?php echo @$nome_produto; ?><?php if(!$visto){ ?> <small><span style="color:green; font-weight:1000;">NOVO</span></small> <?php } ?></span><span style="float:right;">R$ <?php echo $valor_total_itemF; ?></span>
<small><span><?php echo $res[$i]['comentario']; ?></span></small> <span style="float:right"><a ref="javascript:;"  title="Remover" class="btn-remove deletecart"><i aria-hidden="true" class="fa fa-trash"></i></a></span>
        </div>
</div>
  <?php $visto = 1; ?>

   <?php } ?>
   <ul id="totais-pedido" class="totais-pedido font-default">
          <li class="flexBetCenter colorblack strong font-semibig">
    
          </li>
        </ul>
   </div>
   <?php if($pedido['subtotal']==0.00){ ?>


   
   <div class="mx-auto" style="margin-top:10px;">
      <label class="container-check">Pagar gorjeta?
        <input id="comissao" value="1" name="comissao" type="checkbox" checked="checked">
        <span class="checkmark"></span>
    </label>
  </div>
  <div class="form-group">
            <label for="rangeInput">Porcentagem de gorjeta: <span class="font-size: 22px; font-weight: bold" id="pctTxt">0</span></label>
            <input type="range" class="form-control-range" value="10" id="rangeInput1" min="0" max="100" step="5">
        </div>
      </div>

        <div class="pagamento-bar">
        <div class="pagamento-options" style="padding:0;">
          <a style="background-color: chartreuse;color: unset;justify-content: center;" onclick="fecharContaMesa()" id="buttonPix" class="bt-icon-light open-modalN2">Fechar conta</a>
        </div>
        <center>        
          <span id="valorDividido"></span><input type="text" name="pessoas" id="pessoas" size="4" style="margin-bottom:5px;justify-content: center;text-align: center; background-color:white;" class="qt filled"></center>
        <div class="pagamento-options" style="padding:0;">
          <a style="background-color: chartreuse;color: unset;justify-content: center;" onclick="dividirConta()" id="buttonPix" class="bt-icon-light open-modalN2">Dividir Conta</a>
          </div>
  
        </div>
        <ul id="valor_div" class="totais-pedido font-default">
          <li class="flexBetCenter colorblack strong font-semibig">
    
          </li>
        </ul>
        <?php }else{?>

       <?php if($pedido['pago']=="Não"){?>
        <h5 class="text-center"style="margin-top:20px; margin-bottom:20px;"> Conta fechada o cliente deve pagar:R$<?php echo $pedido['subtotal']; ?>  </h5>
        <button class="btn btn-success" onclick="pagar()" id="pago">PAGAR</button>

       <?php } ?>
<?php } ?>
   <script>

global_valor = <?php echo $total_venda; ?>;
var rangeInput = document.getElementById('rangeInput1');
                    rangeInput.addEventListener('input', (event) => {
                      $("#pctTxt").html(`${event.target.value}%`)
                      calcularTotalGarcom();
                    });
calcularTotalGarcom();
$("#rangeInput1").trigger("input");
   </script>
<?php
$pdo->prepare("UPDATE  pedidos set visto = 1  where id = ?")->execute([$id_pedido]);
} else {
    $result = json_encode(array('itens' => '0'));
    echo $result;
}

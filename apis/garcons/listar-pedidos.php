<?php
require_once("../config.php");
require_once('../conexao.php');
$postjson = $_POST;

$limite = 100;
$start = 0;
$mesa = @$postjson['mesa'];
$id_pedido = "";
$vibrar= 0;
if($mesa){
	$query = $pdo->query("SELECT * FROM pedidos where mesa = $mesa and pago = 'Não' order by id asc limit $start, $limite");
}else{
	$query = $pdo->query("SELECT * FROM pedidos where pago = 'Não'  order by id asc limit $start, $limite");
}


$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {?>
	<div class="row" style="justify-content: normal;">
		<?php
foreach($res as $pedido){
	$bebida = 0; 
	$produtos_query = $pdo->query("SELECT * FROM itens_pedidos where pedido = ".$pedido['id']);
	$produtos = $produtos_query->fetchAll(PDO::FETCH_ASSOC);
	$pago = $pedido['pago'];
	$visto = $pedido['visto'];
	foreach($produtos as $produto){
		
		if($produto['tipo']=="Bebida"){
			$bebida = 1;
	
		}
	}
	$mesa = $pedido['mesa'];
	$chamada_query = $pdo->query("SELECT * FROM chamadas_garcom where mesa = $mesa and visto = '0'");
	$chamada = $chamada_query->fetch(PDO::FETCH_ASSOC);	
	$aberto = 0;
	if($pedido['subtotal']==0.00){
		$class= "blue";
		$aberto = 1;
		$cor = "#4895FF";
	}else{
		$class="red";
		$cor = "#B3404A";
	}
	?>


      <div class="card1 text-center <?php echo $class; ?>" >
	 <span class="order" pedido="<?php echo $pedido['id'];?>" mesa="<?php echo $mesa; ?>">
        <h3 style="color:<?php echo $cor; ?>">Pedido da mesa <?php echo $mesa;?></h3>
       <?php if(!$visto){ ?>

		<p style="color:<?php echo $cor; ?>; font-weight:1000;">NOVO ITEM NO PEDIDO!</p>
	   </span>
	   <?php }else{ ?>
		<p style="color:<?php echo $cor; ?>; font-weight:1000;"></p>
	   <?php } ?>
	   <?php if($pago=="Sim"){ ?>

		<p style="color:<?php echo $cor; ?>;">PAGO</p>

		<?php }else{ ?>
	
	   <?php } ?>
		
			<?php if(!$aberto && $pago=="Não"){ ?>

				<p style="color:<?php echo $cor; ?>; font-weight:1000;">Conta fechada o cliente deve pagar R$ <?php echo $pedido['subtotal']; ?> </p>
			<?php } ?>

			<?php if($chamada){ ?>

				<button class="mensagem btn btn-success" mesa="<?php echo $chamada['mesa']; ?>" style="font-weight:1000;">Nova mensagem!</button>

			<?php } ?>

      </div>

	  
	 
<?php } ?>
    
</div>
<script>
$(".mensagem").click(function(){
	var mesa = $(this).attr("mesa");
	console.log("teste");
	$.ajax({
            url: url_api +'garcons/ver-mensagem.php',
                        method: 'POST',
                        data: {
                            mesa:mesa
                       },
                        success: function (result) {
							console.log(result);
							$("#mensagem").html(result);
							$("#modalMensagem").fadeIn();
                 }
        });
})
	$(".order").click(function(){
		var pedido  = $(this).attr("pedido")
		var mesa = $(this).attr("mesa")
		$("#id_pedido").val(pedido);
		$.ajax({
            url: url_api +'garcons/listar-itens.php',
                        method: 'POST',
                        data: {
                            pedido:pedido, mesa:mesa
                       },
                        success: function (result) {
							$("#pedido").html(result);
                        }
                    });
		$("#modalPedido").fadeIn();
	})



</script>
<?php }

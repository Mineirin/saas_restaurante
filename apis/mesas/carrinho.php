<?php
require_once("../conexao.php");
$mesa= @$_POST['mesa'];
$query = $pdo->query("SELECT * FROM carrinho where mesa = $mesa order by id desc");

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
    foreach($res as $item){ 
        $produto_id =$item['prato'];
        $query2 = $pdo->query("SELECT * FROM pratos where id = $produto_id ");

        $produto = $query2->fetch(PDO::FETCH_ASSOC);
        
        $nome = $produto['nome'];
        $id = $item['id'];
        $valor = $produto['valor'];
        ?>

<div class="form-group mx-auto" style="border-bottom:solid 1px #CCCCCC; height:80px; width:270px;">
      
<span style="margin:15px; padding:5px; margin-top:20px;"><img width="50" src="<?php echo $url; ?>saas/images/pratos/<?php echo $produto['imagem']; ?>"></span></span><span class="colorblack font-default strong"><?php echo $item['quantidade']; ?> x <?php echo @$nome; ?></span><span style="float:right"><a ref="javascript:;" onclick="removeCart(<?php echo $id; ?>);" title="Remover" class="btn-remove deletecart"><i aria-hidden="true" style="color:#CE0015;"class="fa fa-times"></i></a></span><br>

<span class="font-medium color-min"><?php echo $item['descricao']; ?></span>

<span class="preco font-default colorblack" style="float:right;">R$ <?php echo $valor*$item['quantidade']; ?> </span>
       
</div>
 



   <?php } ?>



<?php } ?>

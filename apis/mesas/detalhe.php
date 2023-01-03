<?php
require_once("../conexao.php");
$produto = @$_POST['produto'];
$categoria = $_POST['categoria'];

$query = $pdo->query("SELECT * FROM pratos where id = $produto");
  
$res = $query->fetch(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$categoria = $res['categoria'];
$query2 = $pdo->query("SELECT * FROM categorias where id = $categoria ");
$empresa = $res['empresa'];
$res2 = $query2->fetch(PDO::FETCH_ASSOC);
$categoria = $res2['nome'];

$query3 = $pdo->query("SELECT * FROM opcoes where empresa = $empresa ");
$bebida = 0;
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
if($total_reg > 0){?>
<br>
 <div class="row" style="background-color:#eee;">
    <div class="col-6" style="height:200px; top:50px;">
    <div class="form-group text-center">
        <div class="col-md-12" >
<img class="thumb" style="max-width:200px;" src="<?php echo $url.'saas/images/pratos/'.$res['imagem'] ?>">
        </div>

    </div>
    <div class="form-group text-center">
       
<span style="font-size:20px;"><?php echo @$res['nome']; ?></span>
       <div class="font-min color-min"><?php echo $res['descricao']; ?></div>
   </div>
</div>
<div class="col-6" >

    <div class="form-group" style="height:150px;">
        <div class="col-md-12">
            <?php if((strtolower($categoria)=="bebida") || (strtolower($categoria)=="bebidas")|| $categoria=="sucos"||  $categoria=="Sucos"|| $categoria=="suco" || strtolower($categoria)=="bebidas alcoolicas" || strtolower($categoria)=="bebidas alcoólicas"|| strtolower($categoria)=="bebidas alcoólica"|| strtolower($categoria)=="bebidas alcolica"|| strtolower($categoria)=="bebida alcoólica") { $bebida = 1;?>
          
                <div class="qty ">
    <label>Copos&nbsp;&nbsp;&nbsp;&nbsp;<i class="mdi mdi-cup"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <span class=" minus2">-</span>
                        <input type="number" class="count2" id="qty2" name="qty2" value="1">
                        <span class="plus2 ">+</span>
    </div>
                <?php foreach($res3 as $opcao){ ?>
                
                    <label class="container-check"><?php echo $opcao['nome']; ?>
                        <input id="<?php echo $opcao['nome']; ?>" value="<?php echo $opcao['nome']; ?>" name="option" type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                <?php } ?>

            <?php } else { ?>

                <div style="height:100px;"></div>

            <?php } ?>
    


    <div class="qty " style="margin-bottom:30px; margin-top:10px;">
    <label>Quantidade</label>
                        <span class="minus">-</span>
                        <input type="number" class="count" id="qty" name="qty" value="1">
                        <span class="plus">+</span>
    </div>

    <button id="addCart" class="btn btn-success primary">Adicionar</button>
  

<input type="hidden" id="prato" name="prato" value="<?php echo $res['id'];?>">
</div>
</div>
</div>
            </div>
<script>
        $("#addCart").click(function(){
            var comentario = $("#comentario").val();
            if(!comentario){
                comentario = '';
                $("input:checkbox[name=option]:checked").each(function(){
                        comentario += $(this).val()+"\n"; 
                             
            });
            <?php if($bebida){ ?>
                comentario += "Copos:"+$("#qty2").val();   
                
                
                <?php } ?>
        }
        var prato = $("#prato").val();
        var qtd = $("#qty").val();
        addToCart(prato,qtd,comentario)

    });

   

</script>
<?php } ?>

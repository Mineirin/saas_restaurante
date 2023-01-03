<?php
require_once("../config.php");
require_once('../conexao.php');
$postjson = $_POST;

$mesa = @$postjson['mesa'];
$id_pedido = "";
$vibrar= 0;
$azul = '';
if($mesa){
	$query = $pdo->query("SELECT * FROM chamadas_garcom where mesa = $mesa order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) { ?>
<h2 class="text-center">Mesa<?php echo $mesa; ?></h2>
<?php
	foreach($res as $mensagem){ 
		
	if($azul==1){
		$azul = 0;
		$classe = "message-orange";
	}else{
		$azul = 1; 
		$classe = "message-blue";
	}
		if(!$mensagem['info']){
			$msg = "um garçom";
		}else{
			$msg = $mensagem['info'];
		}
		
		?>

<div class="box sb1">Soliciou <?php echo $msg; ?></div>


	<?php 


}?>

<?php 
$pdo->prepare("UPDATE  chamadas_garcom set visto = '1'  where mesa = ?")->execute([$mesa]);

} ?>
<?php
require_once("../conexao.php");
$empresa  = $_POST["empresa"];
$query = $pdo->query("SELECT * FROM pratos where vibrar = '1' and empresa = $empresa and feito = '0'");

$prato = $query->fetch(PDO::FETCH_ASSOC);

if($prato){
        
  
        $dados = array(
                        "nome" => $prato['nome'],
                        "imagem" => $url.'/saas/images/pratos/'.$prato['imagem'],
                        "tempo" => $prato['tempo'],
                        "feito" => $prato['feito'],
                        "descricao" => $prato['descricao'],
                        "categoria" => $prato['categoria'],
                        "id" => $prato['id']
        );
        
   $result = json_encode($dados);
   echo $result;
   $pdo->prepare("UPDATE  pratos set feito = '1' where id = ".$prato['id'])->execute(); 
 } else{
        $pdo->prepare("UPDATE  pratos set feito = '0'")->execute(); 
        $query = $pdo->query("SELECT * FROM pratos where vibrar = '1' and empresa = $empresa and feito = '0'");

        $prato = $query->fetch(PDO::FETCH_ASSOC);
          
        $dados = array(
                "nome" => $prato['nome'],
                "imagem" => $url.'saas/images/pratos/'.$prato['imagem'],
                "tempo" => $prato['tempo'],
                "feito" => $prato['feito'],
                "descricao" => $prato['descricao'],
                "valor" => $prato['valor'],
                "categoria" => $prato['categoria'],
                "id" => $prato['id']
        );
     

        $result = json_encode($dados);
        echo $result;
        $pdo->prepare("UPDATE  pratos set feito = '1' where id = ".$prato['id'])->execute(); 
 }
 
 
 ?>


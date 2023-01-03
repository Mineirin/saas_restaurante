<?php
    require_once("../config.php");
    require_once('../conexao.php');
    $postjson = $_POST;
    $empresa    = @intVal($postjson['empresa']);
    $query      = $pdo->query("SELECT * FROM categorias where empresa = $empresa");
	$res        = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg  = @count($res);
	if($total_reg > 0){ 

        for($i=0; $i < $total_reg; $i++){
            foreach ($res[$i] as $key => $value){	}

            $dados[] = array(
                'id'        => $res[$i]['id'],
                'nome'      => $res[$i]['nome'],          
                'imagem'    => $url.'saas/images/categorias/'.$res[$i]['imagem']  ,         
            );
        }

        $result = json_encode(array('categorias'=>$dados));
        echo $result;

    }else{
        $result = json_encode(array('categorias'=>'0'));
        echo $result; 
    }

?>
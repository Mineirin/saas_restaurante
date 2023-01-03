<?php
    require_once("../config.php");
    require_once('../conexao.php');
    
    $postjson   = json_decode(file_get_contents('php://input'), true);
    $limite     = intVal($postjson['limit']);
    $start      = intVal($postjson['start']);
    $idEmpresa  = $postjson['empresa'];


    $busca = '%'.$postjson['nome'].'%';    
    $query = $pdo->query("SELECT * FROM pratos where nome LIKE '$busca' and pratos.empresa= '$idEmpresa' order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 

        for ($i = 0; $i < $total_reg; $i++) {
            foreach ($res[$i] as $key => $value) {
            }
    
            $id_cat = $res[$i]['categoria'];
            $query_2 = $pdo->query("SELECT * from categorias where id = '$id_cat' and categorias.empresa= '$idEmpresa'");
            $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
            $nome_cat = @$res_2[0]['nome'];
    
            $dados[] = array(
                'id'            => $res[$i]['id'],
                'nome'          => $res[$i]['nome'],
                'valor_venda'   => $res[$i]['valor'],
                'imagem'        => $res[$i]['imagem'],
                'descricao'     => $res[$i]['descricao'],
                'categoria'     => $res[$i]['categoria'],
            );
        }

        $result = json_encode(array('itens'=>$dados));
        echo $result;

    }else{
        $result = json_encode(array('itens'=>'0'));
        echo $result; 
    }
?>
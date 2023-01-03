<?php

     require_once("../../config.php");
     require_once('../../conexao.php');
    // require_once("config.php");
    // require_once('conexao.php');
    $postjson   = json_decode(file_get_contents('php://input'), true);
    $idEmpresa  = $postjson['empresa'];

    $where = "";
    if(@$postjson['idPrato']){
        $where .= " AND pratos.id =".$postjson['idPrato']."";
    }

    $query = $pdo->query("SELECT 
                                empresas.id, 
                                empresas.nome, 
                                pratos.id AS idPrato,
                                pratos.nome AS nomePrato,
                                pratos.descricao,
                                pratos.valor,
                                pratos.imagem, 
                                pratos.ativo,
                                pratos.vibrar,
                                pratos.tempo
                        FROM empresas
                        LEFT JOIN pratos ON (pratos.empresa = empresas.id)
                        WHERE empresas.id = '$idEmpresa' ".$where."");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if($total_reg > 0){ 

        for ($i = 0; $i < $total_reg; $i++) {
            foreach ($res[$i] as $key => $value) {
            }

            $dados[] = array(
                'id'        => $res[$i]['id'],
                'idPrato'   => $res[$i]['idPrato'],
                'nome'      => $res[$i]['nome'],
                'nomePrato' => $res[$i]['nomePrato'],
                'descricao' => $res[$i]['descricao'],
                'valor'     => $res[$i]['valor'],
                'imagem'    => $res[$i]['imagem'],
                'descricao' => $res[$i]['descricao'],
                'ativo'     => $res[$i]['ativo'],
                'vibrar'    => $res[$i]['vibrar'],
                'tempo'     => $res[$i]['tempo']
            );
        }

        $result = json_encode(array('itens'=>$dados));
        echo $result;

    }else{
        $result = json_encode(array('itens'=>'0'));
        echo $result; 
    }

?>
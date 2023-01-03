<?php
    require_once("../../config.php");
    require_once('../conexao.php');
    
    $postjson = json_decode(file_get_contents('php://input'), true);

    $limite     = intVal($postjson['limit']);
    $start      = intVal($postjson['start']);
    $idEmpresa  = $postjson['empresa'];

    $busca = '%'.$postjson['nome'].'%';
    $query = $pdo->query("SELECT * FROM produtos where nome LIKE '$busca' AND produtos.empresa= '$idEmpresa' and estoque > 0 order by id desc limit $start, $limite");
	$res   = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 

        for ($i = 0; $i < $total_reg; $i++) {
            foreach ($res[$i] as $key => $value) {
            }
    
            $id_cat     = $res[$i]['categoria'];
            $query_2    = $pdo->query("SELECT * from categorias where id = '$id_cat' AND categorias.empresa='$idEmpresa'");
            $res_2      = $query_2->fetchAll(PDO::FETCH_ASSOC);
            $nome_cat   = @$res_2[0]['nome'];
    
    
            //BUSCAR OS DADOS DO FORNECEDOR
            $id_forn    = $res[$i]['fornecedor'];
            $query_f    = $pdo->query("SELECT * from fornecedores where id = '$id_forn' AND fornecedores.empresa='$idEmpresa'");
            $res_f      = $query_f->fetchAll(PDO::FETCH_ASSOC);
            $total_reg_f = @count($res_f);
            if ($total_reg_f > 0) {
                $nome_forn = $res_f[0]['nome'];
                $tel_forn  = $res_f[0]['telefone'];
            }else{
                $nome_forn = "Sem Fornecedor";
                $tel_forn  = "Sem Telefone";
            }
    
            $dados[] = array(
                'id'        => $res[$i]['id'],
                'nome'      => $res[$i]['nome'],
                'estoque'   => $res[$i]['estoque'],
                'valor_compra' => $res[$i]['valor_compra'],
                'valor_venda' => $res[$i]['valor_venda'],
                'imagem'    => $res[$i]['imagem'],
                'descricao' => $res[$i]['descricao'],
                'nome_cat'  => $nome_cat,
                'nome_forn' => $nome_forn,
                'tel_forn'  => $tel_forn,
            );
        }

        $result = json_encode(array('itens'=>$dados));
        echo $result;

    }
    else{
        $result = json_encode(array('itens'=>'0'));
        echo $result; 
    }

?>
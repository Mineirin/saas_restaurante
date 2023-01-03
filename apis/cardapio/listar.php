<?php
require_once("../conexao.php");
$url_img = $_POST['url_img'];
$id_empresa = $_POST['id_empresa'];
$query = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
    for($i=0; $i<$total_reg; $i++){
        $nome = $res[$i]["nome"];
        $descricao = $res[$i]["descricao"];
        $descricao = $res[$i]["descricao"];
        $valor_venda = $res[$i]["valor_venda"];
        $imagem = $res[$i]["imagem"];

        echo'<li>';
            echo'<a href="#" class="item-link item-content">';
            echo'<div class="product-image">';

                echo'<img class="img-card" src="'.$url_img.'produtos/'.$imagem.'">';

            echo'</div>';
            echo'<div class="product-details">';

                echo'<h1 class="nome">'.$nome.'</h1>';
                echo'<span class="hint-star star">';
                echo'<i class="mdi mdi-star" aria-hidden="true"></i>';
                echo'<i class="mdi mdi-star" aria-hidden="true"></i>';
                echo'<i class="mdi mdi-star" aria-hidden="true"></i>';
                echo'<i class="mdi mdi-star" aria-hidden="true"></i>';
                echo'<i class="mdi mdi-star" aria-hidden="true"></i>';
                echo'</span>';

                echo'<p class="information">'.$descricao.'</p>';
                echo'<div class="control">';
                echo'<button class="btn">';
                    echo'<span class="price">R$'.$valor_venda.'</span>';
                    echo'<span class="buy sheet-open" href="#" data-sheet=".my-sheet1">ADICIONAR</span>';
                echo'</button>';
                echo'</div>';
            echo'</div>';
            echo'</a>';
        echo'</li>';
    }
}
?>
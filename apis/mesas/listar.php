<?php
require_once("../conexao.php");
$id_usuario = @$_POST['id_usuario'];
$query = $pdo->query("SELECT * FROM mesas order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
    for($i=0; $i<$total_reg; $i++){
        $nome = $res[$i]["nome"];
        $descricao = $res[$i]["descricao"];
        $id_empresa = $res[$i]["empresa"];
        $status = $res[$i]["status"];
        
        echo'<li>';
            echo'<a  href="/home/">';
                echo'<div class="col-15 card-home green" id="card-mesa">';

                    echo'<div class="row">';
                        echo'<div class="col-60 mesa-home" id="nome_mesa">Mesa '.$nome.'</div>';
                        echo'<div class="col-50">';
                            echo'<img class="image-home" src="img/disponivel.png" alt="money" />';
                        echo'</div>';
                    echo'</div>';
                echo'</div>';
            echo'</a>';
        echo'</li>';
    }
}
?>
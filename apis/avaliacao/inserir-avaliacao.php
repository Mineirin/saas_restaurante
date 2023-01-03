<?php

require_once('../conexao.php');

$postjson = $_POST;

$empresa = $postjson['empresa'];
$nome   = $postjson['nome'];
$sugestao = $postjson['sugestão'];
$aval_comida       = $postjson['aval_comida'];
$aval_bebida      = $postjson['aval_bebida'];
$aval_ambiente    = $postjson['aval_ambiente'];
$aval_atendimento = $postjson['aval_atendimento'];
$aval_musica = $postjson['aval_musica'];
$aval_estacionamento = $postjson['aval_estacionamento'];

$query = $pdo->prepare("INSERT INTO avaliacao SET nome = :nome, sugestao = :sugestao, aval_comida = :aval_comida, aval_bebida = :aval_bebida, empresa = :empresa,  aval_ambiente = :aval_ambiente, aval_atendimento = :aval_atendimento, aval_musica = :aval_musica, aval_estacionamento = :aval_estacionamento");
$query->bindValue(":nome", "$nome");
$query->bindValue(":sugestao", "$sugestao");
$query->bindValue(":aval_comida", "$aval_comida");
$query->bindValue(":aval_bebida", "$aval_bebida");
$query->bindValue(":aval_ambiente", "$aval_ambiente");
$query->bindValue(":aval_atendimento", "$aval_atendimento");
$query->bindValue(":aval_musica", "$aval_musica");
$query->bindValue(":aval_estacionamento", "$aval_estacionamento");
$query->bindValue(":empresa", "$empresa");
$query->execute();
$result = json_encode(array('mensagem' => 'Item Adicionado', 'ok' => true));


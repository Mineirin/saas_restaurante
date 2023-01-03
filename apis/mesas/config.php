<?php 

//VARIAVEIS DO PROJETO
$url = 'https://vitesystem.com/'; //caminho do projeto, url do dominio, sempre por a barra no final
$nome_site = 'VITESYSTEM';
$email_adm = 'admin@hotmail.com';
$endereco_site = 'Rua X, Número 50, Bairro Centro -São Paulo';
$telefone_fixo = '(33) 3333-3333';
$telefone_whatsapp = '(33) 93333-3333';
$telefone_whatsapp_link = '5511933333333';
$cnpj_site = '12.345.678/0001-08';

//VARIAVEIS PARA REDES SOCIAIS - Se você deixar algum campo vazio não será mostrado o ícone para aquela rede social no rodapé.
$instagram = '';
$facebook = '/';
$youtube = '';
$googleplus = '';
$twitter = 'https://www.google.com/';


//VARIAVEIS PARA O BANCO DE DADOS
//$servidor = 'localhost';
//$usuario = 'root';
//$senha = '';
//$banco = 'vite';



// //VARIAVEIS PARA O BANCO DE DADOS HOSPEDADO
$servidor = 'localhost';
$usuario = 'u940267718_vite';
$senha = 'Vite2022';
$banco = 'u940267718_vitesystem';

//VARIAVEIS GLOBAIS PARA CONFIGURAÇÕES DO SISTEMA
$nivel_estoque = 10;

$relatorio_pdf = 'Sim'; //Se você não quiser usar a biblioteca do dompdf para gerar os relatórios coloque não nessa opção que ele irá gerar um relatório html, este relatório você poderá salvá-lo também como pdf se necessário.

$rodape_relatorios = "Sistema Desenvolvido por Gustavo da Merc Digital!";

$comissao = 0.1; //0.1 define 10% de comissão para o garçon, caso o restaurante não vá trabalhar com comissão, pode deixar 0;

$couvert = 10;  //esse valor não está em porcentagem, se colocar 10 será adicionado ao total do pedido 10 reais, e assim por diante, caso não tenha essa taxa de couvert artístico colocar o valor de 0;


$itens_tela = 7;  //VARIAVEL PARA DEFINIR QUANTOS ITENS POR PÁGINA SERÃO MOSTRADO NO PAINEO DE TELA DA COZINHA
$tempo_atualizacao_tela = 15;  // A CADA 15 SEGUNDOS ELES VAI MUDAR A PAGINAÇÃO

$itens_tela_chamada = 12; //exibir os 12 ultimos pedidos nessa tela
$card_coluna = 4; //usando um valor de 4 vão ser mostrados 3 cards(pedidos) por cada linha, cada linha possui 12 colunas, se por exemplo desejar 4 cards na linha o valor ali inserido deverá ser 3.
$tempo_atualizacao_tela_chamadas = 5;  // QUANDO OUVER UM NOVO ITEM ELE VAI MOSTRAR ESSE NOVO ITEM POR 3 SEGUNDOS

$itens_por_pagina_blog = 3;

$maximo_imagens_galeria_index = 27; //Imagens da galeria na página index, o máximo de imagens nesse caso que poderá ser exibida lá é de 27 imagens, como são 3 por linha, o ideal é que seja um valor multiplo de 3.

$produtos_por_linha_index = 3; //total de colunas que serão mostrados os cards de produtos na index, se a descrição dos proutos forem muito grandes use apenas duas.
?>
<?php
$pag = 'anuncios';

use FontLib\Table\Type\name;

$tabela = 'banners';
require_once("../../../conexao.php");
$id_empresa = $_POST['id_empresa'];
$query_empresa = $pdo->query("SELECT * FROM empresas  where id = $id_empresa");
$empresa = $query_empresa->fetch(PDO::FETCH_ASSOC);
$empresa = $empresa['nome'];
$query = $pdo->query("SELECT * FROM $tabela  where empresa = $id_empresa");
$banners = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if (count($banners) > 0) { ?>
    <?php echo <<<HTML
        <small>
        <table class="table table-hover" id="tabela-anuncios">
        <thead> 
        <tr> 
        <th>Imagem</th>
        <th>titulo</th>
        <th>pedir</th>	
        <th></th>		
        <th>Ações</th>
        </tr>
        </thead>
        <tbody>

        HTML;
    ?>
    <?php foreach ($banners as $banner) {
        $id_banner = $banner['id'];
        $prato = $banner['prato'];
        $nome = $banner['titulo'];
        $banner['imagem'] = 'images/banners/' . $banner['imagem'];
        echo <<<HTML
        <tr>
        <td class="esc"><img src="{$banner['imagem']}"  width="80px" id="target"></td>
        <td>{$banner['titulo']}</td>
        <td>{$banner['pedir']}</td>
        <td></td>
        <td>
                <big><a href="#" onclick="editar('{$id_empresa}', '{$id_banner}','{$nome}','{$prato}')" title="Editar anuncio {$nome}"><i class="fa fa-edit text-primary"></i></a></big>
                <big><a href="#" onclick="excluir('{$id_banner}','{$id_empresa}','{$empresa}')" title="Excluir anuncio"><i class="fa fa-trash-o text-danger"></i></a></big>
        </td>
        
        </tr>
        HTML;
    } ?>

    </tbody>
    <small>
        <div align="center" id="mensagem-excluir"></div>
    </small>
    </table>
    </small>


<?php } else { ?>

    <h3 class="text-center">Esta empresa não possui anuncio cadastrado!</h3>

<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabela-anuncios').DataTable({
            "ordering": false,
            "stateSave": true
        });
    });
</script>
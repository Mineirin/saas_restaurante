<?php
require_once("../../../conexao.php");

$pag = 'anuncios';

use FontLib\Table\Type\name;

$tabela = 'banners';

$id_anuncio = $_POST['id_anuncio'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id_anuncio'");
$anuncio = $query->fetch(PDO::FETCH_ASSOC);
if ($anuncio) {
    if ($anuncio['imagem']) {
        $anuncio['imagem'] = 'images/banners/' . $anuncio['imagem'];
    } else {
        $anuncio['imagem'] = 'images/' . $anuncio['imagem'];
    }
}
?>

<div class="modal-body">


    <div class="row">
        <div class="col-md-12">
            <label>Titulo</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo" value="<?php echo @$anuncio['titulo']; ?>" required>
        </div>
        <br>
    </div>
    <br>
    <div class="col-md-6">
        <label>Banner</label>
        <input type="file" class="form-control" id="foto" name="foto" value="" onchange="carregarImg()" <?php if (!$anuncio) { ?> required<?php } ?>>
    </div>
    <div class="col-md-6">
            <label>Produto</label>

            <select class="form-control sel2" name="produto1" id="produto1" style="width:100%;" require>

            </select>
        </div>
        <br>
        <br>
        <br>
        <br>
    <div class="col-md-6">
        <label>Pedir</label>

        
            <input id="input-pedir" name="pedir" type="checkbox" <?php if (@$anuncio['pedir'] == "sim") { ?> checked<?php } ?> data-toggle="toggle" data-size="sm" data-on="sim" data-off="nao" data-onstyle="success" data-offstyle="danger">

        
    </div>
    <br>

    <div class="row text-center">
        <div class="col-md-12">
            <img src="<?php echo @$anuncio['imagem'] ?>" width="200px" id="target">

        </div>
    </div>
    <input type="hidden" name="id_empresa" id="id_empresa">
    <input type="hidden" name="id_anuncio" id="id_anuncio">


    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>

<script>
    $(document).ready(function() {
        $('.sel2').select2({
                dropdownParent: $('#modalForm')
            });
        $("#input-pedir").bootstrapToggle();
        $("#input-pedir").change(function() {

            if (document.getElementById('input-pedir').checked) {
                $("#input-pedir").val("sim");
            } else {
                $("#input-pedir").val("nao");
            }
          console.log($("#input-pedir").val());
        })

       

    });
</script>
</div>
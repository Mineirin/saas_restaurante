<?php
require_once("../../../conexao.php");

$pag = 'produtos';

use FontLib\Table\Type\name;

$tabela = 'pratos';

$id_prato = $_POST['id_prato'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id_prato'");
$prato = $query->fetch(PDO::FETCH_ASSOC);
if ($prato) {
    if ($prato['imagem']) {
        $prato['imagem'] = 'images/pratos/' . $prato['imagem'];
    } else {
        $prato['imagem'] = 'images/' . $prato['imagem'];
    }
}
?>

<div class="modal-body">


    <div class="row">
        <div class="col-md-12">
            <label>Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo @$prato['nome']; ?>" required>
        </div>

        <br>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Descrição </label>
            <textarea type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Prato" value="<?php echo @$prato['descricao']; ?>"><?php echo @$prato['descricao']; ?></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>Categoria</label>

            <select class="form-control sel2" name="categoria" id="categoria" style="width:100%;" require>

            </select>
        </div>
        <div class="col-md-6">
            <label>Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="Valor" required value="<?php echo @$prato['valor'] ?>">
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">
            <label>Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" value="" onchange="carregarImg()">
        </div>
        <div class="col-md-2">
            <label>Vibrar?</label>
            <br/>
                <input id="vibrar" name="vibrar" type="checkbox" <?php if (@$prato['vibrar'] == "sim") { ?> checked<?php } ?> data-toggle="toggle" data-size="sm" data-on="sim" data-off="não" data-onstyle="success" data-offstyle="danger">            
        </div>
        <div class="col-md-4" id="idDivTime" style='display:none;'>
            <label>Tempo</label>
                <br/>
                    <select name="tempo" aria-controls="tabela" class="form-control" id="idSlectTime" >
                        <option value="5">5 min</option>
                        <option value="10">10 min</option>
                        <option value="15">15 min</option>
                        <option value="20">20 min</option>
                    </select>
                
        </div>


        <input type="hidden" name="id_empresa" id="id_empresa">
        <input type="hidden" name="id_prato" id="id_prato">

        <br>
        <small>
            <div id="mensagem" align="center"></div>
        </small>
    </div>

    <div class="row">
        <div class="col-md-12">
            <img src="<?php echo @$prato['imagem'] ?>" width="80px" id="target">
        </div>
    </div>


    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
    <script>
        $(document).ready(function() {
            $('#vibrar').bootstrapToggle();
            $("#vibrar").change(function() {

                if (document.getElementById('vibrar').checked) {
                    $("#vibrar").val("sim");
                } else {
                    $("#vibrar").val("0");
                }


            });
            $("#vibrar").change();
            $('.sel2').select2({
                dropdownParent: $('#modalForm')
            });
        });

        $("#vibrar").change(function () { 
            $("#idDivTime").toggle();
        });

        
    </script>
<?php
require_once("../../../conexao.php");

$pag = 'categorias';

use FontLib\Table\Type\name;

$tabela = 'pratos';

$id_categoria = $_POST['id_categoria'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id_categoria'");
$categoria = $query->fetch(PDO::FETCH_ASSOC);

?>

    <div class="modal-body" id='idModal'>
        <div class="row">
            <div class="col-md-12">
                <label>Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo @$categoria['nome']; ?>" required>
            </div>
            <br>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Ativo</label>
                <select class="form-control" id="idAtivo" name="nmAtivo">
                    <option value="">-- Selecione uma opção -- </option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
            </div>    
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Foto</label>
                <input type="file" name="fImage1" id="idImg1" accept="image/*"  class="form-control">
                <img src="photo/camera.png" alt="selecione uma foto" id="imgFoto1" style="width:15%; heigth:15%;">
            </div>    
        </div>

        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>    
        </div>

        <input type="hidden" name="id_empresa" id="id_empresa">
        <input type="hidden" name="id_categoria" id="id_categoria">
        <input type="hidden" name="idAtivo" id="idAtivo" value="Não">

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onclick='fecharModal()'>Salvar</button>
        </div>
    </div>



<script type="text/javascript">
    let foto1 = document.getElementById('imgFoto1');
    let file1 = document.getElementById('idImg1');
	foto1.addEventListener('click',()=>{
        file1.click();
    })
    file1.addEventListener('change',(e)=>{
        if(file1.files.length <=0){
            return;    
        }
        let reader = new FileReader();
        reader.onload=()=>{
            foto1.src = reader.result;
        }
        reader.readAsDataURL(file1.files[0]);
    })
function fecharModal() { 
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Categoria salva com sucesso!',
        showConfirmButton: false,
        timer: 1500
    })

    setTimeout(() => {
        document.location.reload(true);
    }, 3000);
 }

</script>


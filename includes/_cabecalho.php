<?php
    $acesso = new cl_gestorBD();
    $img = $acesso->EXE_QUERY('SELECT img_header FROM tab_imagem');
?>
<div>
    <div class="row mt-3 mb-3 ml-1 mr-1">
        <!-- logotipo -->
        <div class="col-sm-6 p-0">
            <img class="img-fluid ml-0 p-0" src="<?php echo $img[0]['img_header']?>">
        </div>
        <!-- Direita -->
        <div class="col-sm-6 text-right"></div>
    </div>
    <?php if(funcoes::VerificarLogin()):?>
    <div class="row mt-2 mb-2 ml-1 mr-1">
        <div class="col p-0">
            <form class="p-0 m-0" action="?a=recebe_imagem&sender=header" method="post" enctype="multipart/form-data">
                <label class="p-0 m-0">
                    <strong><i class="fas fa-image mr-1 ml-1"></i>
                        <a data-toggle="collapse" href="#collapseInput" id="green" role="button" aria-expanded="false" aria-controls="collapseExample">Alterar imagem</a>
                        <label class="ml-1 file" id="grey">(320x100)</label>
                    </strong>
                </label>
                <div class="collapse" id="collapseInput">
                    <input class="btn btn-warning file p-0" name="arquivo" type="file" accept="image/*">
                    <input class="btn btn-success file m-0 p-1" type="submit" value="Enviar">
                </div>
            </form>
        </div>
    </div>
    <?php endif;?>
</div>
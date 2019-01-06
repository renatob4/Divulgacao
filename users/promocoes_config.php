<?php
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }

    //Instancias
    $acesso = new cl_gestorBD();
    $data = new DateTime();

    $erro = false;
    $mensagem = "";

    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');
    $code = $acesso->EXE_QUERY('SELECT * FROM tab_code');
    $promotion = $acesso->EXE_QUERY('SELECT * FROM tab_promotion');

    if($config[0]['st_promotion'] == 0){
        $mensagem = "As promoções estão desativadas nas configurações de conteúdo.";
        //$_SESSION['resultado'] = $mensagem;
        $erro = false;
    }elseif($code[0]['lnk_script'] == ''){
        $mensagem = "O código do plugin do facebook não esta definido. Verifique as configurações de conteúdo.";
        //$_SESSION['resultado'] = $mensagem;
        $erro = false;
    }elseif($code[0]['id_app'] == ''){
        $mensagem = "O id de aplicativo para integração com o facebook não está definido nas configurações de conteúdo.";
        //$_SESSION['resultado'] = $mensagem;
        $erro = false;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $type_disc = $_POST['type-disc'];
        $ds_disc = $_POST['ds_disc'];
        $qt_val = $_POST['qt_val'];

        $data_att = new DateTime();

        $parametros = [
            ':cd_promotion'     => $promotion[0]['cd_promotion'],
            ':ds_type'          => $type_disc,
            ':ds_discount'      => $ds_disc,
            ':qt_days'          => $qt_val,
            ':dt_updated'       => $data_att->format('Y-m-d H:i:s')
        ];
        $acesso->EXE_NON_QUERY(
            'UPDATE tab_promotion SET
             ds_type = :ds_type,
             ds_discount = :ds_discount,
             qt_days = :qt_days,
             dt_updated = :dt_updated 
             WHERE cd_promotion = :cd_promotion    
            ', $parametros);

        $_SESSION['resultado'] = "Configurações atualizadas com sucesso!";
        echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes_config">');
        exit();
    }
?>
<div class="row mr-1 ml-1 mt-2">
    <div class="col m-0 p-0">
        <div class="card p-2 m-0 shadow-strong borda-painel">
            <?php if(!$erro):?>
            <h5 id="green" class="text-center mt-3 mb-2">CONFIGURAÇÃO DE PROMOÇÕES</h5>
            <div class="card shadow mt-1 p-2">
                <form class="mt-0 pt-0 p-3 line" method="post" action="">
                <h6 id="green" class="text-LEFT mt-1 mb-2"><b>CUPONS</b></h6><hr>
                    <div class="form-row mt-1">
                        <div class="col-md-3 mt-1">
                            <label><b><i id="grey" class=""></i>Tipo do desconto:</b></label>
                            <select id="type" class="form-control" name="type-disc" required>
                                <optgroup label="Tipo">
                                    <option value="pc" <?php echo $promotion[0]['ds_type'] == 'pc' ? 'selected' : '';?>>Porcentagem</option>
                                    <option value="vl" <?php echo $promotion[0]['ds_type'] == 'vl' ? 'selected' : '';?>>Valor Fixo</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <label><b>Desconto:<label id="tag" class="m-0 p-0 ml-2"><?php echo $promotion[0]['ds_type'] == "pc" ? "%":"R$";?></label></b></label>
                            <input id="desc" type="number" name="ds_disc" class="form-control" value="<?php echo $promotion[0]['ds_discount'];?>" required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <label><b><i id="grey" class=""></i>Validade:</b><label class="Obs3 ml-2 m-0 p-0">(QUANTIDADE DE DIAS)</label></label>
                            <input id="val" type="number" name="qt_val" min="1" max="30" value="<?php echo $promotion[0]['qt_days'];?>" class="form-control" required>
                        </div>
                        <div class="col-md-3 mt-1 pt-1 text-center">
                            <button type="submit" class="btn btn-success shadow text-center pt-3 pb-3 mt-2">Aplicar Configurações<i class="fas fa-edit ml-2"></i></button>
                        </div>
                    </div>
                    <label class="Obs3 mt-2">Validos para os proximos cupons gerados a partir da aplicação das configurações</label>
                </form>
            </div>
            <?php else:?>
            <div class="alert alert-danger mt-3 text-center">
                <?php echo $mensagem ?>
            </div>
            <?php endif;?>
            <!-- Verifica se o script cadastro_produtos retornou resultado. -->
            <?php if(isset($_SESSION['resultado'])):?>
            <!-- Se o resultado guardado na variavel de sessao reg-product tiver um final "!", ou seja, um codigo de sucesso, então a classe do alerta será success -->
            <div id="resultado" class="<?php echo (substr($_SESSION['resultado'], -1) == '!') ? 'alert alert-success text-center mt-3 mb-2 pt-4 pb-4' : 'alert alert-danger text-center mt-3 mb-2 pt-4 pb-4';?>"><?php echo $_SESSION['resultado']?></div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php
    //Reinicia a variavel de resposta.
    if(isset($_SESSION['resultado'])){
        unset($_SESSION['resultado']);
    }
?>
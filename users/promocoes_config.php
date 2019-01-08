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
    $cupons = $acesso->EXE_QUERY('SELECT * FROM tab_cupom');

    if($config[0]['st_promotion'] == 0){
        $mensagem = "As promoções estão desativadas nas configurações de conteúdo.";
        //$_SESSION['resultado'] = $mensagem;
        $erro = true;
    }elseif($code[0]['lnk_script'] == ''){
        $mensagem = "O código do plugin do facebook não esta definido. Verifique as configurações de conteúdo.";
        //$_SESSION['resultado'] = $mensagem;
        $erro = true;
    }elseif($code[0]['id_app'] == ''){
        $mensagem = "O id de aplicativo para integração com o facebook não está definido nas configurações de conteúdo.";
        //$_SESSION['resultado'] = $mensagem;
        $erro = true;
    }

    //Verifica se foi definida clear
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
    }

    //carregar os dados dos cupons
    $cupons = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if (isset($_GET['src']) && $_GET['src'] == true) {
            //Pesquisa dos cupons
            if ($_POST['text_pesquisa'] != '') {
                $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
            }
            if (isset($_SESSION['texto_pesquisa'])) {
                $parametros = ['pesquisa'   =>  '%'.$_SESSION['texto_pesquisa'].'%'];
                $cupons = $acesso->EXE_QUERY('SELECT * FROM tab_cupom WHERE cd_cupom LIKE :pesquisa OR nm_customer LIKE :pesquisa ORDER BY nm_customer', $parametros);
            }
        }
        if (isset($_GET['cfg']) && $_GET['cfg'] == true) {
            //Configuração das promoções.
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
            ',$parametros);

            $_SESSION['resultado'] = "Configurações atualizadas com sucesso!";
            echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes_config">');
            exit();
        }
    }
?>
<div class="row mr-1 ml-1 mt-2">
    <div class="col m-0 p-0">
        <div class="card p-2 m-0 shadow-strong borda-painel">
            <?php if(!$erro):?>
            <h5 id="black" class="text-center mt-3 mb-2">CONFIGURAÇÃO DE PROMOÇÕES</h5>
            <div class="card shadow mt-1 p-2">
                <h6 id="green" class="text-left ml-3 mt-3 mb-3"><b>CONFERIR CUPONS</b></h6><hr class="mt-1">
                <div class="pt-0 table-padding m-0 mb-2">
                    <div class="text-center"><label id="grey" class="Obs3 mb-2">Ao encontrar um cupom válido e <b>dar o desconto ao cliente</b>, clique no botão <b>conceder</b> da ultima coluna da tabela para que o registro seja <b>removido do sistema.</b></label></div>
                    <nav class="navbar navbar-light line shadow borda-b">
                        <h6 id="black" class="mt-2 mb-2 m-0">PESQUISE POR UM CUPOM:</h6>
                        <form class="p-0 m-0" action="?a=promocoes_config&src=true" method="post">
                            <div class="form-inline">
                            <input type="search" class="form-control borda-text shadow" name="text_pesquisa" placeholder="Pesquisar" value="<?php echo (isset($_SESSION['texto_pesquisa'])) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                            <button class="btn btn-primary text-center mt-2 mb-2 ml-3 shadow"><i class="fa fa-search" aria-hodden="true"></i></button>
                            <a href="?a=promocoes_config&clear=true" class="btn btn-danger text-center ml-2 shadow"><i class="fa fa-times" aria-hodden="true"></i></a>
                            </div>
                        </form>
                    </nav>
                    <!--Inicio da tabela-->
                    <div class="table-responsive ml-0 mr-0 shadow mb-2 borda-b">
                        <table class="table table-striped table-bordered table-hover borda mb-0">
                            <!--Corpo/Dados da tabela-->
                                <?php if($cupons == null):?>
                                    <td class="text-center">Pesquise por um código de cupom ou pelo nome do cliente para verificar se existe cupom de desconto válido.</td>
                                <?php else:?>
                                    <!--Cabeçalho da tabela-->
                                    <thead class="thead-dark">
                                        <th>Cupom</th>
                                        <th class="text-center">Status</th>
                                        <th>Desconto</th>
                                        <th>Cliente</th>
                                        <th>Gerado</th>
                                        <th class="text-center">Ação</th>
                                    </thead>
                                    <?php foreach ($cupons as $cupom) : ?>
                                    <tr>
                                        <td><b><?php echo $cupom['cd_cupom']?></b></a></td>
                                        <td class="text-center"><b><?php echo (strtotime($cupom['dt_valid']) < strtotime($data->format('Y/m/d')) ) ? '<label id="red">Vencido</label>' : '<label id="green">Válido</label>';?></b></td>
                                        <td><?php echo $cupom['ds_type'] == 'pc' ? $cupom['ds_discount'].'%' : 'R$'.$cupom['ds_discount'];?></td>
                                        <td><?php echo $cupom['nm_customer']?></td>
                                        <td><?php echo $cupom['dt_register']?></td>
                                        <td class="text-center p-0"><a href="?a=conceder_cupom&cupom=<?php echo $cupom['cd_cpm']; ?>" class="btn btn-primary text-center p-1 mt-2">Conceder</a></td>   
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif;?>       
                        </table>
                    </div>
                </div>
                <form class="mt-0 pt-0 p-3 line" method="post" action="?a=promocoes_config&cfg=true">
                    <h6 id="green" class="text-left mt-1 mb-1"><b>CONFIGURAR CUPONS</b></h6><hr>
                    <div class="form-row mt-1">
                        <div class="col-md-3 mt-1">
                            <label><b><i id="grey" class=""></i>Tipo do desconto:</b></label>
                            <select id="type" class="form-control" name="type-disc" required>
                                <optgroup label="Tipo">
                                    <option value="pc" <?php echo $promotion[0]['ds_type'] == 'pc' ? 'selected' : '';?>>Porcentagem (Recomendado)</option>
                                    <option value="vl" <?php echo $promotion[0]['ds_type'] == 'vl' ? 'selected' : '';?>>Valor Fixo</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <label><b>Valor do desconto:<label id="tag" class="m-0 p-0 ml-2"><?php echo $promotion[0]['ds_type'] == "pc" ? "%":"R$";?></label></b></label>
                            <input id="desc" type="number" name="ds_disc" class="form-control" value="<?php echo $promotion[0]['ds_discount'];?>" required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <label><b><i id="grey" class=""></i>Validade:</b><label class="Obs3 ml-2 m-0 p-0">(EM QUANTIDADE DE DIAS)</label></label>
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
    if(isset($_SESSION['texto_pesquisa'])){
        unset($_SESSION['texto_pesquisa']);
    }
?>
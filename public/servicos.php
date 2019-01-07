<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');

    if($config[0]['st_service'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    //Verifica se foi definida clear
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
        if(isset($_SESSION['cfg_rel_service'])){
            unset($_SESSION['cfg_rel_service']);
        }
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['texto_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['texto_pesquisa'];
        }
        // Transforma o valor da relevancia setado no select em uma session
        $_SESSION['cfg_rel_service'] = $_POST['cfg_rel'];
    }

    $servicos = null;
    //paginação
    $total_servicos = 0;
    $pagina = 1;

    if(isset($_GET['p'])){
        $pagina = $_GET['p'];
    }

    $itens_por_pagina = $config[0]['ss_amount'];
    $item_inicial = ($pagina * $itens_por_pagina) - $itens_por_pagina;

    //Itens de filtro de pesquisa select de relevancia
    if(isset($_SESSION['cfg_rel_service'])){
        $relevance = $_SESSION['cfg_rel_service'];
    }else{
        $relevance = $config[0]['ss_relevance'];
    }

    //busca o conteúdo da pagina no banco de dados.
    if (isset($_SESSION['texto_pesquisa'])){

        //Pesquisa com filtro
        $parametros = ['pesquisa'   =>  '%'.$_SESSION['texto_pesquisa'].'%' ];
        $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service WHERE nm_service LIKE :pesquisa OR ds_description LIKE :pesquisa OR cd_alternative_service LIKE :pesquisa ORDER BY nm_service ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
        //Contagem dos produtos na tabela.
        $total_servicos = count($acesso->EXE_QUERY('SELECT * FROM tab_service WHERE nm_service LIKE :pesquisa OR ds_description LIKE :pesquisa ORDER BY nm_service ASC', $parametros));

    } else {

        //Defini o tipo de lista de produtos que sera exibida
        switch ($relevance) {
            case 1:
                $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service ORDER By vl_service ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                $total_servicos = count($servicos);
                    break;
            case 2:
                $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service ORDER By vl_service DESC LIMIT '.$item_inicial.','.$itens_por_pagina);
                $total_servicos = count($servicos);
                    break;
            case 3:
                $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service ORDER By dt_register DESC LIMIT '.$item_inicial.','.$itens_por_pagina);
                $total_servicos = count($servicos);
                    break;
            case 4:
                $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service ORDER By dt_register ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                $total_servicos = count($servicos);
                    break;
            case 5:
                $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service WHERE st_promotion = 1 ORDER By vl_service ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                $total_servicos = count($servicos);
                    break;
        }
    }
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA SERVIÇOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <!-- Controles de pesquisa -->
            <div class="card line shadow borda-b pb-3 pt-2">
                <form class="p-0 m-0" action="?a=servicos" method="POST">
                    <div class="form-row">
                        <div class="col-md-2 p-1 pr-2 pl-2">
                            <div class="form-inline text-center ml-4 mt-2"><h5>Serviços: <label id="grey"><?php echo $total_servicos; ?> <?php echo $total_servicos > 1 ? 'Serviços' : 'Serviço'; ?></label></h5></div>
                        </div>
                        <div class="col-md-3 p-1 pr-2 pl-2">
                        </div>
                        <div class="col-md-3 p-1 pr-2 pl-2">
                            <label id="black" class="Obs3 mb-1 ml-1">Por relevancia:</b></label>
                            <select class="form-control mb-1 shadow" name="cfg_rel" required>
                                <optgroup label="Relevancia">
                                <?php if(isset($_SESSION['cfg_rel_service'])):?>
                                    <option value=1 <?php echo $_SESSION['cfg_rel_service'] == 1 ? 'selected' : '';?>>Preço crescente</option>
                                    <option value=2 <?php echo $_SESSION['cfg_rel_service'] == 2 ? 'selected' : '';?>>Preço decrescente</option>
                                    <option value=3 <?php echo $_SESSION['cfg_rel_service'] == 3 ? 'selected' : '';?>>Novidades</option>
                                    <option value=4 <?php echo $_SESSION['cfg_rel_service'] == 4 ? 'selected' : '';?>>Antigos na loja</option>
                                    <option value=5 <?php echo $_SESSION['cfg_rel_service'] == 5 ? 'selected' : '';?>>Em Promoção</option>
                                <?php else:?>
                                    <option value=1 <?php echo $config[0]['ss_relevance'] == 1 ? 'selected' : '';?>>Preço crescente</option>
                                    <option value=2 <?php echo $config[0]['ss_relevance'] == 2 ? 'selected' : '';?>>Preço decrescente</option>
                                    <option value=3 <?php echo $config[0]['ss_relevance'] == 3 ? 'selected' : '';?>>Novidades</option>
                                    <option value=4 <?php echo $config[0]['ss_relevance'] == 4 ? 'selected' : '';?>>Antigos na loja</option>
                                    <option value=5 <?php echo $config[0]['ss_relevance'] == 5 ? 'selected' : '';?>>Em Promoção</option>
                                <?php endif;?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-4 p-1 pr-2 pl-2">
                            <label id="black" class="Obs3 mb-1 ml-1">Por uma palavra chave:</b></label>
                            <div class="form-inline">
                                <input type="search" class="form-control shadow mb-1" name="texto_pesquisa" placeholder="Pesquisar" value="<?php echo (isset($_SESSION['texto_pesquisa'])) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                                <button class="btn btn-primary pr-3 pl-3 p-2 mb-1 ml-3 mr-2 shadow"><i class="fa fa-search"></i></button>
                                <a href="?a=servicos&clear=true" class="btn btn-secondary pr-3 pl-3 p-2 mb-1 shadow"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Verifica se o script produto_inserir retornou resultado. -->
            <?php if(isset($_SESSION['resultado'])):?>
                <!-- Se o resultado guardado na variavel de sessao reg-product tiver um final "!", ou seja, um codigo de sucesso, então a classe do alerta será success -->
                <div id="resultado" class="<?php echo (substr($_SESSION['resultado'], -1) == '!') ? 'alert alert-success text-center mt-2 mb-1 pt-4 pb-4' : 'alert alert-danger text-center mt-2 mb-1 pt-4 pb-4';?>"><?php echo $_SESSION['resultado']?></div>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <h5 id="green" class="text-center mt-2 mb-3">NOSSOS SERVIÇOS</h5><hr class="mb-1 mt-1">
            <?php if(count($servicos) == 0):?>
                <div class="text-center mt-1"><p>Nenhum serviço disponível no momento.</p></div>
            <?php endif;?>
            <?php foreach ($servicos as $servico) : ?>
            <!-- Card do produto -->
            <div class="<?php echo $servico['st_promotion'] == 1 ? 'card borda-produto-p mb-3' : 'card borda-produto mb-3';?>">
                <div class="row m-0">
                    <div class="col-md-9 m-0">
                        <div class="row p-0">
                            <div class="col-md-2 p-2 prbdiv prrdiv-non text-center">
                                <label class="service-img text-center m-0"><i id="grey" class="fas fa-wrench mr-1"></i></label>
                            </div>
                            <div class="col-md-10 prbdiv text-left">
                                <h5><label id="blue" class="mr-2 mt-3"><i class="fas fa-barcode mr-1"></i><?php echo $servico['cd_alternative_service'];?></label><?php echo $servico['nm_service'];?></h5>
                                <?php if($servico['st_promotion'] == 1):?>
                                <i id="gold" class="fas fa-star mr-2 star-s"></i>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="row p-3">
                            <p class="mb-1" id="black"><?php echo nl2br($servico['ds_description']);?></p>
                        </div>
                    </div>
                    <div class="col-md-3 card p-2 min-hgt text-center">
                        <label id="black" class="Obs3 price mr-1 mb-0"><strong>R$ <?php echo number_format($servico['vl_service'],2, ',', '.');?></strong></label>
                        <a href="?a=contatos" class="btn btn-primary mt-2 ml-2 mr-2 p-3">Interessado?</a>
                        <label class="Obs3 mt-2">Fale conosco para contratar.</label>
                        <?php if($servico['st_promotion'] == 1):?>
                        <p id="green" class="pmtn m-0 p-0"><b>Promoção!</b></p>
                        <?php endif;?>  
                        <?php if(funcoes::VerificarLogin()):?>
                        <hr class="mb-2 mt-2">
                        <div class="card line text-center mt-2 brt">
                            <div class="row p-0 m-0">
                                <div class="col text-center">
                                    <div class="mt-2 mb-2">
                                        <a id="black" href="?a=servico_editar&s=<?php echo $servico['cd_service'];?>" class="mr-2"><i id="grey" class="fas fa-edit mr-1"></i><b>Editar</b></a>|<a id="black" href="?a=servico_deletar&s=<?php echo $servico['cd_service'];?>" class="ml-2"><i id="grey" class="fas fa-trash mr-1"></i><b>Apagar</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <div class="row mt-0 mb-1 mr-3 ml-3">
                <!--Pagina Atual-->
                <div class="col-sm-6 text-left">
                    <label style="opacity: 0.5"><?php echo 'Pagina: ' . $pagina ?></label>
                </div>
                <!--Mecanismo de paginação-->
                <div class="col-sm-6 text-right">
                    <?php funcoes::Paginacao('?a=produtos', $pagina, $itens_por_pagina, $total_servicos) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(funcoes::VerificarLogin()):?>
<div class="row shadow-strong mt-4 ml-1 mr-1">
    <div class="col p-0">
        <div class="card painel-direito p-0 pl-3 pr-3">
            <h5 id="white" class="mt-3">CADASTRO DE NOVO SERVIÇO</h5><hr class="mb-1 mt-1">
            <form action="?a=servico_inserir" method="POST">
                <div class="text-left">
                    <div class="form-row mt-2">
                        <div class="col">
                            <label id="black"><b><i id="black" class="fas fa-barcode mr-2"></i>Código:</b></label>
                            <input type="text" name="cd_service" class="form-control shadow" title="Defina um código para o serviço" required>
                        </div>
                        <div class="col">
                            <label id="black"><b>Serviço:</b></label>
                            <input type="text" name="nm_service" class="form-control shadow" required>
                        </div>
                        <div class="col">
                            <label id="black"><i id="black" class="fas fa-money-bill-alt ml-1 mr-2"></i><b>Preço/Valor:</b></label>
                            <div class="input-group">
                            <div class="input-group-prepend ml-1"><div class="input-group-text shadow"><strong>R$</strong></div></div>
                            <input type="number"  pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name="vl_service" class="form-control shadow" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-goup mt-3">
                        <label id="black"><i id="black" class="fas fa-info-circle mr-2"></i><b>Descrição:</b></label>
                        <textarea type="text" name="ds_desc_service" class="form-control shadow" rows="7" title="Informações do serviço" required></textarea>
                    </div>
                    <div class="form-row mt-3 p-0">
                        <div class="col">
                            <div class="form-inline">
                                <label id="black" class="Obs3 ml-1 mr-3"><b>Este serviço esta em promoção?</b></label>
                                <label id="black" class="radio-inline mr-3"><input type="radio" name="pmtsradio" value=1>Sim</label>
                                <label id="black" class="radio-inline"><input type="radio" name="pmtsradio" value=0 checked>Não</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-right">
                                <button class="btn btn-success shadow mb-3">Inserir Serviço</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row shadow-strong mt-4 ml-1 mr-1">
    <div class="col p-0">
        <div class="card painel-direito p-0 pl-3 pr-3">
            <h5 id="white" class="mt-3">CONFIGURAÇÕES DE EXIBIÇÃO</h5><hr class="mb-1 mt-1">
            <form action="?a=update_config&sender=services" method="POST">
                <div class="text-left">
                    <div class="form-row p-0 mt-2">
                        <div class="col-sm-6 mb-2">
                            <label id="black">Exibir lista de serviços na página por:</label>
                            <select class="form-control shadow" name="cfg_rel_service" required>
                                <optgroup label="Relevancia">
                                    <option value=1 <?php echo $config[0]['ss_relevance'] == 1 ? 'selected' : '';?>>1 - Preço crescente</option>
                                    <option value=2 <?php echo $config[0]['ss_relevance'] == 2 ? 'selected' : '';?>>2 - Preço decrescente</option>
                                    <option value=3 <?php echo $config[0]['ss_relevance'] == 3 ? 'selected' : '';?>>3 - Ultimos a serem adicionados</option>
                                    <option value=4 <?php echo $config[0]['ss_relevance'] == 4 ? 'selected' : '';?>>4 - Primeiros a serem adicionados</option>
                                    <option value=5 <?php echo $config[0]['ss_relevance'] == 5 ? 'selected' : '';?>>5 - Apenas em promoção</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-6 mb-1">
                            <label id="black">Quantidade de itens por página:</label>
                            <select class="form-control shadow" name="cfg_amount_service" required>
                                <optgroup label="Quantidade">
                                    <option value=5 <?php echo $config[0]['ss_amount'] == 5 ? 'selected' : '';?>>5</option>
                                    <option value=10 <?php echo $config[0]['ss_amount'] == 10 ? 'selected' : '';?>>10</option>
                                    <option value=15 <?php echo $config[0]['ss_amount'] == 15 ? 'selected' : '';?>>15</option>
                                    <option value=20 <?php echo $config[0]['ss_amount'] == 20 ? 'selected' : '';?>>20</option>
                                    <option value=25 <?php echo $config[0]['ss_amount'] == 25 ? 'selected' : '';?>>25</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2">
                    <button class="btn btn-success shadow mb-3">Atualizar</button>
                </div>        
            </form>
        </div>
    </div>
</div>
<?php endif;?>
<?php
    //Reinicia a variavel de resposta.
    if(isset($_SESSION['resultado'])){
        unset($_SESSION['resultado']);
    }
    if(isset($_SESSION['texto_pesquisa'])){
        unset($_SESSION['texto_pesquisa']);
    }
?>
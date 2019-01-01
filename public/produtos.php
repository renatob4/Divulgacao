<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //$data = new DateTime();
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');

    if($config[0]['st_product'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    //Verifica se foi definida clear
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
        if(isset($_SESSION['cfg_relevance'])){
            unset($_SESSION['cfg_relevance']);
        }
        if(isset($_SESSION['cfg_category'])){
            unset($_SESSION['cfg_category']);
        }
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['text_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
        }
        // Transforma o valor da relevancia setado no select em uma session
        $_SESSION['cfg_relevance'] = $_POST['cfg_relevance'];
        // Transforma o valor da categoria setado no select em uma session
        $_SESSION['cfg_category'] = $_POST['cfg_category'];
    }

    $produtos = null;
    //paginação
    $total_produtos = 0;
    $pagina = 1;

    if(isset($_GET['p'])){
        $pagina = $_GET['p'];
    }

    $itens_por_pagina = $config[0]['sp_amount'];
    $item_inicial = ($pagina * $itens_por_pagina) - $itens_por_pagina;

    //Itens de filtro de pesquisa select de relevancia
    if(isset($_SESSION['cfg_relevance'])){
        $relevance = $_SESSION['cfg_relevance'];
    }else{
        $relevance = $config[0]['sp_relevance'];
    }

    //Itens de filtro de pesquisa select de categoria
    if(isset($_SESSION['cfg_category'])){
        $category = $_SESSION['cfg_category'];
    }else {
        $category = "Geral";
    }
    
    //busca o conteúdo da pagina no banco de dados.
    if (isset($_SESSION['texto_pesquisa'])){

        //Pesquisa com filtro
        $parametros = ['pesquisa'   =>  '%'.$_SESSION['texto_pesquisa'].'%' ];
        $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE nm_product LIKE :pesquisa OR ds_description LIKE :pesquisa OR cd_alternative_product LIKE :pesquisa ORDER BY nm_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
        //Contagem dos produtos na tabela.
        $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product WHERE nm_product LIKE :pesquisa OR ds_description LIKE :pesquisa ORDER BY nm_product ASC', $parametros));
    
    } else {

        //Pesquisa sem filtro
        $parametros = [':ds_category'   =>  $category ];
        //Defini o tipo de lista de produtos que sera exibida
        switch ($relevance) {
            case 1:
                if ($category == "Geral") {
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By vl_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                    $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product'));;
                } else {
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE ds_category = :ds_category ORDER By vl_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
                    $total_produtos = count($produtos);
                }
                    break;
            case 2:
                if($category == "Geral"){
                   $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By vl_product DESC LIMIT '.$item_inicial.','.$itens_por_pagina);
                   $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product'));;
                } else {
                   $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE ds_category = :ds_category ORDER By vl_product DESC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
                   $total_produtos = count($produtos);
                }
                    break;
            case 3:
                if($category == "Geral"){
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By dt_register DESC LIMIT '.$item_inicial.','.$itens_por_pagina);
                    $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product'));;
                } else {
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE ds_category = :ds_category ORDER By dt_register DESC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
                    $total_produtos = count($produtos); 
                }
                    break;
            case 4:
                if($category == "Geral"){
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By dt_register ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                    $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product'));; 
                } else {
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE ds_category = :ds_category ORDER By dt_register ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
                    $total_produtos = count($produtos);
                }
                    break;
            case 5:
                if($category == "Geral"){
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE st_promotion = 1 ORDER By dt_register ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                    $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product'));; 
                } else {
                    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE ds_category = :ds_category AND st_promotion = 1 ORDER By vl_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
                    $total_produtos = count($produtos);
                }
                    break;
        }
    }
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA PRODUTOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <!-- Controles de pesquisa -->
            <div class="card line shadow borda-b pb-3 pt-2">
                <form class="p-0 m-0" action="?a=produtos" method="POST">
                    <div class="form-row">
                        <div class="col-md-2 p-1 pr-2 pl-2">
                            <div class="form-inline text-center ml-4 mt-2"><h5>Produtos: <label id="grey"><?php echo $total_produtos; ?> <?php echo $total_produtos > 1 ? 'Produtos' : 'Produto'; ?></label></h5></div>
                        </div>
                        <div class="col-md-3 p-1 pr-2 pl-2">
                            <label id="black" class="Obs3 mb-1 ml-1">Exibir itens da categoria:</b></label>
                            <select class="form-control mb-1 shadow" name="cfg_category" required>
                                <optgroup label="Categoria">
                                    <option value="Geral" <?php echo $category == 'Geral' ? 'selected' : '';?>>Todas as categorias</option>
                                    <option value="Peça" <?php echo $category == 'Peça' ? 'selected' : '';?>>Peça</option>
                                    <option value="Comida" <?php echo $category == 'Comida' ? 'selected' : '';?>>Comida</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-3 p-1 pr-2 pl-2">
                            <label id="black" class="Obs3 mb-1 ml-1">Por relevancia:</b></label>
                            <select class="form-control mb-1 shadow" name="cfg_relevance" required>
                                <optgroup label="Relevancia">
                                <?php if(isset($_SESSION['cfg_relevance'])):?>
                                    <option value=1 <?php echo $_SESSION['cfg_relevance'] == 1 ? 'selected' : '';?>>Preço crescente</option>
                                    <option value=2 <?php echo $_SESSION['cfg_relevance'] == 2 ? 'selected' : '';?>>Preço decrescente</option>
                                    <option value=3 <?php echo $_SESSION['cfg_relevance'] == 3 ? 'selected' : '';?>>Novidades</option>
                                    <option value=4 <?php echo $_SESSION['cfg_relevance'] == 4 ? 'selected' : '';?>>Antigos na loja</option>
                                    <option value=5 <?php echo $_SESSION['cfg_relevance'] == 5 ? 'selected' : '';?>>Em Promoção</option>
                                <?php else:?>
                                    <option value=1 <?php echo $config[0]['sp_relevance'] == 1 ? 'selected' : '';?>>Preço crescente</option>
                                    <option value=2 <?php echo $config[0]['sp_relevance'] == 2 ? 'selected' : '';?>>Preço decrescente</option>
                                    <option value=3 <?php echo $config[0]['sp_relevance'] == 3 ? 'selected' : '';?>>Novidades</option>
                                    <option value=4 <?php echo $config[0]['sp_relevance'] == 4 ? 'selected' : '';?>>Antigos na loja</option>
                                    <option value=5 <?php echo $config[0]['sp_relevance'] == 5 ? 'selected' : '';?>>Em Promoção</option>
                                <?php endif;?>        
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-4 p-1 pr-2 pl-2">
                            <label id="black" class="Obs3 mb-1 ml-1">Por uma palavra chave:</b></label>
                            <div class="form-inline">
                                <input type="search" class="form-control shadow  mb-1" name="text_pesquisa" placeholder="Pesquisar" value="<?php echo (isset($_SESSION['texto_pesquisa'])) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                                <button class="btn btn-primary pr-3 pl-3 p-2 mb-1 ml-3 mr-2 shadow"><i class="fa fa-search"></i></button>
                                <a href="?a=produtos&clear=true" class="btn btn-secondary pr-3 pl-3 p-2 mb-1 shadow"><i class="fa fa-times"></i></a>
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
        <h5 id="green" class="text-center mt-2 mb-3">NOSSOS PRODUTOS</h5><hr class="mb-1 mt-1">
            <?php if(count($produtos) == 0):?>
                <div class="text-center mt-1"><p>Nenhum produto disponível no momento.</p></div>
            <?php endif;?>
            <?php foreach ($produtos as $produto):?>
            <!-- Card do produto -->
            <div class="<?php echo $produto['st_promotion'] == 1 ? 'card borda-produto-p mb-3' : 'card borda-produto mb-3';?>">
                <div class="row p-0 m-0">
                    <div class="col-md-3 p-0 text-center prrdiv">
                        <?php if($produto['st_promotion'] == 1):?>
                        <i id="gold" class="fas fa-star mr-2 star"></i>
                        <?php endif;?>
                        <!-- Imagem -->
                        <?php if($produto['img_product'] == ''):?>
                        <label class="product-img text-center m-0"><i id="grey" class="fas fa-shopping-cart"></i></label>
                        <?php else:?>
                        <div class="p-2 text-center"><img class="img-fluid pdimg-size" src="<?php echo $produto['img_product']?>"></div>
                        <?php endif;?>
                    </div>
                    <div class="col-md-9 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-sm-9 p-2 prrdiv prbdiv">
                                <h5><label id="green" class="mr-2"><i class="fas fa-barcode mr-1"></i><?php echo $produto['cd_alternative_product'];?></label><?php echo $produto['nm_product'];?></h5>
                                <p class="mb-4" id="grey"><?php echo substr($produto['ds_description'], 0, 200)?><a data-toggle="collapse" class="Obs4" href="#<?php echo $produto['cd_alternative_product'];?>" role="button" aria-expanded="false" aria-controls="collapseExample"><i id="grey "class="fas fa-arrow-alt-circle-down ml-2 mr-1"></i>Descrição Completa</a></p>
                            </div>
                            <div class="col-sm-3 p-2 text-center">
                                <label id="grey" class="Obs3 mb-0"><label id="black" class="price mr-1 mb-0"><strong>R$ <?php echo number_format($produto['vl_product'],2, ',', '.');?></strong></label>/<?php echo $produto['ds_unity'];?></label>
                                <a href="?a=contatos" class="btn btn-success mt-2 p-3">Interessado?</a>
                                <label class="Obs3 mt-2">Entre em contato para adquirir.</label>
                                <?php if($produto['st_promotion'] == 1):?>
                                <p id="blue" class="pmtn m-0 p-0"><b>Promoção!</b></p>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="<?php echo $produto['cd_alternative_product'];?>">
                    <div class="card brad p-3">
                        <p class="mb-1" id="green"><?php echo nl2br($produto['ds_description']);?></p>
                    </div>
                </div>
                <?php if(funcoes::VerificarLogin()):?>
                <div class="card line text-center brt">
                    <div class="row p-0 m-0">
                        <div class="col-sm-8 pl-0 text-left">
                            <div class="row m-1">
                                <div class="col-sm-10 p-0 text-left mt-0 mb-0">
                                    <form class="p-0 m-0" action="?a=recebe_imagem&sender=product&p=<?php echo $produto['cd_product'];?>" method="post" enctype="multipart/form-data">
                                        <div class="m-1">
                                            <input class="btn btn-warning file mr-2 p-0" name="arquivo" type="file" accept="image/*">
                                            <input class="btn btn-success file m-0 p-1" type="submit" value="Enviar">
                                            <label class="ml-1 file" id="grey">(Ideal: 200x200)</label>
                                            <?php if ($produto['img_product'] != ''):?>
                                            <label class="mr-2 ml-2">|</label><strong><i id="grey" class="fas fa-image mr-2 file"></i><a href="?a=deleta_imagem&sender=product&img=<?php echo $produto['img_product']?>" class="file">Remover</a></strong>
                                            <?php endif;?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <div class="mt-2 mr-1">
                                <a id="black" href="?a=produto_editar&p=<?php echo $produto['cd_product'];?>" class="mr-2"><i id="grey" class="fas fa-edit mr-1"></i><b>Editar</b></a>|<a id="black" href="?a=produto_deletar&p=<?php echo $produto['cd_product'];?>" class="ml-2"><i id="grey" class="fas fa-trash mr-1"></i><b>Apagar</b></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <?php endforeach;?>
            <div class="row mt-0 mb-1 mr-3 ml-3">
                <!--Pagina Atual-->
                <div class="col-sm-6 text-left">
                    <label style="opacity: 0.5"><?php echo 'Pagina: ' . $pagina ?></label>
                </div>
                <!--Mecanismo de paginação-->
                <div class="col-sm-6 text-right">
                    <?php funcoes::Paginacao('?a=produtos', $pagina, $itens_por_pagina, $total_produtos) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(funcoes::VerificarLogin()):?>
<div class="row shadow-strong mt-4 ml-1 mr-1">
    <div class="col p-0">
        <div class="card painel-direito p-0 pl-3 pr-3">
            <h5 id="white" class="mt-3">CADASTRO DE NOVO PRODUTO</h5><hr class="mb-1 mt-1">
            <form action="?a=produto_inserir" method="POST">
                <div class="text-left">
                    <div class="form-row mt-2">
                        <div class="col">
                            <label id="black"><b><i id="black" class="fas fa-barcode mr-2"></i>Código:</b></label>
                            <input type="text" name="cd_produto" class="form-control shadow" title="Defina um código para o produto" required>
                        </div>
                        <div class="col">
                            <label id="black"><b>Produto:</b></label>
                            <input type="text" name="nm_produto" class="form-control shadow" required>
                        </div>
                    </div>
                    <div class="form-row p-0 mt-2">
                        <div class="col-md-5 mb-2">
                            <label id="black"><b>Categoria:</b></label>
                            <select class="form-control shadow" name="cat_produto" required>
                                <optgroup label="Categoria">
                                    <option value="Geral">Geral</option>
                                    <option value="Peça">Peça</option>
                                    <option value="Comida">Comida</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label id="black"><b><i id="black" class="fas fa-boxes mr-2"></i>Unidade de medida:</b></label>
                            <select class="form-control shadow" name="ds_unidade" required>
                                <optgroup label="Medida">
                                    <option value="Unidade">Unidade</option>
                                    <option value="Caixa">Caixa</option>
                                    <option value="Fardo">Fardo</option>
                                    <option value="Pacote">Pacote</option>
                                    <option value="Peça">Peça</option>
                                    <option value="Item">Item</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 p-0">
                            <label id="black"><i id="black" class="fas fa-money-bill-alt ml-1 mr-2"></i><b>Preço/Valor:</b></label>
                            <div class="input-group">
                            <div class="input-group-prepend ml-1">
                                <div class="input-group-text shadow"><strong>R$</strong></div>
                            </div>
                            <input type="number"  pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name="vl_produto" class="form-control shadow" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-goup mt-2">
                        <label id="black"><i id="black" class="fas fa-info-circle mr-2"></i><b>Descrição:</b></label>
                        <textarea type="text" name="ds_descricao" class="form-control shadow" rows="7" title="Informações do produto" required></textarea>
                    </div>
                    <div class="form-row mt-3 p-0">
                        <div class="col">
                            <div class="form-inline">
                                <label id="black" class="Obs3 ml-1 mr-3"><b>Este produto é uma promoção?</b></label>
                                <label id="black" class="radio-inline mr-3"><input type="radio" name="pmtradio" value=1>Sim</label>
                                <label id="black" class="radio-inline"><input type="radio" name="pmtradio" value=0 checked>Não</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-right mb-3">
                                <button class="btn btn-success shadow mb-0">Inserir Produto</button>
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
            <form action="?a=update_config&sender=products" method="POST">
                <div class="text-left">
                    <div class="form-row p-0 mt-2">
                        <div class="col-sm-6 mb-2">
                            <label id="black">Exibir lista de produtos na página por:</label>
                            <select class="form-control shadow" name="cfg_rel" required>
                                <optgroup label="Relevancia">
                                    <option value=1 <?php echo $config[0]['sp_relevance'] == 1 ? 'selected' : '';?>>1 - Preço crescente</option>
                                    <option value=2 <?php echo $config[0]['sp_relevance'] == 2 ? 'selected' : '';?>>2 - Preço decrescente</option>
                                    <option value=3 <?php echo $config[0]['sp_relevance'] == 3 ? 'selected' : '';?>>3 - Ultimos a serem adicionados</option>
                                    <option value=4 <?php echo $config[0]['sp_relevance'] == 4 ? 'selected' : '';?>>4 - Primeiros a serem adicionados</option>
                                    <option value=5 <?php echo $config[0]['sp_relevance'] == 5 ? 'selected' : '';?>>5 - Apenas em promoção</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-6 mb-1">
                            <label id="black">Quantidade de itens por página:</label>
                            <select class="form-control shadow" name="cfg_amount" required>
                                <optgroup label="Quantidade">
                                    <option value=5 <?php echo $config[0]['sp_amount'] == 5 ? 'selected' : '';?>>5</option>
                                    <option value=10 <?php echo $config[0]['sp_amount'] == 10 ? 'selected' : '';?>>10</option>
                                    <option value=15 <?php echo $config[0]['sp_amount'] == 15 ? 'selected' : '';?>>15</option>
                                    <option value=20 <?php echo $config[0]['sp_amount'] == 20 ? 'selected' : '';?>>20</option>
                                    <option value=25 <?php echo $config[0]['sp_amount'] == 25 ? 'selected' : '';?>>25</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2 mb-3">
                    <button class="btn btn-success shadow">Atualizar</button>
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
?>
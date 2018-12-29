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
        if(isset($_SESSION['cfg_pesquisa'])){
            unset($_SESSION['cfg_pesquisa']);
        }
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['text_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
        }
        $_SESSION['cfg_pesquisa'] = $_POST['cfg_pesquisa'];
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

    //Itens de filtro de pesquisa
    if(isset($_SESSION['cfg_pesquisa'])){
        $relevance = $_SESSION['cfg_pesquisa'];
    }else{
        $relevance = $config[0]['sp_relevance'];
    }
    
    //busca o conteúdo da pagina no banco de dados.
    if(isset($_SESSION['texto_pesquisa'])){
      
        $parametros = ['pesquisa'   =>  '%'.$_SESSION['texto_pesquisa'].'%' ];
        $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE nm_product LIKE :pesquisa OR ds_description LIKE :pesquisa ORDER BY nm_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);
        $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product WHERE nm_product LIKE :pesquisa OR ds_description LIKE :pesquisa ORDER BY nm_product ASC', $parametros));

    } else {
        //Pesquisa sem filtro
        switch ($relevance){
            case 1:
            $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By vl_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                break;
            case 2:
            $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By vl_product DESC LIMIT '.$item_inicial.','.$itens_por_pagina);
                break;
            case 3:
            $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By dt_register DESC LIMIT '.$item_inicial.','.$itens_por_pagina);
                break;
            case 4:
            $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By dt_register ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
                break;
            // default:
            // $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product ORDER By cd_alternative_product ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
        }
        //Contagem dos produtos na tabela.
        $total_produtos = count($acesso->EXE_QUERY('SELECT * FROM tab_product'));
    }
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA PRODUTOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <!-- Controles de pesquisa -->
            <div class="card line shadow borda-b pb-3 pt-2">
                <form class="p-0 m-0" action="?a=produtos" method="POST">
                    <div class="form-row form-inline">
                        <div class="col-sm-4">
                            <div class="form-inline text-center ml-4 mt-2"><h5>Produtos: <label id="grey" style="font-style: italic;"><?php echo $total_produtos;?> <?php echo $total_produtos > 1 ? 'Produtos' : 'Produto'; ?></label></h5></div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <label id="black" class="Obs3 mb-1">Exibir lista de produtos na página por:</b></label>
                            <select class="form-control mb-1 shadow" name="cfg_pesquisa" required>
                                <optgroup label="Relevancia">
                                    <option value=1 <?php echo (isset($_SESSION['cfg_pesquisa']) ? $_SESSION['cfg_pesquisa'] : $config[0]['sp_relevance']) == 1 ? 'selected' : '';?>>Preço crescente</option>
                                    <option value=2 <?php echo (isset($_SESSION['cfg_pesquisa']) ? $_SESSION['cfg_pesquisa'] : $config[0]['sp_relevance']) == 2 ? 'selected' : '';?>>Preço decrescente</option>
                                    <option value=3 <?php echo (isset($_SESSION['cfg_pesquisa']) ? $_SESSION['cfg_pesquisa'] : $config[0]['sp_relevance']) == 3 ? 'selected' : '';?>>Ultimos a serem adicionados</option>
                                    <option value=4 <?php echo (isset($_SESSION['cfg_pesquisa']) ? $_SESSION['cfg_pesquisa'] : $config[0]['sp_relevance']) == 4 ? 'selected' : '';?>>Primeiros a serem adicionados</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-4 text-center">
                            <label id="black" class="Obs3 mb-1">Pequise por uma palavra chave:</b></label>
                            <input type="search" class="form-control shadow mr-2 mb-1" name="text_pesquisa" placeholder="Pesquisar" value="<?php echo (isset($_SESSION['texto_pesquisa'])) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                            <button class="btn btn-primary pr-3 pl-3 p-2 mb-1 shadow"><i class="fa fa-search"></i></button>
                            <a href="?a=produtos&clear=true" class="btn btn-secondary pr-3 pl-3 p-2 mb-1 shadow"><i class="fa fa-times"></i></a>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <?php foreach ($produtos as $produto) : ?>
            <!-- Card do produto -->
            <div class="card borda-produto mb-3">
                <div class="row p-0 m-0">
                    <div class="col-md-3 p-0 text-center">
                        <!-- Imagem -->
                        <?php if($produto['img_product'] == ''):?>
                        <label class="product-img text-center m-0"><i id="grey" class="fas fa-shopping-cart"></i></label>
                        <?php else:?>
                        <img src="produto.png">
                        <?php endif;?>
                    </div>
                    <div class="col-md-9 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-sm-9 p-2 prrdiv prldiv">
                                <h5><label id="green" class="mr-2"><i class="fas fa-barcode mr-1"></i><?php echo $produto['cd_alternative_product'];?></label><?php echo $produto['nm_product'];?></h5>
                                <p class="mb-4" id="grey"><?php echo substr($produto['ds_description'], 0, 210)?></p>
                                <div class="lnk-info mb-1"><a data-toggle="collapse" href="#<?php echo $produto['cd_alternative_product'];?>" role="button" aria-expanded="false" aria-controls="collapseExample"><i id="grey "class="fas fa-arrow-alt-circle-down mr-2"></i>Descrição Completa</a></div>
                            </div>
                            <div class="col-sm-3 p-2 text-center">
                                <label id="grey" class="Obs3"><label id="black" class="price mr-1"><strong>R$ <?php echo number_format($produto['vl_product'],2, ',', '.');?></strong></label>/<?php echo $produto['ds_unity'];?></label>
                                <a class="btn btn-success mt-2 p-3" href="?a=contatos">Interessado?</a>
                                <label class="Obs3 mt-2">Entre em contato para adquirir.</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="<?php echo $produto['cd_alternative_product'];?>">
                    <div class="card brad p-3">
                        <p class="mb-2" id="green"><?php echo $produto['ds_description'];?></p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <div class="row mt-0 mb-1 mr-1 ml-1">
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
        <div class="card line p-3">
            <h5 id="green" class="mt-2">CADASTRO DE NOVO PRODUTO</h5><hr>
            <form action="?a=produto_inserir" method="POST">
                <div class="text-left">
                    <div class="form-row mt-2">
                        <div class="col">
                            <label id="black"><b><i id="grey" class="fas fa-barcode mr-2"></i>Código:</b></label>
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
                            <label id="black"><b><i id="grey" class="fas fa-boxes mr-2"></i>Unidade de medida:</b></label>
                            <select class="form-control shadow" name="ds_unidade" required>
                                <optgroup label="Categoria">
                                    <option value="Unidade">Unidade</option>
                                    <option value="Caixa">Caixa</option>
                                    <option value="Fardo">Fardo</option>
                                    <option value="Pacote">Pacote</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 p-0">
                            <label id="black"><i id="grey" class="fas fa-money-bill-alt ml-1 mr-2"></i><b>Preço/Valor:</b></label>
                            <div class="input-group">
                            <div class="input-group-prepend ml-1">
                                <div class="input-group-text shadow"><strong>R$</strong></div>
                            </div>
                            <input type="number"  pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name="vl_produto" class="form-control shadow" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-goup mt-2">
                        <label id="black"><i id="grey" class="fas fa-info-circle mr-2"></i><b>Descrição:</b></label>
                        <textarea type="text" name="ds_descricao" class="form-control shadow" rows="5" title="Informações do produto" required></textarea>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button class="btn btn-success mb-0">Inserir Produto</button>
                </div>        
            </form>
        </div>
    </div>
</div>
<div class="row shadow-strong mt-4 ml-1 mr-1">
    <div class="col p-0">
        <div class="card painel-direito p-3">
            <h5 id="white" class="mt-2">CONFIGURAÇÕES DE EXIBIÇÃO</h5><hr class="mb-1 mt-1">
            <form action="?a=update_config&sender=products" method="POST">
                <div class="text-left">
                    <div class="form-row p-0 mt-2">
                        <div class="col-sm-4 mb-2">
                            <label id="white">Exibir lista de produtos na página por:</b></label>
                            <select class="form-control shadow" name="cfg_relevance" required>
                                <optgroup label="Relevancia">
                                    <option value=1 <?php echo $config[0]['sp_relevance'] == 1 ? 'selected' : '';?>>1 - Preço crescente</option>
                                    <option value=2 <?php echo $config[0]['sp_relevance'] == 2 ? 'selected' : '';?>>2 - Preço decrescente</option>
                                    <option value=3 <?php echo $config[0]['sp_relevance'] == 3 ? 'selected' : '';?>>3 - Ultimos a serem adicionados</option>
                                    <option value=4 <?php echo $config[0]['sp_relevance'] == 4 ? 'selected' : '';?>>4 - Primeiros a serem adicionados</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <label id="white">Categoria:</label>
                            <select class="form-control shadow" name="cfg_category" required>
                                <optgroup label="Categoria">
                                    <option value=1 <?php echo $config[0]['sp_category'] == 1 ? 'selected' : '';?>>1 - Todas as categorias</option>
                                    <option value=2 <?php echo $config[0]['sp_category'] == 2 ? 'selected' : '';?>>2 - Peça</option>
                                    <option value=3 <?php echo $config[0]['sp_category'] == 3 ? 'selected' : '';?>>3 - Comida</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-4 mb-1">
                            <label id="white">Quantidade de itens por página:</label>
                            <select class="form-control shadow" name="cfg_amount" required>
                                <optgroup label="Quantidade">
                                    <option value=5 <?php echo $config[0]['sp_amount'] == 5 ? 'selected' : '';?>>5</option>
                                    <option value=10 <?php echo $config[0]['sp_amount'] == 10 ? 'selected' : '';?>>10</option>
                                    <option value=15 <?php echo $config[0]['sp_amount'] == 15 ? 'selected' : '';?>>15</option>
                                    <option value=20 <?php echo $config[0]['sp_amount'] == 20 ? 'selected' : '';?>>20</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2">
                    <button class="btn btn-success">Atualizar</button>
                </div>        
            </form>
        </div>
    </div>
</div>
<?php endif;?>
<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //$data = new DateTime();
    $config = $acesso->EXE_QUERY('SELECT st_product FROM tab_config');

    if($config[0]['st_product'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    //busca o conteúdo da pagina no banco de dados.
    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product');

    // if($_SERVER['REQUEST_METHOD'] == 'POST'){


    // }
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA PRODUTOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-5 borda-painel line shadow-strong">
            <h3 class="text-center">CONTROLES DE PESQUISA</h3>
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
                                <label id="grey" class="Obs3"><label id="black" class="price mr-1"><strong>R$ <?php echo $produto['vl_product'];?></strong></label>/<?php echo $produto['ds_unity'];?></label>
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
                                <input type="number" name="vl_produto" class="form-control shadow" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-goup mt-2">
                            <label id="black"><i id="grey" class="fas fa-info-circle mr-2"></i><b>Descrição:</b></label>
                            <textarea type="text" name="ds_descricao" class="form-control shadow" rows="5" title="Informações do produto" required></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-success mb-2">Inserir Produto</button>
                    </div>        
                </form>
            </div>
        </div>
    </div>
<?php endif;?>
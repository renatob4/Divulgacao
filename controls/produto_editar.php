<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');

    if($config[0]['st_product'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
        exit();
    }

    if(!isset($_GET['p'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
        exit();
    }

    //Pega o codigo do produto na URL
    $cd_produto = $_GET['p'];

    $mensagem = '';

    //pesquisa se existe produto com esse codigo na base
    $parametros = [
        ':cd_product'   =>  $cd_produto
    ];
    $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE cd_product = :cd_product', $parametros);

    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($produtos) == 0){
        echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
        exit();
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $edit_cd  =  $_POST['edit_cd'];
        $edit_nm  =  $_POST['edit_nm'];
        $edit_cat  =  $_POST['edit_cat'];
        $edit_un  =  $_POST['edit_un'];
        $edit_vl  =  $_POST['edit_vl'];
        $edit_desc  =  $_POST['edit_desc'];
        $edit_radio  =  $_POST['edit_radio'];

        //Atualizar os dados no produto no banco
        $parametros = [
            ':cd_product'               =>  $produtos[0]['cd_product'],
            ':cd_alternative_product'   =>  $edit_cd,
            ':nm_product'               =>  $edit_nm,
            ':ds_category'              =>  $edit_cat,
            ':vl_product'               =>  $edit_vl,
            ':ds_description'           =>  $edit_desc,
            ':ds_unity'                 =>  $edit_un,
            ':st_promotion'             =>  $edit_radio,
            ':dt_updated'               =>  $data->format('Y-m-d H:i:s')
        ];
        //Atualizar a DB
        $acesso->EXE_NON_QUERY('UPDATE tab_product 
                                SET cd_alternative_product = :cd_alternative_product, 
                                nm_product = :nm_product, 
                                ds_category = :ds_category,
                                vl_product = :vl_product, 
                                ds_description = :ds_description,
                                ds_unity = :ds_unity,
                                st_promotion = :st_promotion, 
                                dt_updated = :dt_updated 
                                WHERE cd_product = :cd_product', $parametros);

        $mensagem = "Produto ".$produtos[0]['cd_alternative_product']." editado com sucesso!";
    
        //Redirecionar
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=produto_editar&p='.$produtos[0]['cd_product'].'">');
        exit();
    }
?>
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <h5 id="green" class="text-center mt-2 mb-3">EDITE AS INFORMAÇÕES DO PRODUTO ABAIXO</h5>
            <!-- Card do produto -->
            <div class="<?php echo $produtos[0]['st_promotion'] == 1 ? 'card borda-produto-p mb-3' : 'card borda-produto mb-3';?>">
                <div class="row p-0 m-0">
                    <div class="col-md-3 p-0 text-center prrdiv">
                        <?php if($produtos[0]['st_promotion'] == 1):?>
                        <i id="gold" class="fas fa-star mr-2 star"></i>
                        <?php endif;?>
                        <!-- Imagem -->
                        <?php if($produtos[0]['img_product'] == ''):?>
                        <label class="product-img text-center m-0"><i id="grey" class="fas fa-shopping-cart"></i></label>
                        <?php else:?>
                        <div class="p-2 text-center"><img class="img-fluid pdimg-size" src="<?php echo $produtos[0]['img_product']?>"></div>
                        <?php endif;?>
                    </div>
                    <div class="col-md-9 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-sm-9 p-2 prrdiv prbdiv">
                                <h5><label id="green" class="mr-2"><i class="fas fa-barcode mr-1"></i><?php echo $produtos[0]['cd_alternative_product'];?></label><?php echo $produtos[0]['nm_product'];?></h5>
                                <p class="mb-4" id="grey"><?php echo substr($produtos[0]['ds_description'], 0, 200)?><a data-toggle="collapse" class="Obs4" href="#<?php echo $produtos[0]['cd_alternative_product'];?>" role="button" aria-expanded="false" aria-controls="collapseExample"><i id="grey "class="fas fa-arrow-alt-circle-down ml-2 mr-1"></i>Descrição Completa</a></p>
                            </div>
                            <div class="col-sm-3 p-2 text-center">
                                <label id="grey" class="Obs3 mb-0"><label id="black" class="price mr-1 mb-0"><strong>R$ <?php echo number_format($produtos[0]['vl_product'],2, ',', '.');?></strong></label>/<?php echo $produtos[0]['ds_unity'];?></label>
                                <a class="btn btn-success mt-2 p-3" href="?a=contatos">Interessado?</a>
                                <label class="Obs3 mt-2">Entre em contato para adquirir.</label>
                                <?php if($produtos[0]['st_promotion'] == 1):?>
                                <p id="blue" class="pmtn m-0 p-0"><b>Promoção!</b></p>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="<?php echo $produtos[0]['cd_alternative_product'];?>">
                    <div class="card brad p-3">
                        <p class="mb-1" id="green"><?php echo nl2br($produtos[0]['ds_description']);?></p>
                    </div>
                </div>
                <div class="card line text-center brt">
                    <div class="row p-0 m-0">
                        <div class="col-sm-8 pl-0 text-left">
                            <div class="row m-1">
                                <div class="col-sm-10 p-0 text-left mt-0 mb-0">
                                    <form class="p-0 m-0" action="?a=recebe_imagem&sender=product&p=<?php echo $produtos[0]['cd_product'];?>" method="post" enctype="multipart/form-data">
                                        <div class="m-1">
                                            <input class="btn btn-warning file mr-2 p-0" name="arquivo" type="file" accept="image/*">
                                            <input class="btn btn-success file m-0 p-1" type="submit" value="Enviar">
                                            <label class="ml-1 file" id="grey">(Ideal: 200x200)</label>
                                            <?php if ($produtos[0]['img_product'] != ''):?>
                                            <label class="mr-2 ml-2">|</label><strong><i id="grey" class="fas fa-image mr-2 file"></i><a href="?a=deleta_imagem&sender=product&img=<?php echo $produtos[0]['img_product']?>" class="file">Remover</a></strong>
                                            <?php endif;?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row shadow-strong mt-4 ml-1 mr-1">
    <div class="col p-0">
        <div class="card painel-direito p-0 pl-3 pr-3">
            <h5 id="white" class="mt-3">INFORMAÇÕES DO PRODUTO</h5><hr class="mb-1 mt-1">
            <form action="?a=produto_editar&p=<?php echo $produtos[0]['cd_product'];?>" method="POST">
                <div class="text-left">
                    <div class="form-row mt-2">
                        <div class="col">
                            <label id="black"><b><i id="black" class="fas fa-barcode mr-2"></i>Código:</b></label>
                            <input type="text" name="edit_cd" class="form-control shadow" value="<?php echo $produtos[0]['cd_alternative_product'];?>" title="Defina um código para o produto" required>
                        </div>
                        <div class="col">
                            <label id="black"><b>Produto:</b></label>
                            <input type="text" name="edit_nm" class="form-control shadow" value="<?php echo $produtos[0]['nm_product'];?>" required>
                        </div>
                    </div>
                    <div class="form-row p-0 mt-2">
                        <div class="col-md-5 mb-2">
                            <label id="black"><b>Categoria:</b></label>
                            <select class="form-control shadow" name="edit_cat" required>
                                <optgroup label="Categoria">
                                    <option value="Geral" <?php echo $produtos[0]['ds_category'] == 'Geral' ? 'selected' : '';?>>Geral</option>
                                    <option value="Peça" <?php echo $produtos[0]['ds_category'] == 'Peça' ? 'selected' : '';?>>Peça</option>
                                    <option value="Comida" <?php echo $produtos[0]['ds_category'] == 'Comida' ? 'selected' : '';?>>Comida</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label id="black"><b><i id="black" class="fas fa-boxes mr-2"></i>Unidade de medida:</b></label>
                            <select class="form-control shadow" name="edit_un" required>
                                <optgroup label="Medida">
                                    <option value="Unidade" <?php echo $produtos[0]['ds_unity'] == 'Unidade' ? 'selected' : '';?>>Unidade</option>
                                    <option value="Caixa" <?php echo $produtos[0]['ds_unity'] == 'Caixa' ? 'selected' : '';?>>Caixa</option>
                                    <option value="Fardo" <?php echo $produtos[0]['ds_unity'] == 'Fardo' ? 'selected' : '';?>>Fardo</option>
                                    <option value="Pacote" <?php echo $produtos[0]['ds_unity'] == 'Pacote' ? 'selected' : '';?>>Pacote</option>
                                    <option value="Peça" <?php echo $produtos[0]['ds_unity'] == 'Peça' ? 'selected' : '';?>>Peça</option>
                                    <option value="Item" <?php echo $produtos[0]['ds_unity'] == 'Item' ? 'selected' : '';?>>Item</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 p-0">
                            <label id="black"><i id="black" class="fas fa-money-bill-alt ml-1 mr-2"></i><b>Preço/Valor:</b></label>
                            <div class="input-group">
                            <div class="input-group-prepend ml-1">
                                <div class="input-group-text shadow"><strong>R$</strong></div>
                            </div>
                            <input type="number"  pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name="edit_vl" class="form-control shadow" value="<?php echo $produtos[0]['vl_product']*1;?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-goup mt-2">
                        <label id="black"><i id="black" class="fas fa-info-circle mr-2"></i><b>Descrição:</b></label>
                        <textarea type="text" name="edit_desc" class="form-control shadow" rows="7" title="Informações do produto" required><?php echo $produtos[0]['ds_description'];?></textarea>
                    </div>
                    <div class="form-row mt-3 p-0">
                        <div class="col">
                            <div class="form-inline">
                                <label id="black" class="Obs3 ml-1 mr-3"><b>Este produto é uma promoção?</b></label>
                                <label id="black" class="radio-inline mr-3"><input type="radio" name="edit_radio" value=1 <?php echo $produtos[0]['st_promotion'] == 1 ? 'checked' : '';?>>Sim</label>
                                <label id="black" class="radio-inline"><input type="radio" name="edit_radio" value=0 <?php echo $produtos[0]['st_promotion'] == 0 ? 'checked' : '';?>>Não</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-right">
                                <a href="?a=produtos" class="btn btn-primary shadow mr-2">Voltar</a>
                                <a href="?a=produto_deletar&p=<?php echo $produtos[0]['cd_product'];?>" class="btn btn-danger shadow mb-0 mr-2">Apagar</a>
                                <button class="btn btn-success shadow mb-0">Atualizar Produto</button>
                            </div>    
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>
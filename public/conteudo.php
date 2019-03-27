<?php
    // ========================================
    // Referente ao forma da Pagina CONTEUDO ao abrir um card
    // ========================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();
    $mensagem = '';

    //Pega o codigo do card na URL
    if(isset($_GET['card']))
        $cd_card = $_GET['card'];
    else
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');

    //pesquisa se existe card com esse codigo na base
    $parametros = [
        ':cd_card'   =>  $cd_card
    ];
    $card = $acesso->EXE_QUERY('SELECT * FROM tab_card WHERE cd_card = :cd_card', $parametros);
     
    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($card) == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    // verifica se foi enviado um arquivo
    if (isset($_FILES['arquivo']['name']) && $_FILES['arquivo']['error'] == 0){
       
        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $nome = $_FILES['arquivo']['name'];
    
        // Pega a extensão
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        // Converte a extensão para minúsculo
        $extensao = strtolower($extensao);
    
        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)){

            $novoNome = uniqid(time()).'.'.$extensao;
            // Concatena a pasta com o nome
            $destino = './images/'.$novoNome;
            
            // tenta mover o arquivo para o destino
            if(@move_uploaded_file($arquivo_tmp, $destino)){

                if(isset($_GET['flag'])){

                    if($card[0]['img_front_card'] != ''){
                        //Apaga a imagem antiga do diretorio do site.
                        unlink("./".$card[0]['img_front_card']);
                    }
                    //Atualiza o banco com o nome da nova imagem.
                    $parametros = [
                        ':cd_card'            =>  $cd_card,
                        ':img_front_card'     =>  "images/".$novoNome,
                        ':dt_updated'         =>  $data->format('Y-m-d H:i:s')
                    ];
                    $acesso->EXE_NON_QUERY('UPDATE tab_card SET img_front_card = :img_front_card, dt_updated = :dt_updated WHERE cd_card = :cd_card', $parametros);     
                    $mensagem = 'Arquivo salvo com sucesso!.';

                    echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
                    exit();
                }
                else {
                    
                    if($card[0]['img_card'] != ''){
                        //Apaga a imagem antiga do diretorio do site.
                        unlink("./".$card[0]['img_card']);
                    }
                    //Atualiza o banco com o nome da nova imagem.
                    $parametros = [
                        ':cd_card'      =>  $cd_card,
                        ':img_card'     =>  "images/".$novoNome,
                        ':dt_updated'   =>  $data->format('Y-m-d H:i:s')
                    ];
                    $acesso->EXE_NON_QUERY('UPDATE tab_card SET img_card = :img_card, dt_updated = :dt_updated WHERE cd_card = :cd_card', $parametros);     
                    $mensagem = 'Arquivo salvo com sucesso!.';

                    echo('<meta http-equiv="refresh" content="0;URL=?a=conteudo&card='.$cd_card.'">');
                    exit();
                }
        
            }else{
                $mensagem = 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
            }
        }else{
            $mensagem = 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br/>';
        }
    }else{
        $mensagem = 'Você não enviou nenhum arquivo!';
    }
?>
<div class="row mr-1 ml-1 mt-2 borda-painel shadow-strong">
    <div class="col p-0">
        <div class="card p-2">
            <div><h6 class="text-right" id="grey"><i class="far fa-clock mr-2"></i><?php echo $card[0]['dt_updated']?></h6><h4 class="text-center wrap"><i id="gold" class="fas fa-star mr-2"></i><?php echo $card[0]['ds_title']?></h4></div>
            <div class="card text-center p-3 m-3 mb-5 shadow"><p class="wrap"><?php echo $card[0]['ds_content']?></p>
                <!-- Mostra a imagem no corpo se ela existir ====================================================-->
                <?php if ($card[0]['img_card'] != ''):?>
                <div class="pb-0 pl-3 pr-3"><img class="img-fluid shadow-strong" src="<?php echo $card[0]['img_card']?>"></div>
                <?php endif;?>
                <?php if (funcoes::VerificarLogin()):?>
                <div class="row mt-2 mb-0">
                    <div class="col p-0 text-left mt-1 mb-0 pl-2">
                        <form class="p-0 m-0" action="?a=conteudo&card=<?php echo $cd_card?>" method="post" enctype="multipart/form-data">
                            <label class="p-0 m-0">
                                <strong><i id="grey" class="fas fa-image mr-1 ml-1"></i>
                                    <a data-toggle="collapse" href="#collapseInputD" id="green" role="button" aria-expanded="false" aria-controls="collapseExample">Inserir</a>
                                    <label class="ml-1 file" id="grey">(Ideal: 960x460)</label>
                                </strong>
                            </label>
                            <div class="collapse" id="collapseInputD">
                                <input class="btn btn-warning file p-0" name="arquivo" type="file" accept="image/*">
                                <input class="btn btn-success file m-0 p-1" type="submit" value="Enviar">
                            </div>
                        </form>
                    </div>
                    <?php if ($card[0]['img_card'] != ''):?>
                    <div class="col p-0 text-right mt-1 mb-0 pr-2">
                        <strong><i id="grey" class="fas fa-trash-alt mr-2"></i><a href="?a=deleta_imagem&sender=card&img=<?php echo $card[0]['img_card']?>">Remover</a></strong>
                    </div>
                    <?php endif;?>
                </div>
                <?php endif;?>
                <!-- ================================================================================================= -->
            </div>
        </div>
    </div>
</div>
<?php if(funcoes::VerificarLogin()):?>
    <div class="row mt-5">
        <div class="col p-0">
            <div class="card painel-direito p-3">
                <h5 id="black" class="text-left">Edite as informações do conteúdo acima:</h5>
                <form action="?a=card_editar&card=<?php echo $card[0]['cd_card']?>" method="POST">
                    <div class="form-goup mt-2">
                        <label><b><i class="fas fa-star mr-2"></i>Título:</b></label>
                        <input type="text" name="cardtext_titulo" class="form-control" maxlength="50" value="<?php echo $card[0]['ds_title']?>" required>
                    </div>
                    <div class="form-goup mt-2">
                        <label><b><i class="fas fa-file-alt mr-2"></i>Conteúdo:</b></label>
                        <textarea type="text" 
                                  name="cardtext_content" 
                                  class="form-control" 
                                  rows="10" 
                                  required><?php echo $card[0]['ds_content']?></textarea>
                    </div>  
                    <div class="text-right p-0 mr-0 mt-2">
                        <a href="?a=card_deletar&card=<?php echo $card[0]['cd_card']?>" class="btn btn-danger borda-painel mr-2"><i class="fas fa-trash mr-2"></i>Apagar</a>
                        <button type="submit" class="btn btn-success borda-painel"><i class="fas fa-edit mr-2"></i>Aplicar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif;?>
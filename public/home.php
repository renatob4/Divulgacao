<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
    $card = $acesso->EXE_QUERY('SELECT * FROM tab_card');

?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA INICIAL__________________________________________________________ -->

        <!-- Barra divisoria branca -->
        <div class="row barra-branca"></div>
        <!-- Imagem Painel -->
        <div class="row">
            <div class="imagem-painel">
                <div class="posicao-botao">
                    <button class="btn btn-primary botao">Call to Action!</button>
                </div>
            </div>
        </div>

        <!-- Nome da empresa e slogan -->
         <!-- <div class="row">
            <div class="col-xs-6 col-xs-offset-3 text-center espaco-services mt-2 pb-0">
                <h1><?php //echo $conteudo[0]['nm_company']?></h1>
                <p><?php //echo $conteudo[0]['ds_slogan']?></p>
            </div>
         </div> -->

        <!-- Apresentação da empresa, texto. -->
        <hr>
            <div class="row m-1">
                <div class="col-md-8 p-0">
                    <div class="text-center p-4">
                        <h4 class="mb-3">Apresentação</h4>
                        <!-- Dados contidos no campo 'ds_presentation' do banco de dados -->
                        <p class="mb-4"><?php echo $conteudo[0]['ds_presentation']?></p>        
                    </div>
                </div>
                <!-- Painel rapido de contatos telefonicos -->
                <div class="col-md-4 p-0">
                    <div class="card painel-direito text-center p-4 ml-3">
                        <h4 id="black"><i class="fas fa-phone-square mr-2 "></i>Fale conosco:</h4><hr>
                        <h5>Telefone 1: <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_1'])?></h5>
                        <h5>Telefone 2: <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_2'])?></h5><hr>
                        <p id="black"><i class="fas fa-envelope ml-2 mr-1"></i>Ou envie um e-mail direto <a href="?a=contatos">Aqui</a></p>
                    </div>
                </div>
            </div>
        <hr>

        <!-- Cards de texto -->
        <div class="row">
            <?php for($i = 0; $i<=count($card)-1; $i++) :?>
                <!-- CARD-->
                <?php if(count($card) >= 3) :?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                <?php elseif(count($card) == 2) :?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                <?php else :?>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                <?php endif;?>
                    <div class="panel panel-default text-center espaco-paineis">
                        <!-- Titulo carregado direto da base de dados -->
                        <p class="titulo-painel"><?php echo $card[$i]['ds_title']?></p>
                        <!-- Conteúdo carregado direto da base de dados -->
                        <div class="conteudo-baixo mb-3"><div><?php echo substr($card[$i]['ds_content'], 0, 225)?></div></div>
                        <div class="text-center p-0 ml-0">
                            <?php if(funcoes::VerificarLogin()) :?>
                                <a href="#edit<?php echo $card[$i]['cd_card']?>" class="btn btn-outline-success p-2 mr-1" data-toggle="collapse" role="button" aria-expanded="false"><i class="fas fa-edit"></i>Edit</a>                    
                                <a href="?a=conteudo&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-primary p-2">Saiba mais</a>
                                <a href="?a=card_deletar&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-outline-danger p-2 ml-1"><i class="fas fa-trash"></i>Del</a>   
                                <div class="collapse" id="edit<?php echo $card[$i]['cd_card']?>"><hr>
                                    <div class="text-left">
                                        <form action="?a=card_editar&card=<?php echo $card[$i]['cd_card']?>" method="POST">
                                            <div class="form-goup mt-2">
                                                <label><b>Título:</b></label>
                                                <input type="text" name="card_text_titulo" class="form-control">
                                            </div>
                                            <div class="form-goup mt-2">
                                                <label><b>Conteúdo:</b></label>
                                                <textarea type="text" name="card_text_content" class="form-control" rows="3"></textarea>
                                            </div>  
                                            <div class="text-right p-0 mr-0 mt-2"><button type="submit" class="btn btn-success">Aplicar</button></div>
                                        </form>
                                    </div>
                                </div>
                            <?php else : ?>
                                <a href="?a=conteudo&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-primary p-2">Saiba mais...</a>
                            <?php endif; ?>
                        </div>
                    </div>              
                </div>
            <?php endfor;?>
        </div>

        <!-- Botão para adição de novos cards, limitados a quantidade maxima de 6. -->
        <?php if(funcoes::VerificarLogin()) :?>
            <?php if(count($card) < 6) :?>      
            <div class="row text-right p-0 mt-2 ">
                <div class="col">
                    <a href="?a=card_inserir" class="btn btn-success text-center borda-painel" >Adicinar novo card<i class="fas fa-plus-square mr-2 ml-2"></i></a>                   
                </div>
            </div>
            <?php else :?>
                <div class="row text-right p-0 mt-2 ">
                    <div class="col">
                        Obs. Ja está no limite de <strong>6</strong> Cards.                 
                    </div>
                </div>
            <?php endif; ?>
        <?php endif;?>

<!-- ______________________________________________________________________________________________________________________________________ -->




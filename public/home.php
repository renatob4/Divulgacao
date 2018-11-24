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
                <!-- Coluna 1-->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default text-center espaco-paineis">
                        <p class="titulo-painel"><?php echo $card[0]['ds_title']?></p>
                        <p><?php echo $card[0]['ds_content']?></p>
                        <div class="text-center p-0 ml-0">
                            <?php if(funcoes::VerificarLogin()) :?>
                                <a href="#edit" class="btn btn-outline-success p-2 mr-1" data-toggle="collapse" role="button" aria-expanded="false"><i class="fas fa-edit"></i>Edit</a>                    
                                <a href="?a=conteudo&card=<?php echo $card[0]['cd_card']?>" class="btn btn-primary p-2">Saiba mais</a>
                                <a href="?a=card_deletar&card=<?php echo $card[0]['cd_card']?>" class="btn btn-outline-danger p-2 ml-1"><i class="fas fa-trash"></i>Del</a>   
                                <div class="collapse" id="edit"><hr>
                                    <div class="text-left"> 
                                        <div class="form-goup mt-2">
                                            <label><b>Título:</b></label>
                                            <input type="text" name="card_text_titulo" class="form-control">
                                        </div>
                                        <div class="form-goup mt-2">
                                            <label><b>Conteúdo:</b></label>
                                            <textarea type="text" name="card_text_content" class="form-control"></textarea>
                                        </div>  
                                    </div>
                                    <div class="text-right p-0 mr-0 mt-2"><a href="?a=card_editar&card=<?php echo $card[0]['cd_card']?>" class="btn btn-success">Aplicar</a></div>
                                </div>
                            <?php else : ?>
                                <a href="?a=conteudo&card=<?php echo $card[0]['cd_card']?>" class="btn btn-primary p-2">Saiba mais...</a>
                            <?php endif; ?>
                        </div>
                    </div>              
                </div>
                <!-- Coluna 2-->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default text-center espaco-paineis">
                        <p class="titulo-painel"><?php echo $card[1]['ds_title']?></p>
                        <p><?php echo $card[1]['ds_content']?></p>
                        <a href="" class="btn btn-primary">Saiba mais...</a>
                    </div>              
                </div>
                <!-- Coluna 3-->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default text-center espaco-paineis">
                        <p class="titulo-painel"><?php echo $card[2]['ds_title']?></p>
                        <p><?php echo $card[2]['ds_content']?></p>
                        <a href="" class="btn btn-primary">Saiba mais...</a>
                    </div>              
                </div>                
        </div>

<!-- ______________________________________________________________________________________________________________________________________ -->




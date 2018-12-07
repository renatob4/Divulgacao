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
    $post = $acesso->EXE_QUERY('SELECT * FROM tab_post');
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA INICIAL__________________________________________________________ -->
    <!-- Imagem Painel -->
    <div class="row mt-0 mr-1 ml-1">
        <div class="imagem-painel">
            <div class="posicao-botao">
                <button class="btn btn-primary botao">Call to Action!</button>
            </div>
        </div>
    </div>
    <!-- Apresentação da empresa, texto. -->
    <hr>
        <div class="row m-1">
            <div class="col-md-8 p-0">
                <div class="text-center p-4">
                    <h4 class="mb-3">APRESENTAÇÃO</h4>
                    <!-- Dados contidos no campo 'ds_presentation' do banco de dados -->
                    <p class="mb-4"><?php echo $conteudo[0]['ds_presentation']?></p> 
                </div>
            </div>
            <div class="col-md-4 p-0">
                <!-- Painel rapido de contatos telefonicos -->
                <div class="card painel-direito text-center p-4">
                    <h4 id="black"><i class="fas fa-phone-square mr-2"></i>Fale conosco:</h4>
                    <div class="card m-2 pt-4 p-3 borda-painel">
                    <h5><label class="mb-0" id="black">Contato:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_1'])?></h5>
                    <?php if($conteudo[0]['cd_phone_2'] != ''):?>
                        <h5><label id="black">Ou:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_2'])?></h5>
                        <?php endif;?>
                    </div>
                    <div class="text-center mt-2"><p id="black"><i class="fas fa-envelope ml-2 mr-1"></i>Ou envie um e-mail direto <a href="?a=contatos">Aqui</a></p></div>
                </div>
                <?php if($conteudo[0]['lnk_map'] != ''):?>
                <!-- Painel rapido de localização/mapa -->
                <div class="card painel-direito text-center p-2 pt-4 mt-3">
                    <h4 id="black"><i class="fas fa-map-marked mr-2"></i>Nos encontre:</h4>
                    <div class="card mt-2">
                        <!-- iframe do mapa -->
                        <?php echo $conteudo[0]['lnk_map']?>
                    </div>
                    <!-- <div class="text-left mt-2 ml-1"><p id="black"><strong><i class="fas fa-thumbtack mr-1"></i>Endereço:</strong></p></div>     -->
                </div>
                <?php endif;?>
            </div>
        </div>
    <hr class="mb-1">
    <!-- Cards de texto -->
    <div class="row">
        <?php for($i = 0; $i <= count($card)-1; $i++):?>
            <!-- CARD-->
            <?php if(count($card) >= 3):?>
                <div class="col-md-4 col-sm-6 col-xs-12">
            <?php elseif(count($card) == 2):?>
                <div class="col-md-6 col-sm-6 col-xs-12">
            <?php else:?>
                <div class="col-md-12 col-sm-6 col-xs-12">
            <?php endif;?>
                <div class="panel panel-default text-center espaco-paineis">
                    <!-- Titulo carregado direto da base de dados -->
                    <p class="titulo-painel"><i id="gold" class="fas fa-star mr-2"></i><?php echo $card[$i]['ds_title']?></p>
                    <!-- Conteúdo carregado direto da base de dados -->
                    <div class="conteudo-baixo mb-3"><div><?php echo substr($card[$i]['ds_content'], 0, 225)?></div></div>
                    <div class="text-center p-0 ml-0">
                        <?php if(funcoes::VerificarLogin()):?>
                            <a href="#edit<?php echo $card[$i]['cd_card']?>" class="btn btn-outline-success p-2 mr-1" data-toggle="collapse" role="button" aria-expanded="false"><i class="fas fa-edit mr-1"></i>Edit</a>                    
                            <a href="?a=conteudo&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-primary p-2"><i class="fas fa-plus-square mr-2"></i>Mais</a>
                            <a href="?a=card_deletar&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-outline-danger p-2 ml-1"><i class="fas fa-trash mr-1"></i>Del</a>   
                            <div class="collapse" id="edit<?php echo $card[$i]['cd_card']?>"><hr>
                                <div class="text-left">
                                    <form action="?a=card_editar&card=<?php echo $card[$i]['cd_card']?>" method="POST">
                                        <div class="form-goup mt-2">
                                            <label><b>Título:</b></label>
                                            <input type="text" name="card_text_titulo" class="form-control" required>
                                        </div>
                                        <div class="form-goup mt-2">
                                            <label><b>Conteúdo:</b></label>
                                            <textarea type="text" name="card_text_content" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="text-right p-0 mr-0 mt-2"><button type="submit" class="btn btn-success">Aplicar</button></div>
                                    </form>
                                </div>
                            </div>
                        <?php else :?>
                            <a href="?a=conteudo&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-primary p-2"><i class="fas fa-plus-square mr-2"></i>Saiba mais</a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        <?php endfor;?>
    </div>
    <!-- Botão para adição de novos cards, limitados a quantidade maxima de 6. -->
    <?php if(funcoes::VerificarLogin()):?>
        <?php if(count($card) < 6):?>
        <div class="row text-right p-0 mt-2">
            <div class="col">
                <a href="?a=card_inserir" class="btn btn-success text-center mt-2">Adicinar novo card<i class="fas fa-plus-square mr-2 ml-2"></i></a>                   
            </div>
        </div>
        <?php else:?>
            <div class="row text-right p-0 mt-2 ">
                <div class="col">
                    Obs. Ja está no limite de <strong>6</strong> Cards.          
                </div>
            </div>
        <?php endif; ?>
    <?php endif;?>
    <!-- Noticias/Microforum -->
    <?php if(count($post) > 0):?>
    <hr>
    <div class="row borda-painel m-0">
        <div class="col p-0">
            <div class="card painel-direito"><div id="black" class="text-center mt-3 mb-2"><h5><i id="green" class="fas fa-comments mr-2"></i><label>NOTÍCIAS RECENTES</label></h5></div>
                <?php for($x = 0; $x < count($post); $x++):?>
                    <!-- Corpo da noticia -->
                    <div class="card text-left p-0 m-2">
                        <div class="p-2">
                            <div class="row p-0">
                                <div id="black" class="col-sm-6 text-left m-0"><h6><i id="green" class="fas fa-flag mr-2"></i><?php echo $post[$x]['ds_title']?> | <label id="grey"><?php echo $post[$x]['nm_autor']?> </label>                                
                                <?php if(funcoes::VerificarLogin()):?>
                                    <a class="ml-3" href="?a=post_editar&post=<?php echo $post[$x]['cd_post']?>">Editar</a> | <a href="?a=post_deletar&post=<?php echo $post[$x]['cd_post']?>">Apagar</a>
                                <?php endif;?></h6></div>                    
                                <div id="grey" class="col text-right mr-2"><h6><i class="far fa-clock mr-2"></i><?php echo $post[$x]['dt_register']?></h6></div>                               
                            </div><hr class="mb-1 mt-0">
                            <p><?php echo $post[$x]['ds_content']?></p>
                        </div>
                    </div><!-- Encerra corpo -->
                <?php endfor;?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <!-- Form para postar noticias -->
    <?php if(funcoes::VerificarLogin()):?>
        <hr><form class="p-0 mb-0" method="POST" action="?a=post_inserir">
            <div class="form-row">
                <div class="col-md-8 mt-1">
                    <label><b><i class="far fa-star mr-2"></i>Título:</b></label>
                    <input type="text" name="post_text_titulo" class="form-control" required>
                </div>
                <div class="col-md-4 mt-1">
                    <label><b><i class="far fa-user mr-2"></i>Autor:</b></label>
                    <input type="text" name="post_text_autor" class="form-control" value="<?php echo $_SESSION['nm_user']?>" required>
                </div>
            </div>
            <div class="form-goup mt-2">
                <label><b><i class="fas fa-file-alt mr-2"></i>Conteúdo:</b></label>
                <textarea type="text" name="post_text_content" class="form-control" rows="3" required></textarea>
            </div>
            <div class="text-right p-0 mr-0 mt-3"><button type="submit" class="btn btn-success">Postar<i class="fas fa-plus-square mr-2 ml-2"></i></button></div>
        </form>
    <?php endif;?>
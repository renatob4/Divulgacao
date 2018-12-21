<?php
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
    $link = $acesso->EXE_QUERY('SELECT * FROM tab_link');
    $endereco = $acesso->EXE_QUERY('SELECT * FROM tab_adress');
    $activity = $acesso->EXE_QUERY('SELECT * FROM tab_activity');

?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA CONTATOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2 borda-painel">
    <div class="col m-0 p-0">
        <div class="card p-0 m-0 shadow">
            <div class="row p-2 pb-0 m-0">
                <div class="col p-4">
                    <h5 id="green" class="text-center mb-3">COMO E ONDE NOS ENCONTRAR</h5><hr>
                    <?php if ($activity[0]['ds_activity'] != '' && $config[0]['st_activity'] == 1):?>
                    <h5>Estamos prontos para te atender! <?php echo $activity[0]['ds_activity']?></h5>
                    <?php else:?>
                    <h5>Estamos prontos para te atender!</h5>
                    <?php endif;?>
                    <div>
                    <?php if ($link[0]['ds_link_face'] != ''):?>
                    <i id="grey" class="fab fa-facebook-square mr-2"></i><label class="mt-2 mb-0">Facebook: </label> <a href="<?php echo $link[0]['ds_link_face']?>" target="_blank"><?php echo $link[0]['ds_link_face']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_twit'] != ''):?>
                    <i id="grey" class="fab fa-twitter-square mr-2"></i><label class="mt-0 mb-0">Twitter: </label> <a href="<?php echo $link[0]['ds_link_twit']?>" target="_blank"><?php echo $link[0]['ds_link_twit']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_insta'] != ''):?>
                    <i id="grey" class="fab fa-instagram mr-2"></i><label class="mt-0 mb-0">Instagram: </label> <a href="<?php echo $link[0]['ds_link_insta']?>" target="_blank"><?php echo $link[0]['ds_link_insta']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_linked'] != ''):?>
                    <i id="grey" class="fab fa-linkedin mr-2"></i><label class="mt-0 mb-0">LinkedIn: </label> <a href="<?php echo $link[0]['ds_link_linked']?>" target="_blank"><?php echo $link[0]['ds_link_linked']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_olx'] != ''):?>
                    <i id="grey" class="far fa-handshake mr-2"></i><label class="mt-0 mb-0">Instagram: </label> <a href="<?php echo $link[0]['ds_link_olx']?>" target="_blank"><?php echo $link[0]['ds_link_olx']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_market'] != ''):?>
                    <i id="grey" class="fas fa-shopping-cart mr-2"></i><label class="mt-0 mb-0">LinkedIn: </label> <a href="<?php echo $link[0]['ds_link_market']?>" target="_blank"><?php echo $link[0]['ds_link_market']?></a><br/>
                    <?php endif;?>
                </div>
            </div>
                <div class="col m-0 p-0">
                    <div class="painel-direito text-center altura p-3 m-0 shadow-strong">
                        <div class="flex-media">
                            <h4 id="black"><i id="white" class="fas fa-phone-square mr-2 mb-3 mt-2"></i>Fale conosco:</h4>
                            <div class="card m-2 p-3 borda-painel">
                                <label><label class="mb-0" id="black"><i id="grey" class="fas fa-phone mr-1"></i>Contato:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_1'])?></label>
                                <?php if ($conteudo[0]['cd_phone_2'] != ''):?>
                                <label><label id="black"><i id="grey" class="fab fa-whatsapp mr-1"></i>Ou:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_2'])?></label>
                                <?php endif;?>
                                <label><label id="black"><i id="grey" class="fas fa-at mr-1"></i>Email:</label> <?php echo $conteudo[0]['ds_email']?></label>                
                            </div>
                            <?php if ($endereco[0]['ds_adress'] != '' && $endereco[0]['ds_city'] != '' && $endereco[0]['cd_uf'] != '' && $config[0]['st_adress'] == 1):?>
                        </div>   
                        <div class="text-center">
                            <label id="black" class="mr-2"><strong><i id="white" class="fas fa-map-marker-alt mr-2"></i>Endereço:</strong></label>
                            <label id="white"><?php echo $endereco[0]['ds_adress']?>.  <?php echo $endereco[0]['ds_city']?> - <?php echo $endereco[0]['cd_uf']?></label>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Formulario para envio de mensagem pelo site -->
<div class="row mr-1 ml-1 mt-2 borda-painel">
    <div class="col m-0 p-0">
        <div class="card p-3 m-0 shadow">
            <h5 id="green" class="text-center mb-2 mt-3">NOS DEIXE UMA MENSAGEM</h5><hr>
            <div class="row">
                <div class="col-md-8 pl-3 p-3">
                    <form class="mt-0 pt-0 p-3 line shadow-strong" method="post" action="">
                        <div class="form-goup">
                            <label><b><i id="grey" class="fas fa-building mr-2"></i>Nome:</b></label>
                            <input type="text" name="" class="form-control" value="" required>
                        </div>
                        <div class="form-goup mt-4">
                            <label><b><i id="grey" class="fas fa-at mr-2"></i>E-mail:</b></label>
                            <input type="email" name="" class="form-control" value="" required>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-md-6 mt-1">
                                <label><b><i id="grey" class="fab fa-whatsapp mr-2"></i>Telefone/WhatsApp:</b></label>
                                <input type="tel" name="" class="form-control" value="" required>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label><b><i id="grey" class="fas fa-exclamation mr-2"></i>Assunto:</b></label>
                                <select class="form-control" name="" placeholder="Assunto" required>
                                <optgroup label="Categoria">
                                    <option value="Duvida" selected>Duvida</option>
                                    <option value="Critica">Critica</option>
                                    <option value="Sugestão">Sugestão</option>
                                    <option value="Interesse em produto">Interesse em produto</option>
                                    <option value="Interesse em serviço">Interesse em serviço</option>
                                </optgroup>
                            </select>
                            </div>
                        </div>
                        <div class="form-goup mt-4">
                            <label><b><i id="grey" class="fas fa-envelope-open mr-2"></i>Mensagem:</b></label>
                            <textarea type="text" name="" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-md-7 mt-2">
                                <label class=""><b><i id="grey" class="fas fa-question-circle mr-2"></i>Como nos conheceu?</b></label>
                                <select class="form-control" name="" placeholder="Assunto" required>
                                    <optgroup label="Categoria">
                                        <option value="" selected>Indicação de um amigo.</option>
                                        <option value="">Através do facebook ou outra rede social.</option>
                                        <option value="">Por meio de panfletos.</option>
                                        <option value="">Encontrei a loja presencialmente.</option>
                                        <option value="">Através do Google ou outro motor de busca.</option>
                                        <option value="">Ja sou cliente.</option>
                                        <option value="">Outros...</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-5 mt-2 text-center">
                                <label class="Obs3"><b>Por favor, resolva o captcha:</b></label>
                                <!-- Recapcha -->
                            </div>
                        </div>
                        <div class="form-row mt-5 p-0">
                            <div class="col-md-7 mt-3 text-center">
                                <label class="Obs3"><b>Deseja ficar por dentro de promoções futuras?</b></label>
                                <div class="row pr-5 pl-5">
                                    <div class="col text-center"><label class="radio-inline"><input type="radio" name="optradio" checked>Sim</label></div>
                                    <div class="col text-center"><label class="radio-inline"><input type="radio" name="optradio">Não</label></div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-1">
                                <div class="text-center mt-4">
                                    <input class="btn btn-success borda-painel mb-4" type="submit" value="Enviar mensagem"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 p-3">
                    <div class="text-center"><img class="img-fluid" src="images/mensagem.png"></div>
                    <label id="green" class="mt-5 text-center"><i class="fas fa-exclamation-circle mr-2">
                    </i>Obs. Preencha todos os campos corretamente para que possamos entrar em contato o mais breve possivel. Obrigado pelo interesse!.
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
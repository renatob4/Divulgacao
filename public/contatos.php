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
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA CONTATOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2 borda-painel">
    <div class="col m-0 p-0">
        <div class="card p-0 m-0 shadow">
            <div class="row p-2 pb-0 m-0">
                <div class="col p-4">
                    <h5 id="green" class="text-center mb-3">COMO E ONDE NOS ENCONTRAR</h5><hr>
                    <h6>Estamos prontos para te atender das 10h as 18h de Segunda a Sábado.</h6>
                    <div>
                    <?php if ($link[0]['ds_link_face'] != ''):?>
                    <i id="grey" class="fab fa-facebook-square mr-2"></i><label class="mt-2 mb-0">Facebook: </label> <a href="<?php echo $link[0]['ds_link_face']?>"><?php echo $link[0]['ds_link_face']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_twit'] != ''):?>
                    <i id="grey" class="fab fa-twitter-square mr-2"></i><label class="mt-0 mb-0">Twitter: </label> <a href="<?php echo $link[0]['ds_link_twit']?>"><?php echo $link[0]['ds_link_twit']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_insta'] != ''):?>
                    <i id="grey" class="fab fa-instagram mr-2"></i><label class="mt-0 mb-0">Instagram: </label> <a href="<?php echo $link[0]['ds_link_insta']?>"><?php echo $link[0]['ds_link_insta']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_linked'] != ''):?>
                    <i id="grey" class="fab fa-linkedin mr-2"></i><label class="mt-0 mb-0">LinkedIn: </label> <a href="<?php echo $link[0]['ds_link_linked']?>"><?php echo $link[0]['ds_link_linked']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_olx'] != ''):?>
                    <i id="grey" class="far fa-handshake mr-2"></i><label class="mt-0 mb-0">Instagram: </label> <a href="<?php echo $link[0]['ds_link_olx']?>"><?php echo $link[0]['ds_link_olx']?></a><br/>
                    <?php endif;?>
                    <?php if ($link[0]['ds_link_market'] != ''):?>
                    <i id="grey" class="fas fa-shopping-cart mr-2"></i><label class="mt-0 mb-0">LinkedIn: </label> <a href="<?php echo $link[0]['ds_link_market']?>"><?php echo $link[0]['ds_link_market']?></a><br/>
                    <?php endif;?>
                </div>
            </div>
                <div class="col m-0 p-0">
                    <div class="painel-direito text-center altura p-3 m-0">
                        <h4 id="black"><i id="white" class="fas fa-phone-square mr-2 mb-3"></i>Fale conosco:</h4>
                        <div class="card m-2 p-3 text-left borda-painel">
                            <h5><label class="mb-0" id="black"><i id="grey" class="fas fa-phone mr-1"></i>Contato:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_1'])?></h5>
                            <?php if ($conteudo[0]['cd_phone_2'] != ''):?>
                            <h5><label id="black"><i id="grey" class="fab fa-whatsapp mr-1"></i>Ou:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_2'])?></h5>
                            <?php endif;?>
                            <h5><label id="black"><i id="grey" class="fas fa-at mr-1"></i>Email:</label> <?php echo $conteudo[0]['ds_email']?></h5>                
                        </div>
                        <p id="black" class="text-left ml-2"><strong><i id="white" class="fas fa-map-marker-alt mr-2"></i>Endereço:</strong></p>
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
                    <form class="mt-0 pt-0 p-3 line" method="post" action="">
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
                                <label><b><i id="grey" class="fas fa-question-circle mr-2"></i>Assunto:</b></label>
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
                        <div class="text-center mt-4">
                            <input class="btn btn-success" type="submit" value="Enviar mensagem"/>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 p-3">
                    <div class="text-center"><img class="img-fluid" src="images/mensagem.png"></div>
                    <label id="green" class="mt-5 text-center"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Preencha todos os campos corretamente para que possamos entrar em contato o mais breve possivel.</label>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT ds_email, cd_phone_1, cd_phone_2 FROM tab_content');
    $link = $acesso->EXE_QUERY('SELECT * FROM tab_link');
    $endereco = $acesso->EXE_QUERY('SELECT ds_adress, ds_city, cd_uf FROM tab_adress');
    $activity = $acesso->EXE_QUERY('SELECT ds_activity FROM tab_activity');
    $config = $acesso->EXE_QUERY('SELECT st_adress, st_activity FROM tab_config');

    $resposta = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Tratamento reCAPTCHA
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $respon = $_POST['g-recaptcha-response'];

        $data = array('secret' => "6LdQZYQUAAAAAJ0NbPhpWGikmpVES57JKmQVLQAJ", 'response' => $respon);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsom = json_decode($result);

        // Se o Recaptcha for resolvido com sucesso então o email é enviado.
        if ($jsom->success) {

            //captura dos dados do formulário.
            $text_client = funcoes::TratarCampo($_POST['nm_client']);
            $text_email = funcoes::TratarCampo($_POST['ds_email']);
            $text_tel = funcoes::TratarCampo($_POST['cd_tel']);
            $text_subject = funcoes::TratarCampo($_POST['ds_subject']);
            $text_message = funcoes::TratarCampo($_POST['ds_message']);
            $text_interview = funcoes::TratarCampo($_POST['ds_interview']);

            // Receber emails promocionais SELECT
            $select = $_POST['optradio'];

            //======================================================================================

            $email = new emails();
            //preparação dos dados e do corpo do email.
            $temp = [
                $conteudo[0]['ds_email'],
                $text_subject,
                "<div style='background-color: aliceblue; padding: 20px;border: 1px solid black'>
                <h4 style='color:green;'>Nova mensagem de cliente! <label style='color:black;'>- $text_subject</label></h4>
                <hr>
                <h5 style='color:black;'>Nome do cliente: <label style='font-weight:normal;color:grey;'>$text_client</label></h5>
                <h5 style='color:black;'>Email do cliente: <label style='font-weight:normal;color:grey;'>$text_email</label></h5>
                <h5 style='color:black;'>Contato do cliente: <label style='font-weight:normal;color:grey;'>$text_tel</label></h5>
                <hr>
                <h5 style='color:black;'>Onde ele nos encontrou: <label style='font-weight:normal;color:grey;'>$text_interview</label></h5>
                <div style='border: 2px solid green; padding: 10px;'>
                <h5>Mensagem: <label style='font-weight:normal;color:grey;'>$text_message</label></h5>
                </div>
                </div>",
                $text_client
            ];
            //enviar o email
            $resposta = $email->EnviarMensagem($temp);

            //======================================================================================
            
            // Procedimento interno para armazenar clientes prospects no banco.
            if($select == 'S'){

                $data = new DateTime();
                $parametros = [
                    ':ds_email'    => $text_email
                ];
                $dados = $acesso->EXE_QUERY('SELECT nm_prospect FROM tab_prospect WHERE ds_email = :ds_email', $parametros);

                if(count($dados) == 0){
                    $parametros = [
                        ':nm_prospect'         => strtoupper($text_client),
                        ':ds_email'            => $text_email,
                        ':cd_phone'            => $text_tel,
                        ':ds_channel'          => $text_interview,
                        ':dt_register'         => $data->format('Y-m-d H:i:s')
                    ];
                    //inserir cliente prospect na base.
                    $acesso->EXE_NON_QUERY('INSERT INTO tab_prospect(nm_prospect, ds_email, cd_phone, ds_channel, dt_register)
                                            VALUES(:nm_prospect, :ds_email, :cd_phone, :ds_channel, :dt_register)', $parametros);
                }

                //Log
                funcoes::CriarLOG('Novo cliente prospect capturado.', $_SESSION['nm_user']);
            }

            //Resultado das operações.
            if($resposta){
                $_SESSION['resultado'] = "Mensagem enviada com sucesso!";
                //header("Location:?a=home");

                //Log
                funcoes::CriarLOG('Nova mensagem enviada com sucesso pela página de contatos.', 'Cliente');

                echo('<meta http-equiv="refresh" content="0;URL=?a=contatos">');
                exit();
            }else{
                $_SESSION['resultado'] = "Falha ao enviar sua mensagem.";
                //header("Location:?a=home");

                //Log
                funcoes::CriarLOG('Tentativa de envio de mensagem pela página de contatos falhou.', 'Cliente');

                echo('<meta http-equiv="refresh" content="0;URL=?a=contatos">');
                exit();
            }

        } else {
            //Log
            funcoes::CriarLOG('Submeteu sem o recaptcha.', 'Cliente');
            $_SESSION['resultado'] = "Por gentileza, resolva o reCaptcha para sabermos que você não é um robô.";
            //header("Location:?a=home");
            echo('<meta http-equiv="refresh" content="0;URL=?a=contatos">');
            exit();
        }
    }
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA CONTATOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2">
    <div class="col m-0 p-0">
        <div class="card p-0 m-0 shadow-strong borda-painel">
            <div class="row p-2 pb-0 m-0">
                <div class="col p-4">
                    <h5 id="green" class="text-center mb-3">COMO E ONDE NOS ENCONTRAR</h5><hr>
                    <?php if ($activity[0]['ds_activity'] != '' && $config[0]['st_activity'] == 1):?>
                    <h5 class="wrap">Estamos prontos para te atender! <?php echo $activity[0]['ds_activity']?></h5>
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
                        <?php if ($link[0]['ds_link_ytb'] != ''):?>
                        <i id="red" class="fab fa-youtube mr-2"></i><label class="mt-0 mb-0 mt-3">Youtube: </label> <a href="<?php echo $link[0]['ds_link_ytb']?>" target="_blank"><label class="yt"><?php echo $link[0]['ds_link_ytb']?></label></a><br/>
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
                        </div>
                        <?php if ($endereco[0]['ds_adress'] != '' && $endereco[0]['ds_city'] != '' && $endereco[0]['cd_uf'] != '' && $config[0]['st_adress'] == 1):?>
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
<div class="row mr-1 ml-1 mt-3">
    <div class="col m-0 p-0">
        <div class="card p-0 m-0 pt-3 shadow-strong borda-painel">
            <h5 id="green" class="text-center mb-2 mt-3">NOS DEIXE UMA MENSAGEM</h5><hr class="ml-3 mr-3">
            <div class="row pr-3 pl-3">
                <div class="col-md-8 p-3">
                    <form class="mt-0 pt-0 p-3 line shadow-strong" method="post" action="?a=contatos">
                        <div class="form-goup">
                            <label><b><i id="grey" class="far fa-address-book mr-2"></i>Nome:</b></label>
                            <input type="text" name="nm_client" class="form-control" maxlength="50" required>
                        </div>
                        <div class="form-goup mt-4">
                            <label><b><i id="grey" class="fas fa-at mr-2"></i>E-mail:</b></label>
                            <input type="email" name="ds_email" class="form-control" maxlength="50" required>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-md-6 mt-1">
                                <label><b><i id="grey" class="fab fa-whatsapp mr-2"></i>Telefone/WhatsApp:</b></label>
                                <input type="tel" name="cd_tel" class="form-control" maxlength="20" required>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label><b><i id="grey" class="fas fa-exclamation mr-2"></i>Assunto:</b></label>
                                <select class="form-control" name="ds_subject" maxlength="20" required>
                                <optgroup label="Categoria">
                                    <option value="Duvida">Duvida</option>
                                    <option value="Critica">Critica</option>
                                    <option value="Sugestão">Sugestão</option>
                                    <option value="Interesse em produto">Interesse em Produto</option>
                                    <option value="Interesse em serviço">Interesse em Serviço</option>
                                    <option value="Interesse em serviço" selected>Outro..</option>
                                </optgroup>
                            </select>
                            </div>
                        </div>
                        <div class="form-goup mt-4">
                            <label><b><i id="grey" class="fas fa-envelope-open mr-2"></i>Mensagem:</b></label>
                            <textarea type="text" name="ds_message" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-md-7 mt-2">
                                <label class=""><b><i id="grey" class="fas fa-question-circle mr-2"></i>Como nos conheceu?</b></label>
                                <select class="form-control" name="ds_interview" placeholder="Assunto" maxlength="50" required>
                                    <optgroup label="Categoria">
                                        <option value="Indicação de um amigo.">Indicação de um amigo.</option>
                                        <option value="Através do facebook ou outra rede social.">Através do facebook ou de outra rede social.</option>
                                        <option value="Por meio de panfletos.">Por meio de panfletos.</option>
                                        <option value="Encontrei a loja presencialmente.">Encontrei a loja presencialmente.</option>
                                        <option value="Através do Google ou outro motor de busca.">Através do Google ou outro motor de busca.</option>
                                        <option value="Ja sou cliente.">Ja sou cliente.</option>
                                        <option value="Outros..." selected>Outros..</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-5 mt-2 text-center">
                                <label class="Obs3"><b>Por favor, resolva o captcha:</b></label>
                                <!-- Recapcha -->
                                <div class="g-recaptcha cap mt-1" data-sitekey="6LdQZYQUAAAAADpC60g28DqxTeKYX1npukOXTe9L"></div>
                            </div>
                        </div>
                        <div class="form-row mt-5 p-0">
                            <div class="col-md-7 text-center">
                                <label class="Obs3"><b>Deseja receber emails com promoções futuras?</b></label>
                                <div class="row pr-5 pl-5">
                                    <div class="col text-center"><label class="radio-inline"><input type="radio" name="optradio" value="S" checked>Sim</label></div>
                                    <div class="col text-center"><label class="radio-inline"><input type="radio" name="optradio" value="N">Não</label></div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-0">
                                <div class="text-center">
                                    <input class="btn btn-success borda-painel mb-4 p-4 shadow" type="submit" value="Enviar mensagem"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 p-3">
                    <div class="text-center"><figure><img class="img-fluid" src="images/mensagem.png"></figure></div>
                    <label id="grey" class="mt-5 text-center"><i class="fas fa-exclamation-circle mr-2">
                    </i>Obs. Preencha todos os campos corretamente para que possamos entrar em contato o mais breve possivel. Obrigado pelo interesse!.
                    </label>
                    <!-- Verifica se o script cadastro_produtos retornou resultado. -->
                    <?php if(isset($_SESSION['resultado'])):?>
                        <!-- Se o resultado guardado na variavel de sessao reg-product tiver um final "!", ou seja, um codigo de sucesso, então a classe do alerta será success -->
                        <div id="resultado" class="<?php echo (substr($_SESSION['resultado'], -1) == '!') ? 'alert alert-success text-center mt-2 mb-2 pt-4 pb-4' : 'alert alert-danger text-center mt-2 mb-2 pt-4 pb-4';?>"><?php echo $_SESSION['resultado']?></div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    //Reinicia a variavel de resposta.
    if(isset($_SESSION['resultado'])){
        unset($_SESSION['resultado']);
    }
?>
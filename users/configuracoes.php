<?php
    // ==========================================================
    // PERFIL - Configurações e conteúdo
    // ==========================================================
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }

    //Vai buscar todas as informações do utilizador
    $gestor = new cl_gestorBD();
    $data = new DateTime();

    $parametros = [
        ':cd_login'    =>  $_SESSION['cd_login']
    ];
    $user = $gestor->EXE_QUERY('SELECT * FROM tab_user WHERE cd_login = :cd_login', $parametros);

    //Busca o conteúdo da base de dados.
    $conteudo = $gestor->EXE_QUERY('SELECT * FROM tab_content');
    $link = $gestor->EXE_QUERY('SELECT * FROM tab_link');
    $config = $gestor->EXE_QUERY('SELECT * FROM tab_config');
    $endereco = $gestor->EXE_QUERY('SELECT * FROM tab_adress');
    $atividade = $gestor->EXE_QUERY('SELECT * FROM tab_activity');
    $code = $gestor->EXE_QUERY('SELECT * FROM tab_code');
 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Buscando os valores do form tab_content
        $empresa = funcoes::TratarCampo($_POST['form_nm_company']);
        //Busca e tratamento do form Apresentação do site
        $apresentacao = $_POST['form_ds_presentation'];
        $apresentacao = str_replace('"', "'", $apresentacao);

        $email = funcoes::TratarCampo($_POST['form_ds_email']);
        $doc = funcoes::TratarCampo($_POST['form_ds_document']);
        $tel1 = funcoes::TratarCampo($_POST['form_cd_tel1']);
        $tel2 = funcoes::TratarCampo($_POST['form_cd_tel2']);
        $rodape = funcoes::TratarCampo($_POST['form_ds_footer']);
        $activity = funcoes::TratarCampo($_POST['form_ds_activity']);

        //Buscando os valores do form tab_link
        $face = funcoes::TratarCampo($_POST['form_lnk_face']);
        $twitter = funcoes::TratarCampo($_POST['form_lnk_twit']);
        $linkedin = funcoes::TratarCampo($_POST['form_lnk_link']);
        $instagram = funcoes::TratarCampo($_POST['form_lnk_inst']);
        $olx = funcoes::TratarCampo($_POST['form_lnk_olx']);
        $market = funcoes::TratarCampo($_POST['form_lnk_mark']);
        $youtube = funcoes::TratarCampo($_POST['form_lnk_ytb']);

        //Buscando os valores do form tab_adress
        $adress = funcoes::TratarCampo($_POST['form_ds_endereco']);
        $cidade = funcoes::TratarCampo($_POST['form_ds_cidade']);
        $estado = funcoes::TratarCampo($_POST['form_ds_estado']);

        //Buscando dados dos checkboxes
        $check_contact = (isset($_POST['check_contact'])) ? 1 : 0;
        $check_map  = (isset($_POST['check_map']))  ? 1 : 0;
        $check_doc = (isset($_POST['check_document'])) ? 1 : 0;
        $check_card  = (isset($_POST['check_card']))  ? 1 : 0;
        $check_post = (isset($_POST['check_post'])) ? 1 : 0;
        $check_product = (isset($_POST['check_product'])) ? 1 : 0;
        $check_service = (isset($_POST['check_service'])) ? 1 : 0;
        $check_comment = (isset($_POST['check_comment'])) ? 1 : 0;
        $check_adress = (isset($_POST['check_adress'])) ? 1 : 0;
        $check_activity = (isset($_POST['check_activity'])) ? 1 : 0;
        $check_page = (isset($_POST['check_page'])) ? 1 : 0;
        $check_promotion = (isset($_POST['check_promotion'])) ? 1 : 0;

        //Get e tratamento do link do mapa inserido no campo.
        $mapa = $_POST['form_lnk_map'];
        $mapa = str_replace('"', "'", $mapa);

        //Get e tratamento do script do facebook inserido no campo.
        $appid = $_POST['app_id'];
        $script = $_POST['form_lnk_script'];
        $script = str_replace('"', "'", $script);
        
        //Atualiza a base de dados TAB_CONTENT =====================================
        $parametros = [
            ':cd_info'          => $conteudo[0]['cd_info'],
            ':nm_company'       => $empresa,
            ':ds_presentation'  => $apresentacao,
            ':ds_email'         => $email,
            ':ds_document'      => $doc,
            ':cd_phone_1'       => $tel1,
            ':cd_phone_2'       => $tel2,
            ':ds_text_footer'   => $rodape,
            ':lnk_map'          => $mapa,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_content SET
             nm_company = :nm_company,
             ds_presentation = :ds_presentation,
             ds_email = :ds_email,
             ds_document = :ds_document,
             cd_phone_1 = :cd_phone_1,
             cd_phone_2 = :cd_phone_2,
             ds_text_footer = :ds_text_footer,
             lnk_map = :lnk_map,
             dt_updated = :dt_updated
             WHERE cd_info = :cd_info',
            $parametros
        );

        //Atualiza a base de dados TAB_ADRESS =====================================
        $parametros = [
            ':cd_adress'        => $endereco[0]['cd_adress'],
            ':ds_adress'        => $adress,
            ':ds_city'          => $cidade,
            ':cd_uf'            => $estado,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_adress SET
            ds_adress = :ds_adress,
            ds_city = :ds_city,
            cd_uf = :cd_uf,
            dt_updated = :dt_updated
            WHERE cd_adress = :cd_adress',
            $parametros
        );

        //Atualiza a base de dados TAB_ACTIVITY =====================================
        $parametros = [
            ':cd_activity'      => $atividade[0]['cd_activity'],
            ':ds_activity'      => $activity,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_activity SET
            ds_activity = :ds_activity,
            dt_updated = :dt_updated
            WHERE cd_activity = :cd_activity',
            $parametros
        );

        //Atualiza a base de dados TAB_CODE =====================================
        $parametros = [
            ':cd_code'          => $code[0]['cd_code'],
            ':lnk_script'       => $script,
            ':id_app'           => $appid,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_code SET
            lnk_script = :lnk_script,
            id_app = :id_app,
            dt_updated = :dt_updated
            WHERE cd_code = :cd_code',
            $parametros
        );

        //Atualiza a base de dados TAB_LINK =======================================
        $parametros = [
            ':cd_link'          => $link[0]['cd_link'],
            ':ds_link_face'     => $face,
            ':ds_link_twit'     => $twitter,
            ':ds_link_linked'   => $linkedin,
            ':ds_link_insta'    => $instagram,
            ':ds_link_olx'      => $olx,
            ':ds_link_market'   => $market,
            ':ds_link_ytb'      => $youtube,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_link SET
             ds_link_face = :ds_link_face,
             ds_link_twit = :ds_link_twit,
             ds_link_linked = :ds_link_linked,
             ds_link_insta = :ds_link_insta,
             ds_link_olx = :ds_link_olx,
             ds_link_market = :ds_link_market,
             ds_link_ytb = :ds_link_ytb,
             dt_updated = :dt_updated
             WHERE cd_link = :cd_link',
            $parametros
        );

        //Atualiza a base de dados TAB_CONFIG =======================================
        $parametros = [
            ':cd_config'            => $config[0]['cd_config'],
            ':st_contact'           => $check_contact,
            ':st_service'           => $check_service,
            ':st_product'           => $check_product,
            ':st_promotion'         => $check_promotion,
            ':st_adress'            => $check_adress,
            ':st_activity'          => $check_activity,
            ':st_comment'           => $check_comment,
            ':st_fbpage'            => $check_page,
            ':st_map'               => $check_map,
            ':st_document'          => $check_doc,
            ':st_card'              => $check_card,
            ':st_post'              => $check_post,
            ':dt_updated'           => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
        'UPDATE tab_config SET
            st_contact = :st_contact,
            st_service = :st_service,
            st_product = :st_product,
            st_promotion = :st_promotion,
            st_adress = :st_adress,
            st_activity = :st_activity,
            st_comment = :st_comment,
            st_fbpage = :st_fbpage,
            st_map = :st_map,
            st_document = :st_document,
            st_card = :st_card,
            st_post = :st_post,
            dt_updated = :dt_updated
            WHERE cd_config = :cd_config',
            $parametros
        );

        //Log
        funcoes::CriarLOG('Conteúdo do site atualizado com sucesso!', $_SESSION['nm_user']);

        //$conteudo = $gestor->EXE_QUERY('SELECT * FROM tab_content');
        //header('Location:?a=configuracoes');
        echo('<meta http-equiv="refresh" content="0;URL=?a=configuracoes">');
        exit();
    }
?>
<div class="container m-0 p-0">
    <div class="row mr-1 ml-1 mt-2 borda-painel shadow-strong">
        <div class="col card p-3">
            <h5 id="green" class="text-center">PERFIL DE UTILIZADOR</h5><hr>
            <!--DADOS DO UTILIZADOR-->
            <h5 class="mb-5 mt-3"><i id="grey" class="fa fa-user mr-2" aria-hidden="true"></i><?php echo $user[0]['nm_user']?></h5>
            <h5 class="mb-3"><i class="far fa-id-badge mr-2" aria-hidden="true"></i>Login:  <label id="grey"><?php echo $user[0]['cd_login']?></label><a href="?a=perfil_alterar_login" class="btn btn-outline-success m-0 ml-3 shadow"><i class="fas fa-edit"></i></a></h5>
            <h5 class="mb-3"><i class="fa fa-key mr-2" aria-hidden="true"></i>Senha:  <label id="grey"><?php echo str_repeat("*", 6)?></label><a href="?a=perfil_alterar_senha" class="btn btn-outline-success m-0 ml-3 shadow"><i class="fas fa-edit"></i></a></h5>
            <h5 class="mb-3"><i class="fa fa-envelope mr-2" aria-hidden="true"></i>Email:  <label id="grey"><?php echo $user[0]['ds_email']?></label><a href="?a=perfil_alterar_email" class="btn btn-outline-success m-0 ml-3 shadow"><i class="fas fa-edit"></i></a></h5>
        </div>
    </div>
    <div class="row mr-1 ml-1 mt-3 borda-painel shadow-strong">
        <div class="col card p-3">
            <!-- Formulario para edição do conteudo do site -->
            <div class="text-left">
                <h5 id="green" class="text-center mb-4">GERENCIAR CONTEÚDO</h5><hr class="mt-0">
                <form method="POST" action="?a=configuracoes">
                    <div class="form-row">
                        <div class="col-md-6 mt-1">
                            <label><b><i id="grey" class="fas fa-building mr-2"></i>Nome/Apelido da Empresa:</b></label>
                            <input type="text" name="form_nm_company" class="form-control shadow" maxlength="16" value="<?php echo $conteudo[0]['nm_company']?>" required>
                        </div>
                        <div class="col-md-6 mt-1">
                            <label><b><i id="grey" class="fas fa-passport mr-2"></i>DOC/CNPJ:</b></label>
                            <input type="text" name="form_ds_document" class="form-control shadow" maxlength="18" value="<?php echo $conteudo[0]['ds_document']?>">
                            <div class="text-center"><label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe este campo em branco se não quiser que ele apareça no Site.</label></div>
                        </div>      
                    </div>
                    <div class="form-goup mt-4">
                        <label><b><i id="grey" class="fas fa-file-alt mr-2"></i>Apresentação:</b></label>
                        <textarea type="text" name="form_ds_presentation" class="form-control shadow" maxlength="1000" rows="6" required><?php echo $conteudo[0]['ds_presentation']?></textarea>
                        <div class="text-center"><label class="Obs2 mt-1"><i class="fas fa-exclamation-triangle mr-2"></i>Obs. Este campo aceita um link de imagem em formato html aconselhavel: 650x250px.</label></div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-md-6 mt-1">
                            <label><b><i id="grey" class="fas fa-phone-square mr-2"></i>Telefone 1:</b></label>
                            <input type="tel" name="form_cd_tel1" class="form-control shadow" maxlength="20" value="<?php echo $conteudo[0]['cd_phone_1']?>" required>
                            <div class="text-center"><label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Desmarque os contatos no fim da pagina se não quiser que ele apareça no Site.</label></div>
                        </div>
                        <div class="col-md-6 mt-1">
                            <label><b><i id="grey" class="fab fa-whatsapp mr-2"></i>Telefone 2:</b></label>
                            <input type="tel" name="form_cd_tel2" class="form-control shadow" maxlength="20" value="<?php echo $conteudo[0]['cd_phone_2']?>">
                            <div class="text-center"><label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe este campo em branco ou desmarque se não quiser que ele apareça no Site.</label></div>
                        </div>
                    </div>
                    <div class="form-goup mt-4">
                        <label><b><i id="grey" class="fas fa-at mr-2"></i>E-mail:</b></label>
                        <input type="email" name="form_ds_email" class="form-control shadow" maxlength="50" value="<?php echo $conteudo[0]['ds_email']?>" required>
                    </div>
                    <div class="form-goup mt-4">
                        <label><b><i id="grey" class="fas fa-book mr-2"></i>Texto do rodapé:</b></label>
                        <textarea type="text" name="form_ds_footer" class="form-control shadow" maxlength="254" rows="3" required><?php echo $conteudo[0]['ds_text_footer']?></textarea>
                    </div>
                    <div class="form-goup mt-4">
                        <label><b><i id="grey" class="fas fa-business-time mr-2"></i>Descreva o seu horario de funcionamento: <label class="file" id="grey">(Ex. Segunda a sexta das 8hrs ás 19hrs.)</label></b></label></b></label>
                        <input type="text" name="form_ds_activity" class="form-control shadow" maxlength="64" value="<?php echo $atividade[0]['ds_activity']?>">
                        <div class="text-center"><label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Se este campo estiver vazio os horarios nao aparecerão no site.</label></div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-md-6 mt-1">
                            <label><b><i id="grey" class="fas fa-map-marker mr-2"></i>Endereço:</b></label>
                            <input type="text" name="form_ds_endereco" class="form-control shadow" maxlength="60" value="<?php echo $endereco[0]['ds_adress']?>">
                        </div>
                        <div class="col-md-4 mt-1">
                            <label><b>Cidade:</b></label>
                            <input type="text" name="form_ds_cidade" class="form-control shadow" maxlength="50" value="<?php echo $endereco[0]['ds_city']?>">
                        </div> 
                        <div class="col-md-2 mt-1">
                            <label><b>UF:</b></label>
                            <select class="form-control shadow" maxlength="30" name="form_ds_estado">
                                <optgroup label="Categoria">
                                    <?php if($endereco[0]['cd_uf'] != ''):?>
                                    <option class="alert alert-success" value="<?php echo $endereco[0]['cd_uf']?>" selected><strong><?php echo $endereco[0]['cd_uf']?></strong></option>
                                    <?php endif;?>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espirito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="text-center"><label class="Obs ml-1 mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe estes campos em branco se não quiser que ele apareçam no Site.</label></div>
                    <div class="form-goup mt-4">
                        <label><b><i id="grey" class="fas fa-map-marker-alt mr-2"></i>Mapa: <label class="file" id="grey">(Tag do tipo iframe.)</label></b></label>
                        <input type="text" name="form_lnk_map" class="form-control shadow" value="<?php echo $conteudo[0]['lnk_map']?>">
                        <div class="text-center"><label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe este campo em branco ou desmarque no fim da pagina se não quiser que o mapa apareça no Site.</label></div>
                    </div>
                    <hr class=""><h5 id="green" class="text-center mb-4">GERENCIAR LINKS</h5>
                    <div class="card m-3 p-2 pt-3 shadow">
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="fab fa-facebook-square mr-2"></i>Facebook:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_face" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_face']?>">
                            </div>
                        </div>
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="fab fa-twitter-square mr-2"></i>Twitter:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_twit" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_twit']?>">
                            </div>
                        </div>
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="fab fa-linkedin mr-2"></i>LinkedIn:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_link" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_linked']?>">
                            </div>
                        </div>
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="fab fa-instagram mr-2"></i>Instagram:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_inst" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_insta']?>">
                            </div>
                        </div>
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="far fa-handshake mr-2"></i>OLX:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_olx" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_olx']?>">
                            </div>
                        </div>
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="fas fa-shopping-cart mr-2"></i>Mercado Livre:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_mark" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_market']?>">
                            </div>
                        </div>
                        <div class="form-group row pr-3">
                            <label class="col-sm-2 col-form-label p-0 ml-3"><b><i id="grey" class="fab fa-youtube mr-2"></i>Canal Youtube:</b></label>
                            <div class="col">
                                <input type="text" name="form_lnk_ytb" class="form-control p-0 ml-3 line" maxlength="120" value="<?php echo $link[0]['ds_link_ytb']?>">
                            </div>
                        </div>
                        <div class="text-center"><label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe em branco os links que não quiser que apareçam no Site.</label></div>     
                    </div>
                    <hr class=""><h5 id="green" class="text-center mb-3">CONFIGURAÇÕES DE EXIBIÇÃO</h5>
                    <div class="card m-3 pr-2 shadow">
                        <div class="form-check form-inline linegrey ml-2 mb-2 mt-3">
                            <input class="form-check-input" name="check_contact" type="checkbox" id="Check1" <?php echo $config[0]['st_contact'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-phone ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check1">Exibir contatos na pagina inicial.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_map" type="checkbox" id="Check2" <?php echo $config[0]['st_map'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-map-marked ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check2">Exibir mapa na pagina inicial.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_adress" type="checkbox" id="Check3" <?php echo $config[0]['st_adress'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-map-marker ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check3">Exibir endereço na pagina de contatos.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_activity" type="checkbox" id="Check4" <?php echo $config[0]['st_activity'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-business-time ml-2 mr-2"></i>
                            <label class="form-check-label" for="Check4">Exibir horario de funcionamento na pagina de contatos.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_document" type="checkbox" id="Check5" <?php echo $config[0]['st_document'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-book ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check5">Exibir documento/cnpj no rodapé.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_card" type="checkbox" id="Check6" <?php echo $config[0]['st_card'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-star ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check6">Exibir sessão de cards na pagina inicial.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_post" type="checkbox" id="Check7" <?php echo $config[0]['st_post'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-flag ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check7">Exibir sessão de posts na pagina inicial.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_product" type="checkbox" id="Check8" <?php echo $config[0]['st_product'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-shopping-cart ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check8">Exibir pagina de Produtos.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_service" type="checkbox" id="Check9" <?php echo $config[0]['st_service'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-wrench ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check9">Exibir pagina de Serviços.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_promotion" type="checkbox" id="Check10" <?php echo $config[0]['st_promotion'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-percentage ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check10">Exibir pagina e mecânismo de Promoções.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-2">
                            <input class="form-check-input" name="check_comment" type="checkbox" id="Check11" <?php echo $config[0]['st_comment'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fas fa-comment ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check11">Exibir plugin de comentarios do facebook.</label>
                        </div>
                        <div class="form-check form-inline linegrey ml-2 mb-3">
                            <input class="form-check-input" name="check_page" type="checkbox" id="Check12" <?php echo $config[0]['st_fbpage'] == 1 ? 'checked' : '';?>>
                            <i id="blue" class="fab fa-facebook-square ml-2 mr-3"></i>
                            <label class="form-check-label" for="Check12">Exibir pagina do facebook no rodapé.</label><label class="Obs3 mt-1 ml-2 mb-1">Obs. Para o componente funcionar o link do facebook fornecido deve ser do tipo Página Comercial.</label>
                        </div>
                    </div>
                    <div class="text-right mr-3">
                        <i id="grey" class="fas fa-wrench mr-2"></i><a data-toggle="collapse" href="#dev" id="green" role="button" aria-expanded="false" aria-controls="collapseExample">Configurações de desenvolvedor</a>
                        <div class="collapse text-left" id="dev">
                            <div class="form-row mt-2">
                                <div class="col-md-8 mt-1">
                                    <label><b><i id="grey" class="fas fa-code mr-2"></i>Script de plugins facebook:</b></label>
                                    <input type="text" name="form_lnk_script" class="form-control shadow" value="<?php echo $code[0]['lnk_script']?>">
                                </div>
                                <div class="col-md-4 mt-1">
                                    <label><b><i id="grey" class="fas fa-key mr-2"></i>App ID:</b></label>
                                    <input type="text" name="app_id" class="form-control shadow" value="<?php echo $code[0]['id_app']?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Botões voltar e aplicar alterações -->
                    <div class="text-center">
                        <hr><a href="?a=home" class="btn btn-primary btn-size-150 shadow m-2"><i class="fas fa-arrow-circle-left mr-2"></i>Voltar</a>
                        <button type="submit" class="btn btn-success shadow">Aplicar alterações<i class="fas fa-edit ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
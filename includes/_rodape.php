<?php
    //======================== RODAPÉ ============================
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
    $link = $acesso->EXE_QUERY('SELECT * FROM tab_link');
    $code = $acesso->EXE_QUERY('SELECT * FROM tab_code');
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');
?>
<!-- Rodapé-->
<div class="container rodape mt-3">
    <div class="row">
        <div class="col-sm-8 col-12">
            <div class="ml-1">
                <p><strong><?php echo $conteudo[0]['nm_company']?></strong> &copy; |<i class="fas fa-envelope ml-2 mr-2"></i><a href="mailto:<?php echo $conteudo[0]['ds_email']?>"><?php echo $conteudo[0]['ds_email']?></a></p>
                <h3 class="mb-3">Sobre nossa empresa</h3>
                <p class="wrap"><?php echo $conteudo[0]['ds_text_footer']?></p>
                <!-- DOCUMENTO DA EMPRESA -->
                <?php if ($conteudo[0]['ds_document'] != '' && $config[0]['st_document'] == 1):?>
                    <div class="text-left mt-4">
                        <label id="green">Todos os direitos reservados.</label>
                        <label id="green"><strong>CNPJ:</strong> <?php echo $conteudo[0]['ds_document']?></label>
                    </div>
                <?php endif;?>
                <div class="opct">
                    <label id="grey" class="mr-1 mt-4">Developed by. <a href="mailto:renato.rodrigues_costa@hotmail.com">Renato Rodrigues</a></label>
                    <a href="https://www.linkedin.com/in/renato-rodrigues-da-costa-82599198/" target="_blank" title="Meu LinkedIn."><i class="fab fa-linkedin ml-1" style="font-size: 1.2em;"></i></a>
                </div>
            </div>
        </div>
        <!-- LINKS SOCIAIS -->
        <div class="col-sm-4 col-12 rodape-social text-center">
            <div class="conteudo-baixo">
                <?php if ($link[0]['ds_link_face'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_face']?>" target="_blank" title="Nosso facebook."><i class="fab fa-facebook-square mr-2 shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_twit'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_twit']?>" target="_blank" title="Nosso Twitter."><i class="fab fa-twitter-square mr-2 shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_insta'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_insta']?>" target="_blank" title="Nosso Instagram."><i class="fab fa-instagram mr-2 shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_linked'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_linked']?>" target="_blank" title="Meu LinkedIn."><i class="fab fa-linkedin mr-2 shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_olx'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_olx']?>" target="_blank" title="Nos encontre também pela OLX."><i class="far fa-handshake mr-1 shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_market'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_market']?>" target="_blank" title="Nos encontre também pelo Mercado Livre."><i class="fas fa-shopping-cart shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_ytb'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_ytb']?>" target="_blank" title="Conheça nosso canal no YouTube."><i class="fab fa-youtube-square shadow-strong"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_face'] != '' && $config[0]['st_fbpage'] == 1 && $code[0]['lnk_script'] != ''):?>
                <div class="text-center mt-4 p-0">
                    <div class="fb-page shadow-strong"
                         data-href="<?php echo $link[0]['ds_link_face']?>"
                         data-small-header="false"
                         data-adapt-container-width="true"
                         data-hide-cover="false"
                         data-show-facepile="false">
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
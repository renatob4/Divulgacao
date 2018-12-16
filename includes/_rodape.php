<?php
    //======================== RODAPÉ ============================
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
    $link = $acesso->EXE_QUERY('SELECT * FROM tab_link');
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');
?>
<!-- Rodapé-->
<div class="container rodape mt-3">
    <div class="row">
        <div class="col-sm-8 col-12">
            <div class="ml-3">
                <p><strong><?php echo $conteudo[0]['nm_company']?></strong> &copy; |<i class="fas fa-envelope ml-2 mr-2"></i><a href="mailto:<?php echo $conteudo[0]['ds_email']?>"><?php echo $conteudo[0]['ds_email']?></a></p>
                <h3 class="mb-3">Sobre nossa empresa</h3>
                <p><?php echo $conteudo[0]['ds_text_footer']?></p>
                <!-- DOCUMENTO DA EMPRESA -->
                <?php if ($conteudo[0]['ds_document'] != '' && $config[0]['st_document']):?>
                    <div class="text-left mt-4">
                        <label id="green">Todos os direitos reservados.</label>
                        <label id="green"><strong>CNPJ:</strong> <?php echo $conteudo[0]['ds_document']?></label>
                    </div>
                <?php endif;?>
            </div>    
        </div>
        <!-- LINKS SOCIAIS -->
        <div class="col-sm-4 col-12 rodape-social text-center">
            <div class="conteudo-baixo2 mb-5 pb-5">
                <?php if ($link[0]['ds_link_face'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_face']?>" target="_blank"><i class="fab fa-facebook-square mr-3"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_twit'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_twit']?>" target="_blank"><i class="fab fa-twitter-square mr-3"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_insta'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_insta']?>" target="_blank"><i class="fab fa-instagram mr-3"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_linked'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_linked']?>" target="_blank"><i class="fab fa-linkedin mr-3"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_olx'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_olx']?>" target="_blank"><i class="far fa-handshake mr-2"></i></a>
                <?php endif;?>
                <?php if ($link[0]['ds_link_market'] != ''):?>
                    <a href="<?php echo $link[0]['ds_link_market']?>" target="_blank"><i class="fas fa-shopping-cart"></i></a>
                <?php endif;?>
            </div>
            <div class="text-center mt-3">
                <label id="green" class="dev mr-3">Developed by. <a href="mailto:renato.rodrigues_costa@hotmail.com">Renato Rodrigues</a></label>
            </div>          
        </div>
    </div>
</div>
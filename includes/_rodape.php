<?php
    //======================== RODAPÉ ============================
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
    $link = $acesso->EXE_QUERY('SELECT * FROM tab_link');
?>  
<!-- Rodapé-->
<div class="container rodape mt-0">
    <div class="row">
        <div class="col-sm-6 col-12">
            <p><strong><?php echo $conteudo[0]['nm_company']?></strong> &copy; |<i class="fas fa-envelope ml-2 mr-2"></i><a href="mailto:<?php echo $conteudo[0]['ds_email']?>"><?php echo $conteudo[0]['ds_email']?></a></p>
            <h3 class="mb-3">Sobre a nossa empresa</h3>
            <p><?php echo $conteudo[0]['ds_text_footer']?></p>
        </div>
        <!-- LINKS SOCIAIS -->
        <div class="col-sm-6 col-12 rodape-social text-right">
            <?php if($link[0]['ds_link_face'] != '') :?>
                <a href="<?php echo $link[0]['ds_link_face']?>" target="_blank"><i class="fab fa-facebook-square mr-3"></i></a>
            <?php endif;?>
            <?php if($link[0]['ds_link_twit'] != '') :?>
                <a href="<?php echo $link[0]['ds_link_twit']?>" target="_blank"><i class="fab fa-twitter-square mr-3"></i></a>
            <?php endif;?>
            <?php if($link[0]['ds_link_insta'] != '') :?>
                <a href="<?php echo $link[0]['ds_link_insta']?>" target="_blank"><i class="fab fa-instagram mr-3"></i></a>
            <?php endif;?>
            <?php if($link[0]['ds_link_linked'] != '') :?>
                <a href="<?php echo $link[0]['ds_link_linked']?>" target="_blank"><i class="fab fa-linkedin mr-3"></i></a>
            <?php endif;?>
            <?php if($link[0]['ds_link_olx'] != '') :?>
                <a href="<?php echo $link[0]['ds_link_olx']?>" target="_blank"><i class="far fa-handshake mr-2"></i></a>
            <?php endif;?>
            <?php if($link[0]['ds_link_market'] != '') :?>
                <a href="<?php echo $link[0]['ds_link_market']?>" target="_blank"><i class="fas fa-shopping-cart"></i></a>
            <?php endif;?>
            <!-- DOCUMENTO DA EMPRESA -->
            <?php if($conteudo[0]['ds_document'] != '') :?>
                <div class="text-right mt-4">
                    <label class="doc">Todos os direitos reservados.</label>
                    <label class="doc"><strong>CNPJ:</strong> <?php echo $conteudo[0]['ds_document']?></label>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
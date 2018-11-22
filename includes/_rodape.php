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
            <p><?php echo $conteudo[0]['nm_company']?> &copy; |<i class="fas fa-envelope ml-2 mr-2"></i><a href="mailto:<?php echo $conteudo[0]['ds_email']?>"><?php echo $conteudo[0]['ds_email']?></a></p>
            <h3 class="mb-3">Sobre nossa empresa</h3>
            <p><?php echo $conteudo[0]['ds_text_footer']?></p>
        </div>
        <div class="col-sm-6 col-12 rodape-social text-right">
            <a href="<?php echo $link[0]['ds_link_face']?>" target="_blank"><i class="fab fa-facebook-square mr-3"></i></a>
            <a href="<?php echo $link[0]['ds_link_twit']?>" target="_blank"><i class="fab fa-twitter-square mr-3"></i></a>
            <a href="<?php echo $link[0]['ds_link_insta']?>" target="_blank"><i class="fab fa-instagram mr-3"></i></a>
            <a href="<?php echo $link[0]['ds_link_linked']?>" target="_blank"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</div>
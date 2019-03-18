<?php
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT nm_company FROM tab_content');
    $config = $acesso->EXE_QUERY('SELECT st_product, st_service, st_promotion FROM tab_config');
    $code = $acesso->EXE_QUERY('SELECT lnk_script, id_app FROM tab_code');
?>
<div class="row mr-1 ml-1">
    <div class="col m-0 p-0">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark contentor-menu shadow-strong">
            <a href="?a=home" id="lightseagreen" class="navbar-brand mb-0 mr-4 h1"><?php echo $conteudo[0]['nm_company']?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mt-2 mb-2"><a class="texto-menu mr-2" href="?a=home" title="Página Inicial."><i class="fas fa-home mr-1"></i>INICIO</a></li>
                    <?php if($config[0]['st_product'] == 1):?><li class="nav-item mt-2 mb-2"><a class="texto-menu mr-2" href="?a=produtos" title="Nossos produtos."><i class="fas fa-shopping-cart mr-1"></i>PRODUTOS</a></li><?php endif;?>
                    <?php if($config[0]['st_service'] == 1):?><li class="nav-item mt-2 mb-2"><a class="texto-menu mr-2" href="?a=servicos" title="Nossos serviços."><i class="fas fa-wrench mr-1"></i>SERVIÇOS</a></li><?php endif;?>
                    <li class="nav-item mt-2 mb-2"><a class="texto-menu mr-2" href="?a=contatos" title="Nossos contatos."><i class="fas fa-phone mr-1"></i>CONTATOS</a></li>
                    <?php if($config[0]['st_promotion'] == 1 && $code[0]['lnk_script'] != '' && $code[0]['id_app'] != ''):?><li class="nav-item mt-2 mb-2"><a class="texto-menu mr-2" href="?a=promocoes" title="Nossas promoções."><i class="fas fa-percentage mr-1"></i>PROMOÇÕES</a></li><?php endif;?>
                </ul>
            </div>
        </nav>
    </div>
</div>
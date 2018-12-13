<?php
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
?>
<div class="row mr-1 ml-1">
    <div class="col m-0 p-0">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark contentor-menu">
            <a href="?a=home" id="lightseagreen" class="navbar-brand mb-0 mr-3 h1"><?php echo $conteudo[0]['nm_company']?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="texto-menu mr-2"><a href="?a=home"><i class="fas fa-home mr-1"></i>INICIO</a></li>
                    <li class="nav-item"><a class="texto-menu mr-2"><a href="?a=galeria"><i class="fas fa-image mr-1"></i>GALERIA</a></li>
                    <li class="nav-item"><a class="texto-menu mr-2"><a href="?a=servicos"><i class="fas fa-wrench mr-1"></i>SERVICOS</a></li>
                    <li class="nav-item"><a class="texto-menu mr-2"><a href="?a=contatos"><i class="fas fa-phone mr-1"></i>CONTATOS</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>
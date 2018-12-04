<?php
    //======================== MENU SUSPENSO ============================
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT nm_company FROM tab_content');
?>

<!-- INÍCIO DO MENU SUPERIOR -->
<div class="row">
    <div class="col m-0 mt-2 p-0">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark contentor-menu">
            <a class="navbar-brand mb-0 mr-3 h1" style="color: lightseagreen;" href="?a=home"><?php echo $conteudo[0]['nm_company']?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="texto-menu mr-3"><a href="?a=home">HOME</a></li>
                    <li class="nav-item"><a class="texto-menu mr-3"><a href="?a=galeria">GALERIA</a></li>
                    <li class="nav-item"><a class="texto-menu mr-3"><a href="?a=servicos">SERVIÇOS</a></li>
                    <li class="nav-item"><a class="texto-menu mr-3"><a href="?a=contatos">CONTATOS</a></li>
                </ul>
            </div>
        </nav>     
    </div> 
</div>  
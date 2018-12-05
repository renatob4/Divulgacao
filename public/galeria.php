<?php

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
?>


<!-- ________________________________________________________CONTEÚDO DA PAGINA GALERIA__________________________________________________________ -->

    <div class="row">
        <div class="col p-0">
            <div class="card p-5 borda-painel">
                <h3 class="text-center">Esta é a pagina exemplo de Galeria!</h3>
            </div>
        </div>
    </div>

<!-- _____________________________________________________________________________________________________________________________________________ -->

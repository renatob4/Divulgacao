<?php

    //Código

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');

?>


<!-- ________________________________________________________CONTEÚDO DA PAGINA CONTATOS__________________________________________________________ -->

    <div class="row mr-1 ml-1">
        <div class="col p-0">
            <div class="card p-5 borda-painel">
                <h3 class="text-center">Esta é a pagina exemplo de Contatos!</h3>
            </div>
        </div>
    </div>

<!-- _____________________________________________________________________________________________________________________________________________ -->


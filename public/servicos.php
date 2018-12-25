<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $config = $acesso->EXE_QUERY('SELECT st_service FROM tab_config');

    if($config[0]['st_service'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }else{
        //busca o conteúdo da pagina no banco de dados.
        $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
        // *
        // *
        // *
        // *
        // *
        // *
    }
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA SERVIÇOS__________________________________________________________ -->
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-5 borda-painel shadow-strong">
            <h3 class="text-center">Esta é a pagina exemplo de Serviços!</h3>
        </div>
    </div>
</div>

<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //busca o conteúdo da pagina no banco de dados.
    $card = $acesso->EXE_QUERY('SELECT * FROM tab_card');

    header("Location:?a=home");
?>
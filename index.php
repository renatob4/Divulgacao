<?php
    // ==========================================================
    // INDEX - DA PAGINA PRINCIPAL
    // ==========================================================

    //Controle de sessão.
    session_start();
    
    if(!isset($_SESSION['a'])){
        $_SESSION['a'] = 'home';
    }

    /* Recursos */

    //incluir funções
    include_once('class/funcoes.php');
    //incluir classe de emails
    include_once('class/emails.php');
    //inclui as funções necessarias do sistemas
    include_once('class/gestorBD.php');

    /* Estrutura */

    //barra do utilizador
    include_once('includes/_barra_utilizador.php');
    //Topo (Cabeçalho e menu são incluidos dentro deste arquivo)
    include_once('includes/_topo.php');
    //Menu suspenso
    include_once('includes/_menu.php');
    //Mecanismo de fluxo de paginas.
    include_once('routes.php');
    //Fundo (Rodapé é incluido dentro deste arquivo)
    include_once('includes/_fundo.php');
?>
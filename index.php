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
    //Topo (Cabeçalho, barra de utilizador e menu são incluidos dentro deste arquivo)
    include_once('includes/_topo.php');
    //Mecanismo de fluxo de paginas.
    include_once('routes.php');
    //Fundo (Rodapé é incluido dentro deste arquivo)
    include_once('includes/_fundo.php');
?>
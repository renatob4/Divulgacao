<?php

    // ==========================================================
    // ROUTES
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //vefigica pagina a ser carregada
    $a = 'home';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    //verificar o login ativo
    if(!funcoes::VerificarLogin()){
        //casos especiais (PODEM SER ACESSADOS MESMO O ADM NAO ESTANDO LOGADO) ************************
        $routes_especiais = [
            'recuperar_senha',
            'setup',
            'setup_criar_bd',
            'setup_inserir_utilizadores',
            'login',
            'contatos',
            'servicos',
            'galeria'
        ];
        //bypass do sistema normal
        if(!in_array($a, $routes_especiais)){
            $a='home';
        }   
    }
 
    switch ($a) {

        // =========================== WEBSITE ================================

        //Pagina principal
        case 'home':                            include_once('public/home.php'); break;

        //Pagina de contatos
        case 'contatos':                        include_once('public/contatos.php'); break;

        //Pagina de contatos
        case 'servicos':                        include_once('public/servicos.php'); break;

        //Pagina de contatos
        case 'galeria':                        include_once('public/galeria.php'); break;

        // ========================= LOGIN/LOGOUT =============================

        //Pagina de Login
        case 'login':                           include_once('users/login.php'); break;

        //Script logout
        case 'logout':                          include_once('users/logout.php'); break;

        // ============================ SETUP =================================

        //Criar a base de dados
        case 'setup':                           include_once('setup/setup.php'); break;

        //Criar a base de dados
        case 'setup_criar_bd':                  include_once('setup/setup.php'); break;

        //Inserir utilizadores
        case 'setup_inserir_utilizadores':      include_once('setup/setup.php'); break;

    }    
        
?>                    


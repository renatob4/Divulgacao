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
        //Casos especiais (PODEM SER ACESSADOS MESMO O ADM NÃO ESTANDO LOGADO) ***
        $routes_especiais = [
            'recuperar_senha',
            'setup',
            'setup_criar_bd',
            'setup_inserir_utilizadores',
            'setup_inserir_conteudo',
            'login',
            'contatos',
            'servicos',
            'galeria',
            'recuperar_senha',
            'conteudo'
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

        //Pagina de contatos
        case 'conteudo':                        include_once('public/conteudo.php'); break;

        // ========================= LOGIN/LOGOUT =============================

        //Pagina de Login
        case 'login':                           include_once('users/login.php'); break;

        //Script logout
        case 'logout':                          include_once('users/logout.php'); break;

        // ========================== MANAGEMENT ==============================

        //Pagina de recuperação de senha
        case 'perfil_configuracoes':            include_once('users/perfil_configuracoes.php'); break;

        //Pagina de recuperação de senha
        case 'recuperar_senha':                 include_once('users/recuperar_senha.php'); break;

        //Alterar senha
        case 'perfil_alterar_senha':            include_once('users/perfil_alterar_senha.php'); break;

        //Alterar email vinculado
        case 'perfil_alterar_email':            include_once('users/perfil_alterar_email.php'); break;

        //Alterar Login
        case 'perfil_alterar_login':            include_once('users/perfil_alterar_login.php'); break;

        // ========================== CONTROLE DE DADOS =======================

        //Deletar Card
        case 'card_deletar':                    include_once('controls/card_deletar.php'); break;

        //Editar Card
        case 'card_editar':                     include_once('controls/card_editar.php'); break;

        //Inserir Card
        case 'card_inserir':                    include_once('controls/card_inserir.php'); break;

        //Deletar Post
        case 'post_deletar':                    include_once('controls/post_deletar.php'); break;

        //Alterar Post
        case 'post_editar':                     include_once('controls/post_editar.php'); break;

        //Inserir Post
        case 'post_inserir':                    include_once('controls/post_inserir.php'); break;

        // ============================ SETUP =================================

        //Criar a base de dados
        case 'setup':                           include_once('setup/setup.php'); break;

        //Criar a base de dados
        case 'setup_criar_bd':                  include_once('setup/setup.php'); break;

        //Inserir utilizadores
        case 'setup_inserir_utilizadores':      include_once('setup/setup.php'); break;

        //Inserir Conteúdo
        case 'setup_inserir_conteudo':          include_once('setup/setup.php'); break;

    }    
        
?>                    


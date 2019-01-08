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
        //PODEM SER ACESSADOS MESMO O ADM NÃO ESTANDO LOGADO
        $routes_especiais = [
            'recuperar_senha',
            'login',
            'contatos',
            'servicos',
            'produtos',
            'recuperar_senha',
            'conteudo',
            'promocoes'
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

        //Pagina de serviços
        case 'servicos':                        include_once('public/servicos.php'); break;

        //Pagina de produtos
        case 'produtos':                         include_once('public/produtos.php'); break;

        //Pagina de conteudo
        case 'conteudo':                        include_once('public/conteudo.php'); break;

        //Pagina de promocoes
        case 'promocoes':                        include_once('public/promocoes.php'); break;

        // ========================= LOGIN/LOGOUT =============================

        //Pagina de Login
        case 'login':                           include_once('users/login.php'); break;

        //Script logout
        case 'logout':                          include_once('users/logout.php'); break;

        // ========================== MANAGEMENT ==============================

        //Pagina de recuperação de senha
        case 'configuracoes':                   include_once('users/configuracoes.php'); break;

        //Pagina de recuperação de senha
        case 'recuperar_senha':                 include_once('users/recuperar_senha.php'); break;

        //Alterar senha
        case 'perfil_alterar_senha':            include_once('users/perfil_alterar_senha.php'); break;

        //Alterar email vinculado
        case 'perfil_alterar_email':            include_once('users/perfil_alterar_email.php'); break;

        //Alterar Login
        case 'perfil_alterar_login':            include_once('users/perfil_alterar_login.php'); break;

        //Alterar prospects
        case 'prospects':                       include_once('users/prospects.php'); break;

        //Alterar prospects
        case 'promocoes_config':                include_once('users/promocoes_config.php'); break;

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

        //Inserir imagens
        case 'recebe_imagem':                   include_once('controls/recebe_imagem.php'); break;

        //Apagar imagens
        case 'deleta_imagem':                   include_once('controls/deleta_imagem.php'); break;

        //Configurar Exibição
        case 'update_config':                   include_once('controls/update_config.php'); break;

        //Inserir Produto
        case 'produto_inserir':                 include_once('controls/produto_inserir.php'); break;

        //Apagar Produto
        case 'produto_deletar':                 include_once('controls/produto_deletar.php'); break;

        //Editar Produto
        case 'produto_editar':                  include_once('controls/produto_editar.php'); break;

        //Inserir servico
        case 'servico_inserir':                 include_once('controls/servico_inserir.php'); break;

        //Apagar servico
        case 'servico_deletar':                 include_once('controls/servico_deletar.php'); break;

        //Editar servico
        case 'servico_editar':                  include_once('controls/servico_editar.php'); break;

        //Editar servico
        case 'conceder_cupom':                  include_once('controls/conceder_cupom.php'); break;

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
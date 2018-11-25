<?php
    // ==========================================================
    // SETUP - CRIAR A BASE DE DADOS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Cria a base de dados.
    $gestor = new cl_gestorBD();
    $configs = include('./class/config.php');

    //Apagar a base de dados caso ela exista.
    $gestor->EXE_NON_QUERY('DROP DATABASE IF EXISTS '.$configs['BD_DATABASE']);
    //Criar a nova base de dados.
    $gestor->EXE_NON_QUERY('CREATE DATABASE '.$configs['BD_DATABASE'].' CHARACTER SET UTF8 COLLATE utf8_general_ci');
    $gestor->EXE_NON_QUERY('USE '.$configs['BD_DATABASE']);

    // ===========================================================
    // CRIAÇãO DAS TABELAS
    // ===========================================================

    //tabela tab_user
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_user('.
        'cd_user                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_login                       NVARCHAR(50), '.
        'cd_password                    NVARCHAR(32), '.
        'nm_user                        NVARCHAR(50), '.
        'ds_email                       NVARCHAR(50), '.
        'cd_permition                   NVARCHAR(32), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );

    //tabela tab_content
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_content('.
        'cd_info                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'nm_company                     VARCHAR(60), '.
        'ds_slogan                      VARCHAR(255), '.
        'ds_presentation                TEXT, '.
        'ds_email                       VARCHAR(60), '.
        'ds_document                    VARCHAR(18), '.
        'cd_phone_1                     VARCHAR(20), '.
        'cd_phone_2                     VARCHAR(20), '.
        'ds_text_footer                 VARCHAR(255), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );

    //tabela tab_links
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_link('.
        'cd_link                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_link_face                   VARCHAR(120), '.
        'ds_link_twit                   VARCHAR(120), '.
        'ds_link_linked                 VARCHAR(120), '.
        'ds_link_insta                  VARCHAR(120), '.
        'ds_link_olx                    VARCHAR(120), '.
        'ds_link_market                 VARCHAR(120), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );

    //tabela tab_cards
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_card('.
        'cd_card                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_title                       VARCHAR(50), '.
        'ds_content                     TEXT, '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );

    //tabela tab_log
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_log('.
        'cd_log                          INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'dt_hour                         DATETIME, '.
        'cd_login                        NVARCHAR(50), '.
        'ds_message                      NVARCHAR(256))'
    );
?>

<div class="alert alert-success text-center mt-2 mb-2">Base de dados criada com sucesso!</div>

<?php
    //Como a base inteira foi zerada, ele automaticamente insere conteudo e user padrão.
    include_once('setup_inserir_conteudo.php');
    include_once('setup_inserir_utilizadores.php');
?>



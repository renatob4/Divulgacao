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
        'ds_presentation                TEXT, '.
        'ds_email                       VARCHAR(60), '.
        'ds_document                    VARCHAR(18), '.
        'cd_phone_1                     VARCHAR(20), '.
        'cd_phone_2                     VARCHAR(20), '.
        'ds_text_footer                 VARCHAR(255), '.
        'lnk_map                        TEXT, '.
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
        'ds_link_ytb                    VARCHAR(120), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );
    //tabela tab_cards
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_card('.
        'cd_card                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_title                       VARCHAR(50), '.
        'ds_content                     TEXT, '.
        'img_front_card                 VARCHAR(50), '.
        'img_card                       VARCHAR(50), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );
    //tabela tab_posts
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_post('.
        'cd_post                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_title                       VARCHAR(50), '.
        'ds_content                     VARCHAR(255), '.
        'nm_autor                       VARCHAR(30), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );
    //tabela tab_product
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_product('.
        'cd_product                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_alternative_product         VARCHAR(12) UNIQUE, '.
        'nm_product                     VARCHAR(32), '.
        'ds_category                    VARCHAR(22), '.
        'vl_product                     FLOAT, '.
        'ds_description                 TEXT, '.
        'ds_unity                       VARCHAR(12), '.
        'st_promotion                   BOOLEAN, '.
        'img_product                    VARCHAR(50), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );
    //tabela tab_service
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_service('.
        'cd_service                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_alternative_service         VARCHAR(12) UNIQUE, '.
        'nm_service                     VARCHAR(32), '.
        'vl_service                     FLOAT, '.
        'ds_description                 TEXT, '.
        'st_promotion                   BOOLEAN, '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );
    //tabela tab_imagem
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_imagem('.
        'cd_img                          INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'img_header                      NVARCHAR(50), '.
        'img_panel                       NVARCHAR(50), '.
        'img_body                        NVARCHAR(50), '.
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );
    //tabela tab_activity
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_activity('.
        'cd_activity                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_activity                     NVARCHAR(255), '.
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );
    //tabela tab_adress
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_adress('.
        'cd_adress                      INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_adress                      NVARCHAR(60), '.
        'ds_city                        NVARCHAR(50), '.
        'cd_uf                          NVARCHAR(30), '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );
    //tabela tab_prospects
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_prospect('.
        'cd_prospect                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'nm_prospect                     NVARCHAR(50), '.
        'ds_email                        NVARCHAR(50), '.
        'cd_phone                        NVARCHAR(20), '.
        'ds_channel                      NVARCHAR(120), '.
        'dt_register                     DATETIME)'
    );
    //tabela tab_code
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_code('.
        'cd_code                         INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'lnk_script                      TEXT, '.
        'id_app                          VARCHAR(20), '.
        'secret_app                      VARCHAR(32), '.
        'dt_updated                      DATETIME)'
    );
    //tabela tab_cupom
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_cupom('.
        'cd_cpm                          INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_cupom                        VARCHAR(12), '.
        'ds_discount                     INT, '.
        'ds_type                         VARCHAR(2), '.
        'nm_customer                     VARCHAR(50), '.
        'dt_valid                        DATETIME, '.
        'dt_register                     DATETIME)'
    );
    //tabela tab_promotion
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_promotion('.
        'cd_promotion                    INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_type                         VARCHAR(2), '.
        'ds_discount                     INT, '.
        'qt_days                         INT, '.
        'dt_updated                      DATETIME)'
    );
    //tabela tab_config
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_config('.
        'cd_config                          INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'st_contact                         BOOLEAN, '.
        'st_service                         BOOLEAN, '.
        'st_product                         BOOLEAN, '.
        'st_promotion                       BOOLEAN, '.
        'st_adress                          BOOLEAN, '.
        'st_activity                        BOOLEAN, '.
        'st_comment                         BOOLEAN, '.
        'st_fbpage                          BOOLEAN, '.
        'st_map                             BOOLEAN, '.
        'st_document                        BOOLEAN, '.
        'st_card                            BOOLEAN, '.
        'st_post                            BOOLEAN, '.
        'sp_relevance                       INT, '.
        'sp_amount                          INT, '.
        'ss_relevance                       INT, '.
        'ss_amount                          INT, '.
        'dt_register                        DATETIME, '.
        'dt_updated                         DATETIME)'
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
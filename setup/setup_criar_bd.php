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
        'cd_user                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_login                       NVARCHAR(50), '.
        'cd_password                    NVARCHAR(32), '.
        'nm_user                     NVARCHAR(50), '.
        'ds_email                       NVARCHAR(50), '.
        'cd_permition                   NVARCHAR(32), '.
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

<div class="alert alert-success text-center">Base de dados criada com sucesso!</div>



<?php
    // ==========================================================
    // SETUP
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //verifica se 'A' esta definido na URL
    $a = '';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    //route do setup
    switch ($a) {
        
        case 'setup_criar_bd':
            // Executa os procedimentos para criação da base de dados
            include('setup_criar_bd.php');
            break;

        case 'setup_inserir_utilizadores':
            // Executa os procedimentos para Inserção do admin na base
            include('setup_inserir_utilizadores.php');
            break;

        case 'setup_inserir_conteudo':
            // Executa os procedimentos para Inserção do conteúdo padrão do site na base
            include('setup_inserir_conteudo.php');
            break;

    }
?>    

<div class="container-fluid pad-20">

    <!--titulo-->
    <h3 class="text-center mt-4">Setup</h3><hr>

    <div class="row text-center m-0 p-0">
        <div class="col">
            <a class="btn btn-danger btn-config" href="?a=setup_criar_bd" title="">
            <span class="fas fa-database"></span></a>
            <p class="m-0 m-0 mb-1">Criar/Recriar Database</p>
        </div>
        <div class="col">
            <a class="btn btn-danger btn-config" href="?a=setup_inserir_utilizadores" title="">
            <span class="fas fa-sign-in-alt"></span></a>
            <p class="m-0 m-0 mb-1">Inserir User</p>
        </div>
        <div class="col">
            <a class="btn btn-danger btn-config" href="?a=setup_inserir_conteudo" title="">
            <span class="fas fa-align-left"></span></a>
            <p class="m-0 m-0 mb-1">Inserir Conteúdo</p>
        </div>
    </div>

    <hr>

    <div class="text-center">
        <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a>
    </div>
   
</div>



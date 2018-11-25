<?php
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Trust</title>

        <!-- Bootstrap 3.3.7-->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
        <!--Bootstrap 4.0-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" 
        integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        
        <!-- Icones font AWESOME -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <!-- Css -->
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        
        <!-- Contentor Global -->
        <div class="container contentor-global">

        <!-- Incluir Cabeçalho -->
        <?php include_once('_cabecalho.php'); ?>
        <!-- Incluir Menu -->
        <?php include_once('_menu.php'); ?>
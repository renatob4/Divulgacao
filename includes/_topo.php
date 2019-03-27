<?php
    // Correção de defesa do chrome.
    header("X-XSS-Protection: 0; mode=block");
    //Acesso á DB
    $acesso = new cl_gestorBD();
    $code = $acesso->EXE_QUERY('SELECT id_app FROM tab_code');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="author" content="Renato Rodrigues da Costa">
        <meta name="description" content="Site de divulgação de pequena empresa/negócio. 156 caracteres">
        <meta name="keywords" content="divulgação, conheça, palavras, chave">
        <meta name="robots" content="index">
        <!-- Tags do facebook -->
<?php if($code[0]['id_app'] != '' &&  $code[0]['id_app'] != null):?>
        <meta property="fb:app_id" content="<?php echo $code[0]['id_app'];?>">
<?php endif;?>
        <meta property="og:locale" content="pt_BR">
        <meta property="og:url" content="<?php echo 'http://$_SERVER[HTTP_HOST]';?>">
        <meta property="og:title" content="Título da página ou artigo">
        <meta property="og:site_name" content="Nome do meu site">
        <meta property="og:description" content="Minha boa descrição para intrigar os usuários.">
        <meta property="og:image" content="<?php echo 'http://$_SERVER[HTTP_HOST]';?>/images/logo.png">
        <meta property="og:image:type" content="image/png">
        <!-- <meta property="og:image:width" content="800"> -->
        <!-- <meta property="og:image:height" content="600"> -->
        <meta property="og:type" content="website">
        <!-- Atualização da Página a cada 10 minutos -->
        <meta http-equiv="Refresh" content="600">
            <title>Trust</title>
        <!--Bootstrap 4.0-->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
        integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"/> -->
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <!-- Icones font AWESOME -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"/>
        <!-- reCaptcha API -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!-- Css -->
        <link rel="stylesheet" href="css/main.css"/>
        <!-- Arquivo manifest para web app -->
        <link rel="manifest" href="./manifest.json">
        <!--Favicon-->
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-ico"/>
    </head>
<body>
<!-- Inclui a barra de utilizador -->
<?php include_once('includes/_barra_utilizador.php'); ?>
<!-- Contentor Global -->
<div class="container contentor-global pt-1">
<!-- Incluir Cabeçalho -->
<?php include_once('_cabecalho.php');?>
<!-- Incluir Menu -->
<?php include_once('_menu.php');?>
<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe post definido
    if(!isset($_GET['post'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //Pega o codigo do post na URL
    $cd_post = $_GET['post'];

    //pesquisa se existe card com esse codigo na base
    $parametros = [
        ':cd_post'   =>  $cd_post
    ];
    $result = $acesso->EXE_QUERY('SELECT ds_title FROM tab_post WHERE cd_post = :cd_post', $parametros);
    
    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }
    
    //Atualizar os dados no card no banco
    $parametros = [
        ':cd_post'      =>  $cd_post
    ];  
    //Atualizar a DB
    $acesso->EXE_NON_QUERY('DELETE FROM tab_post WHERE cd_post = :cd_post', $parametros);

    //Log
    funcoes::CriarLOG('Postagem '.$cd_post.' removida.', $_SESSION['nm_user']);

    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
    exit();
?>
<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe post definido
    if(!isset($_GET['s'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
        exit();
    } 

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //Pega o codigo do produto na URL
    $cd_service = $_GET['s'];

    //pesquisa se existe produto com esse codigo na base
    $parametros = [
        ':cd_service'   =>  $cd_service
    ];
    $result = $acesso->EXE_QUERY('SELECT * FROM tab_service WHERE cd_service = :cd_service', $parametros);

    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
        exit();
    }

    //Atualizar a DB
    $acesso->EXE_NON_QUERY('DELETE FROM tab_service WHERE cd_service = :cd_service', $parametros);

    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
    exit();
?>
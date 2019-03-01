<?php
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe card definido
    if(!isset($_GET['cupom'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes_config">');
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //Pega o codigo do card na URL.
    $cd_cupom = $_GET['cupom'];

    //pesquisa se existe card com esse codigo na base
    $parametros = [
        ':cd_cpm'   =>  $cd_cupom
    ];
    $result = $acesso->EXE_QUERY('SELECT cd_cupom FROM tab_cupom WHERE cd_cpm = :cd_cpm', $parametros);

    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes_config">');
        exit();
    }

    //Atualizar a DB
    $acesso->EXE_NON_QUERY('DELETE FROM tab_cupom WHERE cd_cpm = :cd_cpm', $parametros);

    //Log
    funcoes::CriarLOG('Caupom verificado, concedido e removido do sistema.', $_SESSION['nm_user']);

    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes_config">');
    exit();
?>
    
<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe card definido
    if(!isset($_GET['card'])){
        exit();
    } 

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //Pega o codigo do card na URL
    $cd_card = $_GET['card'];

    //pesquisa se existe card com esse codigo na base
    $parametros = [
        ':cd_card'   =>  $cd_card
    ];
    $result = $acesso->EXE_QUERY('SELECT * FROM tab_card WHERE cd_card = :cd_card', $parametros);
    
    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        exit();
    }
    
    //Atualizar os dados no card no banco
    $parametros = [
        ':cd_card'      =>  $cd_card
    ];  
    //Atualizar a DB
    $acesso->EXE_NON_QUERY('DELETE FROM tab_card WHERE cd_card = :cd_card', $parametros);


    header("Location:?a=home");
?>